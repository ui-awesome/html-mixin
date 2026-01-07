<!-- markdownlint-disable MD041 -->
<p align="center">
    <picture>
        <source media="(prefers-color-scheme: dark)" srcset="https://raw.githubusercontent.com/ui-awesome/.github/refs/heads/main/logo/ui_awesome_dark.png">
        <source media="(prefers-color-scheme: light)" srcset="https://raw.githubusercontent.com/ui-awesome/.github/refs/heads/main/logo/ui_awesome_light.png">
        <img src="https://raw.githubusercontent.com/ui-awesome/.github/refs/heads/main/logo/ui_awesome_dark.png" alt="UI Awesome" width="150px">
    </picture>
    <h1 align="center">Html mixin</h1>
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
</p>

<p align="center">
    <strong>A type-safe PHP mixin library for HTML tag rendering components</strong><br>
    <em>Build reusable components with traits for attributes, content, templates, and prefix/suffix management.</em>
</p>

## Features

<picture>
    <source media="(min-width: 768px)" srcset="./docs/svgs/features.svg">
    <img src="./docs/svgs/features-mobile.svg" alt="Feature Overview" style="width: 100%;">
</picture>

### Installation

```bash
composer require ui-awesome/html-mixin:^0.4
```

### Quick start

#### Managing HTML attributes with HasAttributes

The `HasAttributes` trait provides a fluent, immutable API for managing HTML attributes on elements. Supports enum
keys/values, closure-based values, and array merging.

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

$attributes = $component->addAttribute('id', 'my-component')
    ->attributes(['class' => ['container'], 'data-role' => 'main'])
    ->removeAttribute('data-role')
    ->getAttributes();
// ['id' => 'my-component', 'class' => ['container']]
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

$encodedContent = $component->content('<script>alert("XSS")</script>')
    ->getContent();
// &lt;script&gt;alert(&quot;XSS&quot;)&lt;/script&gt;

$component2 = new MyComponent();

$htmlContent = $component2->html('<strong>Raw HTML</strong>')
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

echo $component->template('<div class="card">{content}</div>')
    ->content('Card Content')
    ->render();
// <div class="card">Card Content</div>
```

#### Prefix and suffix content with tag support

The `HasPrefixCollection` and `HasSuffixCollection` traits add content before and after your element, optionally wrapped
in tags with their own attributes.

```php
<?php

declare(strict_types=1);

namespace App\Component;

use UIAwesome\Html\Mixin\{HasContent, HasPrefixCollection, HasSuffixCollection};
use UIAwesome\Html\Interop\Inline;

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

echo $component->prefix('Prefix: ')
    ->prefixTag(Inline::STRONG)
    ->prefixAttributes(['class' => 'prefix-badge'])
    ->content('Main Content')
    ->suffix(' :Suffix')
    ->suffixTag(Inline::EM)
    ->render();
// <strong class="prefix-badge">Prefix: </strong>Main Content<em> :Suffix</em>
```

## Documentation

For detailed configuration options and advanced usage.

- 🧪 [Testing Guide](docs/testing.md)
- 🛠️ [Development Guide](docs/development.md)

## Package information

[![PHP](https://img.shields.io/badge/%3E%3D8.1-777BB4.svg?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/releases/8.1/en.php)
[![Latest Stable Version](https://img.shields.io/packagist/v/ui-awesome/html-mixin.svg?style=for-the-badge&logo=packagist&logoColor=white&label=Stable)](https://packagist.org/packages/ui-awesome/html-mixin)
[![Total Downloads](https://img.shields.io/packagist/dt/ui-awesome/html-mixin.svg?style=for-the-badge&logo=composer&logoColor=white&label=Downloads)](https://packagist.org/packages/ui-awesome/html-mixin)

## Quality code

[![Codecov](https://img.shields.io/codecov/c/github/ui-awesome/html-mixin.svg?style=for-the-badge&logo=codecov&logoColor=white&label=Coverage)](https://codecov.io/github/ui-awesome/html-mixin)
[![PHPStan Level Max](https://img.shields.io/badge/PHPStan-Level%20Max-4F5D95.svg?style=for-the-badge&logo=github&logoColor=white)](https://github.com/ui-awesome/html-mixin/actions/workflows/static.yml)
[![Super-Linter](https://img.shields.io/github/actions/workflow/status/ui-awesome/html-mixin/linter.yml?style=for-the-badge&label=Super-Linter&logo=github)](https://github.com/ui-awesome/html-mixin/actions/workflows/linter.yml)
[![StyleCI](https://img.shields.io/badge/StyleCI-Passed-44CC11.svg?style=for-the-badge&logo=github&logoColor=white)](https://github.styleci.io/repos/767385551?branch=main)

## Our social networks

[![Follow on X](https://img.shields.io/badge/-Follow%20on%20X-1DA1F2.svg?style=for-the-badge&logo=x&logoColor=white&labelColor=000000)](https://x.com/Terabytesoftw)

## License

[![License](https://img.shields.io/badge/License-BSD--3--Clause-brightgreen.svg?style=for-the-badge&logo=opensourceinitiative&logoColor=white&labelColor=555555)](LICENSE)
