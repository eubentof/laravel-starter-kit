import { choiceOptions, formField } from '../formFieldStories';
import SingleChoiceSchemaField from './SingleChoiceSchemaField.vue';

const field = formField('single_choice', { options: choiceOptions });
export default {
    title: 'Forms/Fields/SingleChoice',
    component: SingleChoiceSchemaField,
};
export const Default = { args: { field, modelValue: 'first' } };
export const Invalid = {
    args: { field, modelValue: null, error: 'Required.' },
};
export const Disabled = {
    args: { field: { ...field, disabled: true }, modelValue: 'first' },
};
export const ReadOnly = {
    args: { field, modelValue: 'first', readonly: true },
};
