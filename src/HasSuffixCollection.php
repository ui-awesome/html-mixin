<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin;

use Stringable;
use UIAwesome\Html\Helper\CSSClass;
use UIAwesome\Html\Interop\{BlockInterface, InlineInterface, VoidInterface};

use function implode;

/**
 * Trait for managing suffix content and suffix tag attributes.
 *
 * Provides an immutable API for assigning a suffix string and an optional suffix tag definition used by the
 * implementing renderer.
 *
 * Intended for components that need to append additional markup or text after the main element while keeping a
 * clone-based fluent API.
 *
 * Key features.
 * - Cloning-based immutable updates for suffix state.
 * - Stores a suffix string and an attribute array for the suffix tag.
 * - Stores an optional suffix tag enum via {@see BlockInterface}, {@see InlineInterface}, or {@see VoidInterface}.
 * - Supports adding CSS classes via {@see CSSClass::add()}.
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
     * HTML attributes array for the suffix tag.
     *
     * @phpstan-var mixed[]
     */
    protected array $suffixAttributes = [];

    /**
     * Tag type for the suffix segment.
     */
    protected false|BlockInterface|InlineInterface|VoidInterface $suffixTag = false;

    /**
     * Sets the suffix content string for the element.
     *
     * Creates a new instance with the specified suffix value, overriding any existing value.
     *
     * @param string|Stringable ...$values Suffix content to set for the element.
     *
     * @return static New instance with the updated suffix property.
     *
     * Usage example:
     * ```php
     * $element->suffix(' End', ' of ', 'Element');
     * ```
     */
    public function suffix(Stringable|string ...$values): static
    {
        $new = clone $this;
        $new->suffix = implode('', $values);

        return $new;
    }

    /**
     * Sets the HTML attributes for the suffix tag.
     *
     * Creates a new instance with the specified attributes, overriding any existing suffix attributes.
     *
     * @param array $values Associative array of attribute keys and values.
     *
     * @return static New instance with the updated suffixAttributes property.
     *
     * @phpstan-param mixed[] $values
     *
     * Usage example:
     * ```php
     * $element->suffixAttributes(['id' => 'suffix-id']);
     * ```
     */
    public function suffixAttributes(array $values): static
    {
        $new = clone $this;
        $new->suffixAttributes = $values;

        return $new;
    }

    /**
     * Adds a CSS class to the suffix tag attributes.
     *
     * Creates a new instance with the specified CSS class added to the suffixAttributes array.
     *
     * @param string $value CSS class name to add.
     * @param bool $override Whether to override existing class value.
     *
     * @return static New instance with the updated suffixAttributes property.
     *
     * Usage example:
     * ```php
     * $element->suffixClass('new-class');
     * ```
     */
    public function suffixClass(string $value, bool $override = false): static
    {
        $new = clone $this;
        CSSClass::add($new->suffixAttributes, $value, $override);

        return $new;
    }

    /**
     * Sets the tag type for the suffix segment.
     *
     * Creates a new instance with the specified tag type for the suffix.
     *
     * @param BlockInterface|false|InlineInterface|VoidInterface $value Tag type to set for the suffix segment.
     *
     * @return static New instance with the updated suffixTag property.
     *
     * Usage example:
     * ```php
     * $element->suffixTag(\UIAwesome\Html\Interop\Inline::SPAN);
     * $element->suffixTag(false);
     * ```
     */
    public function suffixTag(false|BlockInterface|InlineInterface|VoidInterface $value = false): static
    {
        $new = clone $this;
        $new->suffixTag = $value;

        return $new;
    }
}
