import type { FormFieldType } from '@/types/generated';
import SchemaFieldRenderer from './SchemaFieldRenderer.vue';

const field = (type: FormFieldType) => ({
    key: type,
    type,
    label: { translations: { en: type.replaceAll('_', ' ') } },
    description: null,
    required: false,
    options: [],
    provider: null,
    validation: [],
    settings: {},
    disabled: false,
});
const choiceField = (type: FormFieldType) => ({
    ...field(type),
    options: [
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
    ],
});
export default {
    title: 'Forms/SchemaFieldRenderer',
    component: SchemaFieldRenderer,
};
export const Text = { args: { field: field('text'), modelValue: '' } };
export const Email = { args: { field: field('email'), modelValue: '' } };
export const Url = { args: { field: field('url'), modelValue: '' } };
export const RichText = {
    args: { field: field('rich_text'), modelValue: '<p>Formatted content</p>' },
};
export const Textarea = { args: { field: field('textarea'), modelValue: '' } };
export const Number = { args: { field: field('number'), modelValue: 4 } };
export const Money = {
    args: {
        field: { ...field('money'), settings: { currency: 'EUR' } },
        modelValue: 25,
    },
};
export const DateAndTime = {
    args: { field: field('date_time'), modelValue: new Date() },
};
export const Phone = { args: { field: field('phone'), modelValue: '+351' } };
export const Agreement = {
    args: { field: field('agreement'), modelValue: false },
};
export const Checkbox = {
    args: { field: field('checkbox'), modelValue: false },
};
export const Rating = {
    args: {
        field: { ...field('rating'), settings: { stars: 5 } },
        modelValue: 3,
    },
};
export const SingleChoice = {
    args: { field: choiceField('single_choice'), modelValue: null },
};
export const MultipleChoice = {
    args: { field: choiceField('multiple_choice'), modelValue: [] },
};
export const CardSelection = {
    args: { field: choiceField('card_selection'), modelValue: null },
};
export const ChoiceGrid = {
    args: { field: choiceField('choice_grid'), modelValue: [] },
};
export const LinearScale = {
    args: {
        field: { ...field('linear_scale'), settings: { min: 1, max: 10 } },
        modelValue: 5,
    },
};
export const Classification = {
    args: {
        field: { ...field('classification'), settings: { min: 1, max: 5 } },
        modelValue: 2,
    },
};
export const File = { args: { field: field('file'), modelValue: null } };
export const ProvidedSingleSelect = {
    args: {
        field: { ...field('provided_single_select'), provider: 'examples' },
        modelValue: null,
    },
};
export const ProvidedMultipleSelect = {
    args: {
        field: { ...field('provided_multiple_select'), provider: 'examples' },
        modelValue: [],
    },
};
export const ProvidedPickList = {
    args: {
        field: { ...field('provided_pick_list'), provider: 'examples' },
        modelValue: [],
    },
};
export const Invalid = {
    args: {
        field: field('text'),
        modelValue: '',
        error: 'This field is required.',
    },
};
export const ReadOnly = {
    args: { field: field('text'), modelValue: 'Example', readonly: true },
};
