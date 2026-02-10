<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin;

use InvalidArgumentException;
use Stringable;
use UIAwesome\Html\Helper\{CSSClass, Enum};
use UIAwesome\Html\Interop\{BlockInterface, InlineInterface, VoidInterface};
use UIAwesome\Html\Mixin\Exception\Message;
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
     * Returns the suffix content string assigned to the element.
     *
     * Usage example:
     * ```php
     * $suffix = $component->getSuffix();
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
     * $id = $component->getSuffixAttribute('id', 'default-id');
     * ```
     *
     * @param string|UnitEnum $key Attribute name.
     * @param mixed $default Default value when the attribute is missing.
     *
     * @return mixed Attribute value or default.
     */
    public function getSuffixAttribute(string|UnitEnum $key, mixed $default = null): mixed
    {
        $normalizedKey = Enum::normalizeValue($key);

        if ($normalizedKey === '' || is_string($normalizedKey) === false) {
            throw new InvalidArgumentException(
                Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage($normalizedKey),
            );
        }

        return $this->suffixAttributes[$normalizedKey] ?? $default;
    }

    /**
     * Returns the `array` of HTML attributes for the suffix element.
     *
     * Usage example:
     * ```php
     * $attributes = $component->getSuffixAttributes();
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
     * $tag = $component->getSuffixTag();
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
     * Sets the suffix content string for the element.
     *
     * Usage example:
     * ```php
     * $component = $component->suffix(' End', ' of ', 'element');
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
     * $component = $component->suffixAttributes(['id' => 'suffix-id']);
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
        $new->suffixAttributes = [...$new->suffixAttributes, ...$values];

        return $new;
    }

    /**
     * Adds a CSS class to the suffix element attributes.
     *
     * Usage example:
     * ```php
     * $component = $component->suffixClass('new-class');
     * $component = $component->suffixClass('override-class', true);
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
     * $component = $component->suffixTag(\UIAwesome\Html\Interop\Inline::SPAN);
     * $component = $component->suffixTag(false);
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
