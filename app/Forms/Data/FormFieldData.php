<?php

namespace App\Forms\Data;

use App\Forms\Enums\FormFieldType;
use App\Support\Data\DataObject;

final readonly class FormFieldData extends DataObject
{
    /**
     * @param  list<ChoiceOptionData>  $options
     * @param  list<string>  $validation
     * @param  array<string, mixed>  $settings
     */
    public function __construct(
        public string $key,
        public FormFieldType $type,
        public LocalizedTextData $label,
        public ?LocalizedTextData $description = null,
        public bool $required = false,
        public array $options = [],
        public ?string $provider = null,
        public array $validation = [],
        public array $settings = [],
        public bool $disabled = false,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            key: $data['key'],
            type: FormFieldType::from($data['type']),
            label: LocalizedTextData::fromArray($data['label']),
            description: isset($data['description']) ? LocalizedTextData::fromArray($data['description']) : null,
            required: $data['required'] ?? false,
            options: array_values(array_map(ChoiceOptionData::fromArray(...), $data['options'] ?? [])),
            provider: $data['provider'] ?? null,
            validation: $data['validation'] ?? [],
            settings: $data['settings'] ?? [],
            disabled: $data['disabled'] ?? false,
        );
    }
}
