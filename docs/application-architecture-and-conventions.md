# Application architecture and conventions

This starter is a Laravel 13, PHP 8.4, Inertia 3, Vue 3, TypeScript, Tailwind 4, PrimeVue, Pest 5 application. It combines the current official Laravel Vue starter (authentication, passkeys, two-factor authentication, settings, dark mode, and Vite Plus) with reusable application boundaries extracted and generalized from Modho.

## Request flow

```text
Route and middleware
  -> Page for an Inertia read, or thin Controller for a command/API adapter
  -> PageProps / Action / Query / DataTable / Data Provider
  -> Eloquent and typed DataObjects
  -> Inertia or JSON
  -> Vue page composition root
  -> tabs, schema forms, DataTable, and shared primitives
```

## Ownership map

- `app/Actions`: persistent operations. Each directory contains a Spatie Data Action, a final invokable Handler typed to that concrete Action, a product-behavior feature, and a test.
- `app/Fortify`: thin framework contract adapters supplied by Laravel's authentication starter. Application-owned persistence delegates from these adapters to `app/Actions/Users`.
- `app/Queries`: reusable non-paginated reads. Queries never persist.
- `app/DataProviders`: searchable/paginated option sources.
- `app/DataTables`: paginated/filterable/sortable collection schemas and queries.
- `app/Forms`: versioned form schema data, builders, normalization, and validation.
- `app/Pages`: typed Inertia page and active-tab composition.
- `app/Support/Data`: recursively serialized object-shaped contracts and Eloquent casts.
- `resources/js/components/forms`: schema rendering.
- `resources/js/components/ui/datatable`: backend-schema DataTable adapter and typed cells.
- `resources/js/components/ui/primitives`: reusable controls with colocated Storybook stories.
- `resources/js/types/generated.ts`: generated PHP-to-TypeScript contract output.
- `specifications/*.md`: validated, developer-oriented technical designs for broad changes.
- colocated `*.feature`: executable product behavior added with its matching Pest tests.

## Choosing a boundary

Use an Action for state change, a Query for one object/summary/aggregate, a DataTable for a paginated collection, and a Data Provider for option lookup. Pages compose reads for Inertia; controllers adapt transport. Services are reserved for focused integrations or reusable algorithms and are not an alternative command/query layer.

The starter intentionally ships without an example business module. Generic registries are empty until an application registers its own Queries, Data Providers, DataTables, Pages, and domain Actions. Account Actions demonstrate the operation structure without introducing sample business data.

## Extension rules

- Object-shaped PHP payloads use DataObjects/PageProps and generated TypeScript.
- Controllers do not validate Action payloads or persist data.
- Server validation and authorization are authoritative.
- Interactive controls use PrimeVue or shared primitives.
- New stable backend component keys must be exhaustively represented in Vue registries.
- Broad work starts with a developer-oriented `specifications/*.md` design and validation before implementation.
- `.feature` scenarios describe observable product behavior rather than technical design, preserve exact Pest description parity, and map to Pest `test()` callers so descriptions render verbatim without an added "it" prefix.
- Scenario titles and all PHP or TypeScript test names state expectations with `should` or `should not` wording.
- Gherkin scenario, Pest description, and step parity is provided by the development dependency `eubentof/gherkish`; no application-owned feature parser is retained.
- `AGENTS.md` and `docs/agents` are normative; this file is the architectural map.

## Verification

Run `just check` in Docker. During development, use focused `just test --filter=...`, `just test-js`, `just types`, and `just build-storybook` commands.
