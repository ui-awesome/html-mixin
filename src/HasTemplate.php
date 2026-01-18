<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin;

/**
 * Trait for managing the template string used in tag construction.
 *
 * Provides an immutable API for assigning a template string used by the implementing renderer.
 *
 * Intended for tags and components that expose a fluent API for changing the template without mutating the original
 * instance.
 *
 * Key features.
 * - Cloning-based immutable updates for template assignment.
 * - Exposes a getter and setter for the template property.
 * - Keeps the template in a dedicated property for reuse by renderers.
 * - Stores the template string used to render the tag.
 *
 * @property string $template Template string used for tag rendering.
 * @phpstan-property string $template
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
trait HasTemplate
{
    /**
     * Template string used for constructing the HTML tag.
     */
    protected string $template = '';

    /**
     * Returns the template assigned to the element.
     *
     * @return string Template value assigned to the element. Never `null`.
     *
     * Usage example:
     * ```php
     * $template = $element->getTemplate();
     * ```
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * Sets the template string for the element.
     *
     * Creates a new instance with the specified template value, overriding any existing value.
     *
     * @param string $value Template string to set for the element.
     *
     * @return static New instance with the updated template property.
     *
     * Usage example:
     * ```php
     * $element->template('<div>{content}</div>');
     * ```
     */
    public function template(string $value): static
    {
        $new = clone $this;
        $new->template = $value;

        return $new;
    }
}
