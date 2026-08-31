import ProvidedSelectInput from './ProvidedSelectInput.vue';

export default { title: 'Primitives/ProvidedSelectInput', component: ProvidedSelectInput };
export const Single = { args: { modelValue: null, provider: 'examples' } };
export const Multiple = { args: { modelValue: [], provider: 'examples', multiple: true } };
