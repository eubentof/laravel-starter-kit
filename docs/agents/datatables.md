# DataTables

Use a DataTable for a paginated collection that needs backend-owned columns, sorting, filtering, cells, selection, or row editing.

- Extend `App\DataTables\DataTable`, return `DataTableSchemaData`, and register the stable table name.
- Every visible configurable column must implement matching server-side sort/filter behavior.
- Only accept sort fields and directions declared by the schema.
- Cells serialize stable enum keys; Vue owns component resolution and rendering.
- Provider-backed columns reference a registered Data Provider instead of embedding unbounded options.
- A row mutation invokes an Action. A DataTable must not hide persistence inside its query pipeline.
- Keep schemas domain-neutral at the framework layer; domain cells belong beside their feature.
