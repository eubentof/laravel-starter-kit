import DateTimeInput from './DateTimeInput.vue';

export default { title: 'Primitives/Input/DateTimeInput', component: DateTimeInput };
export const DateAndTime = { args: { modelValue: '2026-08-31T14:30', mode: 'date_time' } };
export const DateOnly = { args: { modelValue: '2026-08-31', mode: 'date' } };
export const Disabled = { args: { modelValue: '2026-08-31', mode: 'date', disabled: true } };
export const ReadOnly = { args: { modelValue: '2026-08-31', mode: 'date', readonly: true } };
