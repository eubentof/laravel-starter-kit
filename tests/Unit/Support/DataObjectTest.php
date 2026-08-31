<?php

use App\Support\Data\DataObject;
use App\Support\Data\DataObjectCast;
use Illuminate\Database\Eloquent\Model;

enum ExampleState: string
{
    case Ready = 'ready';
}

final readonly class NestedExampleData extends DataObject
{
    public function __construct(public string $label) {}

    public static function fromArray(array $data): self
    {
        return new self($data['label']);
    }
}

final readonly class ExampleData extends DataObject
{
    /** @param list<NestedExampleData> $items */
    public function __construct(public ExampleState $state, public array $items) {}

    public static function fromArray(array $data): self
    {
        return new self(
            ExampleState::from($data['state']),
            array_map(NestedExampleData::fromArray(...), $data['items']),
        );
    }
}

test('should recursively serialize typed object-shaped data', function (): void {
    $data = new ExampleData(ExampleState::Ready, [new NestedExampleData('Nested')]);

    expect($data->toArray())->toBe([
        'state' => 'ready',
        'items' => [['label' => 'Nested']],
    ]);
});

test('should cast typed JSON through Eloquent', function (): void {
    $cast = new DataObjectCast(ExampleData::class);
    $model = new class extends Model {};
    $json = $cast->set($model, 'payload', new ExampleData(ExampleState::Ready, []), []);
    $restored = $cast->get($model, 'payload', $json, []);

    expect($restored)->toBeInstanceOf(ExampleData::class)
        ->and($restored?->state)->toBe(ExampleState::Ready);
});
