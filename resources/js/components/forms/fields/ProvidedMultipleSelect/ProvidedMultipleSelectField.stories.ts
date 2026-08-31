import { formField } from '../formFieldStories';
import ProvidedMultipleSelectSchemaField from './ProvidedMultipleSelectSchemaField.vue';

const field = formField('provided_multiple_select', { provider: 'examples' });
export default {
    title: 'Forms/Fields/ProvidedMultipleSelect',
    component: ProvidedMultipleSelectSchemaField,
};
export const Default = { args: { field, modelValue: [] } };
export const Invalid = { args: { field, modelValue: [], error: 'Required.' } };
export const Disabled = {
    args: { field: { ...field, disabled: true }, modelValue: [] },
};
export const ReadOnly = { args: { field, modelValue: [], readonly: true } };
