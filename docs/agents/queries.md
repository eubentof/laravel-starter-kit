# Queries

Use a Query for a single-resource read, summary, aggregate, or reusable non-paginated read model.

- Queries live under `app/Queries/<Domain>/<QueryName>/` and extend `App\Support\Queries\Query`.
- A Query never persists state and never invokes an Action as a hidden side effect.
- Load the authorization target and invoke a typed `User` capability before returning data.
- Return a typed DataObject/DTO when the result is object-shaped.
- Use a DataTable for paginated/filterable/sortable collections and a Data Provider for option lookup.
- Keep a `.feature` and Pest test beside a Query when its behavior is application-significant. The feature describes observable product behavior; technical query design belongs in `specifications/*.md`.
