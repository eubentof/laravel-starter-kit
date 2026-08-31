# Forms and fields

Use `FormSchemaData` as the canonical versioned form contract. It owns localized content, pages, fields, confirmation content, normalization, and server validation.

- Backend and frontend registries share stable `FormFieldType` values.
- Build schemas with `FormSchemaBuilder`, `FormPageBuilder`, and `FormFieldBuilder`.
- Server normalization and validation are authoritative; browser constraints mirror them for immediate feedback.
- Provider-backed fields use the Data Provider contract.
- A primitive owns generic interaction/accessibility. A schema field wrapper adapts label, help, errors, disabled/read-only state, and schema settings.
- Add or extend the primitive first. Every primitive and field renderer has colocated Storybook coverage.
- Persist schemas as immutable/versioned JSON when historical submissions must retain their original contract.
