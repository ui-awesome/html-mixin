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
     * @phpstan-var mixed[] $attributes
     */
    protected array $attributes = [];

    /**
     * Sets a single HTML attribute for the element.
     *
     * Usage example:
     * ```php
     * $component->addAttribute('id', 'my-id');
     * $component->addAttribute(DataProperty::ID, 'my-id');
     * $component->addAttribute('size', ButtonSize::SMALL);
     * $component->addAttribute('id', null);
     * ```
     *
     * @param string|UnitEnum $key Attribute name.
     * @param mixed $value Attribute value.
     *
     * @return static New instance with the updated `attributes` value.
     */
    public function addAttribute(string|UnitEnum $key, mixed $value): static
    {
        $new = clone $this;

        AttributeBag::add($new->attributes, $key, $value);

        return $new;
    }

    /**
     * Sets one or more HTML attributes for the element.
     *
     * Usage example:
     * ```php
     * $component->attributes(['id' => 'my-id', 'data-role' => 'button']);
     * $component->attributes(['size' => ButtonSize::LARGE, 'disabled' => true]);
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

        AttributeBag::merge($new->attributes, $values);

        return $new;
    }

    /**
     * Returns the value of a single HTML attribute.
     *
     * Usage example:
     * ```php
     * $component->getAttribute('id', 'default-id');
     * $component->getAttribute(DataProperty::ID, 'default-id');
     * ```
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
     * Usage example:
     * ```php
     * $component->getAttributes();
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
     * $component->removeAttribute('id');
     * $component->removeAttribute(DataProperty::ID);
     * ```
     *
     * @param string|UnitEnum $key Attribute name to remove.
     *
     * @return static New instance without the specified `attribute` value.
     */
    public function removeAttribute(string|UnitEnum $key): static
    {
        $new = clone $this;

        AttributeBag::remove($new->attributes, $key);

        return $new;
    }
}
