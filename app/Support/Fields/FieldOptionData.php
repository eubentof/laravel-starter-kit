<?php

namespace App\Support\Fields;

use App\Support\Data\DataObject;

final readonly class FieldOptionData extends DataObject
{
    public function __construct(
        public string|int $value,
        public string $label,
        public ?string $description = null,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self($data['value'], $data['label'], $data['description'] ?? null);
    }
}
