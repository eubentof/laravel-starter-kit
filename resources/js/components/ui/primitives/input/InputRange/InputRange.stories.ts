import InputRange from './InputRange.vue';

export default { title: 'Primitives/Input/InputRange', component: InputRange };
export const Default = { args: { modelValue: 5, min: 1, max: 10 } };
export const Disabled = { args: { modelValue: 5, disabled: true } };
export const ReadOnly = { args: { modelValue: 5, readonly: true } };
