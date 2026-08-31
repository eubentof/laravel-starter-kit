<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

final class MakeActionCommand extends Command
{
    protected $signature = 'make:action {name : Domain/ActionName}';

    protected $description = 'Create a typed Action, handler, product behavior feature, and Pest test';

    public function handle(): int
    {
        [$domain, $name] = $this->parts((string) $this->argument('name'));
        $directory = app_path("Actions/{$domain}/{$name}");

        if (File::isDirectory($directory)) {
            $this->error("Action directory [{$directory}] already exists.");

            return self::FAILURE;
        }

        File::ensureDirectoryExists($directory);
        $namespace = "App\\Actions\\{$domain}\\{$name}";
        $title = Str::headline($name);

        $replacements = ['{{namespace}}' => $namespace, '{{name}}' => $name, '{{title}}' => $title];
        File::put("{$directory}/{$name}.php", strtr($this->actionStub(), $replacements));
        File::put("{$directory}/{$name}Handler.php", strtr($this->handlerStub(), $replacements));
        File::put("{$directory}/{$name}.feature", strtr($this->featureStub(), $replacements));
        File::put("{$directory}/{$name}Test.php", strtr($this->testStub(), $replacements));

        $this->info("Created {$domain}/{$name}.");

        return self::SUCCESS;
    }

    /** @return array{string, string} */
    private function parts(string $value): array
    {
        $parts = array_values(array_filter(explode('/', trim($value, '/'))));
        if (count($parts) !== 2) {
            throw new \InvalidArgumentException('Use the Domain/ActionName format.');
        }

        return [Str::studly($parts[0]), Str::studly($parts[1])];
    }

    private function actionStub(): string
    {
        return <<<'PHP'
<?php

namespace {{namespace}};

use App\Support\Actions\Action;
use App\Support\Actions\HandledBy;

#[HandledBy({{name}}Handler::class)]
final class {{name}} extends Action
{
    public function __construct(public readonly string $value) {}

    public static function fromArray(array $data): self
    {
        return new self(value: $data['value']);
    }
}
PHP;
    }

    private function handlerStub(): string
    {
        return <<<'PHP'
<?php

namespace {{namespace}};

use App\Models\User;
use App\Support\Actions\ActionHandler;

final class {{name}}Handler extends ActionHandler
{
    public function __invoke(User $executor, {{name}} $action): mixed
    {
        // Authorize before applying the state transition.
        return null;
    }
}
PHP;
    }

    private function featureStub(): string
    {
        return <<<'GHERKIN'
Feature: {{title}}
  Scenario: an authorized user should complete the operation
    Given a user is allowed to perform the operation
    When they submit valid details
    Then the requested change is saved
GHERKIN;
    }

    private function testStub(): string
    {
        return <<<'PHP'
<?php

use {{namespace}}\{{name}};

test('an authorized user should complete the operation', function (): void {
    /** @Given a user is allowed to perform the operation */
    /** @When they submit valid details */
    /** @Then the requested change is saved */
    expect({{name}}::class)->toBeString();
});
PHP;
    }
}
