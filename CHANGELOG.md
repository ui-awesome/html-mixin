# ChangeLog

## 0.3.3 Under development

- Bug #43: Add section for automated refactoring using `Rector` in testing documentation (@terabytesoftw)

## 0.3.2 January 24, 2026

- Enh #40: Add `php-forge/coding-standard` to development dependencies for code quality checks (@terabytesoftw)
- Bug #41: Remove redundant cURL commands for `ecs.php` and `rector.php` in scripts section of `composer.json` (@terabytesoftw)
- Bug #42: Remove references to `ecs.php` and `rector.php` from development documentation (@terabytesoftw)

## 0.3.1 January 20, 2026

- Bug #38: Remove redundant usage examples from `HasAttributes`, `HasPrefixCollection`, and `HasSuffixCollection` traits for clarity (@terabytesoftw)
- Bug #39: Enhance documentation for `Message` enum to clarify error message templates and formatting usage (@terabytesoftw)

## 0.3.0 January 18, 2026

- Enh #27: Refactor codebase to improve performance (@terabytesoftw)
- Bug #28: Add test for setting attributes with prefix value in `HasAttributes` mixin (@terabytesoftw)
- Enh #29: Add development guide and enhance testing documentation (@terabytesoftw)
- Bug #30: Update `.editorconfig` and `phpunit.xml.dist` for consistency and clarity (@terabytesoftw)
- Bug #31: Update import paths and fix namespace declarations in configuration files (@terabytesoftw)
- Bug #32: Add `NullableTypeDeclarationFixer` to the configuration and update skip rules in `ECS` configuration (@terabytesoftw)
- Enh #33: Add `getAttribute()` method to `HasAttributes` mixin for retrieving attribute values (@terabytesoftw)
- Bug #34: Improve code examples in `README.md` for better readability and clarity (@terabytesoftw)
- Bug #35: Improve `testing.md` for clarity and consistency in Composer script usage (@terabytesoftw)
- Bug #36: Update documentation for various traits and enums to enhance clarity and consistency (@terabytesoftw)
- Bug #37: Update documentation for test classes to enhance clarity and consistency (@terabytesoftw)

- Enh #26: Update `ui-awesome/html-helper` to `0.2` and move `Components` to `ui-awesome/html-core-component` (@terabytesoftw)

## 0.1.2 March 14, 2024

- Enh #4: Add trait `HasFirstItemClass` class (@terabytesoftw)
- Enh #5: Add trait `HasFirstLinkClass` class (@terabytesoftw)
- Enh #6: Add trait `HasLastItemClass` class (@terabytesoftw)
- Enh #7: Add trait `HasLastLinkClass` class (@terabytesoftw)
- Bug #8: Add for overriding classes in `HasLastItemClass`, `HasLastLinkClass`, `HasFirstItemClass` and `HasFirstLinkClass` (@terabytesoftw)
- Bug #9: Update phpdoc `CSS` class assignments (@terabytesoftw)
- Bug #10: Better naming `HasLinkActiveClass` and `HasLinkDisableClass` (@terabytesoftw)
- Enh #11: Add trait `HasLinkItemActiveClass` class (@terabytesoftw)
- Bug #12: Update value default `override` `true` to `false` in `HasLinkItemActiveClass` (@terabytesoftw)
- Enh #13: Add trait `HasLinkItemDisableClass` class (@terabytesoftw)
- Bug #14: Update value default `override` `true` to `false` in `HasLinkActiveClass` and `HasLinkDisableClass` (@terabytesoftw)
- Enh #15: Add trait `HasTemplateItems` class (@terabytesoftw)
- Enh #16: Add trait `HasTemplateLinkItem` class (@terabytesoftw)
- Bug #17: Better naming `HasTemplateItems` to `HasTemplateItem` (@terabytesoftw)
- Bug #18: Add `linkTag()` method in `HasLinkCollection` trait (@terabytesoftw)
- Enh #19: Add trait `HasLinkContainerCollection` class (@terabytesoftw)
- Enh #20: Add trait `HasLinkActiveTag` class (@terabytesoftw)
- Enh #21: Add trait `HasTag` class (@terabytesoftw)
- Enh #22: Add trait `HasLinkAreaCurrent` class (@terabytesoftw)
- Enh #23: Add trait `HasListItemAreaCurrent` class (@terabytesoftw)
- Bug #24: Fix `linkAriaCurrent()` and `listItemAriaCurrent()` methods to accept a boolean value. (@terabytesoftw)
- Bug #25: Fix `phpdoc` for `psalm` (@terabytesoftw)

## 0.1.1 March 9, 2024

- Enh #2: Add traits `components` classes (@terabytesoftw)
- Bug #3: Fix trait `HasListContainerCollection` class and update `README.md` (@terabytesoftw)

## 0.1.0 March 5, 2024

- Initial release
