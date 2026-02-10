<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin;

/**
 * Provides an immutable API for managing the template string.
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
     * Usage example:
     * ```php
     * $template = $component->getTemplate();
     * ```
     *
     * @return string Template value assigned to the element. Never `null`.
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * Sets the template string for the element.
     *
     * Usage example:
     * ```php
     * $component = $component->template('<div>{content}</div>');
     * ```
     *
     * @param string $value Template string to set for the element.
     *
     * @return static New instance with the updated `template` value.
     */
    public function template(string $value): static
    {
        $new = clone $this;
        $new->template = $value;

        return $new;
    }
}
