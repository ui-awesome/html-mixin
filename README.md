<!-- markdownlint-disable MD041 -->
<p align="center">
    <a href="https://github.com/ui-awesome/html-mixin" target="_blank">
        <img src="https://raw.githubusercontent.com/ui-awesome/.github/refs/heads/main/logo/ui_awesome.png" alt="UI Awesome" width="25%">
    </a>
    <h1 align="center">Html Mixin</h1>
    <br>
</p>
<!-- markdownlint-enable MD041 -->

<p align="center">
    <a href="https://github.com/ui-awesome/html-mixin/actions/workflows/build.yml" target="_blank">
        <img src="https://img.shields.io/github/actions/workflow/status/ui-awesome/html-mixin/build.yml?style=for-the-badge&label=PHPUnit&logo=github" alt="PHPUnit">
    </a>
    <a href="https://dashboard.stryker-mutator.io/reports/github.com/ui-awesome/html-mixin/main" target="_blank">
        <img src="https://img.shields.io/endpoint?style=for-the-badge&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fui-awesome%2Fhtml-mixin%2Fmain" alt="Mutation Testing">
    </a>
    <a href="https://github.com/ui-awesome/html-mixin/actions/workflows/static.yml" target="_blank">
        <img src="https://img.shields.io/github/actions/workflow/status/ui-awesome/html-mixin/static.yml?style=for-the-badge&label=PHPStan&logo=github" alt="PHPStan">
    </a>
    <a href="https://github.com/ui-awesome/html-mixin/actions/workflows/security.yml" target="_blank">
        <img src="https://img.shields.io/github/actions/workflow/status/ui-awesome/html-mixin/security.yml?style=for-the-badge&label=Security&logo=github" alt="Security">
    </a>
</p>

<p align="center">
    <strong>A type-safe PHP mixin library for HTML tag rendering components</strong><br>
    <em>Build reusable components with traits for attributes, content, templates, and prefix/suffix management.</em>
</p>

## Features

<picture>
    <source media="(max-width: 767px)" srcset="./docs/svgs/features-mobile.svg">
    <img src="./docs/svgs/features.svg" alt="Feature Overview" style="width: 100%;">
</picture>

### Installation

```bash
composer require ui-awesome/html-mixin:^0.8
```

### Quick start

#### Managing HTML attributes with HasAttributes

The `HasAttributes` trait provides a fluent, immutable API for managing HTML attributes on elements. It supports enum
keys/values, closure-based values, additive updates with `attributes()`, explicit replacement with `replaceAttributes()`,
and `null` values for removing attributes.

```php
<?php

declare(strict_types=1);

namespace App\Component;

use UIAwesome\Html\Mixin\HasAttributes;

final class MyComponent
{
    use HasAttributes;
}

$component = new MyComponent();

$component = $component
    ->addAttribute('id', 'my-component')
    ->attributes(['class' => 'container', 'role' => 'main'])
    ->attributes(['data-state' => 'open', 'aria-label' => 'Close'])
    ->removeAttribute('role');

$component->getAttributes();
// ['id' => 'my-component', 'class' => 'container', 'data-state' => 'open', 'aria-label' => 'Close']

$component->getAttribute('id', 'default-id');
// 'my-component'

$component->getAttribute('aria-label');
// 'Close'

$replacement = $component->replaceAttributes(['id' => 'replacement']);

$replacement->getAttributes();
// ['id' => 'replacement']
```

#### Managing content with encoding support

The `HasContent` trait handles both safe encoded content and raw HTML with XSS protection through `Encode::content()`.

```php
<?php

declare(strict_types=1);

namespace App\Component;

use UIAwesome\Html\Mixin\HasContent;

final class MyComponent
{
    use HasContent;
}

$component = new MyComponent();

$encodedContent = $component
    ->content('<script>alert("XSS")</script>')
    ->getContent();
// &lt;script&gt;alert(&quot;XSS&quot;)&lt;/script&gt;

$component2 = new MyComponent();

$htmlContent = $component2
    ->html('<strong>Raw HTML</strong>')
    ->getContent();
// <strong>Raw HTML</strong>
```

#### Custom templates with HasTemplate

Define custom rendering templates for your components using the `HasTemplate` trait.

```php
<?php

declare(strict_types=1);

namespace App\Component;

use UIAwesome\Html\Mixin\{HasContent, HasTemplate};

final class MyComponent
{
    use HasContent;
    use HasTemplate;

    public function render(): string
    {
        return str_replace('{content}', $this->content, $this->template);
    }
}

$component = new MyComponent();

echo $component
    ->content('Card Content')
    ->template('<div class="card">{content}</div>')
    ->render();
// <div class="card">Card Content</div>
```

#### Prefix and suffix content with tag support

The `HasPrefixCollection` and `HasSuffixCollection` traits add content before and after your element, optionally wrapped
in tags with their own attributes.

Tag APIs now accept `UnitEnum`, so your components can use any project enum without a direct runtime dependency on
`ui-awesome/html-interop`.

```php
<?php

declare(strict_types=1);

namespace App\Component;

use UIAwesome\Html\Mixin\{HasContent, HasPrefixCollection, HasSuffixCollection};

enum InlineTag: string
{
    case STRONG = 'strong';
    case EM = 'em';
}

final class MyComponent
{
    use HasContent;
    use HasPrefixCollection;
    use HasSuffixCollection;

    public function render(): string
    {
        return $this->prefix . $this->content . $this->suffix;
    }
}

$component = new MyComponent();

echo $component
    ->content('Main Content')
    ->prefix('Prefix: ')
    ->prefixAttributes(['class' => 'prefix-badge'])
    ->prefixTag(InlineTag::STRONG)
    ->suffix(' :Suffix')
    ->suffixTag(InlineTag::EM)
    ->render();
// <strong class="prefix-badge">Prefix: </strong>Main Content<em> :Suffix</em>
```

## Documentation

For detailed configuration options and advanced usage.

- 🧪 [Testing Guide](docs/testing.md)
- ⬆️ [Upgrade Guide](UPGRADE.md)

## Package information

[![PHP](https://img.shields.io/badge/%3E%3D8.3-777BB4.svg?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/releases/8.3/en.php)
[![Latest Stable Version](https://img.shields.io/packagist/v/ui-awesome/html-mixin.svg?style=for-the-badge&logo=packagist&logoColor=white&label=Stable)](https://packagist.org/packages/ui-awesome/html-mixin)
[![Total Downloads](https://img.shields.io/packagist/dt/ui-awesome/html-mixin.svg?style=for-the-badge&logo=composer&logoColor=white&label=Downloads)](https://packagist.org/packages/ui-awesome/html-mixin)

## Project status

[![Codecov](https://img.shields.io/codecov/c/github/ui-awesome/html-mixin.svg?style=for-the-badge&logo=codecov&logoColor=white&label=Coverage)](https://codecov.io/github/ui-awesome/html-mixin)
[![PHPStan Level Max](https://img.shields.io/badge/PHPStan-Level%20Max-4F5D95.svg?style=for-the-badge&logo=github&logoColor=white)](https://github.com/ui-awesome/html-mixin/actions/workflows/static.yml)
[![Quality](https://img.shields.io/github/actions/workflow/status/ui-awesome/html-mixin/quality.yml?style=for-the-badge&label=Quality&logo=github)](https://github.com/ui-awesome/html-mixin/actions/workflows/quality.yml)
[![StyleCI](https://img.shields.io/badge/StyleCI-Passed-44CC11.svg?style=for-the-badge&logo=github&logoColor=white)](https://github.styleci.io/repos/767385551?branch=main)

## Our social networks

[![Follow on X](https://img.shields.io/badge/-Follow%20on%20X-1DA1F2.svg?style=for-the-badge&logo=x&logoColor=white&labelColor=000000)](https://x.com/Terabytesoftw)
[![Follow on Facebook](https://img.shields.io/badge/-Follow%20on%20Facebook-1877F2.svg?style=for-the-badge&logo=facebook&logoColor=white&labelColor=000000)](https://www.facebook.com/wilmer.arambula.9)

## License

[![License](https://img.shields.io/badge/License-BSD--3--Clause-brightgreen.svg?style=for-the-badge&logo=opensourceinitiative&logoColor=white&labelColor=555555)](LICENSE)
