import ProvidedSelectInput from './ProvidedSelectInput.vue';

export default { title: 'Primitives/Select/ProvidedSelectInput', component: ProvidedSelectInput };
export const Single = { args: { modelValue: null, provider: 'examples' } };
export const Multiple = { args: { modelValue: [], provider: 'examples', multiple: true } };
export const Disabled = { args: { modelValue: null, provider: 'examples', disabled: true } };
export const ReadOnly = { args: { modelValue: null, provider: 'examples', readonly: true } };
