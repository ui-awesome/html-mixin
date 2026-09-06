<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin\Tests;

use PHPUnit\Framework\Attributes\{DataProviderExternal, Group};
use PHPUnit\Framework\TestCase;
use Stringable;
use TypeError;
use UIAwesome\Html\Mixin\HasContent;
use UIAwesome\Html\Mixin\Tests\Provider\ContentValueProvider;
use UIAwesome\Html\Mixin\Tests\Support\{ContentInteger, ContentString, ContentUnit};
use UnitEnum;

/**
 * Unit tests for the {@see HasContent} trait managing encoded content and raw HTML fragments.
 *
 * {@see ContentValueProvider} supplies enum, string, and Stringable regression cases.
 */
#[Group('mixin')]
final class HasContentTest extends TestCase
{
    public function testAccumulateMixedContent(): void
    {
        $instance = new class {
            use HasContent;
        };

        // chain methods to test accumulation order and mixed encoding
        $instance = $instance
            ->content('Name: ')
            ->html('<strong>John & Doe</strong>')
            ->content(' (Verified)');

        self::assertSame(
            'Name: <strong>John & Doe</strong> (Verified)',
            $instance->getContent(),
            'Should accumulate content sequentially, respecting the encoding rules of each method.',
        );
    }

    /**
     * @param list<string|Stringable|UnitEnum> $values
     */
    #[DataProviderExternal(ContentValueProvider::class, 'values')]
    public function testAppendNormalizedContentImmutably(array $values, string $expected): void
    {
        $original = new class {
            use HasContent;
        };

        $initial = $original->content('prefix:');
        $result = $initial->content(...$values);

        $chained = $result
            ->html('<strong>&raw;</strong>')
            ->content(ContentInteger::ZERO, ContentString::ENTITIES, ContentUnit::GUIDANCE);

        self::assertNotSame(
            $initial,
            $result,
            'Content must return a new instance even without arguments.',
        );
        self::assertSame(
            '',
            $original->getContent(),
            'The original instance must remain empty.',
        );
        self::assertSame(
            'prefix:',
            $initial->getContent(),
            'Existing content must not be mutated.',
        );
        self::assertSame(
            "prefix:{$expected}",
            $result->getContent(),
            'Values must be normalized and encoded once in order.',
        );
        self::assertSame(
            'prefix:' . $expected . '<strong>&raw;</strong>0&amp;amp; &amp;#60; &amp;quot;GUIDANCE',
            $chained->getContent(),
            'Chained calls must append encoded enum content without changing raw HTML.',
        );
    }

    public function testHtmlWithStringableRemainsRawAndImmutable(): void
    {
        $original = new class {
            use HasContent;
        };

        $raw = new class implements Stringable {
            public function __toString(): string
            {
                return '<b>&amp;</b>';
            }
        };

        $result = $original->html($raw, '<i>&</i>');

        self::assertSame(
            '<b>&amp;</b><i>&</i>',
            $result->getContent(),
            'Raw Stringable HTML must remain unchanged.',
        );
        self::assertSame(
            '',
            $original->getContent(),
            'Raw HTML must not mutate the original instance.',
        );
    }

    public function testReturnEmptyStringWhenContentNotSet(): void
    {
        $instance = new class {
            use HasContent;
        };

        self::assertSame(
            '',
            $instance->getContent(),
            "Should return an empty 'string' when no content is set.",
        );
    }

    public function testReturnNewInstanceWhenSettingContent(): void
    {
        $instance = new class {
            use HasContent;
        };

        self::assertNotSame(
            $instance,
            $instance->content('test'),
            'Should return a new instance when setting content, ensuring immutability.',
        );
    }

    public function testReturnNewInstanceWhenSettingHtml(): void
    {
        $instance = new class {
            use HasContent;
        };

        self::assertNotSame(
            $instance,
            $instance->html('test'),
            'Should return a new instance when setting raw HTML, ensuring immutability.',
        );
    }

    public function testSetContentWithEncoding(): void
    {
        $instance = new class {
            use HasContent;
        };

        // test content encoding
        $instance = $instance->content('<script>alert("xss")</script>');

        self::assertSame(
            '&lt;script&gt;alert("xss")&lt;/script&gt;',
            $instance->getContent(),
            "Should encode special characters when using 'content()'.",
        );
    }

    public function testSetHtmlWithoutEncoding(): void
    {
        $instance = new class {
            use HasContent;
        };

        // test raw HTML insertion
        $instance = $instance->html('<span>Raw Content</span>');

        self::assertSame(
            '<span>Raw Content</span>',
            $instance->getContent(),
            "Should NOT encode characters when using 'html()', allowing raw markup.",
        );
    }

    public function testThrowTypeErrorWhenHtmlReceivesEnum(): void
    {
        $instance = new class {
            use HasContent;
        };

        $this->expectException(TypeError::class);
        $this->expectExceptionMessage(
            'must be of type Stringable|string, ' . ContentString::class . ' given',
        );

        // Exercise the rejected input without suppressing static analysis of the public signature.
        (new \ReflectionMethod($instance, 'html'))->invoke($instance, ContentString::HTML);
    }

    public function testVariadicParameters(): void
    {
        $instance = new class {
            use HasContent;
        };

        $instance = $instance->content('One', 'Two', 'Three');
        $instance = $instance->html('Four', 'Five');

        self::assertSame(
            'OneTwoThreeFourFive',
            $instance->getContent(),
            "Should handle variadic parameters correctly for both 'content()' and 'html()'.",
        );
    }
}
