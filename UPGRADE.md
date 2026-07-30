# Upgrade Guide

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

`containerTag()`, `prefixTag()`, and `suffixTag()`, together with their getters, now accept `false|UnitEnum` instead
of the interop-specific element interfaces.

```php
enum InlineTag: string
{
    case STRONG = 'strong';
}

$component = $component->prefixTag(InlineTag::STRONG);
```
