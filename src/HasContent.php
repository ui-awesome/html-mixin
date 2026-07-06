<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin;

use Stringable;
use UIAwesome\Html\Helper\Encode;

/**
 * Provides an immutable API for managing element content.
 */
trait HasContent
{
    /**
     * Content string assigned to the element.
     */
    protected string $content = '';

    /**
     * Appends encoded content.
     *
     * Usage example:
     * ```php
     * $component->content('Hello, <World>!');
     * ```
     *
     * @param string|Stringable ...$values Content to be encoded and appended.
     *
     * @return static New instance with appended encoded content.
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
     * Usage example:
     * ```php
     * $component->getContent();
     * ```
     *
     * @return string Content value assigned to the element. Never `null`.
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Appends raw HTML content.
     *
     * Usage example:
     * ```php
     * $component->html('<strong>Hello, World!</strong>');
     * ```
     *
     * @param string|Stringable ...$values Raw HTML content to be appended.
     *
     * @return static New instance with appended raw HTML content.
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
