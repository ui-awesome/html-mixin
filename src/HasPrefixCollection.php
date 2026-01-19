<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin;

use Stringable;
use UIAwesome\Html\Helper\CSSClass;
use UIAwesome\Html\Interop\{BlockInterface, InlineInterface, VoidInterface};

use function implode;

/**
 * Trait for managing prefix content and prefix tag attributes.
 *
 * Provides an immutable API for assigning a prefix string and an optional prefix tag definition used by the
 * implementing renderer.
 *
 * Intended for components that need to prepend additional markup or text before the main element while keeping a
 * clone-based fluent API.
 *
 * Key features.
 * - Cloning-based immutable updates for prefix state.
 * - Stores a prefix string and an attribute array for the prefix tag.
 * - Stores an optional prefix tag enum via {@see BlockInterface}, {@see InlineInterface}, or {@see VoidInterface}.
 * - Supports adding CSS classes via {@see CSSClass::add()}.
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
     * HTML attributes array for the prefix tag.
     *
     * @phpstan-var mixed[]
     */
    protected array $prefixAttributes = [];

    /**
     * Tag type for the prefix segment.
     */
    protected false|BlockInterface|InlineInterface|VoidInterface $prefixTag = false;

    /**
     * Sets the prefix content string for the element.
     *
     * Creates a new instance with the specified prefix value, overriding any existing value.
     *
     * @param string|Stringable ...$values Prefix content to set for the element.
     *
     * @return static New instance with the updated prefix property.
     *
     * Usage example:
     * ```php
     * $element->prefix('Start ', 'of ', 'Element');
     * ```
     */
    public function prefix(string|Stringable ...$values): static
    {
        $new = clone $this;
        $new->prefix = implode('', $values);

        return $new;
    }

    /**
     * Sets the HTML attributes for the prefix tag.
     *
     * Creates a new instance with the specified attributes, overriding any existing prefix attributes.
     *
     * @param array $values Associative array of attribute keys and values.
     *
     * @return static New instance with the updated prefixAttributes property.
     *
     * @phpstan-param mixed[] $values
     *
     * Usage example:
     * ```php
     * $element->prefixAttributes(['id' => 'prefix-id']);
     * ```
     */
    public function prefixAttributes(array $values): static
    {
        $new = clone $this;
        $new->prefixAttributes = $values;

        return $new;
    }

    /**
     * Adds a CSS class to the prefix tag attributes.
     *
     * Creates a new instance with the specified CSS class added to the prefixAttributes array.
     *
     * @param string $value CSS class name to add.
     * @param bool $override Whether to override existing class value.
     *
     * @return static New instance with the updated prefixAttributes property.
     *
     * Usage example:
     * ```php
     * $element->prefixClass('new-class');
     * ```
     */
    public function prefixClass(string $value, bool $override = false): static
    {
        $new = clone $this;
        CSSClass::add($new->prefixAttributes, $value, $override);

        return $new;
    }

    /**
     * Sets the tag type for the prefix segment.
     *
     * Creates a new instance with the specified tag type for the prefix.
     *
     * @param BlockInterface|false|InlineInterface|VoidInterface $value Tag type to set for the prefix segment.
     *
     * @return static New instance with the updated prefixTag property.
     *
     * Usage example:
     * ```php
     * $element->prefixTag(\UIAwesome\Html\Interop\Inline::SPAN);
     * $element->prefixTag(false);
     * ```
     */
    public function prefixTag(false|BlockInterface|InlineInterface|VoidInterface $value = false): static
    {
        $new = clone $this;
        $new->prefixTag = $value;

        return $new;
    }
}
