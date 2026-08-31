import { formField } from '../formFieldStories';
import ProvidedPickListSchemaField from './ProvidedPickListSchemaField.vue';

const field = formField('provided_pick_list', { provider: 'examples' });
export default {
    title: 'Forms/Fields/ProvidedPickList',
    component: ProvidedPickListSchemaField,
};
export const Default = { args: { field, modelValue: [] } };
export const Invalid = { args: { field, modelValue: [], error: 'Required.' } };
export const Disabled = {
    args: { field: { ...field, disabled: true }, modelValue: [] },
};
export const ReadOnly = { args: { field, modelValue: [], readonly: true } };
