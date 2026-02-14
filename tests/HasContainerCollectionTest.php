<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin\Tests;

use InvalidArgumentException;
use PHPForge\Support\Stub\BackedInteger;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
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

    public function testRemoveContainerSingleAttributeValue(): void
    {
        $instance = new class {
            use HasContainerCollection;
        };

        $instance = $instance->addContainerAttribute('id', 'container-id');
        $instance = $instance->removeContainerAttribute('id');

        self::assertNull(
            $instance->getContainerAttribute('id'),
            "Should return 'null' after removing the 'id' attribute.",
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
            $instance->containerTag(false),
            'Should return a new instance when setting the container tag, ensuring immutability.',
        );
        self::assertNotSame(
            $instance,
            $instance->addContainerAttribute('id', 'value'),
            'Should return a new instance when adding a container attribute, ensuring immutability.',
        );
        self::assertNotSame(
            $instance,
            $instance->removeContainerAttribute('id'),
            'Should return a new instance when removing a container attribute, ensuring immutability.',
        );
        self::assertNotSame(
            $instance,
            $instance->setContainerAttribute('hidden', true, 'aria-', true),
            'Should return a new instance when setting a container attribute, ensuring immutability.',
        );
    }

    public function testSetContainerAttributesValue(): void
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

    public function testSetContainerAttributesWithExistingValues(): void
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

    public function testSetContainerAttributeWithClosureValue(): void
    {
        $instance = new class {
            use HasContainerCollection;
        };

        $closure = static fn(): string => 'resolved-value';

        $instance = $instance->setContainerAttribute('test', $closure, 'event-');

        self::assertSame(
            ['event-test' => 'resolved-value'],
            $instance->getContainerAttributes(),
            "Should return the correct 'event-test' attribute after setting it.",
        );
    }

    public function testSetContainerAttributeWithNullValueRemovesAttribute(): void
    {
        $instance = new class {
            use HasContainerCollection;
        };

        $instance = $instance
            ->setContainerAttribute('label', 'Container', 'aria-')
            ->setContainerAttribute('hidden', true, 'aria-', true)
            ->setContainerAttribute('label', null, 'aria-');

        self::assertSame(
            ['aria-hidden' => 'true'],
            $instance->getContainerAttributes(),
            "Should remove the attribute when 'null' value is provided.",
        );
    }

    public function testSetContainerAttributeWithPrefixValue(): void
    {
        $instance = new class {
            use HasContainerCollection;
        };

        $instance = $instance
            ->setContainerAttribute('label', 'Container', 'aria-')
            ->setContainerAttribute('hidden', true, 'aria-', true);

        self::assertSame(
            [
                'aria-label' => 'Container',
                'aria-hidden' => 'true',
            ],
            $instance->getContainerAttributes(),
            "Should return the correct 'aria-' attributes after setting them.",
        );
    }

    public function testSetContainerAttributeWithPrefixValueAndBoolStringFalse(): void
    {
        $instance = new class {
            use HasContainerCollection;
        };

        $instance = $instance->setContainerAttribute('disabled', true, 'data-');

        self::assertSame(
            ['data-disabled' => true],
            $instance->getContainerAttributes(),
            "Should return the correct 'data-disabled' attribute after setting it.",
        );
    }

    public function testSetContainerClassValue(): void
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

    public function testSetContainerSingleAttributeValue(): void
    {
        $instance = new class {
            use HasContainerCollection;
        };

        $instance = $instance->addContainerAttribute('id', 'container-id');

        self::assertSame(
            'container-id',
            $instance->getContainerAttribute('id'),
            "Should return the correct 'id' attribute after setting it.",
        );
    }

    public function testSetContainerTagFalseValue(): void
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

    public function testSetContainerTagValue(): void
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

    public function testSetContainerValue(): void
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
