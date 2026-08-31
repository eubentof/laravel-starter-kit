# Action-backed authentication persistence technical specification

## Goal

Keep Laravel Fortify and Laravel Passkeys as the authentication infrastructure while making application-owned persistence explicit and consistent with the starter's Action boundaries.

## Scope

Retain email/password registration, login, logout, password reset, email verification, password confirmation, profile management, password changes, account deletion, passkeys, and two-factor authentication.

Retain Fortify's service provider, configuration, contracts, model traits, routes, UI, and tests. Fortify remains responsible for authentication protocols and session/security infrastructure; application code remains responsible for its persistence boundaries.

## Boundary design

Application-owned persisted account mutations will use dedicated directories under `app/Actions/Users`:

- register a user;
- reset a forgotten password;
- mark an email as verified;
- update profile information;
- update the current password;
- delete the account.

Each operation will use the shared Spatie Data Action, `#[HandledBy]`, a dedicated Handler, Action-owned validation, authorization at the start of authenticated handlers, and transactional execution. Guest-safe Actions explicitly permit execution without an authenticated actor. HTTP controllers and the application-level Fortify contract adapters will only map input into Actions and translate results.

Handlers are invokable classes. An authenticated handler declares `public function __invoke(User $executor, ConcreteAction $action)`, while a guest handler declares `public function __invoke(ConcreteAction $action)`. The concrete Action parameter is the handler contract: handlers do not accept the abstract `Action` type and do not perform runtime `instanceof` narrowing. The shared Action runner validates the Action and wraps the handler invocation in a database transaction.

Login, logout, password confirmation, password-reset email delivery, verification-notification delivery, passkeys, and two-factor authentication remain focused Fortify/Laravel infrastructure. Application-owned adapters must not directly persist the User model.

## Frontend

Keep the existing Inertia pages and settings components, including passkeys and two-factor controls. Regenerate Wayfinder routes and TypeScript contracts after controller changes.

## Tests and product features

Add product-perspective `.feature` scenarios alongside the new Actions and authentication tests during implementation. They will describe what guests and users can do and observe, without naming Fortify, Spatie, handlers, or internal directory structure.

Test registration, login/logout, throttling, password reset, signed email verification, resend behavior, password confirmation, profile changes, password changes, account deletion, authorization, and invalid input. Add an architecture check preventing persisted account writes in controllers.

## Verification

- Confirm Fortify and passkey flows remain installed and covered.
- Confirm application-owned user persistence occurs through Actions.
- Regenerate routes and TypeScript contracts.
- Run feature parity, PHPStan, Pint, Pest, frontend lint/type checks, Vitest, production build, Storybook build, migrations, and Docker checks.
