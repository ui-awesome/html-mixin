<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin\Tests\Support\Stub\Enum;

/**
 * Stub int-backed enum used by test fixtures.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
enum Priority: int
{
    /**
     * High-priority value.
     */
    case HIGH = 2;

    /**
     * Low-priority value.
     */
    case LOW = 1;
}
