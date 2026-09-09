<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin\Tests\Provider;

use Stringable;
use UIAwesome\Html\Mixin\Tests\Support\{ContentInteger, ContentString, ContentUnit};
use UnitEnum;

/**
 * Supplies raw enum, string, and Stringable values with independently specified expected HTML.
 */
final class HtmlValueProvider
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
            'entities enum' => [
                [ContentString::ENTITIES],
                '&amp; &#60; &quot;',
            ],
            'entities string' => [
                ['&amp; &#60; &quot;'],
                '&amp; &#60; &quot;',
            ],
            'HTML enum' => [
                [ContentString::HTML],
                '<b title="value">& \'quoted\'</b>',
            ],
            'HTML string' => [
                ['<b title="value">& \'quoted\'</b>'],
                '<b title="value">& \'quoted\'</b>',
            ],
            'mixed arguments' => [
                [ContentString::HTML, '|', ContentInteger::ZERO, ContentString::EMPTY, ContentUnit::GUIDANCE, self::stringable()],
                '<b title="value">& \'quoted\'</b>|0GUIDANCE<i>&amp;</i>',
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
            'script enum' => [
                [ContentString::SCRIPT],
                '<script>alert("raw")</script>',
            ],
            'script string' => [
                ['<script>alert("raw")</script>'],
                '<script>alert("raw")</script>',
            ],
            'string enum' => [
                [ContentString::TEXT],
                'message',
            ],
            'Stringable' => [
                [self::stringable()],
                '<i>&amp;</i>',
            ],
            'Unicode enum' => [
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
