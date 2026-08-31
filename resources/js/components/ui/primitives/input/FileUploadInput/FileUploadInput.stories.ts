import FileUploadInput from './FileUploadInput.vue';

export default { title: 'Primitives/Input/FileUploadInput', component: FileUploadInput };
export const Default = { args: { modelValue: null, accept: '.pdf,.png' } };
export const Disabled = { args: { modelValue: null, disabled: true } };
export const ReadOnly = { args: { modelValue: { name: 'document.pdf' }, readonly: true } };
