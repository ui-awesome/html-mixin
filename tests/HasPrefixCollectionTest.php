<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin\Tests;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Stringable;
use UIAwesome\Html\Interop\Inline;
use UIAwesome\Html\Mixin\HasPrefixCollection;

/**
 * Unit tests for the {@see HasPrefixCollection} trait managing prefix content, tag, and attributes.
 *
 * Test coverage.
 * - Ensures fluent setters return new instances (immutability).
 * - Merges new prefix attributes with existing ones, overriding duplicates.
 * - Sets the prefix attributes.
 * - Sets the prefix class, including class override behavior.
 * - Sets the prefix tag and supports resetting it to `false`.
 * - Sets the prefix value from strings, variadic parts, and `Stringable` objects.
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

    public function testSetPrefixAttributesWithExistingValues(): void
    {
        $instance = new class {
            use HasPrefixCollection;
        };

        $instance = $instance->prefixAttributes(
            [
                'id' => 'my-id',
            ],
        );
        $instance = $instance->prefixAttributes(
            [
                'class' => 'my-class',
                'id' => 'new-id',
            ],
        );

        self::assertSame(
            [
                'id' => 'new-id',
                'class' => 'my-class',
            ],
            $instance->getPrefixAttributes(),
            'Should merge new attributes with existing ones, overriding duplicates.',
        );
    }

    public function testSetPrefixClassValue(): void
    {
        $instance = new class {
            use HasPrefixCollection;
        };

        self::assertEmpty(
            $instance->getPrefixAttributes(),
            'Should return an empty array when no attributes are set.',
        );

        $instance = $instance->prefixClass('prefix-class');

        self::assertSame(
            'prefix-class',
            $instance->getPrefixAttribute('class', ''),
            'Should return the correct prefix class after setting it.',
        );

        $instance = $instance->prefixClass('prefix-class-1');

        self::assertSame(
            'prefix-class prefix-class-1',
            $instance->getPrefixAttribute('class', ''),
            'Should return the correct prefix class after setting it.',
        );

        $instance = $instance->prefixClass('override-class', true);

        self::assertSame(
            'override-class',
            $instance->getPrefixAttribute('class', ''),
            'Should return the correct prefix class after setting it.',
        );
    }

    public function testSetPrefixTagValue(): void
    {
        $instance = new class {
            use HasPrefixCollection;
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
        };

        self::assertEmpty(
            $instance->getPrefix(),
            'Should return an empty string when no prefix is set.',
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
