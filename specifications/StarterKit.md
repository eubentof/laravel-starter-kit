# Starter kit technical specification

## Goal

Provide a clone-ready Laravel/Inertia foundation containing generic infrastructure and examples that can be reused without carrying product-specific Modho behavior.

## Platform

- Laravel 13 and PHP 8.4.
- Inertia 3, Vue 3, TypeScript, Tailwind 4, PrimeVue, Pinia, and vue-i18n.
- Pest, PHPStan, Vitest, Storybook, Docker Compose, and Just.
- Gherkish validates that product scenarios, Pest descriptions, and Given/When/Then step documentation remain synchronized.

## Application boundaries

- Persistent operations use immutable Spatie Data Actions with dedicated transactional Handlers.
- Reusable non-paginated reads use Queries.
- Inertia responses use Pages, typed PageProps, and optional PageTabs.
- Paginated, filterable collections use registered backend DataTables.
- Searchable control options use registered Data Providers and the shared infinite-loading composable.
- Schema-driven input uses versioned Form data, builders, a backend field registry, and frontend renderers.
- Object-shaped PHP contracts generate the authoritative frontend TypeScript types.

The decision table and normative rules live in `AGENTS.md` and `docs/agents/`.

## Reusable UI

- Interactive controls prefer PrimeVue or shared primitives.
- Reusable primitives and schema field adapters include colocated Storybook stories.
- The generic field catalog covers text, email, URL, rich text, textarea, number, money, date/time, phone, agreement, checkbox, rating, choices, card selection, choice grid, linear scale, classification, file, and provider-backed selections.
- DataTables support server pagination, sorting and filtering plus reusable cells, loading, empty state, selection, pinning, layouts, and row updates.

## Business-module neutrality

The starter contains no example business module, records, routes, navigation, or seed data. Generic registries start empty. Account persistence Actions demonstrate the operation convention without imposing a sample domain on a cloned application.

## Development environment

Docker Compose supplies PHP-FPM, Nginx, PostgreSQL, Redis, Node, Mailpit, a queue worker, and the scheduler. The Node development image also contains PHP and shares Composer dependencies because Vite integrations such as Wayfinder execute Artisan while starting or building. The Justfile is the stable interface for setup, lifecycle, migrations, seeds, tests, formatting, generated types, builds, queues, and cache clearing.

## Specification workflow

Technical proposals are Markdown documents in this directory and are validated before implementation. Executable `.feature` files are added later with tests and describe product-observable behavior rather than internal architecture.

The `just gherkish` and aggregate `just check` recipes run the installed `eubentof/gherkish` command. The starter retains no parallel application-owned feature parser. Until an upstream release declares Laravel 13 compatibility, Composer uses the official 1.1.0 distribution with a local metadata compatibility declaration for Illuminate 13; the package code itself remains unmodified.

## Verification

Pest tests use `test()` so their descriptions are rendered exactly as written; `it()` is not used because it prepends "it" to natural actor-oriented scenario names. All test descriptions and product scenario titles use affirmative `should` or negative `should not` wording. Colocated Action and Query scenario titles remain exactly identical to their matching Pest descriptions.

The complete `just check` command runs its checks in isolated one-off Docker containers without starting the application stack or publishing host ports. It covers PHP and frontend formatting, PHPStan, feature-to-test parity, Vue type checking, production and Storybook builds, and Docker Compose configuration. Pest and Vitest remain explicit `just test` and `just test-js` commands and are intentionally not dependencies of `just check`.
