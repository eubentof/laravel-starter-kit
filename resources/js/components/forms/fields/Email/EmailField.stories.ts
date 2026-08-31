import { formField } from '../formFieldStories';
import EmailSchemaField from './EmailSchemaField.vue';

export default { title: 'Forms/Fields/Email', component: EmailSchemaField };
export const Default = {
    args: { field: formField('email'), modelValue: 'person@example.com' },
};
export const Invalid = {
    args: {
        field: formField('email'),
        modelValue: 'invalid',
        error: 'Invalid email.',
    },
};
export const Disabled = {
    args: {
        field: formField('email', { disabled: true }),
        modelValue: 'person@example.com',
    },
};
export const ReadOnly = {
    args: {
        field: formField('email'),
        modelValue: 'person@example.com',
        readonly: true,
    },
};
