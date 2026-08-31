import AgreementInput from './AgreementInput.vue';

export default { title: 'Primitives/Input/AgreementInput', component: AgreementInput };
export const Default = { args: { modelValue: false, text: 'I agree to the terms.' } };
export const Accepted = { args: { modelValue: true, text: 'I agree to the terms.' } };
export const Disabled = { args: { modelValue: true, text: 'I agree to the terms.', disabled: true } };
export const ReadOnly = { args: { modelValue: true, text: 'I agree to the terms.', readonly: true } };
