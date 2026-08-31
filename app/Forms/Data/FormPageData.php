<?php

namespace App\Forms\Data;

use App\Support\Data\DataObject;

final readonly class FormPageData extends DataObject
{
    /** @param list<FormFieldData> $fields */
    public function __construct(
        public string $key,
        public LocalizedTextData $title,
        public array $fields,
        public ?LocalizedTextData $description = null,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            key: $data['key'],
            title: LocalizedTextData::fromArray($data['title']),
            fields: array_values(array_map(FormFieldData::fromArray(...), $data['fields'] ?? [])),
            description: isset($data['description']) ? LocalizedTextData::fromArray($data['description']) : null,
        );
    }
}
