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
use UIAwesome\Html\Mixin\Tests\Support\ExposeHasAttributesInternals;

/**
 * Unit tests for the {@see HasAttributes} trait managing HTML attributes.
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

    public function testAttributesMergeExistingValues(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        $instance = $instance->attributes(['id' => 'my-id']);
        $instance = $instance->attributes(['class' => 'my-class']);
        $instance = $instance->attributes(['class' => 'new-class']);

        self::assertSame(
            [
                'id' => 'my-id',
                'class' => 'new-class',
            ],
            $instance->getAttributes(),
            'Should merge new attributes and update existing attributes.',
        );
    }

    public function testAttributesPrefixSupportThroughProtectedInternals(): void
    {
        $instance = new class {
            use ExposeHasAttributesInternals;
            use HasAttributes;
        };

        $instance = $instance->setAttributeForTest('label', 'label', 'aria-');

        self::assertSame(
            'label',
            $instance->getAttribute('aria-label'),
            "Should read the prefixed 'aria-label' attribute when using the 'aria-' prefix.",
        );
        self::assertNull(
            $instance->getAttribute('label'),
            "Should not read the prefixed 'aria-label' attribute without the prefix.",
        );

        $instance = $instance->setAttributesForTest(['describedby' => 'field-id'], 'aria-');

        self::assertSame(
            'field-id',
            $instance->getAttribute('aria-describedby'),
            "Should set and read prefixed attributes via internal 'setAttributes()'.",
        );
        self::assertSame(
            [
                'aria-label' => 'label',
                'aria-describedby' => 'field-id',
            ],
            $instance->getAttributes(),
            'Should merge prefixed attributes in bulk.',
        );

        $instance = $instance->removeAttribute('aria-describedby');

        self::assertNull(
            $instance->getAttribute('aria-describedby'),
            "Should remove the prefixed 'aria-describedby' attribute.",
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

    public function testReplaceAttributesReplacesExistingValues(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        $original = $instance->attributes(['id' => 'my-id']);
        $replacement = $original->replaceAttributes(['class' => 'my-class']);

        self::assertSame(
            ['id' => 'my-id'],
            $original->getAttributes(),
            'Should keep the original attributes unchanged after explicit replacement.',
        );
        self::assertSame(
            ['class' => 'my-class'],
            $replacement->getAttributes(),
            'Should replace existing attributes through the explicit replacement API.',
        );
    }

    public function testReturnNewInstanceWhenSettingAttributes(): void
    {
        $instance = new class {
            use ExposeHasAttributesInternals;
            use HasAttributes;
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
            $instance->replaceAttributes([]),
            'Should return a new instance when replacing attributes, ensuring immutability.',
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
            use ExposeHasAttributesInternals;
            use HasAttributes;
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
