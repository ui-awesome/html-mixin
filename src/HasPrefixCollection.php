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
    protected false|BlockInterface|InlineInterface|VoidInterface $prefixTag = false;

    /**
     * Returns the prefix content string assigned to the element.
     *
     * Usage example:
     * ```php
     * $prefix = $component->getPrefix();
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
     * $id = $component->getPrefixAttribute('id', 'default-id');
     * ```
     *
     * @param string|UnitEnum $key Attribute name.
     * @param mixed $default Default value when the attribute is missing.
     *
     * @return mixed Attribute value or default.
     */
    public function getPrefixAttribute(string|UnitEnum $key, mixed $default = null): mixed
    {
        $normalizedKey = Enum::normalizeValue($key);

        if ($normalizedKey === '' || is_string($normalizedKey) === false) {
            throw new InvalidArgumentException(
                Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage($normalizedKey),
            );
        }

        return $this->prefixAttributes[$normalizedKey] ?? $default;
    }

    /**
     * Returns the `array` of HTML attributes for the prefix element.
     *
     * Usage example:
     * ```php
     * $attributes = $component->getPrefixAttributes();
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
     * $tag = $component->getPrefixTag();
     * ```
     *
     * @return BlockInterface|false|InlineInterface|VoidInterface Tag name for the prefix element, or `false` to
     * disable.
     */
    public function getPrefixTag(): BlockInterface|false|InlineInterface|VoidInterface
    {
        return $this->prefixTag;
    }

    /**
     * Sets the prefix content string for the element.
     *
     * Usage example:
     * ```php
     * $component = $component->prefix('Start ', 'of ', 'element');
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
     * $component = $component->prefixAttributes(['id' => 'prefix-id']);
     * ```
     *
     * @param array $values Associative array of attribute keys and values.
     *
     * @return static New instance with the updated `prefixAttributes` value.
     *
     * @phpstan-param mixed[] $values
     */
    public function prefixAttributes(array $values): static
    {
        $new = clone $this;
        $new->prefixAttributes = [...$new->prefixAttributes, ...$values];

        return $new;
    }

    /**
     * Adds a CSS class to the prefix element attributes.
     *
     * Usage example:
     * ```php
     * $component = $component->prefixClass('new-class');
     * $component = $component->prefixClass('override-class', true);
     * ```
     *
     * @param string|Stringable|UnitEnum $value CSS class name to add.
     * @param bool $override Whether to override existing class value.
     *
     * @return static New instance with the updated `prefixAttributes` value.
     */
    public function prefixClass(string|Stringable|UnitEnum $value, bool $override = false): static
    {
        $new = clone $this;
        CSSClass::add($new->prefixAttributes, $value, $override);

        return $new;
    }

    /**
     * Sets the tag name for the prefix element.
     *
     * Usage example:
     * ```php
     * $component = $component->prefixTag(\UIAwesome\Html\Interop\Inline::SPAN);
     * $component = $component->prefixTag(false);
     * ```
     *
     * @param BlockInterface|false|InlineInterface|VoidInterface $value Tag name for the prefix element, or `false` to
     * disable.
     *
     * @return static New instance with the updated `prefixTag` value.
     */
    public function prefixTag(false|BlockInterface|InlineInterface|VoidInterface $value = false): static
    {
        $new = clone $this;
        $new->prefixTag = $value;

        return $new;
    }
}
