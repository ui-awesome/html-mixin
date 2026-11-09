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
     * Whether to skip rendering the label, or `null` when not configured.
     */
    private bool|null $notLabel = null;

    /**
     * Returns the label content.
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
     * @return bool `true` if the label element should be rendered, or `false` to skip rendering.
     */
    public function isLabel(): bool
    {
        return $this->notLabel !== true && $this->label !== '';
    }

    /**
     * Sets the label content.
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
     * Passing `null` preserves existing classes, even when `$override` is `true`.
     * Use `labelRemoveAttribute('class')` to remove the attribute explicitly.
     *
     * @param string|Stringable|UnitEnum|null $value CSS class value, or `null` to preserve existing classes.
     * @param bool $override Whether to replace existing classes (`true`) or merge (`false`) when valid classes are supplied.
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
     * Sets whether to skip rendering the label.
     *
     * @param bool $value Whether to skip rendering the label, or `false` to re-enable a suppressed label.
     *
     * @return static New instance with the updated `notLabel` value.
     */
    public function notLabel(bool $value = true): static
    {
        $new = clone $this;
        $new->notLabel = $value;

        return $new;
    }
}
