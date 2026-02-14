<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin\Tests;

use InvalidArgumentException;
use PHPForge\Support\Stub\{BackedInteger, BackedString};
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Mixin\Exception\Message;
use UIAwesome\Html\Mixin\HasAttributes;

/**
 * Unit tests for the {@see HasAttributes} trait managing HTML attributes.
 *
 * Test coverage.
 * - Ensures fluent setters return new instances (immutability).
 * - Removes attributes and returns expected values.
 * - Sets attributes in bulk and merges new values over existing keys.
 * - Sets single attributes for scalar and enum keys.
 * - Throws InvalidArgumentException for empty or unsupported attribute keys.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('mixin')]
final class HasAttributesTest extends TestCase
{
    public function testGetAttributeValue(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        self::assertNull(
            $instance->getAttribute('id'),
            "Should return 'null' when no attributes are set.",
        );

        $instance = $instance->attributes(
            [
                'class' => 'my-class',
                'id' => 'my-id',
            ],
        );

        self::assertSame(
            'my-id',
            $instance->getAttribute('id'),
            "Should return the correct 'id' attribute after setting it.",
        );
        self::assertSame(
            'my-class',
            $instance->getAttribute('class'),
            "Should return the correct 'class' attribute after setting it.",
        );
        self::assertSame(
            'default-value',
            $instance->getAttribute('missing', 'default-value'),
            'Should return the default value when the attribute does not exist.',
        );
    }

    public function testRemoveAttributeValue(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        $instance = $instance->attributes(
            [
                'class' => 'my-class',
                'id' => 'my-id',
            ],
        );
        $instance = $instance->removeAttribute('id');

        self::assertSame(
            ['class' => 'my-class'],
            $instance->getAttributes(),
            'Should return the attributes array after removing an attribute.',
        );
    }

    public function testReturnNewInstanceWhenSettingAttributes(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        self::assertNotSame(
            $instance,
            $instance->addAttribute('tests', ''),
            'Should return a new instance when adding an attribute, ensuring immutability.',
        );
        self::assertNotSame(
            $instance,
            $instance->attributes([]),
            'Should return a new instance when setting the attributes, ensuring immutability.',
        );
        self::assertNotSame(
            $instance,
            $instance->removeAttribute('tests'),
            'Should return a new instance when removing an attribute, ensuring immutability.',
        );
    }

    public function testSetAttributesValue(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        self::assertEmpty(
            $instance->getAttributes(),
            "Should return an empty 'array' when no attributes are set.",
        );

        $instance = $instance->attributes(
            [
                'class' => 'my-class',
                'id' => 'my-id',
            ],
        );

        self::assertSame(
            [
                'class' => 'my-class',
                'id' => 'my-id',
            ],
            $instance->getAttributes(),
            'Should return the correct attributes after setting them.',
        );
    }

    public function testSetAttributesWithExistingValues(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        $instance = $instance->attributes(
            ['id' => 'my-id'],
        );
        $instance = $instance->attributes(
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
            $instance->getAttributes(),
            'Should merge new attributes with existing ones, overriding duplicates.',
        );
    }

    public function testSetSingleAttributeValue(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        $instance = $instance->addAttribute('id', 'my-id');

        self::assertSame(
            'my-id',
            $instance->getAttribute('id'),
            "Should return the correct 'id' attribute after setting it.",
        );

        self::assertSame(
            ['id' => 'my-id'],
            $instance->getAttributes(),
            'Should return the correct attributes after setting a single attribute.',
        );

        $instance = $instance->addAttribute(BackedString::VALUE, 'active-status');

        self::assertSame(
            'active-status',
            $instance->getAttribute(BackedString::VALUE),
            'Should return the value when using an enum key.',
        );
    }

    public function testSetSingleAttributeWithNullValue(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        $instance = $instance->addAttribute('id', 'my-id');
        $instance = $instance->addAttribute('id', null);

        self::assertNull(
            $instance->getAttribute('id'),
            "Should return 'null' after setting the attribute to 'null'.",
        );
    }

    public function testThrowInvalidArgumentExceptionForGetAttributeEmptyKey(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage(''),
        );

        $instance->getAttribute('');
    }

    public function testThrowInvalidArgumentExceptionForGetAttributeInvalidKey(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage(2),
        );

        $instance->getAttribute(BackedInteger::VALUE);
    }

    public function testThrowInvalidArgumentExceptionForSetSingleAttributeWithEmptyKey(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage(''),
        );

        $instance->addAttribute('', 'value');
    }

    public function testThrowInvalidArgumentExceptionForSetSingleAttributeWithInvalidKey(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage(2),
        );

        $instance->addAttribute(BackedInteger::VALUE, 'value');
    }
}
