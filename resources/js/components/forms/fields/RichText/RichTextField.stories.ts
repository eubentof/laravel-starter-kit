import { formField } from '../formFieldStories';
import RichTextSchemaField from './RichTextSchemaField.vue';

export default {
    title: 'Forms/Fields/RichText',
    component: RichTextSchemaField,
};
export const Default = {
    args: {
        field: formField('rich_text'),
        modelValue: '<p>Formatted text</p>',
    },
};
export const Invalid = {
    args: { field: formField('rich_text'), modelValue: '', error: 'Required.' },
};
export const Disabled = {
    args: {
        field: formField('rich_text', { disabled: true }),
        modelValue: '<p>Text</p>',
    },
};
export const ReadOnly = {
    args: {
        field: formField('rich_text'),
        modelValue: '<p>Text</p>',
        readonly: true,
    },
};
