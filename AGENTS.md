# Project instructions

Read this file and the relevant guide under `docs/agents/` before changing the application.

## Choose the correct application boundary

| Need                                                                        | Use                                            | Do not use                                           |
| --------------------------------------------------------------------------- | ---------------------------------------------- | ---------------------------------------------------- |
| Persist state or trigger a business operation                               | Action plus Handler                            | Controller, Query, Page, or service writing directly |
| Read one resource, summary, aggregate, or reusable non-paginated read model | Query                                          | Action or controller-side query assembly             |
| Read a paginated, sortable, filterable collection                           | DataTable                                      | Query returning a paginator                          |
| Supply searchable or incrementally loaded control options                   | Data Provider                                  | Page props containing an unbounded option list       |
| Compose an Inertia GET response                                             | Page and optional PageTabs                     | A controller containing application reads            |
| Describe and validate schema-driven input                                   | Form schema and field registry                 | A feature-local parallel form abstraction            |
| Share object-shaped PHP data with Vue                                       | DataObject/PageProps plus generated TypeScript | Associative arrays and shadow TypeScript interfaces  |

## Required guides

- Actions and handlers: `docs/agents/actions.md`
- Queries: `docs/agents/queries.md`
- Data providers: `docs/agents/data-providers.md`
- DataTables: `docs/agents/datatables.md`
- Forms and fields: `docs/agents/forms.md`
- Vue components: `docs/agents/components.md`
- Pages and tabs: `docs/agents/pages.md`
- Authorization: `docs/agents/authorizations.md`
- Specifications: `docs/agents/specifications.md`

## Global rules

1. Controllers are HTTP adapters only. They create an Action or Query input, invoke it, and translate its result.
2. Every persisted state change goes through an Action. The Action is a Spatie Laravel Data object and owns input validation.
3. Authorization is enforced at the Action, Query, Page, or DataTable boundary through typed methods on `User`.
4. Generate PHP-to-TypeScript contracts with `composer types`; never edit `resources/js/types/generated.ts` manually.
5. Use PrimeVue, an existing shared primitive, or a shared custom component for interactive controls.
6. Every reusable primitive and schema field renderer must have a colocated `*.stories.ts` file.
7. For broad work, write or update the developer-oriented Markdown specification under `specifications/` first and wait for validation before implementation.
8. Use `.feature` files only for executable behavior written from the product/user perspective. Add them with the tests, not as the initial technical design document.
9. Every behavior-significant Action and Query has a colocated `.feature`, matching Pest description, and exact Gherkish step docblocks. Use Pest's `test()` caller, never `it()`, so descriptions render exactly as written. Every scenario title and test name uses `should` or `should not` wording. Run `php artisan gherkish:check`.
10. Preserve unrelated changes and keep examples neutral and removable.
11. Update `docs/application-architecture-and-conventions.md` when establishing a new project convention.
12. Run focused tests while developing and `just check` before handoff.
