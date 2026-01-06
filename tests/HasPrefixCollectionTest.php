<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin\Tests;

use BackedEnum;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Stringable;
use UIAwesome\Html\Interop\Inline;
use UIAwesome\Html\Mixin\HasPrefixCollection;

/**
 * Test suite for {@see HasPrefixCollection} trait functionality and behavior.
 *
 * Validates the management of prefix content, attributes, class, and tag for HTML elements according to the HTML Living
 * Standard specification.
 *
 * Ensures correct handling, immutability, and validation of prefix-related API in tag rendering, supporting dynamic
 * assignment and override of prefix value.
 *
 * Test coverage.
 * - Accurate assignment and overriding of prefix content, attributes, class, and tag.
 * - Immutability of the trait's API when setting or overriding prefix value.
 * - Proper handling of default and override scenarios for prefix class and tag.
 * - Validation of empty and non-empty states for prefix properties.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('mixin')]
final class HasPrefixCollectionTest extends TestCase
{
    public function testReturnNewInstanceWhenSettingAttributes(): void
    {
        $instance = new class {
            use HasPrefixCollection;
        };

        self::assertNotSame(
            $instance,
            $instance->prefix(''),
            'Should return a new instance when setting the prefix, ensuring immutability.',
        );
        self::assertNotSame(
            $instance,
            $instance->prefixAttributes([]),
            'Should return a new instance when setting the prefix attributes, ensuring immutability.',
        );
        self::assertNotSame(
            $instance,
            $instance->prefixClass('class-name'),
            'Should return a new instance when setting the prefix class, ensuring immutability.',
        );
        self::assertNotSame(
            $instance,
            $instance->prefixTag(Inline::MARK),
            'Should return a new instance when setting the prefix tag, ensuring immutability.',
        );
    }

    public function testSetPrefixAttributesValue(): void
    {
        $instance = new class {
            use HasPrefixCollection;

            /**
             * @phpstan-return mixed[]
             */
            public function getPrefixAttributes(): array
            {
                return $this->prefixAttributes;
            }
        };

        self::assertEmpty(
            $instance->getPrefixAttributes(),
            'Should return an empty array when no attributes are set.',
        );

        $instance = $instance->prefixAttributes(
            [
                'data-value' => '123',
                'id' => 'prefix-id',
            ],
        );

        self::assertSame(
            [
                'data-value' => '123',
                'id' => 'prefix-id',
            ],
            $instance->getPrefixAttributes(),
            'Should return the correct prefix attributes after setting them.',
        );
    }

    public function testSetPrefixClassValue(): void
    {
        $instance = new class {
            use HasPrefixCollection;

            /**
             * @phpstan-return mixed[]
             */
            public function getPrefixAttributes(): array
            {
                return $this->prefixAttributes;
            }
        };

        self::assertEmpty(
            $instance->getPrefixAttributes(),
            'Should return an empty array when no attributes are set.',
        );

        $instance = $instance->prefixClass('prefix-class');

        self::assertSame(
            'prefix-class',
            $instance->getPrefixAttributes()['class'] ?? '',
            'Should return the correct prefix class after setting it.',
        );

        $instance = $instance->prefixClass('prefix-class-1');

        self::assertSame(
            'prefix-class prefix-class-1',
            $instance->getPrefixAttributes()['class'] ?? '',
            'Should return the correct prefix class after setting it.',
        );

        $instance = $instance->prefixClass('override-class', true);

        self::assertSame(
            'override-class',
            $instance->getPrefixAttributes()['class'] ?? '',
            'Should return the correct prefix class after setting it.',
        );
    }

    public function testSetPrefixTagValue(): void
    {
        $instance = new class {
            use HasPrefixCollection;

            public function getPrefixTag(): bool|BackedEnum
            {
                return $this->prefixTag;
            }
        };

        self::assertFalse(
            $instance->getPrefixTag(),
            'Should return false when no tag is set.',
        );

        $instance = $instance->prefixTag(Inline::MARK);

        self::assertSame(
            Inline::MARK,
            $instance->getPrefixTag(),
            'Should return the correct prefix tag after setting it.',
        );

        $instance = $instance->prefixTag(false);

        self::assertFalse(
            $instance->getPrefixTag(),
            "Should return 'false' after resetting the prefix tag.",
        );
    }

    public function testSetPrefixValue(): void
    {
        $instance = new class {
            use HasPrefixCollection;

            public function getPrefix(): string
            {
                return $this->prefix;
            }
        };

        self::assertEmpty(
            $instance->getPrefix(),
            'Should return an empty string when no prefix are set.',
        );

        $instance = $instance->prefix('Prefix content');

        self::assertSame(
            'Prefix content',
            $instance->getPrefix(),
            'Should return the correct prefix after setting it.',
        );
    }

    public function testSetPrefixValueWithMultipleArguments(): void
    {
        $instance = new class {
            use HasPrefixCollection;

            public function getPrefix(): string
            {
                return $this->prefix;
            }
        };

        $instance = $instance->prefix('Prefix', ' ', 'content');

        self::assertSame(
            'Prefix content',
            $instance->getPrefix(),
            'Should concatenate multiple prefix arguments.',
        );
    }

    public function testSetPrefixValueWithStringable(): void
    {
        $instance = new class {
            use HasPrefixCollection;

            public function getPrefix(): string
            {
                return $this->prefix;
            }
        };

        $stringable = new class implements Stringable {
            public function __toString(): string
            {
                return 'Stringable content';
            }
        };

        $instance = $instance->prefix($stringable);

        self::assertSame(
            'Stringable content',
            $instance->getPrefix(),
            'Should handle Stringable objects correctly.',
        );
    }
}
