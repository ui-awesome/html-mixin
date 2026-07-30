# Upgrade Guide

## 0.8.0

### Label suppression flag

`HasLabelCollection::notLabel()` now accepts an explicit flag, so `notLabel(false)` re-enables a suppressed label.
Calls without an argument keep disabling the label, and `isLabel()` behaves the same for every existing sequence.

The internal `notLabel` property default changed from `false` to `null` to distinguish an unset flag from an explicit
`false`. Classes using the trait that read the property directly must treat `null` as "not configured":

```php
// Before
if ($this->notLabel === false) {
    // render the label
}

// After
if ($this->notLabel !== true) {
    // render the label
}
```

## 0.7.0

### Exception message enum

`UIAwesome\Html\Mixin\Exception\Message` was removed. Code that builds or asserts the non-empty attribute key message
must use the helper enum:

```php
// Before
use UIAwesome\Html\Mixin\Exception\Message;

// After
use UIAwesome\Html\Helper\Exception\Message;
```

The thrown exception class and message text are unchanged.

## 0.6.0

### Attribute replacement

`HasAttributes::attributes()` now updates the existing attribute bag. Use `replaceAttributes()` to discard all
previous attributes.

## 0.5.0

### Enum-backed tag APIs

`containerTag()`, `prefixTag()`, and `suffixTag()` now accept `false|UnitEnum`; their getters return
`false|UnitEnum` instead of the interop-specific element interfaces.

Applications that continue using `UIAwesome\Html\Interop` enums must require `ui-awesome/html-interop` directly,
because it is no longer a runtime dependency.

```php
enum InlineTag: string
{
    case STRONG = 'strong';
}

$component = $component->prefixTag(InlineTag::STRONG);
```
