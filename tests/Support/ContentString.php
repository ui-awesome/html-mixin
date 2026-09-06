<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin\Tests\Support;

/**
 * Enum fixture for encoded element content.
 */
enum ContentString: string
{
    case EMPTY = '';
    case ENTITIES = '&amp; &#60; &quot;';
    case HTML = '<b title="value">& \'quoted\'</b>';
    case TEXT = 'message';
    case UNICODE = "caf\u{00E9} \u{4E16}\u{754C}";
    case ZERO = '0';
}
