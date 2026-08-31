<?php

namespace App\Forms\Builders;

use App\Forms\Data\FormFieldData;
use App\Forms\Data\FormPageData;
use App\Forms\Data\LocalizedTextData;

final class FormPageBuilder
{
    /** @var list<FormFieldData> */
    private array $fields = [];

    private ?LocalizedTextData $description = null;

    public function __construct(
        private readonly string $key,
        private readonly LocalizedTextData $title,
    ) {}

    /** @param string|array<string, string> $title */
    public static function make(string $key, string|array $title): self
    {
        return new self($key, LocalizedTextData::from($title));
    }

    /** @param string|array<string, string> $description */
    public function description(string|array $description): self
    {
        $this->description = LocalizedTextData::from($description);

        return $this;
    }

    public function field(FormFieldData|FormFieldBuilder $field): self
    {
        $this->fields[] = $field instanceof FormFieldBuilder ? $field->build() : $field;

        return $this;
    }

    public function build(): FormPageData
    {
        return new FormPageData($this->key, $this->title, $this->fields, $this->description);
    }
}
