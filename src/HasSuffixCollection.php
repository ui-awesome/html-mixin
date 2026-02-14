<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin;

use Closure;
use Stringable;
use UIAwesome\Html\Helper\{AttributeBag, CSSClass};
use UIAwesome\Html\Interop\{BlockInterface, InlineInterface, VoidInterface};
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
    protected false|BlockInterface|InlineInterface|VoidInterface $suffixTag = false;

    /**
     * Sets a single HTML attribute for the suffix element.
     *
     * Usage example:
     * ```php
     * $component->addSuffixAttribute('id', 'my-id');
     * $component->addSuffixAttribute('id', null);
     * ```
     *
     * @param string|UnitEnum $key Attribute name.
     * @param mixed $value Attribute value.
     *
     * @return static New instance with the updated `suffixAttributes` value.
     */
    public function addSuffixAttribute(string|UnitEnum $key, mixed $value): static
    {
        $new = clone $this;

        AttributeBag::add($new->suffixAttributes, $key, $value);

        return $new;
    }

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
     * ```
     *
     * @param string|UnitEnum $key Attribute name.
     * @param mixed $default Default value when the attribute is missing.
     *
     * @return mixed Attribute value or default.
     */
    public function getSuffixAttribute(string|UnitEnum $key, mixed $default = null): mixed
    {
        return AttributeBag::get($this->suffixAttributes, $key, $default);
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
     * @return BlockInterface|false|InlineInterface|VoidInterface Tag name for the suffix element, or `false` to
     * disable.
     */
    public function getSuffixTag(): BlockInterface|false|InlineInterface|VoidInterface
    {
        return $this->suffixTag;
    }

    /**
     * Removes a specific HTML attribute from the suffix element.
     *
     * Usage example:
     * ```php
     * $component->removeSuffixAttribute('id');
     * ```
     *
     * @param string|UnitEnum $key Attribute name to remove.
     *
     * @return static New instance without the specified suffix attribute.
     */
    public function removeSuffixAttribute(string|UnitEnum $key): static
    {
        $new = clone $this;

        AttributeBag::remove($new->suffixAttributes, $key);

        return $new;
    }

    /**
     * Sets a single attribute with prefix handling and value resolution for the suffix element.
     *
     * Usage example:
     * ```php
     * $component->setSuffixAttribute('label', 'Label', 'aria-');
     * $component->setSuffixAttribute('hidden', true, 'aria-', true);
     * ```
     *
     * @param string|UnitEnum $key Attribute key without prefix.
     * @param bool|Closure|float|int|string|Stringable|UnitEnum|null $value Attribute value, or `null` to remove the
     * attribute.
     * @param string $prefix Prefix to prepend to the key.
     * @param bool $boolToString Whether to convert booleans to `true` and `false` strings.
     *
     * @return static New instance with the updated `suffixAttributes` value.
     *
     * @phpstan-param scalar|Stringable|UnitEnum|Closure(): mixed $value
     */
    public function setSuffixAttribute(
        string|UnitEnum $key,
        bool|float|int|string|Closure|Stringable|UnitEnum|null $value,
        string $prefix = '',
        bool $boolToString = false,
    ): static {
        $new = clone $this;

        AttributeBag::set($new->suffixAttributes, $key, $value, $prefix, $boolToString);

        return $new;
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
     * ```
     *
     * @param array $values Associative array of attribute keys and values.
     *
     * @return static New instance with the updated `suffixAttributes` value.
     *
     * @phpstan-param mixed[] $values
     */
    public function suffixAttributes(array $values): static
    {
        $new = clone $this;

        AttributeBag::merge($new->suffixAttributes, $values);

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
     * @param string|Stringable|UnitEnum $value CSS class name to add.
     * @param bool $override Whether to override existing class value.
     *
     * @return static New instance with the updated `suffixAttributes` value.
     */
    public function suffixClass(string|Stringable|UnitEnum $value, bool $override = false): static
    {
        $new = clone $this;

        CSSClass::add($new->suffixAttributes, $value, $override);

        return $new;
    }

    /**
     * Sets the tag type for the suffix element.
     *
     * Usage example:
     * ```php
     * $component->suffixTag(\UIAwesome\Html\Interop\Inline::SPAN);
     * $component->suffixTag(false);
     * ```
     *
     * @param BlockInterface|false|InlineInterface|VoidInterface $value Tag name for the suffix element, or `false` to
     * disable.
     *
     * @return static New instance with the updated `suffixTag` value.
     */
    public function suffixTag(false|BlockInterface|InlineInterface|VoidInterface $value = false): static
    {
        $new = clone $this;
        $new->suffixTag = $value;

        return $new;
    }
}
