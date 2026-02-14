<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Mixin\Exception\Message;
use UIAwesome\Html\Mixin\HasLabelCollection;
use UIAwesome\Html\Mixin\Tests\Support\Stub\Enum\Priority;

/**
 * Unit tests for the {@see HasLabelCollection} trait managing label content and label attributes.
 *
 * Test coverage.
 * - Ensures fluent setters return new instances (immutability).
 * - Merges new label attributes with existing attributes and overrides duplicate keys.
 * - Sets label attributes and returns expected values.
 * - Sets label CSS classes, including merged and overridden values.
 * - Sets label for attribute and returns expected value.
 * - Sets label text content and returns the expected value.
 * - Throws InvalidArgumentException for empty or unsupported attribute keys.
 * - Verifies label rendering state after setting content and disabling rendering.
 *
 * @copyright Copyright (C) 2026 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('mixin')]
final class HasLabelCollectionTest extends TestCase
{
    public function testIsLabel(): void
    {
        $instance = new class {
            use HasLabelCollection;
        };

        self::assertFalse(
            $instance->isLabel(),
            "Should return 'false' when label content is empty.",
        );

        $instance = $instance->label('My Label');

        self::assertTrue(
            $instance->isLabel(),
            "Should return 'true' after setting label content.",
        );

        $instance = $instance->notLabel();

        self::assertFalse(
            $instance->isLabel(),
            "Should return 'false' after disabling the label.",
        );
    }

    public function testRemoveLabelAttribute(): void
    {
        $instance = new class {
            use HasLabelCollection;
        };

        $instance = $instance->labelAttributes(
            [
                'class' => 'label',
                'id' => 'label-id',
            ],
        );

        $instance = $instance->removeLabelAttribute('class');

        self::assertSame(
            ['id' => 'label-id'],
            $instance->getLabelAttributes(),
            "Should remove the 'class' attribute from the label attributes.",
        );
    }

    public function testReturnNewInstanceWhenSettingLabel(): void
    {
        $instance = new class {
            use HasLabelCollection;
        };

        self::assertNotSame(
            $instance,
            $instance->label('Label'),
            'Should return a new instance when setting the label content, ensuring immutability.',
        );
        self::assertNotSame(
            $instance,
            $instance->labelAttributes([]),
            'Should return a new instance when setting the label attributes, ensuring immutability.',
        );
        self::assertNotSame(
            $instance,
            $instance->labelClass(''),
            "Should return a new instance when setting the label 'class' attribute, ensuring immutability.",
        );
        self::assertNotSame(
            $instance,
            $instance->labelFor('for'),
            "Should return a new instance when setting the label 'for' attribute, ensuring immutability.",
        );
        self::assertNotSame(
            $instance,
            $instance->notLabel(),
            'Should return a new instance when disabling the label, ensuring immutability.',
        );
        self::assertNotSame(
            $instance,
            $instance->removeLabelAttribute('class'),
            'Should return a new instance when removing a label attribute, ensuring immutability.',
        );
    }

    public function testSetLabelAttributesValue(): void
    {
        $instance = new class {
            use HasLabelCollection;
        };

        self::assertEmpty(
            $instance->getLabelAttributes(),
            "Should return an empty 'array' when no attributes are set.",
        );

        $instance = $instance->labelAttributes(
            [
                'class' => 'label',
                'id' => 'label-id',
            ],
        );

        self::assertSame(
            [
                'class' => 'label',
                'id' => 'label-id',
            ],
            $instance->getLabelAttributes(),
            'Should return the correct label attributes after setting them.',
        );
    }

    public function testSetLabelAttributesWithExistingValues(): void
    {
        $instance = new class {
            use HasLabelCollection;
        };

        $instance = $instance->labelAttributes(['id' => 'my-id']);
        $instance = $instance->labelAttributes(
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
            $instance->getLabelAttributes(),
            'Should merge new attributes with existing ones, overriding duplicates.',
        );
    }

    public function testSetLabelClassValue(): void
    {
        $instance = new class {
            use HasLabelCollection;
        };

        self::assertEmpty(
            $instance->getLabelAttributes(),
            "Should return an empty 'array' when no attributes are set.",
        );

        $instance = $instance->labelClass('label-class');

        self::assertSame(
            'label-class',
            $instance->getLabelAttribute('class', ''),
            "Should return the correct label 'class' attribute after setting it.",
        );

        $instance = $instance->labelClass('label-class-1');

        self::assertSame(
            'label-class label-class-1',
            $instance->getLabelAttribute('class', ''),
            "Should return the correct label 'class' attribute after setting it.",
        );

        $instance = $instance->labelClass('override-class', true);

        self::assertSame(
            'override-class',
            $instance->getLabelAttribute('class', ''),
            "Should return the correct label 'class' attribute after setting it.",
        );

        $instance = $instance->labelClass(null);

        self::assertSame(
            'override-class',
            $instance->getLabelAttribute('class', ''),
            "Should return the existing label 'class' attribute when setting it to 'null'.",
        );
    }

    public function testSetLabelContent(): void
    {
        $instance = new class {
            use HasLabelCollection;
        };

        self::assertEmpty(
            $instance->getLabel(),
            "Should return an empty 'string' when no label is set.",
        );

        $instance = $instance->label('My Label');

        self::assertSame(
            'My Label',
            $instance->getLabel(),
            'Should return the correct label content after setting it.',
        );
    }

    public function testSetLabelFor(): void
    {
        $instance = new class {
            use HasLabelCollection;
        };

        self::assertNull(
            $instance->getLabelAttribute('for'),
            "Should return 'null' when no 'for' attribute is set.",
        );

        $instance = $instance->labelFor('input-id');

        self::assertSame(
            'input-id',
            $instance->getLabelAttribute('for'),
            "Should return the correct label 'for' attribute after setting it.",
        );
    }

    public function testSetLabelForNullValue(): void
    {
        $instance = new class {
            use HasLabelCollection;
        };

        $instance = $instance->labelFor('input-id');
        $instance = $instance->labelFor(null);

        self::assertNull(
            $instance->getLabelAttribute('for'),
            "Should return 'null' after setting the 'for' attribute to 'null'.",
        );
    }

    public function testThrowInvalidArgumentExceptionForGetLabelAttributeEmptyKey(): void
    {
        $instance = new class {
            use HasLabelCollection;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage(''),
        );

        $instance->getLabelAttribute('');
    }

    public function testThrowInvalidArgumentExceptionForGetLabelAttributeInvalidKey(): void
    {
        $instance = new class {
            use HasLabelCollection;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage(2),
        );

        $instance->getLabelAttribute(Priority::HIGH);
    }
}
