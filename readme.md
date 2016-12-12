# Message Component

[![Build Status](https://travis-ci.org/SerafimArts/MessageComponent.svg?branch=master)](https://travis-ci.org/SerafimArts/MessageComponent)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/SerafimArts/MessageComponent/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/SerafimArts/MessageComponent/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/SerafimArts/MessageComponent/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/SerafimArts/MessageComponent/?branch=master)
[![GitHub license](https://img.shields.io/badge/license-WTFPL-green.svg?style=flat)](https://raw.githubusercontent.com/SerafimArts/Properties/master/LICENSE)
[![Packagist](https://img.shields.io/packagist/v/serafim/message-component.svg)](https://packagist.org/packages/serafim/message-component)


Cross-platform message render component.

- Installation: `composer require serafim/message-component`
- Requirements: `php >= 7.0` or `hhvm >= 3.11`

## Renders example:

```php
use Serafim\MessageComponent\Adapter\PhpBBAdapter;
use Serafim\MessageComponent\Adapter\GitHubAdapter;
use Serafim\MessageComponent\Adapter\SlackAdapter;
use Serafim\MessageComponent\Manager;

$manager = (new Manager())
    ->addAdapter(GitHubAdapter::class, PhpBBAdapter::class, SlackAdapter::class);


$message = '<user uid="Id42">SerafimArts</user> says: <i>$$test$$</i> `code`!';

echo $manager->on('github')->render($message);
// @SerafimArts says: _$$test$$_ \`code\`!

echo $manager->on('phpbb')->render($message);
// [b]SerafimArts[/b] says: [i]$$test$$[/i] `code`!

echo $manager->on('slack')->render($message);
// <@Id42|SerafimArts> says: _$$test$$_ \`code\`!
```

## Platforms

See: https://github.com/SerafimArts/MessageComponent/issues/1

- Gitter: `Serafim\MessageComponent\Adapter\GitterAdapter::class`
- GitHub: `Serafim\MessageComponent\Adapter\GitHubAdapter::class`
- Markdown (generic): `Serafim\MessageComponent\Adapter\MarkdownAdapter::class`
- BBCode (PhpBB engine): `Serafim\MessageComponent\Adapter\PhpBBAdapter::class`
- Slack: `Serafim\MessageComponent\Adapter\SlackAdapter::class`
    - Images does not supports by platform and must be attached:
    ```php
    use Serafim\MessageComponent\Query;
  
    // See https://api.slack.com/docs/message-attachments
    $slackMessage = ['text' => $manager->on('slack')->render($message), 'attachments' => []];
  
    $query = new Query($message);
  
    foreach ($query->find('img') as $img) {
        $slackMessage['attachements']['image_url'] = $img->getUrl();
    }
    ```

## Tags

See: https://github.com/SerafimArts/MessageComponent/issues/2

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
    - Attribute `login` (optional): User login
    - Attribute `uid` (optional): User ID
- `<hr />` - Horizontal delimiter line
- `<li>List item</li>` - Just a list item
- `<img>Image url and|or title</img>` - Image
    - Attribute `src` (optional): Image url
    - Attribute `title` (optional): Image title
- `<date>02-02-2042</date>` - Datetime string
    - Attribute `format` (optional): Date format. 
    It can be one of `date-time` (default), `date`, `formatted-date`, `time`, `day-date-time`, `atom`, `cookie`, 
    `iso8601`, `rfc822`, `rfc850`, `rfc1036`, `rfc1123`, `rfc2822`, `rfc3339`, `rss` or `w3c`

_All code follows PSR-1, PSR-2, PSR-4, PSR-5, PSR-11 and PSR-12 coding standards._
