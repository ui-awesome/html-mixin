<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin\Tests;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Interop\{Block, BlockInterface};
use UIAwesome\Html\Mixin\HasContainer;

/**
 * Unit tests for the {@see HasContainer} trait managing the container tag and attributes.
 *
 * Test coverage.
 * - Ensures fluent setters return new instances (immutability).
 * - Sets the container attributes.
 * - Sets the container rendering flag.
 * - Sets the container tag.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('mixin')]
final class HasContainerTest extends TestCase
{
    public function testReturnNewInstanceWhenSettingContainer(): void
    {
        $instance = new class {
            use HasContainer;
        };

        self::assertNotSame(
            $instance,
            $instance->container(true),
            'Should return a new instance when setting the container flag, ensuring immutability.',
        );
    }

    public function testReturnNewInstanceWhenSettingContainerAttributes(): void
    {
        $instance = new class {
            use HasContainer;
        };

        self::assertNotSame(
            $instance,
            $instance->containerAttributes([]),
            'Should return a new instance when setting the container attributes, ensuring immutability.',
        );
    }

    public function testReturnNewInstanceWhenSettingContainerTag(): void
    {
        $instance = new class {
            use HasContainer;
        };

        self::assertNotSame(
            $instance,
            $instance->containerTag(Block::DIV),
            'Should return a new instance when setting the container tag, ensuring immutability.',
        );
    }

    public function testSetContainerAttributesValue(): void
    {
        $instance = new class {
            use HasContainer;

            /**
             * @phpstan-return mixed[]
             */
            public function getContainerAttributes(): array
            {
                return $this->containerAttributes;
            }
        };

        self::assertEmpty(
            $instance->getContainerAttributes(),
            'Should return an empty array when no attributes are set.',
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

    public function testSetContainerTagValue(): void
    {
        $instance = new class {
            use HasContainer;

            public function getContainerTag(): false|BlockInterface
            {
                return $this->containerTag;
            }
        };

        self::assertFalse(
            $instance->getContainerTag(),
            'Should return false when no tag is set.',
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
            use HasContainer;

            public function isContainer(): bool
            {
                return $this->container;
            }
        };

        self::assertFalse(
            $instance->isContainer(),
            'Should return false when container is not set.',
        );

        $instance = $instance->container(true);

        self::assertTrue(
            $instance->isContainer(),
            'Should return true after setting container to true.',
        );

        $instance = $instance->container(false);

        self::assertFalse(
            $instance->isContainer(),
            'Should return false after setting container to false.',
        );
    }
}
