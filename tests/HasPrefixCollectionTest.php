<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Interop\Inline;
use UIAwesome\Html\Mixin\Exception\Message;
use UIAwesome\Html\Mixin\HasPrefixCollection;
use UIAwesome\Html\Mixin\Tests\Support\Stub\Enum\Priority;

/**
 * Unit tests for the {@see HasPrefixCollection} trait managing prefix content, tag, and attributes.
 *
 * Test coverage.
 * - Ensures fluent setters return new instances (immutability).
 * - Merges new prefix attributes with existing ones, overriding duplicates.
 * - Sets prefix attributes and returns expected values.
 * - Sets prefix CSS classes, including merged and overridden values.
 * - Sets prefix tag values and supports disabling the tag.
 * - Sets prefix text content and returns the expected value.
 * - Throws InvalidArgumentException for empty or unsupported prefix attribute keys.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('mixin')]
final class HasPrefixCollectionTest extends TestCase
{
    public function testGetPrefixAttributeValue(): void
    {
        $instance = new class {
            use HasPrefixCollection;
        };

        self::assertNull(
            $instance->getPrefixAttribute('id'),
            "Should return 'null' when no attributes are set.",
        );

        $instance = $instance->prefixAttributes(
            [
                'class' => 'prefix-class',
                'id' => 'prefix-id',
            ],
        );

        self::assertSame(
            'prefix-id',
            $instance->getPrefixAttribute('id'),
            "Should return the correct 'id' attribute after setting it.",
        );
        self::assertSame(
            'prefix-class',
            $instance->getPrefixAttribute('class'),
            "Should return the correct 'class' attribute after setting it.",
        );
        self::assertSame(
            'default-value',
            $instance->getPrefixAttribute('missing', 'default-value'),
            'Should return the default value when the prefix attribute does not exist.',
        );
    }

    public function testReturnNewInstanceWhenSettingPrefixCollection(): void
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
            "Should return a new instance when setting the prefix 'class' attribute, ensuring immutability.",
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
            "Should return an empty 'array' when no attributes are set.",
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
            "Should return an empty 'array' when no attributes are set.",
        );

        $instance = $instance->prefixClass('prefix-class');

        self::assertSame(
            'prefix-class',
            $instance->getPrefixAttribute('class', ''),
            "Should return the correct prefix 'class' attribute after setting it.",
        );

        $instance = $instance->prefixClass('prefix-class-1');

        self::assertSame(
            'prefix-class prefix-class-1',
            $instance->getPrefixAttribute('class', ''),
            "Should return the correct prefix 'class' attribute after setting it.",
        );

        $instance = $instance->prefixClass('override-class', true);

        self::assertSame(
            'override-class',
            $instance->getPrefixAttribute('class', ''),
            "Should return the correct prefix 'class' attribute after setting it.",
        );
    }

    public function testSetPrefixTagFalseValue(): void
    {
        $instance = new class {
            use HasPrefixCollection;
        };

        $instance = $instance->prefixTag(Inline::MARK);
        $instance = $instance->prefixTag(false);

        self::assertFalse(
            $instance->getPrefixTag(),
            "Should return 'false' after setting the prefix tag to 'false'.",
        );
    }

    public function testSetPrefixTagValue(): void
    {
        $instance = new class {
            use HasPrefixCollection;
        };

        self::assertFalse(
            $instance->getPrefixTag(),
            "Should return 'false' when no tag is set.",
        );

        $instance = $instance->prefixTag(Inline::MARK);

        self::assertSame(
            Inline::MARK,
            $instance->getPrefixTag(),
            'Should return the correct prefix tag after setting it.',
        );
    }

    public function testSetPrefixValue(): void
    {
        $instance = new class {
            use HasPrefixCollection;
        };

        self::assertEmpty(
            $instance->getPrefix(),
            "Should return an empty 'string' when no prefix is set.",
        );

        $instance = $instance->prefix('Prefix content');

        self::assertSame(
            'Prefix content',
            $instance->getPrefix(),
            'Should return the correct prefix after setting it.',
        );
    }

    public function testThrowInvalidArgumentExceptionForGetPrefixAttributeEmptyKey(): void
    {
        $instance = new class {
            use HasPrefixCollection;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage(''),
        );

        $instance->getPrefixAttribute('');
    }

    public function testThrowInvalidArgumentExceptionForGetPrefixAttributeInvalidKey(): void
    {
        $instance = new class {
            use HasPrefixCollection;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage(2),
        );

        $instance->getPrefixAttribute(Priority::HIGH);
    }
}
