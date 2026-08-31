<?php

namespace App\Support\Data;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

/** @implements CastsAttributes<DataObject|null, DataObject|array<string, mixed>|null> */
final readonly class DataObjectCast implements CastsAttributes
{
    /** @param class-string<DataObject> $dataClass */
    public function __construct(private string $dataClass) {}

    public function get(Model $model, string $key, mixed $value, array $attributes): ?DataObject
    {
        if ($value === null) {
            return null;
        }

        return $this->dataClass::fromArray(json_decode((string) $value, true, flags: JSON_THROW_ON_ERROR));
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = is_array($value) ? $this->dataClass::fromArray($value) : $value;

        if (! $value instanceof $this->dataClass) {
            throw new InvalidArgumentException("{$key} must be assigned as {$this->dataClass}.");
        }

        return json_encode($value->toArray(), JSON_THROW_ON_ERROR);
    }
}
