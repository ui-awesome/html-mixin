<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin\Tests;

use PHPUnit\Framework\Attributes\{DataProviderExternal, Group};
use PHPUnit\Framework\TestCase;
use Stringable;
use TypeError;
use UIAwesome\Html\Mixin\HasContent;
use UIAwesome\Html\Mixin\Tests\Provider\{ContentValueProvider, HtmlValueProvider};
use UIAwesome\Html\Mixin\Tests\Support\{ContentInteger, ContentString, ContentUnit};
use UnitEnum;

/**
 * Unit tests for the {@see HasContent} trait managing encoded content and raw HTML fragments.
 *
 * {@see ContentValueProvider} and {@see HtmlValueProvider} supply encoded and raw content regression cases.
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

    /**
     * @param list<string|Stringable|UnitEnum> $values
     */
    #[DataProviderExternal(HtmlValueProvider::class, 'values')]
    public function testAppendNormalizedHtmlImmutably(array $values, string $expected): void
    {
        $original = new class {
            use HasContent;
        };

        $initial = $original->html('<header>&amp;</header>');
        $result = $initial->html(...$values);
        $chained = $result
            ->content(ContentString::HTML)
            ->html(ContentInteger::ZERO, ContentString::ENTITIES, ContentUnit::GUIDANCE);

        self::assertNotSame(
            $initial,
            $result,
            'HTML must return a new instance even without arguments.',
        );
        self::assertSame(
            '',
            $original->getContent(),
            'The original instance must remain empty.',
        );
        self::assertSame(
            '<header>&amp;</header>',
            $initial->getContent(),
            'The previous instance must remain unchanged.',
        );
        self::assertSame(
            '<header>&amp;</header>' . $expected,
            $result->getContent(),
            'Raw values must be normalized and appended in order without encoding.',
        );
        self::assertSame(
            '<header>&amp;</header>' . $expected . '&lt;b title="value"&gt;&amp; \'quoted\'&lt;/b&gt;0&amp; &#60; &quot;GUIDANCE',
            $chained->getContent(),
            'Chained calls must retain raw HTML while content() continues encoding.',
        );
    }

    public function testHtmlConvertsStringableOnce(): void
    {
        $original = new class {
            use HasContent;
        };
        $value = new class implements Stringable {
            public int $calls = 0;

            public function __toString(): string
            {
                $this->calls++;

                return '<i>&amp;</i>';
            }
        };

        $result = $original->html($value);

        self::assertSame(
            1,
            $value->calls,
            'HTML must convert each Stringable argument exactly once.',
        );
        self::assertSame(
            '<i>&amp;</i>',
            $result->getContent(),
            'Stringable markup and entities must remain raw.',
        );
        self::assertSame(
            '',
            $original->getContent(),
            'Conversion must not mutate the original content.',
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

    public function testThrowTypeErrorWhenHtmlReceivesNull(): void
    {
        $instance = new class {
            use HasContent;
        };

        $this->expectException(TypeError::class);
        $this->expectExceptionMessage('must be of type Stringable|UnitEnum|string, null given');

        (new \ReflectionMethod($instance, 'html'))->invoke($instance, null);
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
