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
            FormFieldType::MultipleChoice, FormFieldType::ProvidedMultipleSelect, FormFieldType::ProvidedPickList, FormFieldType::ChoiceGrid => is_array($value) ? array_values($value) : $value,
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
}
