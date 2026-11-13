---
name: ui-awesome-html-mixin
description: Use when working with immutable attributes, content, templates and collection traits in ui-awesome/html-mixin PHP applications. Not for rendering complete elements, sanitizing untrusted HTML, or building Yii widgets, models or asset bundles.
license: BSD-3-Clause
---

# Work with immutable attributes, content, templates and collection traits

## Resolve the actual package

Inspect the installed package path, reference and PHP constraint before choosing an API. Compare Composer installed
metadata, the lockfile and actual source; modified/path repositories
may differ from a published revision. A skill installation does not install runtime dependencies.

Start with the trait the task uses under `src/` and only the related source, tests and guide. Guides may be excluded from
Composer archives: use the installed source or matching-revision repository documentation, not an assumed latest API.
Do not use this package as a substitute for unrelated Yii widgets, database models or frontend asset management.

## Package-specific workflow

- Compose traits in a concrete host class; this package is not an element renderer. Inspect required properties and helper dependencies before mixing traits.

- `HasAttributes::attributes()` updates supplied keys; `replaceAttributes()` replaces the bag. `addAttribute($key, null)` removes a key. Returned clones must be assigned or chained.

- `HasContent::content()` appends encoded text and `html()` appends trusted raw markup. `clearContent()` clears content without resetting other state. Backed enum zero must be preserved; pure enums normalize by name.

- `HasTemplate::template()` replaces the template string on a clone, including an empty string. `getTemplate()` returns the stored value; the host must render or interpolate it. Test replacement and original-instance preservation.

- Collection traits manage labels, containers, prefixes and suffixes with their own merge/null rules. Read the selected trait rather than assuming all collections replace. Verify shallow-clone effects on mutable nested objects.

## Intended behavior that looks like a bug

Do not "fix" these; they are package contracts.

- `content()` encodes every value once, so existing entities are encoded again (`&amp;` becomes `&amp;amp;`) and quotes
  are not escaped.
- `html()` appends its values verbatim; it neither encodes nor sanitizes.
- `attributes()` merges into the existing bag; only `replaceAttributes()` discards keys that are not supplied.
- Prefix/suffix tags and attributes are stored configuration, not automatically rendered wrappers. `HasTemplate` stores a template without interpreting placeholders.
- Every mutator returns a clone and leaves the original instance unchanged.

## Verify the result

Execute focused examples against the inspected package and its actual dependencies. Assert normal, boundary and negative
cases with explicit failures; do not rely on disabled PHP assertions. Preserve supported PHP versions and report missing
runtime/tooling rather than changing constraints to manufacture a pass. Report syntax checks and behavior checks
separately. Do not install dependencies or modify unrelated files without an authorized task.
