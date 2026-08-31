# Form fields and primitives technical specification

## Goal

Bring the reusable form inputs and form-compatible schema field adapters from
`modho-app` into `starter-app`. Assessment-only field types remain outside the
Forms renderer, while their reusable primitives may still support ordinary
form controls.

The result must keep `starter-app` clone-ready and domain-neutral. It ports the
generic interaction and presentation behavior, not Modho product modules or
designer-specific behavior.

## Current state

The backend currently declares and validates 22 field types through
`FormFieldType`, `FormFieldData`, and `FormFieldRegistry`. The frontend currently
renders all of them through one conditional `SchemaFieldRenderer.vue` and only
extracts `ProvidedSelectInput` as a reusable input.

This makes the advertised field catalog renderable, but it does not satisfy the
starter architecture in which primitives own generic interaction and schema
field components are thin adapters with colocated Storybook coverage.

## Scope

### Reusable primitives

Add or adapt the following Modho input families under
`resources/js/components/ui/primitives/`, grouped by input category and by
component name:

| Primitive family                                            | Starter field consumers                                       |
| ----------------------------------------------------------- | ------------------------------------------------------------- |
| `TextInput` and `EditorInput`                               | text, email, URL, textarea, and rich text                     |
| `NumberInput` and `MoneyInput`                              | number and money                                              |
| `PhoneInput`                                                | phone                                                         |
| `DateTimeInput`                                             | date/time                                                     |
| `AgreementInput` and `CheckboxInput`                        | agreement and checkbox                                        |
| `SingleSelectInput`, `MultiSelectInput`, and `ListBoxInput` | static single and multiple choices                            |
| `CardSelectionInput`                                        | card selection                                                |
| `ChoiceGridInput`                                           | choice grid                                                   |
| `InputRange` and `RatingInput`                              | linear scale and classification                               |
| `FileUploadInput`                                           | file                                                          |
| `ProvidedSelectInput` and `ProvidedPickListInput`           | provider-backed single select, multiple select, and pick list |

The existing root-level `ProvidedSelectInput` will move into the same colocated
category structure as the other select primitives. Existing imports will be
updated; no compatibility duplicate will remain.

Each primitive owns its generic value mapping, interaction, accessibility,
disabled state, read-only presentation, and meaningful visible constraints.
PrimeVue remains the control implementation where it supplies the required
behavior.

### Schema field adapters

Replace the field-type conditional template in `SchemaFieldRenderer.vue` with a
form-field component registry. Add a colocated schema field adapter for every
form-compatible declared type:

- `Text`, `Email`, `Url`, `RichText`, and `Textarea`;
- `Number`, `Money`, `DateTime`, and `Phone`;
- `Agreement` and `Checkbox`;
- `SingleChoice`, `MultipleChoice`, `CardSelection`, and `ChoiceGrid`;
- `LinearScale`, `Classification`, and `File`;
- `ProvidedSingleSelect`, `ProvidedMultipleSelect`, and `ProvidedPickList`.

`rating` is treated as assessment-only and does not receive a Forms adapter.
The generic `RatingInput` primitive remains because the form-compatible
classification field composes it. Existing backend enum/normalization support
is retained as compatibility, but the Forms renderer reports the unsupported
type instead of silently falling back to text.

Adapters receive the existing `FormFieldData`, `modelValue`, `error`, and
`readonly` contract. They resolve localized labels/options and translate
generic `settings` into typed primitive props. They do not own reusable control
behavior.

`InputState` remains the common label, description, required-marker, and error
frame. Read-only rendering moves into the relevant primitive instead of using
the current generic comma-joined fallback, so choices, dates, files, booleans,
money, and structured values retain meaningful presentations.

## Field settings and values

The port keeps the existing serialized schema shape. It does not introduce a
second frontend schema model or manually edit generated TypeScript.

The adapters support the settings already implied by the starter catalog:

- money: `currency`, defaulting to `EUR`;
- linear scale and classification: `min` and `max`, with the current defaults;
- date/time: an optional collection `mode`, defaulting to date and time;
- choice grid: optional `rows`, `columns`, and multiple-selection setting, with
  legacy `options` retained as a compatibility fallback;
- file: optional accepted file types;
- card selection: optional presentation settings that can be represented by the
  generic Modho primitive;
- provider-backed fields: the existing `provider` key and shared infinite data
  provider contract.

Where Modho uses a more product-specific or structurally different value shape,
the primitive will be adapted to the starter's existing normalization and
validation contract. A copied component must not silently change persisted
answer shapes.

## Provider-backed fields

All provider-backed adapters use the existing
`useInfiniteFieldDataProvider`. The shared controls retain initial ten-item
loading, incremental loading, server-side search through the starter's existing
`search` query parameter, saved-value hydration, stale-response protection, and
value-keyed deduplication.

`ProvidedPickListInput` presents source and selected collections while using the
same provider state. No second pagination composable or page-prop option list is
introduced.

## Source boundaries and exclusions

The following `modho-app` concerns are explicitly excluded:

- Forms/Assessments designer edit mode and settings editors;
- assessment scoring, targets, profile badges, and evaluation controls;
- organization-specific Users, Recruiters, and Departments adapters/providers;
- Modho form block, page, placement, assignment, and publication models;
- Modho localization enums and product translation keys;
- backend enum, persistence, route, migration, dependency, or generated-type
  changes. The implementation audit identified one missing generic contract:
  structured choice-grid answers require row keys, so normalization and
  validation will support that shape while retaining the existing flat-list
  behavior for legacy schemas without configured rows and columns.

The implementation may copy generic source code where contracts match, but it
must adapt imports, types, styling, and state to the starter rather than copying
the Modho component graph wholesale.

## Storybook and tests

Every primitive and every schema field adapter receives a colocated
`*.stories.ts` file. Stories cover the states that are meaningful for that
component, including default, disabled, read-only, validation/error, empty,
selection-limit, and loading states.

Focused Vitest coverage will verify:

- every form-compatible `FormFieldType` resolves to a registered adapter;
- registry resolution does not fall through to a text input;
- primitives emit the expected starter answer shape;
- disabled and read-only controls do not mutate values;
- choice, grid, range, file, date/time, and provider-backed edge cases;
- provider-backed controls continue to delegate loading and search to the
  existing infinite-provider composable.

Backend tests cover the backward-compatible structured choice-grid
normalization and validation extension. This technical extraction does not add
a product-observable workflow, so it does not require a new `.feature` file.

## Verification

During implementation, run focused Vitest tests for each migrated family and
inspect the generated Storybook index for all primitive and field stories.
Before handoff, run:

1. `just test-js`;
2. `just check-all`;
3. `git diff --check`.

The final review must also confirm that all 21 form-compatible enum values are
registered, the assessment-only rating field is excluded, no raw interactive
HTML control replaces a PrimeVue/shared control, all new components have
colocated stories, generated TypeScript is unchanged unless it was regenerated
from PHP, and unrelated worktree changes remain untouched.

## Acceptance criteria

- All 21 form-compatible starter field types render through explicit registered
  adapters; the assessment-only `rating` type is not registered in Forms.
- Each adapter composes a reusable primitive instead of embedding its control.
- All required Modho-derived primitive families exist in domain-neutral form.
- Provider-backed single, multiple, and pick-list fields share the existing
  infinite provider behavior.
- Read-only and disabled behavior is correct for each value family.
- Every primitive and field adapter has colocated Storybook coverage.
- Focused frontend tests and the complete starter verification commands pass.
