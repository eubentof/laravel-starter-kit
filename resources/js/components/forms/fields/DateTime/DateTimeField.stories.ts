import { formField } from '../formFieldStories';
import DateTimeSchemaField from './DateTimeSchemaField.vue';

const field = formField('date_time', { settings: { mode: 'date_time' } });
export default {
    title: 'Forms/Fields/DateTime',
    component: DateTimeSchemaField,
};
export const Default = { args: { field, modelValue: '2026-08-31T14:30' } };
export const Invalid = { args: { field, modelValue: '', error: 'Required.' } };
export const Disabled = {
    args: {
        field: { ...field, disabled: true },
        modelValue: '2026-08-31T14:30',
    },
};
export const ReadOnly = {
    args: { field, modelValue: '2026-08-31T14:30', readonly: true },
};
