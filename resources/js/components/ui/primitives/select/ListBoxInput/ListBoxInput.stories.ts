import ListBoxInput from './ListBoxInput.vue';

const options = [
    { value: 'first', label: 'First option', description: null },
    { value: 'second', label: 'Second option', description: null },
];
export default { title: 'Primitives/Select/ListBoxInput', component: ListBoxInput };
export const Default = { args: { modelValue: 'first', options } };
export const Multiple = { args: { modelValue: ['first'], options, multiple: true } };
export const Disabled = { args: { modelValue: 'first', options, disabled: true } };
export const ReadOnly = { args: { modelValue: 'first', options, readonly: true } };
