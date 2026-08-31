import NumberInput from './NumberInput.vue';

export default { title: 'Primitives/Input/NumberInput', component: NumberInput };
export const Default = { args: { modelValue: 42 } };
export const Disabled = { args: { modelValue: 42, disabled: true } };
export const ReadOnly = { args: { modelValue: 42, readonly: true } };
