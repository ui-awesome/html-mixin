<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin\Tests;

use InvalidArgumentException;
use PHPForge\Support\Stub\{BackedInteger, BackedString};
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Stringable;
use UIAwesome\Html\Helper\Exception\Message;
use UIAwesome\Html\Mixin\HasAttributes;
use UnitEnum;

/**
 * Unit tests for the {@see HasAttributes} trait managing HTML attributes.
 *
 * Test coverage.
 * - Adds single attributes through the public API.
 * - Ensures fluent setters return new instances (immutability).
 * - Replaces attributes through the public API.
 * - Removes attributes and returns expected values.
 * - Sets prefixed attributes through protected internals exposed by test stubs.
 * - Throws InvalidArgumentException for empty or unsupported attribute keys.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('mixin')]
final class HasAttributesTest extends TestCase
{
    public function testAddAttributeValue(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        $instance = $instance->addAttribute('id', 'my-id');

        self::assertSame(
            'my-id',
            $instance->getAttribute('id'),
            "Should return the correct 'id' attribute after adding it.",
        );
        self::assertSame(
            ['id' => 'my-id'],
            $instance->getAttributes(),
            'Should return the correct attributes after adding a single attribute.',
        );

        $instance = $instance->addAttribute(BackedString::VALUE, 'active-status');

        self::assertSame(
            'active-status',
            $instance->getAttribute(BackedString::VALUE),
            'Should return the value when using an enum key.',
        );
    }

    public function testAddAttributeWithNullValueRemovesAttribute(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        $instance = $instance->addAttribute('id', 'my-id')->addAttribute('id', null);

        self::assertNull(
            $instance->getAttribute('id'),
            "Should return 'null' after adding the attribute with a 'null' value.",
        );
        self::assertSame(
            [],
            $instance->getAttributes(),
            "Should remove the attribute key when the value is 'null'.",
        );
    }

    public function testAddAttributeWithStringableValue(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        $stringable = new class implements Stringable {
            public function __toString(): string
            {
                return 'Stringable value';
            }
        };

        $instance = $instance->addAttribute('stringable', $stringable);

        self::assertSame(
            $stringable,
            $instance->getAttribute('stringable'),
            'Should handle Stringable objects correctly.',
        );
    }

    public function testAttributesPrefixSupportThroughProtectedInternals(): void
    {
        $instance = new class {
            use HasAttributes;

            public function getAttributeForTest(string|UnitEnum $key, mixed $default = null, string $prefix = ''): mixed
            {
                return \UIAwesome\Html\Helper\AttributeBag::get($this->attributes, $key, $default, $prefix);
            }

            public function removeAttributeForTest(string|UnitEnum $key, string $prefix = ''): static
            {
                $new = clone $this;

                \UIAwesome\Html\Helper\AttributeBag::remove($new->attributes, $key, $prefix);

                return $new;
            }

            public function setAttributeForTest(string|UnitEnum $key, mixed $value, string $prefix = ''): static
            {
                return $this->setAttribute($key, $value, $prefix);
            }

            /**
             * @param mixed[] $values
             */
            public function setAttributesForTest(array $values, string $prefix = ''): static
            {
                return $this->setAttributes($values, $prefix);
            }
        };

        $instance = $instance->setAttributeForTest('label', 'label', 'aria-');

        self::assertSame(
            'label',
            $instance->getAttributeForTest('label', null, 'aria-'),
            "Should read the prefixed 'aria-label' attribute when using the 'aria-' prefix.",
        );
        self::assertNull(
            $instance->getAttribute('label'),
            "Should not read the prefixed 'aria-label' attribute without the prefix.",
        );

        $instance = $instance->setAttributesForTest(['describedby' => 'field-id'], 'aria-');

        self::assertSame(
            'field-id',
            $instance->getAttributeForTest('describedby', null, 'aria-'),
            "Should set and read prefixed attributes via internal 'setAttributes()'.",
        );
        self::assertSame(
            ['aria-describedby' => 'field-id'],
            $instance->getAttributes(),
            'Should replace the attribute bag when setting prefixed attributes in bulk.',
        );

        $instance = $instance->removeAttributeForTest('describedby', 'aria-');

        self::assertNull(
            $instance->getAttributeForTest('describedby', null, 'aria-'),
            "Should remove the prefixed 'aria-describedby' attribute.",
        );
    }

    public function testAttributesReplaceExistingValues(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        $instance = $instance->attributes(['id' => 'my-id']);
        $instance = $instance->attributes(['class' => 'my-class']);

        self::assertSame(
            ['class' => 'my-class'],
            $instance->getAttributes(),
            'Should replace existing attributes instead of merging them.',
        );
    }

    public function testAttributesValue(): void
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

            public function setAttributeForTest(string|UnitEnum $key, mixed $value, string $prefix = ''): static
            {
                return $this->setAttribute($key, $value, $prefix);
            }

            /**
             * @phpstan-param mixed[] $values
             */
            public function setAttributesForTest(array $values, string $prefix = ''): static
            {
                return $this->setAttributes($values, $prefix);
            }
        };

        self::assertNotSame(
            $instance,
            $instance->attributes([]),
            'Should return a new instance when setting the attributes, ensuring immutability.',
        );
        self::assertNotSame(
            $instance,
            $instance->addAttribute('tests', ''),
            'Should return a new instance when adding an attribute, ensuring immutability.',
        );
        self::assertNotSame(
            $instance,
            $instance->removeAttribute('tests'),
            'Should return a new instance when removing an attribute, ensuring immutability.',
        );
        self::assertNotSame(
            $instance,
            $instance->setAttributeForTest('tests', ''),
            'Should return a new instance when setting an internal attribute, ensuring immutability.',
        );
        self::assertNotSame(
            $instance,
            $instance->setAttributesForTest([]),
            'Should return a new instance when setting internal attributes, ensuring immutability.',
        );
    }

    public function testSetAttributeWithClosureValueThroughProtectedInternal(): void
    {
        $instance = new class {
            use HasAttributes;

            public function setAttributeForTest(string|UnitEnum $key, mixed $value, string $prefix = ''): static
            {
                return $this->setAttribute($key, $value, $prefix);
            }
        };

        $instance = $instance->setAttributeForTest('test', static fn(): string => 'resolved-value');

        self::assertSame(
            ['test' => 'resolved-value'],
            $instance->getAttributes(),
            "Should return the correct 'test' attribute after setting it.",
        );
    }

    public function testThrowInvalidArgumentExceptionForAddAttributeEmptyKey(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage());

        $instance->addAttribute('', 'value');
    }

    public function testThrowInvalidArgumentExceptionForAddAttributeInvalidKey(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage());

        $instance->addAttribute(BackedInteger::VALUE, 'value');
    }

    public function testThrowInvalidArgumentExceptionForGetAttributeEmptyKey(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage());

        $instance->getAttribute('');
    }

    public function testThrowInvalidArgumentExceptionForGetAttributeInvalidKey(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage());

        $instance->getAttribute(BackedInteger::VALUE);
    }
}
