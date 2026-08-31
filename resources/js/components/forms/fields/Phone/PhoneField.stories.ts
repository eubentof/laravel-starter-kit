import { formField } from '../formFieldStories';
import PhoneSchemaField from './PhoneSchemaField.vue';

export default { title: 'Forms/Fields/Phone', component: PhoneSchemaField };
export const Default = {
    args: { field: formField('phone'), modelValue: '+351 912 345 678' },
};
export const Invalid = {
    args: { field: formField('phone'), modelValue: '', error: 'Required.' },
};
export const Disabled = {
    args: {
        field: formField('phone', { disabled: true }),
        modelValue: '+351 912 345 678',
    },
};
export const ReadOnly = {
    args: {
        field: formField('phone'),
        modelValue: '+351 912 345 678',
        readonly: true,
    },
};
