<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin\Tests;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Stringable;
use UIAwesome\Html\Interop\{Block, BlockInterface, Inline, InlineInterface, VoidInterface};
use UIAwesome\Html\Mixin\HasSuffixCollection;

/**
 * Unit tests for {@see HasSuffixCollection} trait behavior.
 *
 * Verifies observable behavior for {@see HasSuffixCollection} based on this test file only (test methods and
 * assertions).
 *
 * Test coverage.
 * - Immutability for suffix-related setters.
 * - Suffix attribute assignment.
 * - Suffix class handling, including the override flag.
 * - Suffix string concatenation with variadic arguments.
 * - Suffix tag storage and reset.
 *
 * {@see HasSuffixCollection} for implementation details.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('mixin')]
final class HasSuffixCollectionTest extends TestCase
{
    public function testReturnNewInstanceWhenSettingAttributes(): void
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

            /**
             * @phpstan-return mixed[]
             */
            public function getSuffixAttributes(): array
            {
                return $this->suffixAttributes;
            }
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

    public function testSetSuffixClassValue(): void
    {
        $instance = new class {
            use HasSuffixCollection;

            /**
             * @phpstan-return mixed[]
             */
            public function getSuffixAttributes(): array
            {
                return $this->suffixAttributes;
            }
        };

        self::assertEmpty(
            $instance->getSuffixAttributes(),
            'Should return an empty array when no attributes are set.',
        );

        $instance = $instance->suffixClass('suffix-class');

        self::assertSame(
            'suffix-class',
            $instance->getSuffixAttributes()['class'] ?? '',
            'Should return the correct suffix class after setting it.',
        );

        $instance = $instance->suffixClass('suffix-class-1');

        self::assertSame(
            'suffix-class suffix-class-1',
            $instance->getSuffixAttributes()['class'] ?? '',
            'Should return the correct suffix class after setting it.',
        );

        $instance = $instance->suffixClass('override-class', true);

        self::assertSame(
            'override-class',
            $instance->getSuffixAttributes()['class'] ?? '',
            'Should return the correct suffix class after setting it.',
        );
    }

    public function testSetSuffixTagValue(): void
    {
        $instance = new class {
            use HasSuffixCollection;

            public function getSuffixTag(): bool|BlockInterface|InlineInterface|VoidInterface
            {
                return $this->suffixTag;
            }
        };

        self::assertFalse(
            $instance->getSuffixTag(),
            'Should return false when no tag is set.',
        );

        $instance = $instance->suffixTag(Block::DIV);

        self::assertSame(
            Block::DIV,
            $instance->getSuffixTag(),
            'Should return the correct suffix tag after setting it.',
        );

        $instance = $instance->suffixTag(false);

        self::assertFalse(
            $instance->getSuffixTag(),
            "Should return 'false' after resetting the suffix tag.",
        );
    }

    public function testSetSuffixValue(): void
    {
        $instance = new class {
            use HasSuffixCollection;

            public function getSuffix(): string
            {
                return $this->suffix;
            }
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

            public function getSuffix(): string
            {
                return $this->suffix;
            }
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

            public function getSuffix(): string
            {
                return $this->suffix;
            }
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
}
