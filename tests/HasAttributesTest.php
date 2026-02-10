<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin\Tests;

use Closure;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\{DataProviderExternal, Group};
use PHPUnit\Framework\TestCase;
use Stringable;
use UIAwesome\Html\Mixin\Exception\Message;
use UIAwesome\Html\Mixin\HasAttributes;
use UIAwesome\Html\Mixin\Tests\Support\Provider\AttributeProvider;
use UIAwesome\Html\Mixin\Tests\Support\Stub\Enum\{Priority, Status};
use UnitEnum;

/**
 * Unit tests for the {@see HasAttributes} trait managing HTML attributes.
 *
 * Test coverage.
 * - Ensures `getAttribute()` returns default values or `null` for missing keys without mutating attributes.
 * - Ensures fluent setters return new instances (immutability).
 * - Sets attributes in bulk and merges new values over existing keys.
 * - Sets prefixed attributes, including closure resolution and null-based removal.
 * - Sets single attributes for scalar and enum keys.
 * - Throws `InvalidArgumentException` for empty or unsupported attribute keys.
 * - Verifies attribute retrieval for existing keys, including enum keys.
 *
 * {@see AttributeProvider} for test case data providers.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('mixin')]
final class HasAttributesTest extends TestCase
{
    public function testGetAttributeDoesNotMutateInstance(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        $instance = $instance->attributes(['id' => 'my-id']);
        $originalAttributes = $instance->getAttributes();

        $instance->getAttribute('id');
        $instance->getAttribute('nonexistent', 'default');

        self::assertSame(
            $originalAttributes,
            $instance->getAttributes(),
            'Should return the original attributes array when calling get attribute, ensuring immutability.',
        );
    }

    public function testGetAttributeReturnsDefaultWhenAttributeDoesNotExist(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        self::assertSame(
            'default-value',
            $instance->getAttribute('nonexistent', 'default-value'),
            'Should return the default value when the attribute does not exist.',
        );
        self::assertSame(
            42,
            $instance->getAttribute('missing', 42),
            'Should return the default value when the attribute does not exist.',
        );
    }

    public function testGetAttributeReturnsNullWhenAttributeDoesNotExist(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        self::assertNull(
            $instance->getAttribute('nonexistent'),
            "Should return 'null' when the attribute does not exist and no default is provided.",
        );
    }

    public function testGetAttributeReturnsValueWhenAttributeExists(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        $instance = $instance->attributes(['id' => 'my-id', 'class' => 'my-class']);

        self::assertSame(
            'my-id',
            $instance->getAttribute('id'),
            'Should return the value of the attribute when it exists.',
        );
        self::assertSame(
            'my-class',
            $instance->getAttribute('class'),
            'Should return the value of the attribute when it exists.',
        );
    }

    public function testGetAttributeWithEnumKey(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        $instance = $instance->addAttribute(Status::ACTIVE, 'active-status');

        self::assertSame(
            'active-status',
            $instance->getAttribute(Status::ACTIVE),
            'Should return the value when using an enum key.',
        );
    }

    public function testRemoveAttributeValue(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        $instance = $instance->attributes(['id' => 'my-id', 'class' => 'my-class']);
        $instance = $instance->removeAttribute('id');

        self::assertSame(
            ['class' => 'my-class'],
            $instance->getAttributes(),
            'Should return the attributes array after removing an attribute.',
        );
    }

    public function testReturnEmptyArrayWhenAttributesNotSet(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        self::assertSame(
            [],
            $instance->getAttributes(),
            'Should return an empty array when no attributes are set.',
        );
    }

    public function testReturnNewInstanceWhenSettingAttributes(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        self::assertNotSame(
            $instance,
            $instance->addAttribute('key', 'value'),
            'Should return a new instance when adding an attribute, ensuring immutability.',
        );
        self::assertNotSame(
            $instance,
            $instance->attributes([]),
            'Should return a new instance when setting the attributes, ensuring immutability.',
        );
        self::assertNotSame(
            $instance,
            $instance->removeAttribute('key'),
            'Should return a new instance when removing an attribute, ensuring immutability.',
        );
    }

    /**
     * @phpstan-param mixed[] $attributes
     * @phpstan-param mixed[] $expected
     */
    #[DataProviderExternal(AttributeProvider::class, 'values')]
    public function testSetAttributesValue(array $attributes, array $expected, string $message): void
    {
        $instance = new class {
            use HasAttributes;
        };

        $instance = $instance->attributes($attributes);

        self::assertSame(
            $expected,
            $instance->getAttributes(),
            $message,
        );
    }

    public function testSetAttributesWithExistingValues(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        $instance = $instance->attributes(
            [
                'id' => 'my-id',
            ],
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

    public function testSetAttributesWithPrefixValue(): void
    {
        $instance = new class {
            use HasAttributes;

            /**
             * @phpstan-param scalar|null|Closure(): mixed $value
             */
            public function addAriaAttribute(
                string|UnitEnum $key,
                bool|float|int|string|Closure|Stringable|UnitEnum|null $value,
            ): static {
                $new = clone $this;

                $new->setAttribute($key, $value, 'aria-', true);

                return $new;
            }
        };

        $instance = $instance
            ->addAriaAttribute('label', 'Label')
            ->addAriaAttribute('hidden', true);

        self::assertSame(
            [
                'aria-label' => 'Label',
                'aria-hidden' => 'true',
            ],
            $instance->getAttributes(),
            'Should set attribute with prefix correctly.',
        );
    }

    public function testSetAttributesWithPrefixValueAndBoolStringFalse(): void
    {
        $instance = new class {
            use HasAttributes;

            /**
             * @phpstan-param scalar|null|Closure(): mixed $value
             */
            public function addDataAttribute(
                string|UnitEnum $key,
                bool|float|int|string|Closure|Stringable|UnitEnum|null $value,
            ): static {
                $new = clone $this;

                $new->setAttribute($key, $value, 'data-');

                return $new;
            }
        };

        $instance = $instance->addDataAttribute('disabled', true);

        self::assertSame(
            ['data-disabled' => true],
            $instance->getAttributes(),
            'Should set attribute with prefix correctly.',
        );
    }

    public function testSetAttributeWithClosureValue(): void
    {
        $instance = new class {
            use HasAttributes;

            /**
             * @phpstan-param scalar|null|Closure(): mixed $value
             */
            public function addDataAttribute(
                string|UnitEnum $key,
                bool|float|int|string|Closure|Stringable|UnitEnum|null $value,
            ): static {
                $new = clone $this;

                $new->setAttribute($key, $value, 'data-');

                return $new;
            }
        };

        $closure = static fn(): string => 'resolved-value';
        $instance = $instance->addDataAttribute('test', $closure);

        self::assertSame(
            ['data-test' => 'resolved-value'],
            $instance->getAttributes(),
            'Should execute the closure and set the resolved value as the attribute value.',
        );
    }

    public function testSetAttributeWithNullValueRemovesAttribute(): void
    {
        $instance = new class {
            use HasAttributes;

            /**
             * @phpstan-param scalar|null|Closure(): mixed $value
             */
            public function addAriaAttribute(
                string|UnitEnum $key,
                bool|float|int|string|Closure|Stringable|UnitEnum|null $value,
            ): static {
                $new = clone $this;

                $new->setAttribute($key, $value, 'aria-', true);

                return $new;
            }
        };

        $instance = $instance
            ->addAriaAttribute('label', 'Label')
            ->addAriaAttribute('hidden', true)
            ->addAriaAttribute('label', null);

        self::assertSame(
            ['aria-hidden' => 'true'],
            $instance->getAttributes(),
            'Should remove the attribute when null value is provided via setAttribute.',
        );
    }

    /**
     * @phpstan-param scalar|null|Closure(): mixed $value
     * @phpstan-param mixed[] $expected
     */
    #[DataProviderExternal(AttributeProvider::class, 'value')]
    public function testSetSingleAttributeValue(
        string|UnitEnum $key,
        bool|float|int|string|Closure|null $value,
        array $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
        };

        $instance = $instance->addAttribute($key, $value);

        self::assertSame(
            $expected,
            $instance->getAttributes(),
            $message,
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

        $instance->getAttribute(Priority::HIGH);
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

        $instance->addAttribute(Priority::HIGH, 'value');
    }
}
