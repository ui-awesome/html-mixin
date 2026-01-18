<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin\Tests\Support\Stub\Enum;

/**
 * Stub enum for tests.
 *
 * Provides a minimal set of string-backed cases used by test fixtures.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
enum Inline: string
{
    /**
     * Case for the `<a>` HTML tag.
     *
     * Categorized as flow, interactive, palpable, and phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/a
     */
    case A = 'a';
}
