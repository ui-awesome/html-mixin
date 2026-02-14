<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin\Tests;

use InvalidArgumentException;
use PHPForge\Support\Stub\BackedInteger;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Stringable;
use UIAwesome\Html\Interop\Block;
use UIAwesome\Html\Mixin\Exception\Message;
use UIAwesome\Html\Mixin\HasContainerCollection;

/**
 * Unit tests for the {@see HasContainerCollection} trait managing the container tag and attributes.
 *
 * Test coverage.
 * - Ensures fluent setters return new instances (immutability).
 * - Merges new container attributes with existing attributes and overrides duplicate keys.
 * - Sets container attributes and returns expected values.
 * - Sets container CSS classes, including merged and overridden values.
 * - Sets container tag values and supports disabling the tag.
 * - Throws InvalidArgumentException for empty or unsupported container attribute keys.
 * - Verifies container rendering state after enabling and disabling it.
 *
 * @copyright Copyright (C) 2026 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('mixin')]
final class HasContainerCollectionTest extends TestCase
{
    public function testContainerAttributesValue(): void
    {
        $instance = new class {
            use HasContainerCollection;
        };

        self::assertEmpty(
            $instance->getContainerAttributes(),
            "Should return an empty 'array' when no attributes are set.",
        );

        $instance = $instance->containerAttributes(
            [
                'class' => 'container',
                'id' => 'container-id',
            ],
        );

        self::assertSame(
            [
                'class' => 'container',
                'id' => 'container-id',
            ],
            $instance->getContainerAttributes(),
            'Should return the correct container attributes after setting them.',
        );
    }

    public function testContainerAttributesWithExistingValues(): void
    {
        $instance = new class {
            use HasContainerCollection;
        };

        $instance = $instance->containerAttributes(
            [
                'id' => 'my-id',
            ],
        );
        $instance = $instance->containerAttributes(
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
            $instance->getContainerAttributes(),
            'Should merge new attributes with existing ones, overriding duplicates.',
        );
    }

    public function testContainerClassValue(): void
    {
        $instance = new class {
            use HasContainerCollection;
        };

        self::assertEmpty(
            $instance->getContainerAttributes(),
            "Should return an empty 'array' when no attributes are set.",
        );

        $instance = $instance->containerClass('container-class');

        self::assertSame(
            'container-class',
            $instance->getContainerAttribute('class', ''),
            "Should return the correct container 'class' attribute after setting it.",
        );

        $instance = $instance->containerClass('container-class-1');

        self::assertSame(
            'container-class container-class-1',
            $instance->getContainerAttribute('class', ''),
            "Should return the correct container 'class' attribute after setting it.",
        );

        $instance = $instance->containerClass('override-class', true);

        self::assertSame(
            'override-class',
            $instance->getContainerAttribute('class', ''),
            "Should return the correct container 'class' attribute after setting it.",
        );
    }

    public function testContainerRemoveAttributeValue(): void
    {
        $instance = new class {
            use HasContainerCollection;
        };

        $instance = $instance->containerAttributes(
            [
                'class' => 'my-class',
                'id' => 'my-id',
            ],
        );
        $instance = $instance->containerRemoveAttribute('id');

        self::assertNull(
            $instance->getContainerAttribute('id'),
            "Should return 'null' after removing the 'id' attribute.",
        );
    }

    public function testContainerSetAttributeValue(): void
    {
        $instance = new class {
            use HasContainerCollection;
        };

        $instance = $instance->containerSetAttribute('id', 'container-id');

        self::assertSame(
            'container-id',
            $instance->getContainerAttribute('id'),
            "Should return the correct 'id' attribute after setting it.",
        );
    }

    public function testContainerSetAttributeWithClosureValue(): void
    {
        $instance = new class {
            use HasContainerCollection;
        };

        $closure = static fn(): string => 'resolved-value';

        $instance = $instance->containerSetAttribute('event-test', $closure);

        self::assertSame(
            ['event-test' => $closure],
            $instance->getContainerAttributes(),
            "Should return the correct 'event-test' attribute after setting it.",
        );
    }

    public function testContainerSetAttributeWithNullValueRemovesAttribute(): void
    {
        $instance = new class {
            use HasContainerCollection;
        };

        $instance = $instance
            ->containerSetAttribute('aria-label', 'Container')
            ->containerSetAttribute('aria-hidden', true)
            ->containerSetAttribute('aria-label', null);

        self::assertSame(
            ['aria-hidden' => true],
            $instance->getContainerAttributes(),
            "Should remove the attribute when 'null' value is provided.",
        );
    }

    public function testContainerSetAttributeWithStringableValue(): void
    {
        $instance = new class {
            use HasContainerCollection;
        };

        $stringable = new class implements Stringable {
            public function __toString(): string
            {
                return 'Stringable value';
            }
        };

        $instance = $instance->containerSetAttribute('stringable', $stringable);

        self::assertSame(
            $stringable,
            $instance->getContainerAttribute('stringable'),
            'Should handle Stringable objects correctly.',
        );
    }

    public function testContainerTagFalseValue(): void
    {
        $instance = new class {
            use HasContainerCollection;
        };

        $instance = $instance->containerTag(Block::SECTION);
        $instance = $instance->containerTag(false);

        self::assertFalse(
            $instance->getContainerTag(),
            "Should return 'false' after setting the container tag to 'false'.",
        );
    }

    public function testContainerTagValue(): void
    {
        $instance = new class {
            use HasContainerCollection;
        };

        self::assertFalse(
            $instance->getContainerTag(),
            "Should return 'false' when no tag is set.",
        );

        $instance = $instance->containerTag(Block::SECTION);

        self::assertSame(
            Block::SECTION,
            $instance->getContainerTag(),
            'Should return the correct container tag after setting it.',
        );
    }
    public function testGetContainerAttributeValue(): void
    {
        $instance = new class {
            use HasContainerCollection;
        };

        self::assertNull(
            $instance->getContainerAttribute('id'),
            "Should return 'null' when no attributes are set.",
        );

        $instance = $instance->containerAttributes(
            [
                'class' => 'container-class',
                'id' => 'container-id',
            ],
        );

        self::assertSame(
            'container-id',
            $instance->getContainerAttribute('id'),
            "Should return the correct 'id' attribute after setting it.",
        );
        self::assertSame(
            'container-class',
            $instance->getContainerAttribute('class'),
            "Should return the correct 'class' attribute after setting it.",
        );
        self::assertSame(
            'default-value',
            $instance->getContainerAttribute('missing', 'default-value'),
            'Should return the default value when the container attribute does not exist.',
        );
    }

    public function testIsContainerValue(): void
    {
        $instance = new class {
            use HasContainerCollection;
        };

        self::assertFalse(
            $instance->isContainer(),
            "Should return 'false' when container is not set.",
        );

        $instance = $instance->container(true);

        self::assertTrue(
            $instance->isContainer(),
            "Should return 'true' after setting container to 'true'.",
        );

        $instance = $instance->container(false);

        self::assertFalse(
            $instance->isContainer(),
            "Should return 'false' after setting container to 'false'.",
        );
    }

    public function testReturnNewInstanceWhenSettingContainerCollection(): void
    {
        $instance = new class {
            use HasContainerCollection;
        };

        self::assertNotSame(
            $instance,
            $instance->container(true),
            'Should return a new instance when setting the container, ensuring immutability.',
        );
        self::assertNotSame(
            $instance,
            $instance->containerAttributes([]),
            'Should return a new instance when setting the container attributes, ensuring immutability.',
        );
        self::assertNotSame(
            $instance,
            $instance->containerClass(''),
            "Should return a new instance when setting the container 'class' attribute, ensuring immutability.",
        );
        self::assertNotSame(
            $instance,
            $instance->containerRemoveAttribute('tests'),
            'Should return a new instance when removing a container attribute, ensuring immutability.',
        );
        self::assertNotSame(
            $instance,
            $instance->containerSetAttribute('tests', ''),
            'Should return a new instance when setting a container attribute, ensuring immutability.',
        );
        self::assertNotSame(
            $instance,
            $instance->containerTag(false),
            'Should return a new instance when setting the container tag, ensuring immutability.',
        );
    }

    public function testThrowInvalidArgumentExceptionForGetContainerAttributeEmptyKey(): void
    {
        $instance = new class {
            use HasContainerCollection;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage(''),
        );

        $instance->getContainerAttribute('');
    }

    public function testThrowInvalidArgumentExceptionForGetContainerAttributeInvalidKey(): void
    {
        $instance = new class {
            use HasContainerCollection;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage(2),
        );

        $instance->getContainerAttribute(BackedInteger::VALUE);
    }
}
