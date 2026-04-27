<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin;

use UIAwesome\Html\Helper\AttributeBag;
use UnitEnum;

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
     * @var mixed[]
     */
    protected array $attributes = [];

    /**
     * Adds or updates a single HTML attribute for the element.
     *
     * @param string|UnitEnum $key Attribute name.
     * @param mixed $value Attribute value. Use `null` to remove the attribute.
     *
     * @return static New instance with the updated attributes value.
     */
    public function addAttribute(string|UnitEnum $key, mixed $value): static
    {
        return $this->setAttribute($key, $value);
    }

    /**
     * Replaces all HTML attributes for the element.
     *
     * @param mixed[] $values Associative array of attribute keys and values.
     *
     * @return static New instance with the replaced attributes value.
     */
    public function attributes(array $values): static
    {
        return $this->setAttributes($values);
    }

    /**
     * Returns the value of a single HTML attribute.
     *
     * @param string|UnitEnum $key Attribute name.
     * @param mixed $default Default value when the attribute is missing.
     *
     * @return mixed Attribute value or default.
     */
    public function getAttribute(string|UnitEnum $key, mixed $default = null): mixed
    {
        return AttributeBag::get($this->attributes, $key, $default);
    }

    /**
     * Returns the `array` of HTML attributes for the element.
     *
     * @return mixed[] Attributes array assigned to the element.
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Removes a specific HTML attribute from the element.
     *
     * @param string|UnitEnum $key Attribute name to remove.
     *
     * @return static New instance without the specified attribute value.
     */
    public function removeAttribute(string|UnitEnum $key): static
    {
        $new = clone $this;

        AttributeBag::remove($new->attributes, $key);

        return $new;
    }

    /**
     * Sets a single HTML attribute for internal fluent setters.
     *
     * @param string|UnitEnum $key Attribute name.
     * @param mixed $value Attribute value. Use `null` to remove the attribute.
     * @param string $prefix Prefix to ensure (for example, `aria-`, `data-`, `on`).
     *
     * @return static New instance with the updated attributes value.
     */
    private function setAttribute(string|UnitEnum $key, mixed $value, string $prefix = ''): static
    {
        $new = clone $this;

        AttributeBag::set($new->attributes, $key, $value, $prefix);

        return $new;
    }

    /**
     * Replaces all HTML attributes for internal fluent setters.
     *
     * @param mixed[] $values Associative array of attribute keys and values.
     * @param string $prefix Prefix to ensure (for example, `aria-`, `data-`, `on`).
     *
     * @return static New instance with the replaced attributes value.
     */
    private function setAttributes(array $values, string $prefix = ''): static
    {
        $new = clone $this;

        AttributeBag::replace($new->attributes, $values, $prefix);

        return $new;
    }
}
