import RatingInput from './RatingInput.vue';

export default { title: 'Primitives/Rating/RatingInput', component: RatingInput };
export const Default = { args: { modelValue: 3, stars: 5 } };
export const Disabled = { args: { modelValue: 3, stars: 5, disabled: true } };
export const ReadOnly = { args: { modelValue: 3, stars: 5, readonly: true } };
