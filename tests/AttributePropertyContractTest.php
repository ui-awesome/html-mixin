<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin\Tests;

use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use ReflectionEnum;
use UIAwesome\Html\Mixin\Tests\Provider\AttributePropertyContractProvider;
use UIAwesome\Html\Mixin\Values\AttributeProperty;
use ValueError;

/**
 * Unit tests for the public {@see AttributeProperty} enum contract.
 *
 * {@see AttributePropertyContractProvider} for test case data providers.
 */
#[Group('mixin')]
final class AttributePropertyContractTest extends TestCase
{
    public function testCasesHaveTheExpectedNamesAndBackedValues(): void
    {
        $actualCases = [];

        foreach ((new ReflectionEnum(AttributeProperty::class))->getCases() as $case) {
            $value = $case->getValue();

            if (!$value instanceof AttributeProperty) {
                self::fail('Every case must be an `AttributeProperty` instance.');
            }

            $actualCases[$case->getName()] = $value->value;
        }

        self::assertSame(
            AttributePropertyContractProvider::cases(),
            $actualCases,
            'Should preserve every public case name and backed value.',
        );
    }

    #[DataProviderExternal(AttributePropertyContractProvider::class, 'validValues')]
    public function testFromAndTryFromReturnTheExpectedCase(string $name, string $value): void
    {
        $expectedCase = (new ReflectionEnum(AttributeProperty::class))->getCase($name)->getValue();

        self::assertSame(
            $expectedCase,
            AttributeProperty::from($value),
            'Should resolve the expected public case.',
        );
        self::assertSame(
            $expectedCase,
            AttributeProperty::tryFrom($value),
            'Should resolve the expected public case.',
        );
    }

    public function testThrowValueErrorForAnUnknownBackedValue(): void
    {
        $this->expectException(ValueError::class);
        $this->expectExceptionMessage(
            '"not-an-html-attribute" is not a valid backing value for enum ' . AttributeProperty::class,
        );

        AttributeProperty::from('not-an-html-attribute');
    }

    #[DataProviderExternal(AttributePropertyContractProvider::class, 'invalidValues')]
    public function testTryFromReturnsNullForAnUnknownValue(string $value): void
    {
        self::assertNull(
            AttributeProperty::tryFrom($value),
            'Should return no case for an unknown backed value.',
        );
    }
}
