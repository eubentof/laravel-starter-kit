# Authorization

- Express decisions as operation-specific methods on `User`, such as `canUpdateOwnProfile(): bool` or `canViewDocument(Document $document): bool`.
- Enforce authorization at the Page, Query, Action Handler, Data Provider, or DataTable boundary. UI checks are affordances only.
- Authorize before a state transition or before exposing a protected read model.
- Scope tenant-owned queries before resolving a model. A not-found response is appropriate when existence must not leak.
- Test allowed, denied, and cross-owner/cross-tenant behavior.
