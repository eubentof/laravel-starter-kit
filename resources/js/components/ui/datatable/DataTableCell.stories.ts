import DataTableCell from './DataTableCell.vue';

export default { title: 'DataTable/Cell', component: DataTableCell };
export const Text = { args: { type: 'text', value: 'Reusable value' } };
export const List = { args: { type: 'text_list', value: ['One', 'Two'] } };
export const Empty = { args: { type: 'display', value: null } };
