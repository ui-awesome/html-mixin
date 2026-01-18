<?php

declare(strict_types=1);

namespace UIAwesome\Html\Mixin\Values;

/**
 * Represents HTML attribute names.
 *
 * Provides a set of attribute identifiers for use as keys when building attribute arrays for elements and components.
 * The enum case values match the attribute names as used in HTML markup.
 *
 * Key features.
 * - Exposes attribute names as enum cases.
 * - Provides stable string values via enum case `value`.
 * - Useful as attribute keys in fluent builders and renderers.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Attributes
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
enum AttributeProperty: string
{
    /**
     * `accept` — List of types the server accepts, typically a file type.
     */
    case ACCEPT = 'accept';

    /**
     * `accept-charset` — The character encoding for form submission (historical use; usually "UTF-8").
     */
    case ACCEPT_CHARSET = 'accept-charset';

    /**
     * `accesskey` — Keyboard shortcut to activate or add focus to the element.
     */
    case ACCESSKEY = 'accesskey';

    /**
     * `action` — The URI of a program that processes the information submitted via the form.
     */
    case ACTION = 'action';

    /**
     * `align` — (Deprecated) Specifies the horizontal alignment of the element.
     */
    case ALIGN = 'align';

    /**
     * `allow` — Specifies a feature policy for an iframe.
     */
    case ALLOW = 'allow';

    /**
     * `alt` — Alternative text in case an image can't be displayed.
     */
    case ALT = 'alt';

    /**
     * `async` — Execute the script asynchronously.
     */
    case ASYNC = 'async';

    /**
     * `autocapitalize` — Controls whether and how text input is automatically capitalized.
     */
    case AUTOCAPITALIZE = 'autocapitalize';

    /**
     * `autocomplete` — Indicates whether controls can have their values automatically completed.
     */
    case AUTOCOMPLETE = 'autocomplete';

    /**
     * `autofocus` — A hint that the element should be focused on page load.
     */
    case AUTOFOCUS = 'autofocus';

    /**
     * `autoplay` — The audio or video should play as soon as possible.
     */
    case AUTOPLAY = 'autoplay';

    /**
     * `background` — (Legacy) Specifies the URL of a background image.
     */
    case BACKGROUND = 'background';

    /**
     * `bgcolor` — (Legacy) Background color of the element.
     */
    case BGCOLOR = 'bgcolor';

    /**
     * `border` — (Legacy) The border width.
     */
    case BORDER = 'border';

    /**
     * `capture` — Media capture hint for file inputs.
     */
    case CAPTURE = 'capture';

    /**
     * `charset` — Declares the character encoding of the page or script.
     */
    case CHARSET = 'charset';

    /**
     * `checked` — Indicates whether the element should be checked on page load.
     */
    case CHECKED = 'checked';

    /**
     * `cite` — Contains a URI which points to the source of a quote or change.
     */
    case CITE = 'cite';

    /**
     * `color` — (Legacy) Sets the text color.
     */
    case COLOR = 'color';

    /**
     * `cols` — Number of columns for a textarea.
     */
    case COLS = 'cols';

    /**
     * `colspan` — Number of columns a table cell should span.
     */
    case COLSPAN = 'colspan';

    /**
     * `content` — A value associated with a meta element.
     */
    case CONTENT = 'content';

    /**
     * `contenteditable` — Indicates whether the element's content is editable.
     */
    case CONTENTEDITABLE = 'contenteditable';

    /**
     * `controls` — Indicates whether media controls should be shown.
     */
    case CONTROLS = 'controls';

    /**
     * `coords` — Coordinates for area elements.
     */
    case COORDS = 'coords';

    /**
     * `crossorigin` — How the element handles cross-origin requests.
     */
    case CROSSORIGIN = 'crossorigin';

    /**
     * `class` — Space-separated list of classes for the element.
     */
    case CSS_CLASS = 'class';

    /**
     * `datetime` — Date and time associated with the element (e.g., `<time>`).
     */
    case DATETIME = 'datetime';

    /**
     * `decoding` — Preferred method to decode an image.
     */
    case DECODING = 'decoding';

    /**
     * `defer` — Indicates that the script should be executed after the page has been parsed.
     */
    case DEFER = 'defer';

    /**
     * `dir` — Text direction (ltr/rtl).
     */
    case DIR = 'dir';

    /**
     * `dirname` — Indicates that the element's text directionality should be submitted with the form control.
     */
    case DIRNAME = 'dirname';

    /**
     * `disabled` — Indicates that the user cannot interact with the element.
     */
    case DISABLED = 'disabled';

    /**
     * `download` — Indicates that the hyperlink is to be used for downloading a resource.
     */
    case DOWNLOAD = 'download';

    /**
     * `draggable` — Defines whether the element can be dragged.
     */
    case DRAGGABLE = 'draggable';

    /**
     * `enctype` — Content type of the form data when method is POST.
     */
    case ENCTYPE = 'enctype';

    /**
     * `enterkeyhint` — Hint for the enter key on virtual keyboards.
     */
    case ENTERKEYHINT = 'enterkeyhint';

    /**
     * `fetchpriority` — Fetch priority hint for certain resources (images, links, scripts).
     */
    case FETCHPRIORITY = 'fetchpriority';

    /**
     * `for` — Identifies the element(s) which the label is bound to.
     */
    case FOR = 'for';

    /**
     * `form` — Indicates the form owner of a control.
     */
    case FORM = 'form';

    /**
     * `formaction` — Overrides the action attribute of the form for a submit button.
     */
    case FORMACTION = 'formaction';

    /**
     * `formenctype` — Overrides the form enctype for a submit button.
     */
    case FORMENCTYPE = 'formenctype';

    /**
     * `formmethod` — Overrides the form method for a submit button.
     */
    case FORMMETHOD = 'formmethod';

    /**
     * `formnovalidate` — When present, form is not validated on submit for this button.
     */
    case FORMNOVALIDATE = 'formnovalidate';

    /**
     * `formtarget` — Overrides the form target for a submit button.
     */
    case FORMTARGET = 'formtarget';

    /**
     * `headers` — IDs of `<th>` elements which apply to this cell.
     */
    case HEADERS = 'headers';

    /**
     * `height` — Specifies the height of certain elements.
     */
    case HEIGHT = 'height';

    /**
     * `hidden` — Prevents rendering of the element.
     */
    case HIDDEN = 'hidden';

    /**
     * `high` — Upper bound of the upper range for `<meter>`.
     */
    case HIGH = 'high';

    /**
     * `href` — The URL of a linked resource.
     */
    case HREF = 'href';

    /**
     * `hreflang` — Specifies the language of the linked resource.
     */
    case HREFLANG = 'hreflang';

    /**
     * `http-equiv` — Defines a pragma directive for meta elements.
     */
    case HTTP_EQUIV = 'http-equiv';

    /**
     * `id` — Unique identifier for the element.
     */
    case ID = 'id';

    /**
     * `inputmode` — Hint about what kind of input modality (e.g., numeric) is expected.
     */
    case INPUTMODE = 'inputmode';

    /**
     * `integrity` — Subresource integrity metadata for fetched resources.
     */
    case INTEGRITY = 'integrity';

    /**
     * `ismap` — Indicates that the image is part of a server-side image map.
     */
    case ISMAP = 'ismap';

    /**
     * `itemid` — Microdata item identifier.
     */
    case ITEMID = 'itemid';

    /**
     * `itemprop` — Microdata item property name.
     */
    case ITEMPROP = 'itemprop';

    /**
     * `itemref` — Microdata item reference.
     */
    case ITEMREF = 'itemref';

    /**
     * `itemscope` — Indicates that the element is a microdata item.
     */
    case ITEMSCOPE = 'itemscope';

    /**
     * `itemtype` — Microdata item type.
     */
    case ITEMTYPE = 'itemtype';

    /**
     * `kind` — Kind of text track for `<track>` elements.
     */
    case KIND = 'kind';

    /**
     * `label` — User-readable title of the element.
     */
    case LABEL = 'label';

    /**
     * `lang` — Language code for the element's content.
     */
    case LANG = 'lang';

    /**
     * `list` — Identifies a `datalist` element that provides predefined options.
     */
    case LIST = 'list';

    /**
     * `loading` — Lazy or eager loading hint for images and iframes.
     */
    case LOADING = 'loading';

    /**
     * `loop` — Indicates whether media should loop.
     */
    case LOOP = 'loop';

    /**
     * `low` — Upper bound of the lower range for `<meter>`.
     */
    case LOW = 'low';

    /**
     * `max` — Maximum numeric value for inputs and other controls.
     */
    case MAX = 'max';

    /**
     * `maxlength` — Maximum number of characters allowed.
     */
    case MAXLENGTH = 'maxlength';

    /**
     * `media` — Hint describing the media for which the resource is designed.
     */
    case MEDIA = 'media';

    /**
     * `method` — HTTP method used to submit a form (GET or POST).
     */
    case METHOD = 'method';

    /**
     * `min` — Minimum numeric value for inputs and other controls.
     */
    case MIN = 'min';

    /**
     * `minlength` — Minimum number of characters required.
     */
    case MINLENGTH = 'minlength';

    /**
     * `multiple` — Indicates that multiple values can be selected.
     */
    case MULTIPLE = 'multiple';

    /**
     * `muted` — Indicates whether the media should be muted by default.
     */
    case MUTED = 'muted';

    /**
     * `name` — Name of the element, commonly used in form submissions.
     */
    case NAME = 'name';

    /**
     * `novalidate` — Indicates that a form shouldn't be validated on submit.
     */
    case NOVALIDATE = 'novalidate';

    /**
     * `open` — Indicates whether details/dialog are open.
     */
    case OPEN = 'open';

    /**
     * `optimum` — Optimal numeric value for `<meter>`.
     */
    case OPTIMUM = 'optimum';

    /**
     * `pattern` — Regular expression that the input's value must match.
     */
    case PATTERN = 'pattern';

    /**
     * `ping` — Space-separated list of URLs to be notified when the link is followed.
     */
    case PING = 'ping';

    /**
     * `placeholder` — Hint text for inputs and textareas.
     */
    case PLACEHOLDER = 'placeholder';

    /**
     * `playsinline` — Hint to play video inline (not fullscreen).
     */
    case PLAYSINLINE = 'playsinline';

    /**
     * `poster` — URL of poster frame for video.
     */
    case POSTER = 'poster';

    /**
     * `preload` — Hint about what media should be preloaded.
     */
    case PRELOAD = 'preload';

    /**
     * `readonly` — Indicates that the value cannot be modified by the user.
     */
    case READONLY = 'readonly';

    /**
     * `referrerpolicy` — Referrer information to send when fetching the resource.
     */
    case REFERRERPOLICY = 'referrerpolicy';

    /**
     * `rel` — Relationship of the linked resource to the current document.
     */
    case REL = 'rel';

    /**
     * `required` — Indicates that a control must be filled out before submitting the form.
     */
    case REQUIRED = 'required';

    /**
     * `reversed` — Indicates that an ordered list is displayed in descending order.
     */
    case REVERSED = 'reversed';

    /**
     * `role` — Defines an explicit ARIA role for the element.
     */
    case ROLE = 'role';

    /**
     * `rows` — Number of rows for a textarea.
     */
    case ROWS = 'rows';

    /**
     * `rowspan` — Number of rows a table cell should span.
     */
    case ROWSPAN = 'rowspan';

    /**
     * `sandbox` — Restricts capabilities of content in an iframe.
     */
    case SANDBOX = 'sandbox';

    /**
     * `scope` — Scope of a header cell in a table.
     */
    case SCOPE = 'scope';

    /**
     * `selected` — Indicates that an option should be pre-selected on page load.
     */
    case SELECTED = 'selected';

    /**
     * `shape` — Shape for area elements.
     */
    case SHAPE = 'shape';

    /**
     * `size` — Width in characters for inputs or number of items for select.
     */
    case SIZE = 'size';

    /**
     * `sizes` — Sizes attribute for responsive images and links.
     */
    case SIZES = 'sizes';

    /**
     * `slot` — Assigns an element to a named slot in shadow DOM.
     */
    case SLOT = 'slot';

    /**
     * `span` — Number of columns a `<col>` or `<colgroup>` should span.
     */
    case SPAN = 'span';

    /**
     * `spellcheck` — Indicates whether spell checking is enabled for the element.
     */
    case SPELLCHECK = 'spellcheck';

    /**
     * `src` — URL of embeddable content.
     */
    case SRC = 'src';

    /**
     * `srcdoc` — HTML content for an iframe.
     */
    case SRCDOC = 'srcdoc';

    /**
     * `srclang` — Language of the track text data.
     */
    case SRCLANG = 'srclang';

    /**
     * `srcset` — One or more responsive image candidates.
     */
    case SRCSET = 'srcset';

    /**
     * `start` — Starting value for ordered lists.
     */
    case START = 'start';

    /**
     * `step` — Granularity of numeric inputs.
     */
    case STEP = 'step';

    /**
     * `style` — Inline CSS styles for the element.
     */
    case STYLE = 'style';

    /**
     * `tabindex` — Overrides the browser's default tab order.
     */
    case TABINDEX = 'tabindex';

    /**
     * `target` — Where to display the response after following a link or submitting a form.
     */
    case TARGET = 'target';

    /**
     * `title` — Advisory title for the element (often shown as a tooltip).
     */
    case TITLE = 'title';

    /**
     * `translate` — Whether the element's content should be translated.
     */
    case TRANSLATE = 'translate';

    /**
     * `type` — Type information for various elements (input, script, link, etc.).
     */
    case TYPE = 'type';

    /**
     * `usemap` — Indicates an image is associated with a client-side image map.
     */
    case USEMAP = 'usemap';

    /**
     * `value` — Default value for form controls and other elements.
     */
    case VALUE = 'value';

    /**
     * `width` — Specifies the width of certain elements.
     */
    case WIDTH = 'width';

    /**
     * `wrap` — Indicates how text should be wrapped in a textarea.
     */
    case WRAP = 'wrap';
}
