# Data providers

Use a Data Provider when a form field, filter, or selector needs options that may be searched, paged, or hydrated from saved values.

- Extend `FieldDataProvider`, declare a stable `key()`, and register the class in `AppServiceProvider`.
- Return `FieldOptionData` objects with stable values and user-facing labels.
- Implement initial loading, server search, pagination, `hasMore`, and resolution of existing values.
- Scope protected options to the authenticated user or tenant.
- The frontend canonical behavior is 10 initial results, scroll pagination, 300 ms search debounce, stale-response protection, and value-keyed deduplication.
- Do not serialize large option collections in Page props.
