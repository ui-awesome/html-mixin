<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin\Tests\Provider;

/**
 * Data provider for {@see \UIAwesome\Html\Mixin\Tests\AttributePropertyContractTest} test cases.
 *
 * Freezes the public case names and backed values of the {@see \UIAwesome\Html\Mixin\Values\AttributeProperty} enum.
 */
final class AttributePropertyContractProvider
{
    /**
     * @return array<string, string>
     */
    public static function cases(): array
    {
        return [
            'ACCEPT' => 'accept',
            'ACCEPT_CHARSET' => 'accept-charset',
            'ACCESSKEY' => 'accesskey',
            'ACTION' => 'action',
            'ALIGN' => 'align',
            'ALLOW' => 'allow',
            'ALT' => 'alt',
            'ASYNC' => 'async',
            'AUTOCAPITALIZE' => 'autocapitalize',
            'AUTOCOMPLETE' => 'autocomplete',
            'AUTOFOCUS' => 'autofocus',
            'AUTOPLAY' => 'autoplay',
            'BACKGROUND' => 'background',
            'BGCOLOR' => 'bgcolor',
            'BORDER' => 'border',
            'CAPTURE' => 'capture',
            'CHARSET' => 'charset',
            'CHECKED' => 'checked',
            'CITE' => 'cite',
            'COLOR' => 'color',
            'COLS' => 'cols',
            'COLSPAN' => 'colspan',
            'CONTENT' => 'content',
            'CONTENTEDITABLE' => 'contenteditable',
            'CONTROLS' => 'controls',
            'COORDS' => 'coords',
            'CROSSORIGIN' => 'crossorigin',
            'CSS_CLASS' => 'class',
            'DATETIME' => 'datetime',
            'DECODING' => 'decoding',
            'DEFER' => 'defer',
            'DIR' => 'dir',
            'DIRNAME' => 'dirname',
            'DISABLED' => 'disabled',
            'DOWNLOAD' => 'download',
            'DRAGGABLE' => 'draggable',
            'ENCTYPE' => 'enctype',
            'ENTERKEYHINT' => 'enterkeyhint',
            'FETCHPRIORITY' => 'fetchpriority',
            'FOR' => 'for',
            'FORM' => 'form',
            'FORMACTION' => 'formaction',
            'FORMENCTYPE' => 'formenctype',
            'FORMMETHOD' => 'formmethod',
            'FORMNOVALIDATE' => 'formnovalidate',
            'FORMTARGET' => 'formtarget',
            'HEADERS' => 'headers',
            'HEIGHT' => 'height',
            'HIDDEN' => 'hidden',
            'HIGH' => 'high',
            'HREF' => 'href',
            'HREFLANG' => 'hreflang',
            'HTTP_EQUIV' => 'http-equiv',
            'ID' => 'id',
            'INPUTMODE' => 'inputmode',
            'INTEGRITY' => 'integrity',
            'ISMAP' => 'ismap',
            'ITEMID' => 'itemid',
            'ITEMPROP' => 'itemprop',
            'ITEMREF' => 'itemref',
            'ITEMSCOPE' => 'itemscope',
            'ITEMTYPE' => 'itemtype',
            'KIND' => 'kind',
            'LABEL' => 'label',
            'LANG' => 'lang',
            'LIST' => 'list',
            'LOADING' => 'loading',
            'LOOP' => 'loop',
            'LOW' => 'low',
            'MAX' => 'max',
            'MAXLENGTH' => 'maxlength',
            'MEDIA' => 'media',
            'METHOD' => 'method',
            'MIN' => 'min',
            'MINLENGTH' => 'minlength',
            'MULTIPLE' => 'multiple',
            'MUTED' => 'muted',
            'NAME' => 'name',
            'NOVALIDATE' => 'novalidate',
            'OPEN' => 'open',
            'OPTIMUM' => 'optimum',
            'PATTERN' => 'pattern',
            'PING' => 'ping',
            'PLACEHOLDER' => 'placeholder',
            'PLAYSINLINE' => 'playsinline',
            'POSTER' => 'poster',
            'PRELOAD' => 'preload',
            'READONLY' => 'readonly',
            'REFERRERPOLICY' => 'referrerpolicy',
            'REL' => 'rel',
            'REQUIRED' => 'required',
            'REVERSED' => 'reversed',
            'ROLE' => 'role',
            'ROWS' => 'rows',
            'ROWSPAN' => 'rowspan',
            'SANDBOX' => 'sandbox',
            'SCOPE' => 'scope',
            'SELECTED' => 'selected',
            'SHAPE' => 'shape',
            'SIZE' => 'size',
            'SIZES' => 'sizes',
            'SLOT' => 'slot',
            'SPAN' => 'span',
            'SPELLCHECK' => 'spellcheck',
            'SRC' => 'src',
            'SRCDOC' => 'srcdoc',
            'SRCLANG' => 'srclang',
            'SRCSET' => 'srcset',
            'START' => 'start',
            'STEP' => 'step',
            'STYLE' => 'style',
            'TABINDEX' => 'tabindex',
            'TARGET' => 'target',
            'TITLE' => 'title',
            'TRANSLATE' => 'translate',
            'TYPE' => 'type',
            'USEMAP' => 'usemap',
            'VALUE' => 'value',
            'WIDTH' => 'width',
            'WRAP' => 'wrap',
        ];
    }

    /**
     * @return array<string, array{string}>
     */
    public static function invalidValues(): array
    {
        return [
            'empty value' => [''],
            'unknown value' => ['not-an-html-attribute'],
            'uppercase case name' => ['ACCEPT'],
            'whitespace padded value' => [' accept '],
        ];
    }

    /**
     * @return array<string, array{string, string}>
     */
    public static function validValues(): array
    {
        $values = [];

        foreach (self::cases() as $name => $value) {
            $values["AttributeProperty::{$name}"] = [$name, $value];
        }

        return $values;
    }
}
