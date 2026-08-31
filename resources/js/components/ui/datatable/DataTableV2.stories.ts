import DataTableV2 from './DataTableV2.vue';

export default { title: 'DataTable/DataTableV2', component: DataTableV2 };
export const Records = { args: { schema: { name: 'records', rowKey: 'id', perPage: 10, defaultSortField: 'id', defaultSortDirection: 'desc', emptyTitle: 'No records yet', emptyDescription: 'Create the first record.', columns: [{ field: 'name', label: 'Name', cell: 'text', filter: 'text', sortable: true, editable: false, visible: true, pinned: false, provider: null }] } } };
