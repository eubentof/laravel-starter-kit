import { choiceOptions, formField } from '../formFieldStories';
import MultipleChoiceSchemaField from './MultipleChoiceSchemaField.vue';

const field = formField('multiple_choice', { options: choiceOptions });
export default {
    title: 'Forms/Fields/MultipleChoice',
    component: MultipleChoiceSchemaField,
};
export const Default = { args: { field, modelValue: ['first'] } };
export const Invalid = { args: { field, modelValue: [], error: 'Required.' } };
export const Disabled = {
    args: { field: { ...field, disabled: true }, modelValue: ['first'] },
};
export const ReadOnly = {
    args: { field, modelValue: ['first'], readonly: true },
};
