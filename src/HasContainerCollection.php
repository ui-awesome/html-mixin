<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin;

use InvalidArgumentException;
use Stringable;
use UIAwesome\Html\Helper\{CSSClass, Enum};
use UIAwesome\Html\Interop\BlockInterface;
use UIAwesome\Html\Mixin\Exception\Message;
use UnitEnum;

/**
 * Provides an immutable API for managing the container element and its attributes.
 *
 * @copyright Copyright (C) 2026 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
trait HasContainerCollection
{
    /**
     * Whether to render the container.
     */
    protected bool $container = false;

    /**
     * HTML attributes array for the container element.
     *
     * @phpstan-var mixed[] $containerAttributes
     */
    protected array $containerAttributes = [];

    /**
     * Tag name for the container element, or `false` to disable.
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
     * @param bool $value Set to `true` to render the container element, or `false` to skip rendering.
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
     * @param array $attributes Array of attributes to apply to the container element.
     *
     * @return static New instance with the updated `containerAttributes` value.
     *
     * @phpstan-param mixed[] $attributes
     */
    public function containerAttributes(array $attributes): static
    {
        $new = clone $this;
        $new->containerAttributes = [...$new->containerAttributes, ...$attributes];

        return $new;
    }

    /**
     * Adds a CSS class to the container element attributes.
     *
     * Usage example:
     * ```php
     * $component = $component->containerClass('new-class');
     * $component = $component->containerClass('override-class', true);
     * ```
     *
     * @param string|Stringable|UnitEnum $value CSS class name to add.
     * @param bool $override Whether to override existing class value.
     *
     * @return static New instance with the updated `containerAttributes` value.
     */
    public function containerClass(string|Stringable|UnitEnum $value, bool $override = false): static
    {
        $new = clone $this;
        CSSClass::add($new->containerAttributes, $value, $override);

        return $new;
    }

    /**
     * Sets the container tag name.
     *
     * Usage example:
     * ```php
     * $component = $component->containerTag(Block::SECTION);
     * $component = $component->containerTag(false);
     * ```
     *
     * @param BlockInterface|false $value Tag name for the container element, or `false` to disable.
     *
     * @return static New instance with the updated `containerTag` value.
     */
    public function containerTag(BlockInterface|false $value): static
    {
        $new = clone $this;
        $new->containerTag = $value;

        return $new;
    }

    /**
     * Returns the value of a single HTML attribute for the container element attributes.
     *
     * Usage example:
     * ```php
     * $id = $component->getContainerAttribute('id', 'default-id');
     * ```
     *
     * @param string|UnitEnum $key Attribute name.
     * @param mixed $default Default value when the attribute is missing.
     *
     * @return mixed Attribute value or default.
     */
    public function getContainerAttribute(string|UnitEnum $key, mixed $default = null): mixed
    {
        $normalizedKey = Enum::normalizeValue($key);

        if ($normalizedKey === '' || is_string($normalizedKey) === false) {
            throw new InvalidArgumentException(
                Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage($normalizedKey),
            );
        }

        return $this->containerAttributes[$normalizedKey] ?? $default;
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
     * Returns the tag name for the container element.
     *
     * @return BlockInterface|false Tag name for the container element, or `false` to disable.
     */
    public function getContainerTag(): false|BlockInterface
    {
        return $this->containerTag;
    }

    /**
     * Returns whether the container element should be rendered.
     *
     * @return bool `true` if the container element should be rendered, or `false` to skip rendering.
     */
    public function isContainer(): bool
    {
        return $this->container;
    }
}
