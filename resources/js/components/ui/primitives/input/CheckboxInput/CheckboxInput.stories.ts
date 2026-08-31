import CheckboxInput from './CheckboxInput.vue';

export default { title: 'Primitives/Input/CheckboxInput', component: CheckboxInput };
export const Default = { args: { modelValue: false, ariaLabel: 'Example checkbox' } };
export const Checked = { args: { modelValue: true, ariaLabel: 'Example checkbox' } };
export const Disabled = { args: { modelValue: true, disabled: true } };
export const ReadOnly = { args: { modelValue: true, readonly: true } };
