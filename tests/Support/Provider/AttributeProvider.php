<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin\Tests\Support\Provider;

use UIAwesome\Html\Mixin\Values\AttributeProperty;
use UnitEnum;

/**
 * Data provider for {@see \UIAwesome\Html\Mixin\Tests\HasAttributesTest} class.
 *
 * Supplies comprehensive test data for validating the handling of HTML attributes in tag rendering, ensuring
 * standards-compliant attribute generation, override behavior, and value propagation.
 *
 * The test data covers real-world scenarios for setting, overriding, and removing attributes, supporting bool, scalar
 * values, and deferred evaluation via \Closure, to maintain consistent output across different rendering
 * configurations.
 *
 * The provider organizes test cases with descriptive names for clear identification of failure cases during test
 * execution and debugging sessions.
 *
 * Key features.
 * - Ensures correct propagation, assignment, override, and removal of attributes in HTML element rendering.
 * - Named test data sets for precise failure identification.
 * - Validation of bool, string (including empty strings), int, float, \Closure, and `null` handling for attributes,
 *   including hyphenated keys and unset scenarios.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class AttributeProvider
{
    /**
     * Provides test cases for single HTML attribute scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of a single HTML attribute, including string
     * keys, UnitEnum keys and values provided as scalars, \Closure, and `null`.
     *
     * Each test case includes the attribute key, the input value, the expected attributes array, and an assertion
     * message for clear identification.
     *
     * @return array Test data for single attribute scenarios.
     *
     * @phpstan-return array<string, array{string|UnitEnum, scalar|\Closure(): mixed|null, mixed[], string}>
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
     * Provides test cases for HTML attribute value map scenarios.
     *
     * Supplies test data for validating bulk assignment, normalization, and removal of HTML attributes, ensuring
     * consistent key handling, hyphenated key support, and value propagation for scalars, \Closure, and `null`.
     *
     * Each test case includes the input values map, the expected normalized attributes array, and an assertion message
     * for clear identification.
     *
     * @return array Test data for attribute value map scenarios.
     *
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
