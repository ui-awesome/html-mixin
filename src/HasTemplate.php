<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin;

/**
 * Provides an immutable API for managing the template string.
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
     * $component->getTemplate();
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
     * $component->template('<div>{content}</div>');
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
