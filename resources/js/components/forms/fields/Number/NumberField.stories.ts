import { formField } from '../formFieldStories';
import NumberSchemaField from './NumberSchemaField.vue';

export default { title: 'Forms/Fields/Number', component: NumberSchemaField };
export const Default = { args: { field: formField('number'), modelValue: 42 } };
export const Invalid = {
    args: { field: formField('number'), modelValue: null, error: 'Required.' },
};
export const Disabled = {
    args: { field: formField('number', { disabled: true }), modelValue: 42 },
};
export const ReadOnly = {
    args: { field: formField('number'), modelValue: 42, readonly: true },
};
