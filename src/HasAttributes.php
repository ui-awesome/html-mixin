<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin;

use Closure;
use InvalidArgumentException;
use Stringable;
use UIAwesome\Html\Helper\{Attributes, Enum};
use UIAwesome\Html\Mixin\Exception\Message;
use UnitEnum;

use function is_bool;
use function is_string;

/**
 * Provides an immutable API for managing HTML attributes.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Attributes
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
     * Usage example:
     * ```php
     * $component = $component->addAttribute('id', 'my-id');
     * $component = $component->addAttribute(DataProperty::ID, 'my-id');
     * $component = $component->addAttribute('size', ButtonSize::SMALL);
     * $component = $component->addAttribute('id', null);
     * ```
     *
     * @param string|UnitEnum $key Attribute name.
     * @param mixed $value Attribute value.
     *
     * @return static New instance with the updated `attributes` value.
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
     * Usage example:
     * ```php
     * $component = $component->attributes(['id' => 'my-id', 'data-role' => 'button']);
     * $component = $component->attributes(['size' => ButtonSize::LARGE, 'disabled' => true]);
     * ```
     *
     * @param array $values Associative array of attribute keys and values.
     *
     * @return static New instance with the updated `attributes` value.
     *
     * @phpstan-param mixed[] $values
     */
    public function attributes(array $values): static
    {
        $new = clone $this;

        $new->attributes = [...$new->attributes, ...$values];

        return $new;
    }

    /**
     * Returns the value of a single HTML attribute.
     *
     * Usage example:
     * ```php
     * $id = $component->getAttribute('id', 'default-id');
     * $id = $component->getAttribute(DataProperty::ID, 'default-id');
     * ```
     *
     * @param string|UnitEnum $key Attribute name.
     * @param mixed $default Default value when the attribute is missing.
     *
     * @return mixed Attribute value or default.
     */
    public function getAttribute(string|UnitEnum $key, mixed $default = null): mixed
    {
        $normalizedKey = Enum::normalizeValue($key);

        if ($normalizedKey === '' || is_string($normalizedKey) === false) {
            throw new InvalidArgumentException(
                Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage($normalizedKey),
            );
        }

        return $this->attributes[$normalizedKey] ?? $default;
    }

    /**
     * Returns the `array` of HTML attributes for the element.
     *
     * Usage example:
     * ```php
     * $attributes = $component->getAttributes();
     * ```
     *
     * @return array Attributes `array` assigned to the element.
     *
     * @phpstan-return mixed[]
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Removes a specific HTML attribute from the element.
     *
     * Usage example:
     * ```php
     * $component = $component->removeAttribute('id');
     * $component = $component->removeAttribute(DataProperty::ID);
     * ```
     *
     * @param string|UnitEnum $key Attribute name to remove.
     *
     * @return static New instance without the specified `attribute` value.
     */
    public function removeAttribute(string|UnitEnum $key): static
    {
        $normalizedKey = Enum::normalizeValue($key);

        $new = clone $this;

        unset($new->attributes[$normalizedKey]);

        return $new;
    }

    /**
     * Sets a single attribute with prefix handling and value resolution.
     *
     * @param mixed $key Attribute key (without the prefix if a prefix is supplied).
     * @param bool|Closure|float|int|string|Stringable|UnitEnum|null $value Attribute value, or `null` to remove the
     * attribute.
     * @param string $prefix Optional prefix to prepend to the key (for example, 'aria-', 'data-', 'on').
     * @param bool $boolToString Whether to convert boolean values to `true`/`false` strings.
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
