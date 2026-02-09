<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin;

use UIAwesome\Html\Interop\BlockInterface;

/**
 * Provides an immutable API for managing the container tag and its attributes.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
trait HasContainer
{
    /**
     * Whether to render the container.
     */
    protected bool $container = false;

    /**
     * HTML attributes array for the container tag.
     *
     * @phpstan-var mixed[]
     */
    protected array $containerAttributes = [];

    /**
     * Tag type for the container.
     */
    protected false|BlockInterface $containerTag = false;

    /**
     * Sets whether to render the container.
     *
     * Usage example:
     * ```php
     * $component = $component->container(true);
     * ```
     *
     * @param bool $value Set to `true` to render the container, or `false` to skip rendering.
     *
     * @return static A new instance with the updated container rendering flag.
     */
    public function container(bool $value): static
    {
        $new = clone $this;
        $new->container = $value;

        return $new;
    }

    /**
     * Sets the container attributes.
     *
     * Usage example:
     * ```php
     * $component = $component->containerAttributes(['class' => 'wrapper']);
     * ```
     *
     * @param array $attributes The `array` of attributes to apply to the container.
     *
     * @return static A new instance with the updated container attributes.
     *
     * @phpstan-param mixed[] $attributes
     */
    public function containerAttributes(array $attributes): static
    {
        $new = clone $this;
        $new->containerAttributes = $attributes;

        return $new;
    }

    /**
     * Sets the container tag name.
     *
     * Usage example:
     * ```php
     * $component = $component->containerTag(Block::SECTION);
     * ```
     *
     * @param BlockInterface $value The tag name for the container.
     *
     * @return static A new instance with the updated container tag name.
     */
    public function containerTag(BlockInterface $value): static
    {
        $new = clone $this;
        $new->containerTag = $value;

        return $new;
    }
}
