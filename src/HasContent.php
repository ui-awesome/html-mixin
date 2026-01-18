<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin;

use Stringable;
use UIAwesome\Html\Helper\Encode;

/**
 * Trait for managing HTML element content in tag rendering.
 *
 * Provides an immutable API for appending encoded text content or raw HTML content to an element-like object.
 *
 * Intended for components that need to build up content incrementally while keeping the original instance unchanged.
 *
 * Key features.
 * - Appends raw HTML without encoding when using {@see HasContent::html()}.
 * - Cloning-based immutable updates for content assignment.
 * - Encodes content via {@see Encode::content()} when using {@see HasContent::content()}.
 * - Supports `string` and `Stringable` values.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
trait HasContent
{
    /**
     * Content string assigned to the element.
     */
    protected string $content = '';

    /**
     * Appends encoded (safe) content to the current content string.
     *
     * This method encodes content using {@see Encode::content()}.
     *
     * The values are appended to the existing content (Builder pattern).
     *
     * @param string|Stringable ...$values Content to be encoded and appended.
     *
     * @return static A new instance with the appended content.
     *
     * Usage example:
     * ```php
     * $element->content('Hello, <World>!');
     * ```
     */
    public function content(string|Stringable ...$values): static
    {
        $new = clone $this;

        foreach ($values as $value) {
            $new->content .= Encode::content((string) $value);
        }

        return $new;
    }

    /**
     * Returns the content assigned to the element.
     *
     * @return string Content value assigned to the element. Never `null`.
     *
     * Usage example:
     * ```php
     * $content = $element->getContent();
     * ```
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Appends raw (unsafe) HTML to the current content string.
     *
     * Use this method to insert HTML tags deliberately. The developer is responsible for the security of this content.
     *
     * The values are appended to the existing content.
     *
     * @param string|Stringable ...$values Raw HTML content to be appended.
     *
     * @return static A new instance with the appended content.
     *
     * Usage example:
     * ```php
     * $element->html('<strong>Hello, World!</strong>');
     * ```
     */
    public function html(string|Stringable ...$values): static
    {
        $new = clone $this;

        foreach ($values as $value) {
            $new->content .= $value;
        }

        return $new;
    }
}
