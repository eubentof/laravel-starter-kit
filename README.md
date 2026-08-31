# Laravel Inertia Starter

A clone-ready Laravel 13 + Inertia 3 + Vue 3 starter built for typed, specification-first product development. Broad work starts with a developer-oriented Markdown design; executable `.feature` files describe product behavior alongside tests. The starter adds reusable Actions, Queries, Pages, Data Providers, schema-driven Forms, DataTables, PrimeVue primitives, Storybook, generated TypeScript contracts, Docker, and Just recipes.

## Included

- Authentication, profile settings, passkeys, two-factor authentication, dark mode, Tailwind 4, and Vite Plus from the official Laravel Vue starter.
- Spatie Data Actions with handlers, transactions, generators, colocated product-behavior Gherkin, and parity checks.
- Typed Queries, PageProps, Pages/PageTabs, DataObjects, and Eloquent JSON casts.
- Searchable, 10-at-a-time Data Providers with debounced infinite loading and saved-value hydration contracts.
- Versioned localized form schemas, builders, field normalization/validation, reusable field types, and PrimeVue rendering.
- Backend-schema DataTables with pagination, sorting, filters, typed cells, empty states, and a Vue adapter.
- PrimeVue, Pinia, vue-i18n, Vitest, Storybook, Pest, Pennant, Docker Compose, and a comprehensive Justfile.
- Empty registries and generic infrastructure ready for the application's own domain modules.

## Quick start with Docker

Requirements: Docker and [Just](https://just.systems/).

```bash
just setup
just up
```

Open `http://localhost:3000`; Mailpit is at `http://localhost:8026` and Storybook can be started with `just storybook`.

The Docker stack contains PHP 8.4 FPM, Nginx, PostgreSQL 17, Redis 8, Mailpit, Node 24, a queue worker, and the Laravel scheduler. Ports and credentials can be overridden in `.env`.

## Local setup

```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
npm install
npm run build
composer run dev
```

## Starting a feature

Read [AGENTS.md](AGENTS.md), the relevant guide under [docs/agents](docs/agents), and the [specification guide](docs/agents/specifications.md). For broad work, validate a `specifications/*.md` technical design before implementation. The short boundary decision rule is:

- state change: Action;
- single resource/summary/aggregate: Query;
- paginated/filterable collection: DataTable;
- searchable options: Data Provider;
- Inertia response composition: Page;
- schema-defined input: Form.

Generate an Action with:

```bash
php artisan make:action Users/DeactivateUser
```

## Verification

```bash
just check
```

This runs PHP/frontend formatting and static checks, feature parity, Pest, Vitest, the production build, Storybook build, and Docker Compose validation. See [the architecture guide](docs/application-architecture-and-conventions.md) for extension points and conventions.

## Reference credentials

The development seeder creates `developer@example.test` with password `password`. Change or remove it when adapting the starter.

## License

MIT.
