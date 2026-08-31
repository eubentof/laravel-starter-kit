<?php

namespace App\Support\Data;

use BackedEnum;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

/** @implements Arrayable<string, mixed> */
abstract readonly class DataObject implements Arrayable, JsonSerializable
{
    /** @param array<string, mixed> $data */
    abstract public static function fromArray(array $data): self;

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return self::serialize(get_object_vars($this));
    }

    /** @return array<string, mixed> */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    private static function serialize(mixed $value): mixed
    {
        if ($value instanceof BackedEnum) {
            return $value->value;
        }

        if ($value instanceof self) {
            return $value->toArray();
        }

        if ($value instanceof Arrayable) {
            return self::serialize($value->toArray());
        }

        if (is_array($value)) {
            return array_map(self::serialize(...), $value);
        }

        return $value;
    }
}
