<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin;

use Stringable;
use UIAwesome\Html\Helper\{AttributeBag, CSSClass};
use UnitEnum;

/**
 * Provides an immutable API for label content and label attributes.
 *
 * @see https://developer.mozilla.org/en-US/docs/Web/HTML/Element/label
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
     * @phpstan-var mixed[]
     */
    private array $labelAttributes = [];

    /**
     * Whether to render the label.
     */
    private bool $notLabel = false;

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
     * $component->getLabelAttribute('label', 'default-label', 'aria-');
     * ```
     *
     * @param string|UnitEnum $key Attribute name.
     * @param mixed $default Default value when the attribute is missing.
     * @param string $prefix Prefix to ensure (for example, `aria-`, `data-`, `on`).
     *
     * @return mixed Attribute value, or `$default` when missing.
     */
    public function getLabelAttribute(string|UnitEnum $key, mixed $default = null, string $prefix = ''): mixed
    {
        return AttributeBag::get($this->labelAttributes, $key, $default, $prefix);
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
     * @param string|Stringable $content Label content.
     *
     * @return static New instance with the updated `label` value.
     */
    public function label(string|Stringable $content): static
    {
        $new = clone $this;
        $new->label = (string) $content;

        return $new;
    }

    /**
     * Sets the label attributes.
     *
     * Usage example:
     * ```php
     * $component->labelAttributes(['class' => 'form-label']);
     * $component->labelAttributes(['label' => 'Close'], 'aria-');
     * ```
     *
     * @param array $attributes Label attributes.
     * @param string $prefix Prefix to ensure (for example, `aria-`, `data-`, `on`).
     *
     * @return static New instance with the updated `labelAttributes` value.
     *
     * @phpstan-param mixed[] $attributes
     */
    public function labelAttributes(array $attributes, string $prefix = ''): static
    {
        $new = clone $this;

        AttributeBag::setMany($new->labelAttributes, $attributes, $prefix);

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
     * Removes a specific label attribute.
     *
     * Usage example:
     * ```php
     * $component->labelRemoveAttribute('id');
     * $component->labelRemoveAttribute(DataProperty::ID);
     * $component->labelRemoveAttribute('label', 'aria-');
     * ```
     *
     * @param string|UnitEnum $key Attribute name to remove.
     * @param string $prefix Prefix to ensure (for example, `aria-`, `data-`, `on`).
     *
     * @return static New instance without the specified label attribute.
     */
    public function labelRemoveAttribute(string|UnitEnum $key, string $prefix = ''): static
    {
        $new = clone $this;

        AttributeBag::remove($new->labelAttributes, $key, $prefix);

        return $new;
    }

    /**
     * Sets a single HTML attribute for the label element.
     *
     * Usage example:
     * ```php
     * $component->labelSetAttribute('id', 'my-id');
     * $component->labelSetAttribute('id', null);
     * $component->labelSetAttribute('label', 'Close', 'aria-');
     * ```
     *
     * @param string|UnitEnum $key Attribute name.
     * @param mixed $value Attribute value.
     * @param string $prefix Prefix to ensure (for example, `aria-`, `data-`, `on`).
     *
     * @return static New instance with the updated `labelAttributes` value.
     */
    public function labelSetAttribute(string|UnitEnum $key, mixed $value, string $prefix = ''): static
    {
        $new = clone $this;

        AttributeBag::set($new->labelAttributes, $key, $value, $prefix);

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
}
