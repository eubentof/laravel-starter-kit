import { formField } from '../formFieldStories';
import ProvidedSingleSelectSchemaField from './ProvidedSingleSelectSchemaField.vue';

const field = formField('provided_single_select', { provider: 'examples' });
export default {
    title: 'Forms/Fields/ProvidedSingleSelect',
    component: ProvidedSingleSelectSchemaField,
};
export const Default = { args: { field, modelValue: null } };
export const Invalid = {
    args: { field, modelValue: null, error: 'Required.' },
};
export const Disabled = {
    args: { field: { ...field, disabled: true }, modelValue: null },
};
export const ReadOnly = { args: { field, modelValue: null, readonly: true } };
