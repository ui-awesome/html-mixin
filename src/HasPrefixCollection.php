<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin;

use Stringable;
use UIAwesome\Html\Helper\{AttributeBag, CSSClass};
use UnitEnum;

use function implode;

/**
 * Provides an immutable API for managing prefix element and its attributes.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
trait HasPrefixCollection
{
    /**
     * Prefix content string assigned to the element.
     */
    protected string $prefix = '';

    /**
     * HTML attributes array for the prefix element.
     *
     * @phpstan-var mixed[] $prefixAttributes
     */
    protected array $prefixAttributes = [];

    /**
     * Tag name for the prefix element, or `false` to disable.
     */
    protected false|UnitEnum $prefixTag = false;

    /**
     * Returns the prefix content string assigned to the element.
     *
     * Usage example:
     * ```php
     * $component->getPrefix();
     * ```
     *
     * @return string Prefix content string assigned to the element.
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * Returns the value of a single HTML attribute for the prefix element attributes.
     *
     * Usage example:
     * ```php
     * $component->getPrefixAttribute('id', 'default-id');
     * $component->getPrefixAttribute('label', 'default-label', 'aria-');
     * ```
     *
     * @param string|UnitEnum $key Attribute name.
     * @param mixed $default Default value when the attribute is missing.
     * @param string $prefix Prefix to ensure (for example, `aria-`, `data-`, `on`).
     *
     * @return mixed Attribute value or default.
     */
    public function getPrefixAttribute(string|UnitEnum $key, mixed $default = null, string $prefix = ''): mixed
    {
        return AttributeBag::get($this->prefixAttributes, $key, $default, $prefix);
    }

    /**
     * Returns the `array` of HTML attributes for the prefix element.
     *
     * Usage example:
     * ```php
     * $component->getPrefixAttributes();
     * ```
     *
     * @return array Attributes `array` assigned to the prefix element.
     *
     * @phpstan-return mixed[]
     */
    public function getPrefixAttributes(): array
    {
        return $this->prefixAttributes;
    }

    /**
     * Returns the tag name for the prefix element.
     *
     * Usage example:
     * ```php
     * $component->getPrefixTag();
     * ```
     *
     * @return false|UnitEnum Tag name for the prefix element, or `false` to disable.
     */
    public function getPrefixTag(): false|UnitEnum
    {
        return $this->prefixTag;
    }

    /**
     * Sets the prefix content string for the element.
     *
     * Usage example:
     * ```php
     * $component->prefix('Start ', 'of ', 'element');
     * ```
     *
     * @param string|Stringable ...$values Prefix content to set for the element.
     *
     * @return static New instance with the updated `prefix` value.
     */
    public function prefix(string|Stringable ...$values): static
    {
        $new = clone $this;
        $new->prefix = implode('', $values);

        return $new;
    }

    /**
     * Sets the HTML attributes for the prefix element.
     *
     * Usage example:
     * ```php
     * $component->prefixAttributes(['id' => 'prefix-id']);
     * $component->prefixAttributes(['label' => 'Start'], 'aria-');
     * ```
     *
     * @param array $values Associative array of attribute keys and values.
     * @param string $prefix Prefix to ensure (for example, `aria-`, `data-`, `on`).
     *
     * @return static New instance with the updated `prefixAttributes` value.
     *
     * @phpstan-param mixed[] $values
     */
    public function prefixAttributes(array $values, string $prefix = ''): static
    {
        $new = clone $this;

        AttributeBag::setMany($new->prefixAttributes, $values, $prefix);

        return $new;
    }

    /**
     * Adds a CSS class to the prefix element attributes.
     *
     * Usage example:
     * ```php
     * $component->prefixClass('new-class');
     * $component->prefixClass('override-class', true);
     * ```
     *
     * @param string|Stringable|UnitEnum|null $value CSS class name to add.
     * @param bool $override Whether to override existing class value.
     *
     * @return static New instance with the updated `prefixAttributes` value.
     */
    public function prefixClass(string|Stringable|UnitEnum|null $value, bool $override = false): static
    {
        $new = clone $this;

        CSSClass::add($new->prefixAttributes, $value, $override);

        return $new;
    }

    /**
     * Removes a specific HTML attribute from the prefix element.
     *
     * Usage example:
     * ```php
     * $component->prefixRemoveAttribute('id');
     * $component->prefixRemoveAttribute('label', 'aria-');
     * ```
     *
     * @param string|UnitEnum $key Attribute name to remove.
     * @param string $prefix Prefix to ensure (for example, `aria-`, `data-`, `on`).
     *
     * @return static New instance without the specified prefix attribute.
     */
    public function prefixRemoveAttribute(string|UnitEnum $key, string $prefix = ''): static
    {
        $new = clone $this;

        AttributeBag::remove($new->prefixAttributes, $key, $prefix);

        return $new;
    }

    /**
     * Sets a single HTML attribute for the prefix element.
     *
     * Usage example:
     * ```php
     * $component->prefixSetAttribute('id', 'my-id');
     * $component->prefixSetAttribute('id', null);
     * $component->prefixSetAttribute('label', 'Start', 'aria-');
     * ```
     *
     * @param string|UnitEnum $key Attribute name.
     * @param mixed $value Attribute value.
     * @param string $prefix Prefix to ensure (for example, `aria-`, `data-`, `on`).
     *
     * @return static New instance with the updated `prefixAttributes` value.
     */
    public function prefixSetAttribute(string|UnitEnum $key, mixed $value, string $prefix = ''): static
    {
        $new = clone $this;

        AttributeBag::set($new->prefixAttributes, $key, $value, $prefix);

        return $new;
    }

    /**
     * Sets the tag name for the prefix element.
     *
     * Usage example:
     * ```php
     * $component->prefixTag(\UIAwesome\Html\Interop\Inline::SPAN);
     * $component->prefixTag(false);
     * ```
     *
     * @param false|UnitEnum $value Tag name for the prefix element, or `false` to disable.
     *
     * @return static New instance with the updated `prefixTag` value.
     */
    public function prefixTag(false|UnitEnum $value = false): static
    {
        $new = clone $this;
        $new->prefixTag = $value;

        return $new;
    }
}
