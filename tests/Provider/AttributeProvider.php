<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin\Tests\Provider;

use Closure;
use UIAwesome\Html\Mixin\Values\AttributeProperty;
use UnitEnum;

/**
 * Data provider for {@see \UIAwesome\Html\Mixin\Tests\HasAttributesTest} test cases.
 *
 * Provides representative input/output pairs for testing the HTML attribute.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class AttributeProvider
{
    /**
     * @phpstan-return array<string, array{string|UnitEnum, scalar|Closure|null, mixed[], string}>
     */
    public static function value(): array
    {
        $closure = static fn(): string => 'my-value';

        $enumCases = [];

        foreach (AttributeProperty::cases() as $case) {
            $enumCases["AttributeProperty::{$case->name}"] = [
                $case,
                '',
                [$case->value => ''],
                "Should return the attribute '{$case->value}' after setting it.",
            ];
        }

        $staticCases = [
            'boolean false' => [
                'disabled',
                false,
                ['disabled' => false],
                'Should return the attribute value after setting it.',
            ],
            'boolean true' => [
                'disabled',
                true,
                ['disabled' => true],
                'Should return the attribute value after setting it.',
            ],
            'closure' => [
                'id',
                $closure,
                ['id' => $closure],
                'Should return the attribute value after setting it.',
            ],
            'empty string' => [
                'class',
                '',
                ['class' => ''],
                'Should return an empty string when setting an empty string.',
            ],
            'float' => [
                'tabindex',
                0.42,
                ['tabindex' => 0.42],
                'Should return the attribute value after setting it.',
            ],
            'hyphenated key' => [
                'aria-label',
                'value',
                ['aria-label' => 'value'],
                'Should return the attribute value after setting it.',
            ],
            'integer' => [
                'tabindex',
                0,
                ['tabindex' => 0],
                'Should return the attribute value after setting it.',
            ],
            'string' => [
                'id',
                'my-id',
                ['id' => 'my-id'],
                'Should return the attribute value after setting it.',
            ],
            'unset with null' => [
                'class',
                null,
                [],
                "Should unset the 'class' attribute when 'null' is provided after a value.",
            ],
        ];

        return [...$staticCases, ...$enumCases];
    }

    /**
     * @phpstan-return array<string, array{mixed[], mixed[], string}>
     */
    public static function values(): array
    {
        $closure = static fn(): string => 'my-value';

        return [
            'boolean false' => [
                ['disabled' => false],
                ['disabled' => false],
                'Should return the attribute value after setting it.',
            ],
            'boolean true' => [
                ['disabled' => true],
                ['disabled' => true],
                'Should return the attribute value after setting it.',
            ],
            'closure' => [
                ['id' => $closure],
                ['id' => $closure],
                'Should return the attribute value after setting it.',
            ],
            'empty string' => [
                ['class' => ''],
                ['class' => ''],
                'Should return an empty string when setting an empty string.',
            ],
            'float' => [
                ['tabindex' => 0.42],
                ['tabindex' => 0.42],
                'Should return the attribute value after setting it.',
            ],
            'hyphenated key' => [
                ['aria-label' => 'value'],
                ['aria-label' => 'value'],
                'Should return the attribute value after setting it.',
            ],
            'integer' => [
                ['tabindex' => 0],
                ['tabindex' => 0],
                'Should return the attribute value after setting it.',
            ],
            'mixed string and closure' => [
                [
                    'id' => 'my-id',
                    'class' => $closure,
                ],
                [
                    'id' => 'my-id',
                    'class' => $closure,
                ],
                'Should set multiple attributes with mixed string and closure values.',
            ],
            'string' => [
                ['id' => 'my-id'],
                ['id' => 'my-id'],
                'Should return the attribute value after setting it.',
            ],
            'null value' => [
                [
                    'class' => null,
                ],
                [
                    'class' => null,
                ],
                "Should preserve 'null' value when set explicitly.",
            ],
        ];
    }
}
