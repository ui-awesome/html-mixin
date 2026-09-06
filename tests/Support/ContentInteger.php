<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin\Tests\Support;

/**
 * Enum fixture for encoded element content.
 */
enum ContentInteger: int
{
    case NEGATIVE = -7;
    case POSITIVE = 42;
    case ZERO = 0;
}
