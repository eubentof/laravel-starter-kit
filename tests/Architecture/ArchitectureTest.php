<?php

use App\Models\User;
use App\Support\Actions\Action;
use App\Support\Actions\ActionHandler;
use App\Support\Actions\GuestActionHandler;
use App\Support\Actions\HandledBy;
use App\Support\Queries\Query;
use Illuminate\Support\Facades\File;

test('should keep every action and handler in the required operation format', function (): void {
    $actions = collect(File::allFiles(app_path('Actions')))
        ->filter(fn (SplFileInfo $file): bool => $file->getExtension() === 'php' && ! str_ends_with($file->getFilename(), 'Handler.php') && ! str_ends_with($file->getFilename(), 'Test.php'));
    $handlers = collect(File::allFiles(app_path('Actions')))
        ->filter(fn (SplFileInfo $file): bool => str_ends_with($file->getFilename(), 'Handler.php'));

    expect($handlers)->toHaveCount($actions->count());

    foreach ($actions as $file) {
        $actionName = $file->getBasename('.php');
        $relative = str($file->getPathname())->after(app_path().DIRECTORY_SEPARATOR)->replace('/', '\\')->beforeLast('.php');
        $class = 'App\\'.$relative;
        $reflection = new ReflectionClass($class);
        $attributes = $reflection->getAttributes(HandledBy::class);
        $expectedHandler = $class.'Handler';

        expect($reflection->isSubclassOf(Action::class))->toBeTrue()
            ->and($reflection->isFinal())->toBeTrue()
            ->and($file->getPathInfo()->getBasename())->toBe($actionName)
            ->and($attributes)->toHaveCount(1)
            ->and($reflection->hasMethod('fromArray'))->toBeTrue()
            ->and($reflection->getMethod('fromArray')->isPublic())->toBeTrue()
            ->and($reflection->getMethod('fromArray')->isStatic())->toBeTrue()
            ->and(File::exists($file->getPath().DIRECTORY_SEPARATOR.$actionName.'Handler.php'))->toBeTrue()
            ->and(File::exists($file->getPath().DIRECTORY_SEPARATOR.$actionName.'.feature'))->toBeTrue()
            ->and(File::exists($file->getPath().DIRECTORY_SEPARATOR.$actionName.'Test.php'))->toBeTrue();

        $handlerClass = $attributes[0]->newInstance()->handler;
        $handler = new ReflectionClass($handlerClass);
        $invoke = $handler->getMethod('__invoke');
        $parameters = $invoke->getParameters();
        $parameterType = static function (ReflectionParameter $parameter): ?string {
            $type = $parameter->getType();

            return $type instanceof ReflectionNamedType ? $type->getName() : null;
        };

        expect($handlerClass)->toBe($expectedHandler)
            ->and($handler->isSubclassOf(ActionHandler::class))->toBeTrue()
            ->and($handler->isFinal())->toBeTrue()
            ->and($handler->getFileName())->toBe($file->getPath().DIRECTORY_SEPARATOR.$actionName.'Handler.php')
            ->and($invoke->getDeclaringClass()->getName())->toBe($handlerClass)
            ->and($invoke->isPublic())->toBeTrue()
            ->and($invoke->isStatic())->toBeFalse()
            ->and($invoke->hasReturnType())->toBeTrue()
            ->and($handler->hasMethod('execute'))->toBeFalse();

        if ($handler->isSubclassOf(GuestActionHandler::class)) {
            expect($parameters)->toHaveCount(1)
                ->and($parameterType($parameters[0]))->toBe($class);
        } else {
            expect($parameters)->toHaveCount(2)
                ->and($parameterType($parameters[0]))->toBe(User::class)
                ->and($parameterType($parameters[1]))->toBe($class);
        }
    }
});

test('should keep the query boundary separate from persistence actions', function (): void {
    $reflection = new ReflectionClass(Query::class);

    expect($reflection->isAbstract())->toBeTrue()
        ->and($reflection->isSubclassOf(Action::class))->toBeFalse();
});

test('should delegate application persistence from controllers and Fortify adapters to actions', function (): void {
    $files = collect([
        ...File::allFiles(app_path('Http/Controllers')),
        ...File::allFiles(app_path('Fortify')),
    ])->filter(fn (SplFileInfo $file): bool => $file->getExtension() === 'php');

    $directPersistencePatterns = [
        '->save(',
        '->update(',
        '->delete(',
        '::create(',
        'forceFill(',
    ];

    foreach ($files as $file) {
        $contents = File::get($file->getPathname());

        foreach ($directPersistencePatterns as $pattern) {
            expect($contents)
                ->not->toContain($pattern, "{$file->getPathname()} persists data directly through {$pattern}");
        }
    }
});

test('all scenario and test names should use expectation wording', function (): void {
    $files = collect([
        ...File::allFiles(app_path()),
        ...File::allFiles(base_path('tests')),
        ...File::allFiles(resource_path('js')),
    ])->filter(function (SplFileInfo $file): bool {
        return $file->getExtension() === 'feature'
            || str_ends_with($file->getFilename(), 'Test.php')
            || str_ends_with($file->getFilename(), '.spec.ts')
            || str_ends_with($file->getFilename(), '.test.ts');
    });

    foreach ($files as $file) {
        $contents = File::get($file->getPathname());
        $names = [];

        if ($file->getExtension() === 'feature') {
            preg_match_all('/^\s*Scenario(?: Outline)?:\s*(.+)$/m', $contents, $matches);
            $names = $matches[1];
        } else {
            if ($file->getExtension() === 'php') {
                expect($contents)->not->toMatch('/\bit\s*\(/', "{$file->getPathname()} should use Pest's test() caller");
            }

            preg_match_all('/\b(?:it|test)\(\s*[\'\"]([^\'\"]+)[\'\"]/', $contents, $descriptionMatches);
            preg_match_all('/function\s+test_([a-zA-Z0-9_]+)/', $contents, $methodMatches);
            $names = [...$descriptionMatches[1], ...array_map(
                static fn (string $name): string => str_replace('_', ' ', $name),
                $methodMatches[1],
            )];
        }

        foreach ($names as $name) {
            expect($name)->toMatch('/\bshould(?:\s+not)?\b/i', "{$file->getPathname()} has a non-conforming name: {$name}");
        }
    }
});
