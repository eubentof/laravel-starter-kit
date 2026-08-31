import { formField } from '../formFieldStories';
import LinearScaleSchemaField from './LinearScaleSchemaField.vue';

const field = formField('linear_scale', { settings: { min: 1, max: 10 } });
export default {
    title: 'Forms/Fields/LinearScale',
    component: LinearScaleSchemaField,
};
export const Default = { args: { field, modelValue: 5 } };
export const Invalid = {
    args: { field, modelValue: null, error: 'Required.' },
};
export const Disabled = {
    args: { field: { ...field, disabled: true }, modelValue: 5 },
};
export const ReadOnly = { args: { field, modelValue: 5, readonly: true } };
