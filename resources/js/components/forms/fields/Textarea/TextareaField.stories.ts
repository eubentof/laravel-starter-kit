import { formField } from '../formFieldStories';
import TextareaSchemaField from './TextareaSchemaField.vue';

export default {
    title: 'Forms/Fields/Textarea',
    component: TextareaSchemaField,
};
export const Default = {
    args: { field: formField('textarea'), modelValue: 'Long answer' },
};
export const Invalid = {
    args: { field: formField('textarea'), modelValue: '', error: 'Required.' },
};
export const Disabled = {
    args: {
        field: formField('textarea', { disabled: true }),
        modelValue: 'Long answer',
    },
};
export const ReadOnly = {
    args: {
        field: formField('textarea'),
        modelValue: 'Long answer',
        readonly: true,
    },
};
