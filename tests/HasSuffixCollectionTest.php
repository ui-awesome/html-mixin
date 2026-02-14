<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin\Tests;

use InvalidArgumentException;
use PHPForge\Support\Stub\BackedInteger;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Stringable;
use UIAwesome\Html\Interop\{Block, Inline};
use UIAwesome\Html\Mixin\Exception\Message;
use UIAwesome\Html\Mixin\HasSuffixCollection;

/**
 * Unit tests for the {@see HasSuffixCollection} trait managing suffix content, tag, and attributes.
 *
 * Test coverage.
 * - Ensures fluent setters return new instances (immutability).
 * - Merges new suffix attributes with existing ones, overriding duplicates.
 * - Sets the suffix attributes.
 * - Sets the suffix class, including class override behavior.
 * - Sets the suffix tag and supports resetting it to `false`.
 * - Sets the suffix value from strings, variadic parts, and `Stringable` objects.
 * - Throws InvalidArgumentException for empty or unsupported suffix attribute keys.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('mixin')]
final class HasSuffixCollectionTest extends TestCase
{
    public function testGetSuffixAttributeValue(): void
    {
        $instance = new class {
            use HasSuffixCollection;
        };

        self::assertNull(
            $instance->getSuffixAttribute('id'),
            "Should return 'null' when no attributes are set.",
        );

        $instance = $instance->suffixAttributes(
            [
                'class' => 'suffix-class',
                'id' => 'suffix-id',
            ],
        );

        self::assertSame(
            'suffix-id',
            $instance->getSuffixAttribute('id'),
            "Should return the correct 'id' attribute after setting it.",
        );
        self::assertSame(
            'suffix-class',
            $instance->getSuffixAttribute('class'),
            "Should return the correct 'class' attribute after setting it.",
        );
        self::assertSame(
            'default-value',
            $instance->getSuffixAttribute('missing', 'default-value'),
            'Should return the default value when the suffix attribute does not exist.',
        );
    }

    public function testReturnNewInstanceWhenSettingSuffixCollection(): void
    {
        $instance = new class {
            use HasSuffixCollection;
        };

        self::assertNotSame(
            $instance,
            $instance->suffix(''),
            'Should return a new instance when setting the suffix, ensuring immutability.',
        );
        self::assertNotSame(
            $instance,
            $instance->suffixAttributes([]),
            'Should return a new instance when setting the suffix attributes, ensuring immutability.',
        );
        self::assertNotSame(
            $instance,
            $instance->suffixClass('class-name'),
            'Should return a new instance when setting the suffix class, ensuring immutability.',
        );
        self::assertNotSame(
            $instance,
            $instance->suffixTag(Inline::MARK),
            'Should return a new instance when setting the suffix tag, ensuring immutability.',
        );
    }

    public function testSetSuffixAttributesValue(): void
    {
        $instance = new class {
            use HasSuffixCollection;
        };

        self::assertEmpty(
            $instance->getSuffixAttributes(),
            'Should return an empty array when no attributes are set.',
        );

        $instance = $instance->suffixAttributes(
            [
                'data-value' => '123',
                'id' => 'suffix-id',
            ],
        );

        self::assertSame(
            [
                'data-value' => '123',
                'id' => 'suffix-id',
            ],
            $instance->getSuffixAttributes(),
            'Should return the correct suffix attributes after setting them.',
        );
    }

    public function testSetSuffixAttributesWithExistingValues(): void
    {
        $instance = new class {
            use HasSuffixCollection;
        };

        $instance = $instance->suffixAttributes(
            [
                'id' => 'my-id',
            ],
        );
        $instance = $instance->suffixAttributes(
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
            $instance->getSuffixAttributes(),
            'Should merge new attributes with existing ones, overriding duplicates.',
        );
    }

    public function testSetSuffixClassValue(): void
    {
        $instance = new class {
            use HasSuffixCollection;
        };

        self::assertEmpty(
            $instance->getSuffixAttributes(),
            'Should return an empty array when no attributes are set.',
        );

        $instance = $instance->suffixClass('suffix-class');

        self::assertSame(
            'suffix-class',
            $instance->getSuffixAttribute('class', ''),
            'Should return the correct suffix class after setting it.',
        );

        $instance = $instance->suffixClass('suffix-class-1');

        self::assertSame(
            'suffix-class suffix-class-1',
            $instance->getSuffixAttribute('class', ''),
            'Should return the correct suffix class after setting it.',
        );

        $instance = $instance->suffixClass('override-class', true);

        self::assertSame(
            'override-class',
            $instance->getSuffixAttribute('class', ''),
            'Should return the correct suffix class after setting it.',
        );
    }

    public function testSetSuffixTagFalseValue(): void
    {
        $instance = new class {
            use HasSuffixCollection;
        };

        $instance = $instance->suffixTag(Block::DIV);

        $instance = $instance->suffixTag(false);

        self::assertFalse(
            $instance->getSuffixTag(),
            "Should return 'false' after setting the suffix tag to 'false'.",
        );
    }

    public function testSetSuffixTagValue(): void
    {
        $instance = new class {
            use HasSuffixCollection;
        };

        self::assertFalse(
            $instance->getSuffixTag(),
            "Should return 'false' when no tag is set.",
        );

        $instance = $instance->suffixTag(Block::DIV);

        self::assertSame(
            Block::DIV,
            $instance->getSuffixTag(),
            'Should return the correct suffix tag after setting it.',
        );
    }

    public function testSetSuffixValue(): void
    {
        $instance = new class {
            use HasSuffixCollection;
        };

        self::assertEmpty(
            $instance->getSuffix(),
            'Should return an empty string when no suffix is set.',
        );

        $instance = $instance->suffix('Suffix content');

        self::assertSame(
            'Suffix content',
            $instance->getSuffix(),
            'Should return the correct suffix after setting it.',
        );
    }

    public function testSetSuffixValueWithMultipleArguments(): void
    {
        $instance = new class {
            use HasSuffixCollection;
        };

        $instance = $instance->suffix('Suffix', ' ', 'content');

        self::assertSame(
            'Suffix content',
            $instance->getSuffix(),
            'Should concatenate multiple suffix arguments.',
        );
    }

    public function testSetSuffixValueWithStringable(): void
    {
        $instance = new class {
            use HasSuffixCollection;
        };

        $stringable = new class implements Stringable {
            public function __toString(): string
            {
                return 'Stringable content';
            }
        };

        $instance = $instance->suffix($stringable);

        self::assertSame(
            'Stringable content',
            $instance->getSuffix(),
            'Should handle Stringable objects correctly.',
        );
    }

    public function testThrowInvalidArgumentExceptionForGetSuffixAttributeEmptyKey(): void
    {
        $instance = new class {
            use HasSuffixCollection;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage(''),
        );

        $instance->getSuffixAttribute('');
    }

    public function testThrowInvalidArgumentExceptionForGetSuffixAttributeInvalidKey(): void
    {
        $instance = new class {
            use HasSuffixCollection;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage(2),
        );

        $instance->getSuffixAttribute(BackedInteger::VALUE);
    }
}
