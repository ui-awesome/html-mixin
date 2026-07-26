# Upgrade Guide

## 0.7.0

### Package-local `Exception\Message` enum removed

The `UIAwesome\Html\Mixin\Exception\Message` enum has been removed.

It was never thrown by this package: the `InvalidArgumentException` raised for empty or non-`string` attribute keys
always originates from `ui-awesome/html-helper`, which uses
`UIAwesome\Html\Helper\Exception\Message::KEY_MUST_BE_NON_EMPTY_STRING`.

Code that catches those exceptions is unaffected, because the exception class and the message text are unchanged.
Code that referenced the enum to build or assert the expected message must reference the helper enum instead.

Before:

```php
use UIAwesome\Html\Mixin\Exception\Message;

$this->expectExceptionMessage(Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage());
```

After:

```php
use UIAwesome\Html\Helper\Exception\Message;

$this->expectExceptionMessage(Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage());
```

## 0.6.0

### Attribute replacement

- `HasAttributes::attributes()` now updates existing attributes instead of replacing the full attribute bag.
- Use `replaceAttributes()` when you need to discard previous attributes before applying new ones.

## 0.5.0

### Runtime dependencies

- `ui-awesome/html-interop` is no longer required at runtime by `ui-awesome/html-mixin`.
- If your application uses enums from `ui-awesome/html-interop`, require it directly in your project.

### Tag APIs now use `UnitEnum`

The following APIs now accept `false|UnitEnum`:

- `containerTag()` / `getContainerTag()`
- `prefixTag()` / `getPrefixTag()`
- `suffixTag()` / `getSuffixTag()`

This replaces the interop-specific interface unions (`BlockInterface`, `InlineInterface`, `VoidInterface`).

### Migration example

Before:

```php
use UIAwesome\Html\Interop\Inline;

$component = $component->prefixTag(Inline::STRONG);
```

After (project enum):

```php
enum InlineTag: string
{
    case STRONG = 'strong';
}

$component = $component->prefixTag(InlineTag::STRONG);
```
