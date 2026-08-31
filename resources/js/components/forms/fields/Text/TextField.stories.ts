import { formField } from '../formFieldStories';
import TextSchemaField from './TextSchemaField.vue';

export default { title: 'Forms/Fields/Text', component: TextSchemaField };
export const Default = {
    args: { field: formField('text'), modelValue: 'Example' },
};
export const Invalid = {
    args: { field: formField('text'), modelValue: '', error: 'Required.' },
};
export const Disabled = {
    args: {
        field: formField('text', { disabled: true }),
        modelValue: 'Example',
    },
};
export const ReadOnly = {
    args: { field: formField('text'), modelValue: 'Example', readonly: true },
};
