<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin;

use Stringable;
use UIAwesome\Html\Helper\{Encode, Enum};
use UnitEnum;

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
     * Backed enums use their value (including `0`); pure enums use their name. Values are normalized before encoding.
     *
     * @param string|Stringable|UnitEnum ...$values Content to be encoded and appended.
     *
     * @return static New instance with appended encoded content.
     */
    public function content(string|Stringable|UnitEnum ...$values): static
    {
        $clone = clone $this;

        foreach ($values as $value) {
            $clone->content .= Encode::content(
                Enum::normalizeStringValue($value),
            );
        }

        return $clone;
    }

    /**
     * Returns the content assigned to the element.
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
