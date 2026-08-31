import MoneyInput from './MoneyInput.vue';

export default { title: 'Primitives/Input/MoneyInput', component: MoneyInput };
export const Default = { args: { modelValue: 25, currency: 'EUR' } };
export const Disabled = { args: { modelValue: 25, disabled: true } };
export const ReadOnly = { args: { modelValue: 25, readonly: true } };
