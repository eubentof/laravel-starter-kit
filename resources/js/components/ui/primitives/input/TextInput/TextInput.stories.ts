import TextInput from './TextInput.vue';

export default { title: 'Primitives/Input/TextInput', component: TextInput };
export const Default = { args: { modelValue: 'Example' } };
export const Multiline = { args: { modelValue: 'Multiple lines', multiline: true } };
export const Disabled = { args: { modelValue: 'Disabled', disabled: true } };
export const ReadOnly = { args: { modelValue: 'Read only', readonly: true } };
