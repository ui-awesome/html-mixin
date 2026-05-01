# Changelog

All notable changes to this project will be documented in this file.

The format is based on Keep a Changelog, and this project adheres to Semantic Versioning.

## 0.6.1 Under development

## 0.6.0 April 30, 2026

- fix: make `HasAttributes::attributes()` update existing attributes and add `replaceAttributes()` for full replacement.
- docs: update `README.md` and feature assets for attribute update and replacement APIs.

## 0.5.0 April 29, 2026

- fix: remove `ui-awesome/html-interop` from runtime dependencies and keep it as a development-only dependency for local tooling and tests.
- feat: update `HasAttributes` to replace attributes with `attributes()`, add single attributes with `addAttribute()`, and remove attributes on `null` values.
- docs: refresh package metadata and feature overview assets for the current mixin surface.

## 0.4.2 February 15, 2026

- feat: add prefixed attribute support to `HasAttributes`, `HasLabelCollection`, `HasPrefixCollection`, and `HasSuffixCollection` through attribute bag methods and corresponding collection methods.

## 0.4.1 February 15, 2026

- test: update attribute tests to assert resolved values directly instead of closures.

## 0.4.0 February 14, 2026

- feat: add prefixed `setAttribute()` APIs to `HasContainerCollection`, `HasLabelCollection`, `HasPrefixCollection`, and `HasSuffixCollection` with related tests.
- refactor: migrate mixin attribute setters and tests to the simplified API.

## 0.3.6 February 14, 2026

- feat: add `HasLabelCollection` mixin for managing label tag and attributes.
- refactor: use `AttributeBag` in `HasAttributes`, `HasContainerCollection`, `HasPrefixCollection`, and `HasSuffixCollection` for consistent attribute handling.
- test: replace enum usage with `BackedInteger` in attribute tests and remove unused enum files.

## 0.3.5 February 9, 2026

- feat: add `HasContainer` mixin for managing container tag and attributes.
- refactor: rename `HasContainer` to `HasContainerCollection` and standardize PHPDoc in `src` and `tests`.

## 0.3.4 January 29, 2026

- chore: update the `ui-awesome/html-interop` requirement from `^0.2` to `^0.3` in `composer.json`.
- test: add coverage for `Closure` and `null` value resolution in `HasAttributes::setAttribute()`.

## 0.3.3 January 28, 2026

- docs: add an automated refactoring section to the testing documentation.
- docs: update testing examples for running Composer scripts with arguments.
- docs: update command syntax in `development.md` and `testing.md` for clarity and consistency.
- chore: remove the redundant ignore rule in `actionlint.yml` and update the Rector command in `composer.json`.

## 0.3.2 January 24, 2026

- chore: add `php-forge/coding-standard` to development dependencies for code quality checks.
- chore: remove redundant cURL commands from the `composer.json` scripts section.
- docs: remove references to `ecs.php` and `rector.php` from development documentation.

## 0.3.1 January 20, 2026

- docs: remove redundant usage examples from `HasAttributes`, `HasPrefixCollection`, and `HasSuffixCollection`.
- docs: clarify `Message` enum error message templates and formatting usage.

## 0.3.0 January 18, 2026

- refactor: improve codebase performance.
- test: add coverage for setting attributes with prefix values in `HasAttributes`.
- docs: add development guide and enhance testing documentation.
- chore: update `.editorconfig` and `phpunit.xml.dist` for consistency and clarity.
- fix: update import paths and namespace declarations in configuration files.
- chore: add `NullableTypeDeclarationFixer` to the configuration and update ECS skip rules.
- feat: add `getAttribute()` to `HasAttributes` for retrieving attribute values.
- docs: improve `README.md` code examples for readability and clarity.
- docs: improve `testing.md` for consistent Composer script usage.
- docs: update documentation for traits and enums.
- docs: update documentation for test classes.
- chore: update `ui-awesome/html-helper` to `0.2` and move components to `ui-awesome/html-core-component`.

## 0.1.2 March 14, 2024

- feat: add `HasFirstItemClass` trait.
- feat: add `HasFirstLinkClass` trait.
- feat: add `HasLastItemClass` trait.
- feat: add `HasLastLinkClass` trait.
- fix: support overriding classes in `HasLastItemClass`, `HasLastLinkClass`, `HasFirstItemClass`, and `HasFirstLinkClass`.
- docs: update PHPDoc for CSS class assignments.
- refactor: rename `HasLinkActiveClass` and `HasLinkDisableClass`.
- feat: add `HasLinkItemActiveClass` trait.
- fix: change the default `override` value from `true` to `false` in `HasLinkItemActiveClass`.
- feat: add `HasLinkItemDisableClass` trait.
- fix: change the default `override` value from `true` to `false` in `HasLinkActiveClass` and `HasLinkDisableClass`.
- feat: add `HasTemplateItems` trait.
- feat: add `HasTemplateLinkItem` trait.
- refactor: rename `HasTemplateItems` to `HasTemplateItem`.
- feat: add `linkTag()` to `HasLinkCollection`.
- feat: add `HasLinkContainerCollection` trait.
- feat: add `HasLinkActiveTag` trait.
- feat: add `HasTag` trait.
- feat: add `HasLinkAreaCurrent` trait.
- feat: add `HasListItemAreaCurrent` trait.
- fix: allow boolean values in `linkAriaCurrent()` and `listItemAriaCurrent()`.
- docs: fix PHPDoc for Psalm.

## 0.1.1 March 9, 2024

- feat: add component traits.
- fix: update `HasListContainerCollection` and `README.md`.

## 0.1.0 March 5, 2024

- feat: initial `ui-awesome/html-mixin` package structure.
