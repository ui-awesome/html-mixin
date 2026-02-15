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
     * Sets one or more HTML attributes for the element.
     *
     * Usage example:
     * ```php
     * $component->setAttributes(['id' => 'my-id', 'data-role' => 'button']);
     * $component->setAttributes(['size' => ButtonSize::LARGE, 'disabled' => true]);
     * $component->setAttributes(['aria-label' => 'Close'], 'aria-');
     * ```
     *
     * @param array $values Associative array of attribute keys and values.
     * @param string $prefix Prefix to ensure (for example, `aria-`, `data-`, `on`).
     *
     * @return static New instance with the updated `attributes` value.
     *
     * @phpstan-param mixed[] $values
     */
    public function attributes(array $values, string $prefix = ''): static
    {
        $new = clone $this;

        AttributeBag::setMany($new->attributes, $values, $prefix);

        return $new;
    }

    /**
     * Returns the value of a single HTML attribute.
     *
     * Usage example:
     * ```php
     * $component->getAttribute('id', 'default-id');
     * $component->getAttribute(DataProperty::ID, 'default-id');
     * $component->getAttribute('aria-label', 'Default Label', 'aria-');
     * ```
     *
     * @param string|UnitEnum $key Attribute name.
     * @param mixed $default Default value when the attribute is missing.
     * @param string $prefix Prefix to ensure (for example, `aria-`, `data-`, `on`).
     *
     * @return mixed Attribute value or default.
     */
    public function getAttribute(string|UnitEnum $key, mixed $default = null, string $prefix = ''): mixed
    {
        return AttributeBag::get($this->attributes, $key, $default, $prefix);
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
     * $component->removeAttribute('aria-label', 'aria-');
     * ```
     *
     * @param string|UnitEnum $key Attribute name to remove.
     * @param string $prefix Prefix to ensure (for example, `aria-`, `data-`, `on`).
     *
     * @return static New instance without the specified `attribute` value.
     */
    public function removeAttribute(string|UnitEnum $key, string $prefix = ''): static
    {
        $new = clone $this;

        AttributeBag::remove($new->attributes, $key, $prefix);

        return $new;
    }

    /**
     * Sets a single HTML attribute for the element.
     *
     * Usage example:
     * ```php
     * $component->setAttribute('id', 'my-id');
     * $component->setAttribute(DataProperty::ID, 'my-id');
     * $component->setAttribute('size', ButtonSize::SMALL);
     * $component->setAttribute('id', null);
     * $component->setAttribute('aria-label', 'Close', 'aria-');
     * ```
     *
     * @param string|UnitEnum $key Attribute name.
     * @param mixed $value Attribute value.
     * @param string $prefix Prefix to ensure (for example, `aria-`, `data-`, `on`).
     *
     * @return static New instance with the updated `attributes` value.
     */
    public function setAttribute(string|UnitEnum $key, mixed $value, string $prefix = ''): static
    {
        $new = clone $this;

        AttributeBag::set($new->attributes, $key, $value, $prefix);

        return $new;
    }
}
