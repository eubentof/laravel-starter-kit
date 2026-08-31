# Actions

Use an Action for every operation that creates, updates, deletes, publishes, sends, imports, or otherwise persists application state.

Each operation owns a directory:

```text
app/Actions/<Domain>/<ActionName>/
├── <ActionName>.php
├── <ActionName>Handler.php
├── <ActionName>.feature
└── <ActionName>Test.php
```

- The Action extends `App\Support\Actions\Action`, is marked with `#[HandledBy]`, uses promoted `public readonly` constructor properties, and defines explicit `fromArray()` mapping with named arguments.
- Validation comes from Spatie Laravel Data types and validation attributes. Do not validate the same payload in a controller or Form Request.
- The Handler is a final invokable class. Authenticated handlers declare `public function __invoke(User $executor, ConcreteAction $action)`; guest handlers declare `public function __invoke(ConcreteAction $action)`. Type the concrete Action directly and never add an `instanceof` guard.
- The shared Action runner validates and wraps the handler invocation in a database transaction. The Handler authorizes first, then performs one focused state transition.
- Nested Actions receive the same executor. Queue an Action with `dispatch($executor)` when work is asynchronous.
- A genuinely guest operation uses a Handler derived from `GuestActionHandler` and calls `executeAsGuest()`. Do not invent a placeholder User to satisfy an authenticated Action.
- Controllers only combine untrusted request values with trusted route values, execute the Action, and return an HTTP response.
- For a broad operation, describe the technical design in the relevant `specifications/*.md` document and get it validated before implementation.
- Keep the colocated `.feature` product-oriented: describe what the actor can do and observe, not which PHP class, package, or validation mechanism implements it. Scenario titles and matching test descriptions must use `should` or `should not` wording. Use Pest's `test()` caller so actor-oriented descriptions render verbatim; never use `it()`.
- Run `php artisan make:action Domain/ActionName` and `php artisan gherkish:check`.
