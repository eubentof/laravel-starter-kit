import { formField } from '../formFieldStories';
import ChoiceGridSchemaField from './ChoiceGridSchemaField.vue';

const field = formField('choice_grid', {
    settings: {
        rows: [{ value: 'quality', label: 'Quality' }],
        columns: [
            { value: 1, label: 'Low' },
            { value: 2, label: 'High' },
        ],
    },
});
export default {
    title: 'Forms/Fields/ChoiceGrid',
    component: ChoiceGridSchemaField,
};
export const Default = { args: { field, modelValue: { quality: 2 } } };
export const Invalid = {
    args: { field, modelValue: {}, error: 'Every row is required.' },
};
export const Disabled = {
    args: { field: { ...field, disabled: true }, modelValue: { quality: 2 } },
};
export const ReadOnly = {
    args: { field, modelValue: { quality: 2 }, readonly: true },
};
