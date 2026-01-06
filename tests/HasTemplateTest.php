<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin\Tests;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Mixin\HasTemplate;

/**
 * Test suite for {@see HasTemplate} trait functionality and behavior.
 *
 * Validates the management of the template property for HTML rendering according to the HTML Living Standard
 * specification.
 *
 * Ensures correct handling, immutability, and validation of the template in tag rendering, supporting string for
 * dynamic template assignment.
 *
 * Test coverage.
 * - Accurate retrieval of the template value.
 * - Immutability of the trait's API when setting or overriding the template.
 * - Proper assignment and overriding of template value.
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
            'Should return an empty string when no template is set.',
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
