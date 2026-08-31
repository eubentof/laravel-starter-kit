import PhoneInput from './PhoneInput.vue';

export default { title: 'Primitives/Input/PhoneInput', component: PhoneInput };
export const Default = { args: { modelValue: '+351 912 345 678' } };
export const Disabled = { args: { modelValue: '+351 912 345 678', disabled: true } };
export const ReadOnly = { args: { modelValue: '+351 912 345 678', readonly: true } };
