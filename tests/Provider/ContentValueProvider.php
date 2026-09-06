<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin\Tests\Provider;

use Stringable;
use UIAwesome\Html\Mixin\Tests\Support\{ContentInteger, ContentString, ContentUnit};
use UnitEnum;

/**
 * Data provider for encoded content normalization and regression tests.
 */
final class ContentValueProvider
{
    /**
     * @return array<string, array{list<string|Stringable|UnitEnum>, string}>
     */
    public static function values(): array
    {
        return [
            'empty string enum' => [
                [ContentString::EMPTY],
                '',
            ],
            'empty string' => [
                [''],
                '',
            ],
            'entities string enum' => [
                [ContentString::ENTITIES],
                '&amp;amp; &amp;#60; &amp;quot;',
            ],
            'entities string' => [
                ['&amp; &#60; &quot;'],
                '&amp;amp; &amp;#60; &amp;quot;',
            ],
            'HTML string enum' => [
                [ContentString::HTML],
                '&lt;b title="value"&gt;&amp; \'quoted\'&lt;/b&gt;',
            ],
            'HTML string' => [
                ['<b title="value">& \'quoted\'</b>'],
                '&lt;b title="value"&gt;&amp; \'quoted\'&lt;/b&gt;',
            ],
            'mixed arguments' => [
                [
                    ContentString::HTML,
                    '|',
                    ContentInteger::ZERO,
                    ContentString::EMPTY,
                    ContentUnit::GUIDANCE,
                    self::stringable(),
                ],
                '&lt;b title="value"&gt;&amp; \'quoted\'&lt;/b&gt;|0GUIDANCE&lt;i&gt;&amp;amp;&lt;/i&gt;',
            ],
            'negative integer enum' => [
                [ContentInteger::NEGATIVE],
                '-7',
            ],
            'no arguments' => [
                [],
                '',
            ],
            'positive integer enum' => [
                [ContentInteger::POSITIVE],
                '42',
            ],
            'pure enum' => [
                [ContentUnit::GUIDANCE],
                'GUIDANCE',
            ],
            'string enum' => [
                [ContentString::TEXT],
                'message',
            ],
            'Stringable' => [
                [self::stringable()],
                '&lt;i&gt;&amp;amp;&lt;/i&gt;',
            ],
            'Unicode string enum' => [
                [ContentString::UNICODE],
                "caf\u{00E9} \u{4E16}\u{754C}",
            ],
            'Unicode string' => [
                ["caf\u{00E9} \u{4E16}\u{754C}"],
                "caf\u{00E9} \u{4E16}\u{754C}",
            ],
            'zero integer enum' => [
                [ContentInteger::ZERO],
                '0',
            ],
            'zero string enum' => [
                [ContentString::ZERO],
                '0',
            ],
            'zero string' => [
                ['0'],
                '0',
            ],
        ];
    }

    private static function stringable(): Stringable
    {
        return new class implements Stringable {
            public function __toString(): string
            {
                return '<i>&amp;</i>';
            }
        };
    }
}
