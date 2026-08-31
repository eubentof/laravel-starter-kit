<?php

namespace App\Forms\Builders;

use App\Forms\Data\ChoiceOptionData;
use App\Forms\Data\FormFieldData;
use App\Forms\Data\LocalizedTextData;
use App\Forms\Enums\FormFieldType;

final class FormFieldBuilder
{
    private ?LocalizedTextData $description = null;

    private bool $required = false;

    private bool $disabled = false;

    /** @var list<ChoiceOptionData> */
    private array $options = [];

    /** @var list<string> */
    private array $validation = [];

    /** @var array<string, mixed> */
    private array $settings = [];

    private ?string $provider = null;

    public function __construct(
        private readonly string $key,
        private readonly FormFieldType $type,
        private readonly LocalizedTextData $label,
    ) {}

    /** @param string|array<string, string> $label */
    public static function make(string $key, FormFieldType $type, string|array $label): self
    {
        return new self($key, $type, LocalizedTextData::from($label));
    }

    /** @param string|array<string, string> $description */
    public function description(string|array $description): self
    {
        $this->description = LocalizedTextData::from($description);

        return $this;
    }

    public function required(bool $required = true): self
    {
        $this->required = $required;

        return $this;
    }

    public function disabled(bool $disabled = true): self
    {
        $this->disabled = $disabled;

        return $this;
    }

    /** @param array<string|int, string|array<string, string>> $options */
    public function options(array $options): self
    {
        $this->options = array_values(collect($options)->map(
            fn (string|array $label, string|int $value): ChoiceOptionData => new ChoiceOptionData($value, LocalizedTextData::from($label)),
        )->all());

        return $this;
    }

    public function provider(string $provider): self
    {
        $this->provider = $provider;

        return $this;
    }

    public function rules(string ...$rules): self
    {
        $this->validation = array_values(array_unique([...$this->validation, ...$rules]));

        return $this;
    }

    public function setting(string $key, mixed $value): self
    {
        $this->settings[$key] = $value;

        return $this;
    }

    public function build(): FormFieldData
    {
        return new FormFieldData(
            key: $this->key,
            type: $this->type,
            label: $this->label,
            description: $this->description,
            required: $this->required,
            options: $this->options,
            provider: $this->provider,
            validation: $this->validation,
            settings: $this->settings,
            disabled: $this->disabled,
        );
    }
}
