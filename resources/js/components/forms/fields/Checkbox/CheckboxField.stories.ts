import { formField } from '../formFieldStories';
import CheckboxSchemaField from './CheckboxSchemaField.vue';

export default {
    title: 'Forms/Fields/Checkbox',
    component: CheckboxSchemaField,
};
export const Default = {
    args: { field: formField('checkbox'), modelValue: false },
};
export const Invalid = {
    args: {
        field: formField('checkbox'),
        modelValue: false,
        error: 'Required.',
    },
};
export const Disabled = {
    args: {
        field: formField('checkbox', { disabled: true }),
        modelValue: true,
    },
};
export const ReadOnly = {
    args: { field: formField('checkbox'), modelValue: true, readonly: true },
};
