import CardSelectionInput from './CardSelectionInput.vue';

const options = [
    { value: 'first', label: 'First card', description: null },
    { value: 'second', label: 'Second card', description: null },
];
export default { title: 'Primitives/Input/CardSelectionInput', component: CardSelectionInput };
export const Default = { args: { modelValue: 'first', options } };
export const Disabled = { args: { modelValue: 'first', options, disabled: true } };
export const ReadOnly = { args: { modelValue: 'first', options, readonly: true } };
