import { choiceOptions, formField } from '../formFieldStories';
import CardSelectionSchemaField from './CardSelectionSchemaField.vue';

const field = formField('card_selection', { options: choiceOptions });
export default {
    title: 'Forms/Fields/CardSelection',
    component: CardSelectionSchemaField,
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
