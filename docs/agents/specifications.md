# Specifications

Use two distinct specification layers.

## Developer specification

Write `specifications/<Topic>.md` before implementing broad or ambiguous work. This is the technical design contract and may describe:

- goals, non-goals, and assumptions;
- application-boundary choices such as Action, Query, Page, Data Provider, DataTable, or Form;
- backend and frontend ownership;
- data contracts, persistence, routes, migrations, dependencies, and compatibility;
- authorization and validation placement;
- rollout, deletion, and migration steps;
- the test and verification strategy.

Present this Markdown document for validation before implementation. Revise it when the agreed technical approach changes.

## Product behavior specification

Add `.feature` files while implementing tests. A feature is executable behavior from an actor or product perspective:

- express a product capability or observable rule;
- use Given/When/Then language understood without knowing the code structure;
- avoid class names, framework packages, database implementation, and architectural mechanics unless they are themselves observable requirements;
- colocate an Action or Query feature with its Pest test when appropriate;
- keep every scenario title identical to its matching Pest `test()` description;
- use Pest's `test()` caller, never `it()`, so natural actor-oriented descriptions render exactly as written;
- write every scenario title and test name as an expectation using `should` or `should not` wording;
- document each Gherkin step in the matching Pest test with an exact `@Given`, `@When`, `@Then`, `@And`, or `@But` docblock;
- run `php artisan gherkish:check` to enforce scenario, description, and step parity.

Do not use a `.feature` file as the first technical proposal. Do not put implementation plans in Gherkin merely to satisfy the executable-spec convention.
