<?php

namespace App\Forms\Data;

use App\Forms\FormFieldRegistry;
use App\Support\Data\DataObject;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

final readonly class FormSchemaData extends DataObject
{
    /** @param list<FormPageData> $pages */
    public function __construct(
        public int $version,
        public LocalizedTextData $title,
        public array $pages,
        public ?LocalizedTextData $description = null,
        public ?LocalizedTextData $confirmation = null,
    ) {
        if ($version !== 1) {
            throw new \InvalidArgumentException("Unsupported form schema version [{$version}].");
        }

        if ($pages === []) {
            throw new \InvalidArgumentException('A form schema requires at least one page.');
        }

        $keys = array_map(fn (FormFieldData $field): string => $field->key, $this->fields());
        if (count($keys) !== count(array_unique($keys))) {
            throw new \InvalidArgumentException('Form field keys must be unique.');
        }
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            version: $data['version'] ?? 1,
            title: LocalizedTextData::fromArray($data['title']),
            pages: array_values(array_map(FormPageData::fromArray(...), $data['pages'] ?? [])),
            description: isset($data['description']) ? LocalizedTextData::fromArray($data['description']) : null,
            confirmation: isset($data['confirmation']) ? LocalizedTextData::fromArray($data['confirmation']) : null,
        );
    }

    /** @return list<FormFieldData> */
    public function fields(): array
    {
        return array_merge(...array_map(fn (FormPageData $page): array => $page->fields, $this->pages));
    }

    /**
     * @param  array<string, mixed>  $values
     * @return array<string, mixed>
     */
    public function normalize(array $values, FormFieldRegistry $registry): array
    {
        return collect($this->fields())->mapWithKeys(
            fn (FormFieldData $field): array => [$field->key => $registry->normalize($field, $values[$field->key] ?? null)],
        )->all();
    }

    /**
     * @param  array<string, mixed>  $values
     * @return array<string, mixed>
     *
     * @throws ValidationException
     */
    public function validate(array $values, FormFieldRegistry $registry): array
    {
        $normalized = $this->normalize($values, $registry);
        Validator::make($normalized, $registry->rules($this))->validate();

        return $normalized;
    }
}
