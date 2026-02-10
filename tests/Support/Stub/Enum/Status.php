<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin\Tests\Support\Stub\Enum;

/**
 * Stub string-backed enum used by test fixtures.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
enum Status: string
{
    /**
     * Active status value.
     */
    case ACTIVE = 'active';

    /**
     * Inactive status value.
     */
    case INACTIVE = 'inactive';
}
