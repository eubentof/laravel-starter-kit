# Project specifications

This directory contains developer-oriented technical specifications. For broad changes, write or update a Markdown specification here, validate it, and only then implement it.

Markdown specifications explain design intent: scope, architecture, contracts, dependencies, migrations, risks, and verification. They may name concrete classes and framework mechanisms.

Executable `.feature` files serve a different purpose. They live beside the Action, Query, or test they exercise and describe observable behavior from the product or actor perspective. They are written with the tests and checked by `php artisan gherkish:check`.

See [the specification agent guide](../docs/agents/specifications.md) for the normative workflow.
