<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin\Tests;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Mixin\HasContent;

/**
 * Test suite for {@see HasContent} mixin functionality and behavior.
 *
 * Validates the management and immutability of HTML content handling in tag rendering, according to the HTML Living
 * Standard specification.
 *
 * Ensures correct initialization, assignment, and retrieval of content, supporting both encoded and raw HTML content,
 * enforcing immutability when setting new content, and preventing XSS vulnerabilities through proper encoding.
 *
 * Test coverage.
 * - Accurate accumulation and retrieval of mixed content.
 * - Correct handling of empty and unset content.
 * - Immutability of the mixin when setting content or HTML.
 * - Proper encoding of special characters to prevent XSS.
 * - Support for variadic parameters in content and HTML methods.
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

        // test XSS prevention
        $instance = $instance->content('<script>alert("xss")</script>');

        self::assertSame(
            '&lt;script&gt;alert("xss")&lt;/script&gt;',
            $instance->getContent(),
            'Should encode special characters when using content() to prevent XSS.',
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
