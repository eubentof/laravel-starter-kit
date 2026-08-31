import EditorInput from './EditorInput.vue';

export default { title: 'Primitives/Input/EditorInput', component: EditorInput };
export const Default = { args: { modelValue: '<p>Formatted content</p>' } };
export const Disabled = { args: { modelValue: '<p>Disabled</p>', disabled: true } };
export const ReadOnly = { args: { modelValue: '<p>Read only</p>', readonly: true } };
