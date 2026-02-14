<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin;

use Closure;
use Stringable;
use UIAwesome\Html\Helper\{AttributeBag, CSSClass};
use UnitEnum;

/**
 * Provides an immutable API for label content and label attributes.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Element/label
 *
 * @copyright Copyright (C) 2026 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
trait HasLabelCollection
{
    /**
     * Label content.
     */
    private string $label = '';

    /**
     * Label attributes.
     *
     * @phpstan-var mixed[] $labelAttributes
     */
    private array $labelAttributes = [];

    /**
     * Whether to render the label.
     */
    private bool $notLabel = false;

    /**
     * Sets a single HTML attribute for the label element.
     *
     * Usage example:
     * ```php
     * $component->addLabelAttribute('id', 'my-id');
     * $component->addLabelAttribute('id', null);
     * ```
     *
     * @param string|UnitEnum $key Attribute name.
     * @param mixed $value Attribute value.
     *
     * @return static New instance with the updated `labelAttributes` value.
     */
    public function addLabelAttribute(string|UnitEnum $key, mixed $value): static
    {
        $new = clone $this;

        AttributeBag::add($new->labelAttributes, $key, $value);

        return $new;
    }

    /**
     * Returns the label content.
     *
     * Usage example:
     * ```php
     * $component->getLabel();
     * ```
     *
     * @return string Label content.
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Returns one label attribute value.
     *
     * Usage example:
     * ```php
     * $component->getLabelAttribute('id', 'default-id');
     * ```
     *
     * @param string|UnitEnum $key Attribute name.
     * @param mixed $default Default value when the attribute is missing.
     *
     * @return mixed Attribute value, or `$default` when missing.
     */
    public function getLabelAttribute(string|UnitEnum $key, mixed $default = null): mixed
    {
        return AttributeBag::get($this->labelAttributes, $key, $default);
    }

    /**
     * Returns label attributes.
     *
     * Usage example:
     * ```php
     * $component->getLabelAttributes();
     * ```
     *
     * @return array Label attributes.
     *
     * @phpstan-return mixed[]
     */
    public function getLabelAttributes(): array
    {
        return $this->labelAttributes;
    }

    /**
     * Returns whether the label element should be rendered.
     *
     * Usage example:
     * ```php
     * $component->isLabel();
     * ```
     *
     * @return bool `true` if the label element should be rendered, or `false` to skip rendering.
     */
    public function isLabel(): bool
    {
        return $this->notLabel === false && $this->label !== '';
    }

    /**
     * Sets the label content.
     *
     * Usage example:
     * ```php
     * $component->label('My Label');
     * ```
     *
     * @param string $content Label content.
     *
     * @return static New instance with the updated `label` value.
     */
    public function label(string $content): static
    {
        $new = clone $this;
        $new->label = $content;

        return $new;
    }

    /**
     * Sets the label attributes.
     *
     * Usage example:
     * ```php
     * $component->labelAttributes(['class' => 'form-label']);
     * ```
     *
     * @param array $attributes Label attributes.
     *
     * @return static New instance with the updated `labelAttributes` value.
     *
     * @phpstan-param mixed[] $attributes
     */
    public function labelAttributes(array $attributes): static
    {
        $new = clone $this;

        AttributeBag::merge($new->labelAttributes, $attributes);

        return $new;
    }

    /**
     * Adds a CSS class to the label element attributes.
     *
     * Usage example:
     * ```php
     * $component->labelClass('my-class');
     * $component->labelClass(
     *     new class implements Stringable {
     *         public function __toString(): string
     *         {
     *             return 'stringable-class';
     *         }
     *     },
     * );
     * $component->labelClass('override-class', true);
     * $component->labelClass(null);
     * ```
     *
     * @param string|Stringable|UnitEnum|null $value CSS class value, or `null` to remove the attribute.
     * @param bool $override Whether to override existing classes (`true`) or merge (`false`).
     *
     * @return static New instance with the updated `labelAttributes['class']` value.
     */
    public function labelClass(string|Stringable|UnitEnum|null $value, bool $override = false): static
    {
        $new = clone $this;

        CSSClass::add($new->labelAttributes, $value, $override);

        return $new;
    }

    /**
     * Sets the `for` attribute of the label.
     *
     * Usage example:
     * ```php
     * $component->labelFor('input-id');
     * $component->labelFor(null);
     * ```
     *
     * @param string|null $value `for` attribute value.
     *
     * @return static New instance with the updated `labelAttributes['for']` value.
     */
    public function labelFor(string|null $value): static
    {
        $new = clone $this;
        $new->labelAttributes['for'] = $value;

        return $new;
    }

    /**
     * Disables label rendering.
     *
     * Usage example:
     * ```php
     * $component->notLabel();
     * ```
     *
     * @return static New instance with the updated `notLabel` value.
     */
    public function notLabel(): static
    {
        $new = clone $this;
        $new->notLabel = true;

        return $new;
    }

    /**
     * Removes a specific label attribute.
     *
     * Usage example:
     * ```php
     * $component->removeLabelAttribute('id');
     * $component->removeLabelAttribute(DataProperty::ID);
     * ```
     *
     * @param string|UnitEnum $key Attribute name to remove.
     *
     * @return static New instance without the specified label attribute.
     */
    public function removeLabelAttribute(string|UnitEnum $key): static
    {
        $new = clone $this;

        AttributeBag::remove($new->labelAttributes, $key);

        return $new;
    }

    /**
     * Sets a single attribute with prefix handling and value resolution for the label element.
     *
     * Usage example:
     * ```php
     * $component->setLabelAttribute('label', 'Label', 'aria-');
     * $component->setLabelAttribute('hidden', true, 'aria-', true);
     * ```
     *
     * @param string|UnitEnum $key Attribute key without prefix.
     * @param bool|Closure|float|int|string|Stringable|UnitEnum|null $value Attribute value, or `null` to remove the
     * attribute.
     * @param string $prefix Prefix to prepend to the key.
     * @param bool $boolToString Whether to convert booleans to `true` and `false` strings.
     *
     * @return static New instance with the updated `labelAttributes` value.
     *
     * @phpstan-param scalar|Stringable|UnitEnum|Closure(): mixed $value
     */
    public function setLabelAttribute(
        string|UnitEnum $key,
        bool|float|int|string|Closure|Stringable|UnitEnum|null $value,
        string $prefix = '',
        bool $boolToString = false,
    ): static {
        $new = clone $this;

        AttributeBag::set($new->labelAttributes, $key, $value, $prefix, $boolToString);

        return $new;
    }
}
