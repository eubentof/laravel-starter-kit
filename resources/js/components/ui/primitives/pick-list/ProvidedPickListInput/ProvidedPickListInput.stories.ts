import ProvidedPickListInput from './ProvidedPickListInput.vue';

export default { title: 'Primitives/PickList/ProvidedPickListInput', component: ProvidedPickListInput };
export const Default = { args: { modelValue: [], provider: 'examples' } };
export const Disabled = { args: { modelValue: [], provider: 'examples', disabled: true } };
export const ReadOnly = { args: { modelValue: [1], provider: 'examples', readonly: true } };
