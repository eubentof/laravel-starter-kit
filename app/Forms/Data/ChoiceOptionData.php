<?php

namespace App\Forms\Data;

use App\Support\Data\DataObject;

final readonly class ChoiceOptionData extends DataObject
{
    public function __construct(
        public string|int $value,
        public LocalizedTextData $label,
        public ?LocalizedTextData $description = null,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            value: $data['value'],
            label: LocalizedTextData::fromArray($data['label']),
            description: isset($data['description']) ? LocalizedTextData::fromArray($data['description']) : null,
        );
    }
}
