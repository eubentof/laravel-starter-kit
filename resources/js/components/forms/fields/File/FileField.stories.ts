import { formField } from '../formFieldStories';
import FileSchemaField from './FileSchemaField.vue';

const field = formField('file', { settings: { accept: '.pdf,.png' } });
export default { title: 'Forms/Fields/File', component: FileSchemaField };
export const Default = { args: { field, modelValue: null } };
export const Invalid = {
    args: { field, modelValue: null, error: 'A file is required.' },
};
export const Disabled = {
    args: { field: { ...field, disabled: true }, modelValue: null },
};
export const ReadOnly = {
    args: { field, modelValue: { name: 'document.pdf' }, readonly: true },
};
