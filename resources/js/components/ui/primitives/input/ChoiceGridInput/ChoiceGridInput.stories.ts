import ChoiceGridInput from './ChoiceGridInput.vue';

const rows = [
    { value: 'quality', label: 'Quality', description: null },
    { value: 'speed', label: 'Speed', description: null },
];
const columns = [
    { value: 1, label: 'Low', description: null },
    { value: 2, label: 'High', description: null },
];
export default { title: 'Primitives/Input/ChoiceGridInput', component: ChoiceGridInput };
export const Default = { args: { modelValue: { quality: 2 }, rows, columns } };
export const Multiple = { args: { modelValue: { quality: [1, 2] }, rows, columns, multiple: true } };
export const Disabled = { args: { modelValue: { quality: 2 }, rows, columns, disabled: true } };
export const ReadOnly = { args: { modelValue: { quality: 2 }, rows, columns, readonly: true } };
