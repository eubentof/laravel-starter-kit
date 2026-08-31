import MultiSelectInput from './MultiSelectInput.vue';

const options = [
    { value: 'first', label: 'First option', description: null },
    { value: 'second', label: 'Second option', description: null },
];
export default { title: 'Primitives/Select/MultiSelectInput', component: MultiSelectInput };
export const Default = { args: { modelValue: ['first'], options } };
export const Disabled = { args: { modelValue: ['first'], options, disabled: true } };
export const ReadOnly = { args: { modelValue: ['first'], options, readonly: true } };
