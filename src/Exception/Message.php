<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin\Exception;

use function sprintf;

/**
 * Represents error message templates.
 *
 * This enum defines message templates used by mixin components when validating inputs.
 *
 * It provides message templates that can be formatted at call sites.
 *
 * Each case stores the template string in its enum `value` and can be formatted using {@see Message::getMessage()}.
 *
 * Key features.
 * - Defines message templates as enum cases.
 * - Formats templates with `sprintf()` via {@see Message::getMessage()}.
 * - Intended for exception call sites that need consistent messages.
 * - Supports optional message formatting arguments.
 * - Uses the enum case `value` as the template string.
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
     * @param int|string ...$argument Values to insert into the message template.
     *
     * @return string Formatted error message with interpolated arguments.
     *
     * Usage example:
     * ```php
     * throw new InvalidArgumentException(Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage());
     * ```
     */
    public function getMessage(int|string ...$argument): string
    {
        return sprintf($this->value, ...$argument);
    }
}
