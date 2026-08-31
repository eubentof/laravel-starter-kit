import { formField } from '../formFieldStories';
import ClassificationSchemaField from './ClassificationSchemaField.vue';

const field = formField('classification', { settings: { min: 1, max: 5 } });
export default {
    title: 'Forms/Fields/Classification',
    component: ClassificationSchemaField,
};
export const Default = { args: { field, modelValue: 3 } };
export const Invalid = {
    args: { field, modelValue: null, error: 'Required.' },
};
export const Disabled = {
    args: { field: { ...field, disabled: true }, modelValue: 3 },
};
export const ReadOnly = { args: { field, modelValue: 3, readonly: true } };
