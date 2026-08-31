import { formField } from '../formFieldStories';
import AgreementSchemaField from './AgreementSchemaField.vue';

const field = formField('agreement', {
    settings: { agreementText: 'I agree to the terms.' },
});
export default {
    title: 'Forms/Fields/Agreement',
    component: AgreementSchemaField,
};
export const Default = { args: { field, modelValue: false } };
export const Invalid = {
    args: { field, modelValue: false, error: 'Agreement is required.' },
};
export const Disabled = {
    args: { field: { ...field, disabled: true }, modelValue: true },
};
export const ReadOnly = { args: { field, modelValue: true, readonly: true } };
