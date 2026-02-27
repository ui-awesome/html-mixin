<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin;

use Stringable;
use UIAwesome\Html\Helper\{AttributeBag, CSSClass};
use UnitEnum;

use function implode;

/**
 * Provides an immutable API for managing suffix element and its attributes.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
trait HasSuffixCollection
{
    /**
     * Suffix content string assigned to the element.
     */
    protected string $suffix = '';

    /**
     * HTML attributes array for the suffix element.
     *
     * @phpstan-var mixed[] $suffixAttributes
     */
    protected array $suffixAttributes = [];

    /**
     * Tag name for the suffix element, or `false` to disable.
     */
    protected false|UnitEnum $suffixTag = false;

    /**
     * Returns the suffix content string assigned to the element.
     *
     * Usage example:
     * ```php
     * $component->getSuffix();
     * ```
     *
     * @return string Suffix content string assigned to the element.
     */
    public function getSuffix(): string
    {
        return $this->suffix;
    }

    /**
     * Returns the value of a single HTML attribute for the suffix element attributes.
     *
     * Usage example:
     * ```php
     * $component->getSuffixAttribute('id', 'default-id');
     * $component->getSuffixAttribute('label', 'default-label', 'aria-');
     * ```
     *
     * @param string|UnitEnum $key Attribute name.
     * @param mixed $default Default value when the attribute is missing.
     * @param string $prefix Prefix to ensure (for example, `aria-`, `data-`, `on`).
     *
     * @return mixed Attribute value or default.
     */
    public function getSuffixAttribute(string|UnitEnum $key, mixed $default = null, string $prefix = ''): mixed
    {
        return AttributeBag::get($this->suffixAttributes, $key, $default, $prefix);
    }

    /**
     * Returns the `array` of HTML attributes for the suffix element.
     *
     * Usage example:
     * ```php
     * $component->getSuffixAttributes();
     * ```
     *
     * @return array Attributes `array` assigned to the suffix element.
     *
     * @phpstan-return mixed[]
     */
    public function getSuffixAttributes(): array
    {
        return $this->suffixAttributes;
    }

    /**
     * Returns the tag name for the suffix element.
     *
     * Usage example:
     * ```php
     * $component->getSuffixTag();
     * ```
     *
     * @return false|UnitEnum Tag name for the suffix element, or `false` to disable.
     */
    public function getSuffixTag(): false|UnitEnum
    {
        return $this->suffixTag;
    }

    /**
     * Sets the suffix content string for the element.
     *
     * Usage example:
     * ```php
     * $component->suffix(' End', ' of ', 'element');
     * ```
     *
     * @param string|Stringable ...$values Suffix content to set for the element.
     *
     * @return static New instance with the updated `suffix` value.
     */
    public function suffix(Stringable|string ...$values): static
    {
        $new = clone $this;
        $new->suffix = implode('', $values);

        return $new;
    }

    /**
     * Sets the HTML attributes for the suffix element.
     *
     * Usage example:
     * ```php
     * $component->suffixAttributes(['id' => 'suffix-id']);
     * $component->suffixAttributes(['label' => 'End'], 'aria-');
     * ```
     *
     * @param array $values Associative array of attribute keys and values.
     * @param string $prefix Prefix to ensure (for example, `aria-`, `data-`, `on`).
     *
     * @return static New instance with the updated `suffixAttributes` value.
     *
     * @phpstan-param mixed[] $values
     */
    public function suffixAttributes(array $values, string $prefix = ''): static
    {
        $new = clone $this;

        AttributeBag::setMany($new->suffixAttributes, $values, $prefix);

        return $new;
    }

    /**
     * Adds a CSS class to the suffix element attributes.
     *
     * Usage example:
     * ```php
     * $component->suffixClass('new-class');
     * $component->suffixClass('override-class', true);
     * ```
     *
     * @param string|Stringable|UnitEnum|null $value CSS class name to add.
     * @param bool $override Whether to override existing class value.
     *
     * @return static New instance with the updated `suffixAttributes` value.
     */
    public function suffixClass(string|Stringable|UnitEnum|null $value, bool $override = false): static
    {
        $new = clone $this;

        CSSClass::add($new->suffixAttributes, $value, $override);

        return $new;
    }

    /**
     * Removes a specific HTML attribute from the suffix element.
     *
     * Usage example:
     * ```php
     * $component->suffixRemoveAttribute('id');
     * $component->suffixRemoveAttribute('label', 'aria-');
     * ```
     *
     * @param string|UnitEnum $key Attribute name to remove.
     * @param string $prefix Prefix to ensure (for example, `aria-`, `data-`, `on`).
     *
     * @return static New instance without the specified suffix attribute.
     */
    public function suffixRemoveAttribute(string|UnitEnum $key, string $prefix = ''): static
    {
        $new = clone $this;

        AttributeBag::remove($new->suffixAttributes, $key, $prefix);

        return $new;
    }

    /**
     * Sets a single HTML attribute for the suffix element.
     *
     * Usage example:
     * ```php
     * $component->suffixSetAttribute('id', 'my-id');
     * $component->suffixSetAttribute('id', null);
     * $component->suffixSetAttribute('label', 'End', 'aria-');
     * ```
     *
     * @param string|UnitEnum $key Attribute name.
     * @param mixed $value Attribute value.
     * @param string $prefix Prefix to ensure (for example, `aria-`, `data-`, `on`).
     *
     * @return static New instance with the updated `suffixAttributes` value.
     */
    public function suffixSetAttribute(string|UnitEnum $key, mixed $value, string $prefix = ''): static
    {
        $new = clone $this;

        AttributeBag::set($new->suffixAttributes, $key, $value, $prefix);

        return $new;
    }

    /**
     * Sets the tag type for the suffix element.
     *
     * Usage example:
     * ```php
     * $component->suffixTag(\UIAwesome\Html\InteropInline::SPAN);
     * $component->suffixTag(false);
     * ```
     *
     * @param false|UnitEnum $value Tag name for the suffix element, or `false` to disable.
     *
     * @return static New instance with the updated `suffixTag` value.
     */
    public function suffixTag(false|UnitEnum $value = false): static
    {
        $new = clone $this;
        $new->suffixTag = $value;

        return $new;
    }
}
