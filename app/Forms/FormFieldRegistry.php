<?php

namespace App\Forms;

use App\Forms\Data\FormFieldData;
use App\Forms\Data\FormSchemaData;
use App\Forms\Enums\FormFieldType;
use Illuminate\Validation\Rule;

final class FormFieldRegistry
{
    public function normalize(FormFieldData $field, mixed $value): mixed
    {
        return match ($field->type) {
            FormFieldType::Number, FormFieldType::LinearScale, FormFieldType::Classification => is_numeric($value) ? $value + 0 : $value,
            FormFieldType::Agreement, FormFieldType::Checkbox => filter_var($value, FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE) ?? $value,
            FormFieldType::ChoiceGrid => $this->normalizeChoiceGrid($field, $value),
            FormFieldType::MultipleChoice, FormFieldType::ProvidedMultipleSelect, FormFieldType::ProvidedPickList => is_array($value) ? array_values($value) : $value,
            FormFieldType::Text, FormFieldType::Email, FormFieldType::Url, FormFieldType::RichText, FormFieldType::Textarea, FormFieldType::DateTime, FormFieldType::Phone => is_string($value) ? trim($value) : $value,
            default => $value,
        };
    }

    /** @return array<string, list<mixed>> */
    public function rules(FormSchemaData $schema): array
    {
        $resolved = [];

        foreach ($schema->fields() as $field) {
            $fieldRules = $field->validation;

            if ($field->required && ! in_array('required', $fieldRules, true)) {
                array_unshift($fieldRules, 'required');
            } elseif (! $field->required && ! in_array('nullable', $fieldRules, true)) {
                array_unshift($fieldRules, 'nullable');
            }

            $defaultRule = match ($field->type) {
                FormFieldType::Text, FormFieldType::Email, FormFieldType::Url, FormFieldType::RichText, FormFieldType::Textarea, FormFieldType::Phone => 'string',
                FormFieldType::Number, FormFieldType::Money, FormFieldType::Rating, FormFieldType::LinearScale, FormFieldType::Classification => 'numeric',
                FormFieldType::DateTime => 'date',
                FormFieldType::File => 'file',
                FormFieldType::MultipleChoice, FormFieldType::ChoiceGrid, FormFieldType::ProvidedMultipleSelect, FormFieldType::ProvidedPickList => 'array',
                default => null,
            };

            if ($defaultRule !== null && ! in_array($defaultRule, $fieldRules, true)) {
                $fieldRules[] = $defaultRule;
            }

            $resolved[$field->key] = $fieldRules;
            if ($field->type === FormFieldType::ChoiceGrid && $this->hasStructuredGrid($field)) {
                $this->addStructuredGridRules($resolved, $field);

                continue;
            }

            $optionValues = array_map(fn ($option) => $option->value, $field->options);
            if ($optionValues !== [] && in_array($field->type, [FormFieldType::SingleChoice, FormFieldType::CardSelection], true)) {
                $resolved[$field->key][] = Rule::in($optionValues);
            }
            if ($optionValues !== [] && in_array($field->type, [FormFieldType::MultipleChoice, FormFieldType::ChoiceGrid], true)) {
                $resolved["{$field->key}.*"] = [Rule::in($optionValues)];
            }
        }

        return $resolved;
    }

    private function normalizeChoiceGrid(FormFieldData $field, mixed $value): mixed
    {
        if (! is_array($value)) {
            return $value;
        }

        if (! $this->hasStructuredGrid($field) || array_is_list($value)) {
            return array_values($value);
        }

        return array_map(
            fn (mixed $rowValue): mixed => is_array($rowValue) ? array_values($rowValue) : $rowValue,
            $value,
        );
    }

    /** @param array<string, list<mixed>> $rules */
    private function addStructuredGridRules(array &$rules, FormFieldData $field): void
    {
        $columns = $this->settingOptionValues($field, 'columns');
        $requiresEveryRow = ($field->settings['requireEveryRow'] ?? false) === true;
        $allowsMultiple = ($field->settings['multiple'] ?? false) === true;

        foreach ($this->settingOptionValues($field, 'rows') as $row) {
            $key = "{$field->key}.{$row}";
            $presenceRule = $requiresEveryRow ? 'required' : 'nullable';

            if ($allowsMultiple) {
                $rules[$key] = [$presenceRule, 'array'];
                $rules["{$key}.*"] = [Rule::in($columns)];
            } else {
                $rules[$key] = [$presenceRule, Rule::in($columns)];
            }
        }
    }

    private function hasStructuredGrid(FormFieldData $field): bool
    {
        return $this->settingOptionValues($field, 'rows') !== []
            && $this->settingOptionValues($field, 'columns') !== [];
    }

    /** @return list<string|int> */
    private function settingOptionValues(FormFieldData $field, string $key): array
    {
        $options = $field->settings[$key] ?? [];
        if (! is_array($options)) {
            return [];
        }

        return array_values(array_filter(array_map(
            static fn (mixed $option): string|int|null => is_array($option)
                && (is_string($option['value'] ?? null) || is_int($option['value'] ?? null))
                    ? $option['value']
                    : null,
            $options,
        ), static fn (mixed $value): bool => $value !== null));
    }
}
