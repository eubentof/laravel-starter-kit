# Pages and tabs

- An Inertia GET route points to a `Page` subclass. The Page owns authorization, typed PageProps, forms, providers, DataTables, and tabs.
- PageProps extend `PageProps` and are converted to arrays only at the Inertia boundary.
- Register expensive dependencies on the PageTab that consumes them; only the active tab resolves its props.
- The Vue `*Page.vue` file owns the layout, title, breadcrumbs, shared dialogs, and `PageTabs`.
- Each tab has a stable backend key matching its Vue named slot and owns its feature-local content/actions.
- Do not assemble application reads in a GET controller.
