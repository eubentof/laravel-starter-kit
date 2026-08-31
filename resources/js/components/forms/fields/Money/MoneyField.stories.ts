import { formField } from '../formFieldStories';
import MoneySchemaField from './MoneySchemaField.vue';

const field = formField('money', { settings: { currency: 'EUR' } });
export default { title: 'Forms/Fields/Money', component: MoneySchemaField };
export const Default = { args: { field, modelValue: 25 } };
export const Invalid = {
    args: { field, modelValue: null, error: 'Required.' },
};
export const Disabled = {
    args: { field: { ...field, disabled: true }, modelValue: 25 },
};
export const ReadOnly = { args: { field, modelValue: 25, readonly: true } };
