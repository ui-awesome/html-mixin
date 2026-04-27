<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin\Tests\Support;

use UnitEnum;

/**
 * Exposes protected HasAttributes internals for focused trait tests.
 *
 * @copyright Copyright (C) 2026 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
trait ExposeHasAttributesInternals
{
    public function setAttributeForTest(string|UnitEnum $key, mixed $value, string $prefix = ''): static
    {
        return $this->setAttribute($key, $value, $prefix);
    }

    /**
     * @param mixed[] $values
     */
    public function setAttributesForTest(array $values, string $prefix = ''): static
    {
        return $this->setAttributes($values, $prefix);
    }
}
