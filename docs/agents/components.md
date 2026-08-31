# Vue components

- Prefer PrimeVue, an existing shared primitive, or an existing custom control. Do not introduce a raw interactive HTML control when a shared control fits.
- Put reusable controls under `resources/js/components/ui/primitives` and schema adapters under `resources/js/components/forms/fields`.
- Every primitive and form field renderer has a colocated `*.stories.ts` covering default, disabled, error, and read-only states where meaningful.
- Keep pages as composition roots and move reusable state into composables.
- Props and emits are typed. Use the generated backend contracts rather than parallel local interfaces.
- Verify with focused Vitest tests, `npm run types:check`, the production build, and the Storybook build.
