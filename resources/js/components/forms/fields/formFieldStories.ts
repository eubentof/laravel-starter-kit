import type { FormFieldData, FormFieldType } from '@/types/generated';

export const formField = (
    type: FormFieldType,
    overrides: Partial<FormFieldData> = {},
): FormFieldData => ({
    key: type,
    type,
    label: { translations: { en: type.replaceAll('_', ' ') } },
    description: { translations: { en: 'Example field description.' } },
    required: false,
    options: [],
    provider: null,
    validation: [],
    settings: {},
    disabled: false,
    ...overrides,
});

export const choiceOptions = [
    {
        value: 'first',
        label: { translations: { en: 'First option' } },
        description: null,
    },
    {
        value: 'second',
        label: { translations: { en: 'Second option' } },
        description: null,
    },
];
