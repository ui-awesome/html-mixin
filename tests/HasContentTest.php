<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin\Tests;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Mixin\HasContent;

/**
 * Unit tests for the {@see HasContent} trait managing encoded content and raw HTML fragments.
 *
 * Test coverage.
 * - Ensures `getContent()` returns an empty string when content is not set.
 * - Ensures fluent setters return new instances (immutability).
 * - Sets encoded content via `content()`.
 * - Sets raw HTML via `html()` without encoding.
 * - Verifies mixed `content()` and `html()` calls preserve append order.
 * - Verifies variadic arguments are appended by `content()` and `html()`.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
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

    public function testReturnEmptyStringWhenContentNotSet(): void
    {
        $instance = new class {
            use HasContent;
        };

        self::assertSame(
            '',
            $instance->getContent(),
            'Should return an empty string when no content is set.',
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
            'Should encode special characters when using content().',
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
            'Should NOT encode characters when using html(), allowing raw markup.',
        );
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
            'Should handle variadic parameters correctly for both content() and html().',
        );
    }
}
