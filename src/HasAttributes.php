<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin;

use Closure;
use InvalidArgumentException;
use Stringable;
use UIAwesome\Html\Helper\{Attributes, Enum};
use UIAwesome\Html\Mixin\Exception\Message;
use UnitEnum;

use function array_merge;
use function is_bool;
use function is_string;

/**
 * Trait for managing global HTML attributes in tag rendering.
 *
 * Provides a standards-compliant, immutable API for setting arbitrary HTML attributes on elements, following the HTML
 * specification for global attributes.
 *
 * Intended for use in components that require dynamic or programmatic manipulation of element attributes, ensuring
 * correct attribute handling, type safety, and value merging.
 *
 * Key features.
 * - Designed for use in tag rendering systems.
 * - Enforces standards-compliant handling of HTML global attributes.
 * - Immutable method for setting or overriding attributes.
 * - Supports merging of multiple attribute arrays for flexible assignment.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Attributes
 * @link https://www.w3.org/TR/html52/dom.html#global-attributes
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
trait HasAttributes
{
    /**
     * HTML attributes array used by the implementing class.
     *
     * @phpstan-var mixed[] $attributes
     */
    protected array $attributes = [];

    /**
     * Sets a single HTML attribute for the element.
     *
     * Creates a new instance with the specified attribute, overriding any existing value for that attribute.
     *
     * @param string|UnitEnum $key  Attribute name.
     * @param mixed $value Attribute value.
     *
     * @return static New instance with the updated attribute.
     *
     * Usage example:
     * ```php
     * // sets a single attribute
     * $element->addAttribute('id', 'my-id');
     *
     * // sets single attribute with an enum key
     * $element->addAttribute(DataProperty::ID, 'my-id');
     *
     * // sets single attribute with an enum value
     * $element->addAttribute('size', ButtonSize::SMALL);
     *
     * // removes attribute
     * $element->addAttribute('id', null);
     * ```
     */
    public function addAttribute(string|UnitEnum $key, mixed $value): static
    {
        $normalizedKey = Enum::normalizeValue($key);

        if ($normalizedKey === '' || is_string($normalizedKey) === false) {
            throw new InvalidArgumentException(
                Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage($normalizedKey),
            );
        }

        if ($value === null) {
            return $this->removeAttribute($normalizedKey);
        }

        $new = clone $this;
        $new->attributes[$normalizedKey] = $value;

        return $new;
    }

    /**
     * Sets one or more HTML attributes for the element.
     *
     * Creates a new instance with the specified attributes, merging them with any existing attributes according to
     * standards-compliant handling of HTML global attributes.
     *
     * @param array $values Associative array of attribute keys and values.
     *
     * @return static New instance with the updated attributes.
     *
     * @phpstan-param mixed[] $values
     *
     * Usage example:
     * ```php
     * // sets multiple attributes
     * $element->attributes(['id' => 'my-id', 'data-role' => 'button']);
     *
     * // sets multiple attributes with an enum value
     * $element->attributes(['size' => ButtonSize::LARGE, 'disabled' => true]);
     * ```
     */
    public function attributes(array $values): static
    {
        $new = clone $this;

        $new->attributes = array_merge($new->attributes, $values);

        return $new;
    }

    /**
     * Returns the array of HTML attributes for the element.
     *
     * @return array Attributes array assigned to the element.
     *
     * @phpstan-return mixed[]
     *
     * Usage example:
     * ```php
     * $attrs = $element->getAttributes();
     * ```
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Removes a specific HTML attribute from the element.
     *
     * Creates a new instance without the specified attribute.
     *
     * @param string|UnitEnum $key Attribute name to remove.
     *
     * @return static New instance without the specified attribute.
     *
     * Usage example:
     * ```php
     * // removes attribute
     * $element->removeAttribute('id');
     *
     * // removes attribute with an enum key
     * $element->removeAttribute(DataProperty::ID);
     * ```
     */
    public function removeAttribute(string|UnitEnum $key): static
    {
        $normalizedKey = Enum::normalizeValue($key);

        $new = clone $this;

        unset($new->attributes[$normalizedKey]);

        return $new;
    }

    /**
     * Internal method to set a single attribute with prefix handling and value resolution.
     *
     * Modifies the current instance by setting or removing the specified attribute, supporting scalar, Closure and
     * UnitEnum values. Handles normalization of keys with prefixes (for example, 'aria-', 'data-', 'on').
     *
     * @param mixed $key Attribute key (without the prefix if a prefix is supplied).
     * @param bool|Closure|float|int|string|Stringable|UnitEnum|null $value Attribute value. Can be `null` to unset the attribute.
     * @param string $prefix Optional prefix to prepend to the key (for example, 'aria-', 'data-', 'on').
     * @param bool $boolToString Whether to convert boolean values to 'true'/'false' strings.
     *
     * @phpstan-param scalar|Stringable|UnitEnum|Closure(): mixed $value
     */
    private function setAttribute(
        mixed $key,
        bool|float|int|string|Closure|Stringable|UnitEnum|null $value,
        string $prefix = '',
        bool $boolToString = false,
    ): void {
        $normalizedKey = Attributes::normalizeKey($key, $prefix);

        if ($value instanceof Closure) {
            $value = $value();
        }

        if ($boolToString && is_bool($value)) {
            $value = $value ? 'true' : 'false';
        }

        if ($value === null) {
            unset($this->attributes[$normalizedKey]);
        } else {
            $this->attributes[$normalizedKey] = $value;
        }
    }
}
