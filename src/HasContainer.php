<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin;

use UIAwesome\Html\Interop\BlockInterface;

use function array_merge;

/**
 * Provides an immutable API for managing the container tag and its attributes.
 *
 * @copyright Copyright (C) 2026 Terabytesoftw.
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
     * @phpstan-var mixed[] $containerAttributes
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
     * @return static New instance with the updated `container` value.
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
     * @param array $attributes Array of attributes to apply to the container.
     *
     * @return static New instance with the updated `containerAttributes` value.
     *
     * @phpstan-param mixed[] $attributes
     */
    public function containerAttributes(array $attributes): static
    {
        $new = clone $this;
        $new->containerAttributes = array_merge($new->containerAttributes, $attributes);

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
     * @param BlockInterface $value Tag name for the container.
     *
     * @return static New instance with the updated `containerTag` value.
     */
    public function containerTag(BlockInterface $value): static
    {
        $new = clone $this;
        $new->containerTag = $value;

        return $new;
    }

    /**
     * Returns the `array` of HTML attributes for the container element.
     *
     * @return array Attributes `array` assigned to the container element.
     *
     * @phpstan-return mixed[]
     */
    public function getContainerAttributes(): array
    {
        return $this->containerAttributes;
    }

    /**
     * Returns whether the container should be rendered.
     *
     * @return bool `true` if the container should be rendered, or `false` otherwise.
     */
    public function isContainer(): bool
    {
        return $this->container;
    }

    /**
     * Returns the tag name for the container.
     *
     * @return false|BlockInterface Tag name for the container, or `false` if not set.
     */
    public function getContainerTag(): false|BlockInterface
    {
        return $this->containerTag;
    }
}
