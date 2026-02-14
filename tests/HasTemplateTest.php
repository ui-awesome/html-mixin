<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin\Tests;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Mixin\HasTemplate;

/**
 * Unit tests for the {@see HasTemplate} trait managing component template strings.
 *
 * Test coverage.
 * - Ensures `getTemplate()` returns an empty string when template is not set.
 * - Ensures fluent setters return new instances (immutability).
 * - Sets the template value.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('mixin')]
final class HasTemplateTest extends TestCase
{
    public function testReturnEmptyStringWhenTemplateNotSet(): void
    {
        $instance = new class {
            use HasTemplate;
        };

        self::assertSame(
            '',
            $instance->getTemplate(),
            "Should return an empty 'string' when no template is set.",
        );
    }

    public function testReturnNewInstanceWhenSettingTemplate(): void
    {
        $instance = new class {
            use HasTemplate;
        };

        self::assertNotSame(
            $instance,
            $instance->template(''),
            'Should return a new instance when setting the template, ensuring immutability.',
        );
    }

    public function testSetTemplateValue(): void
    {
        $instance = new class {
            use HasTemplate;
        };

        $instance = $instance->template('{prefix}\n{tag}\n{suffix}');

        self::assertSame(
            '{prefix}\n{tag}\n{suffix}',
            $instance->getTemplate(),
            'Should return the template value after setting it.',
        );
    }
}
