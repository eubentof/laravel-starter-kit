import { formField } from '../formFieldStories';
import UrlSchemaField from './UrlSchemaField.vue';

export default { title: 'Forms/Fields/Url', component: UrlSchemaField };
export const Default = {
    args: { field: formField('url'), modelValue: 'https://example.com' },
};
export const Invalid = {
    args: {
        field: formField('url'),
        modelValue: 'invalid',
        error: 'Invalid URL.',
    },
};
export const Disabled = {
    args: {
        field: formField('url', { disabled: true }),
        modelValue: 'https://example.com',
    },
};
export const ReadOnly = {
    args: {
        field: formField('url'),
        modelValue: 'https://example.com',
        readonly: true,
    },
};
