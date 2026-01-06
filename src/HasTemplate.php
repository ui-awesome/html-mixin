<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin;

/**
 * Trait for managing the template string used in HTML tag construction.
 *
 * Provides a standards-compliant, immutable API for setting the template property on HTML elements, following the HTML
 * specification for tag structure and rendering.
 *
 * Intended for use in tags and components that require dynamic or programmatic manipulation of templates, ensuring
 * correct handling, type safety, and value assignment.
 *
 * Key features.
 * - Designed for use in tags and components.
 * - Enforces standards-compliant handling of the template property for HTML tag construction.
 * - Immutable method for setting or overriding the template string.
 * - Supports flexible assignment of template values for advanced rendering scenarios.
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
