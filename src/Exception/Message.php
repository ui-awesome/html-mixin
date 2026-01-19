<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin\Exception;

use function sprintf;

/**
 * Represents error message templates.
 *
 * This enum defines formatted error messages for various error conditions that may occur during operations such as
 * input validation in mixin components.
 *
 * It provides message templates that can be formatted at call sites.
 *
 * Each case represents a specific type of error, with a message template that can be populated with dynamic values
 * using the {@see Message::getMessage()} method.
 *
 * Each message template can be formatted with arguments.
 *
 * Key features.
 * - Can be used by exception call sites that need formatted messages.
 * - Defines message templates as enum cases.
 * - Formats templates with `sprintf()` via {@see Message::getMessage()}.
 * - Supports message formatting with dynamic parameters.
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
