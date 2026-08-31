import InputState from './InputState.vue';

export default { title: 'Primitives/InputState', component: InputState };
export const Default = { args: { label: 'Display name', description: 'A reusable field frame.', required: true } };
export const Invalid = { args: { label: 'Display name', error: 'The display name is required.' } };
