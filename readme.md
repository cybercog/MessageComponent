# Message Component

[![Build Status](https://travis-ci.org/SerafimArts/MessageComponent.svg?branch=master)](https://travis-ci.org/SerafimArts/MessageComponent)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/SerafimArts/MessageComponent/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/SerafimArts/MessageComponent/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/SerafimArts/MessageComponent/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/SerafimArts/MessageComponent/?branch=master)
[![GitHub license](https://img.shields.io/badge/license-WTFPL-green.svg?style=flat)](https://raw.githubusercontent.com/SerafimArts/Properties/master/LICENSE)
[![Packagist](https://img.shields.io/packagist/v/serafim/message-component.svg)](https://packagist.org/packages/serafim/message-component)


Cross-platform message render component.

- Installation: `composer require serafim/message-component`
- Requirements: `php >= 7.0` or `hhvm >= 3.11`

## Example:

```php
use Serafim\MessageComponent\Adapter\GitterMarkdown;
use Serafim\MessageComponent\Manager;

$manager = (new Manager())
    ->addAdapter(GitterMarkdown::class);

$out = $manager->render('gitter', '<user>SerafimArts</user> says `<i>{{ message }}!</i>`');
// $out = '@SerafimArts says \`_hello_\`';
```

## Available platforms

- Gitter: `Serafim\MessageComponent\Adapter\GitterMarkdown::class`
- Skype: _in progress..._
- Slack: _in progress..._
- Telegram: _in progress..._
- GitHub: _in progress..._
- Vk: _in progress..._
- Facebook: _in progress..._

## Available tags

- `<i>Italic</i>` - Italic text
- `<b>Bold</b>` - Bold text
- `<s>Stroke</s>` - Stroke text
- `<a>Link and/or title</a>` - External link
    - Attribute `href` (optional): Link url
    - Attribute `title` (optional): Link title
- `<code>Code</code>` - Single or multiline code
    - Attribute `lang` (optional): Code language
- `<quote>Quoted text</quote>` - User quote
- `<h1>Header 1</h1>` - Header 1 (can be h1...h6)
- `<user>Name</user>` - Username
- `<hr />` - Horizontal delimiter line
- `<li>List item</li>` - Just a list item
- `<img>Image url and|or title</img>` - Image
    - Attribute `src` (optional): Image url
    - Attribute `title` (optional): Image title
- '<date>02-02-2042</date>' - Datetime string
    - Attribute `format` (optional): Date format. 
    It can be one of `date-time` (default), `date`, `formatted-date`, `time`, `day-date-time`, `atom`, `cookie`, 
    `iso8601`, `rfc822`, `rfc850`, `rfc1036`, `rfc1123`, `rfc2822`, `rfc3339`, `rss` or `w3c`

_All code follows PSR-1, PSR-2, PSR-4, PSR-5, PSR-11 and PSR-12 coding standards._