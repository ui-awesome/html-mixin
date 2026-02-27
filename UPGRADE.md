# Upgrade Guide

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
