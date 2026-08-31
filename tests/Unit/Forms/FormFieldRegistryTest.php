<?php

use App\Forms\Data\FormSchemaData;
use App\Forms\FormFieldRegistry;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

uses(TestCase::class);

function choiceGridSchema(array $settings, array $options = []): FormSchemaData
{
    return FormSchemaData::fromArray([
        'version' => 1,
        'title' => ['en' => 'Example'],
        'pages' => [[
            'key' => 'main',
            'title' => ['en' => 'Main'],
            'fields' => [[
                'key' => 'grid',
                'type' => 'choice_grid',
                'label' => ['en' => 'Grid'],
                'settings' => $settings,
                'options' => $options,
            ]],
        ]],
    ]);
}

test('structured choice grids should preserve row keys during normalization', function () {
    $schema = choiceGridSchema([
        'rows' => [['value' => 'quality'], ['value' => 'speed']],
        'columns' => [['value' => 1], ['value' => 2]],
        'multiple' => true,
    ]);

    expect($schema->normalize([
        'grid' => ['quality' => [2, 1], 'speed' => [1]],
    ], new FormFieldRegistry))->toBe([
        'grid' => ['quality' => [2, 1], 'speed' => [1]],
    ]);
});

test('structured choice grids should validate configured rows and columns', function () {
    $schema = choiceGridSchema([
        'rows' => [['value' => 'quality'], ['value' => 'speed']],
        'columns' => [['value' => 1], ['value' => 2]],
        'requireEveryRow' => true,
    ]);

    expect($schema->validate([
        'grid' => ['quality' => 2, 'speed' => 1],
    ], new FormFieldRegistry))->toBe([
        'grid' => ['quality' => 2, 'speed' => 1],
    ]);
});

test('structured choice grids should reject values outside configured columns', function () {
    $schema = choiceGridSchema([
        'rows' => [['value' => 'quality']],
        'columns' => [['value' => 1], ['value' => 2]],
        'requireEveryRow' => true,
    ]);

    expect(fn () => $schema->validate([
        'grid' => ['quality' => 3],
    ], new FormFieldRegistry))->toThrow(ValidationException::class);
});

test('legacy choice grids should retain flat list normalization', function () {
    $schema = choiceGridSchema([], [
        ['value' => 'first', 'label' => ['en' => 'First']],
        ['value' => 'second', 'label' => ['en' => 'Second']],
    ]);

    expect($schema->validate([
        'grid' => ['first', 'second'],
    ], new FormFieldRegistry))->toBe([
        'grid' => ['first', 'second'],
    ]);
});
