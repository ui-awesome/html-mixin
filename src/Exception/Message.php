<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin\Exception;

use function sprintf;

/**
 * Represents error message templates for attribute exceptions.
 *
 * Use {@see Message::getMessage()} to format the template with `sprintf()` arguments.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
enum Message: string
{
    /**
     * Error when a key is not a non-empty string.
     *
     * Format: "Key must be a non-empty string."
     */
    case KEY_MUST_BE_NON_EMPTY_STRING = 'Key must be a non-empty string.';

    /**
     * Returns the formatted message string for the error case.
     *
     * Usage example:
     * ```php
     * throw new \InvalidArgumentException(
     *     \UIAwesome\Html\Mixin\Exception\Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage(),
     * );
     * ```
     *
     * @param int|string ...$argument Values to insert into the message template.
     *
     * @return string Formatted error message with interpolated arguments.
     */
    public function getMessage(int|string ...$argument): string
    {
        return sprintf($this->value, ...$argument);
    }
}
