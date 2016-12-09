# Message Component

[![Build Status](https://travis-ci.org/SerafimArts/MessageComponent.svg?branch=master)](https://travis-ci.org/SerafimArts/MessageComponent)

Multiplatform message render component.

## Example:

```php
use Serafim\MessageComponent\Adapter\GitterMarkdown;
use Serafim\MessageComponent\Manager;

$manager = (new Manager())
    ->addAdapter(GitterMarkdown::class);

$out = $manager->render('gitter', '<user>SerafimArts</user> says `<i>{{ message }}!</i>`');
// $out = '@SerafimArts says \`_hello_\`';
```

## Available tags

- `<i>Italic</i>` - Italic text
- `<b>Bold</b>` - Bold text
- `<s>Stroke</s>` - Stroke text
- `<a>Link</a>` - External link
    - Attribute `href` (optional): Link url
    - Attribute `title` (optional): Link title
- `<code>Code</code>` - Single or multiline code
    - Attribute `lang` (optional): Code language
- `<quote>Quoted text</quote>` - User quote
- `<h1>Header 1</h1>` - Header 1 (can be h1...h6)
- `<user>Name</user>` - Username
- `<hr />` - Horizontal delimiter line
- `<li>List item</li>` - Just a list item
- `<img>Image url</img>` - Image
    - Attribute `src` (optional): Image url
    - Attribute `title` (optional): Image title

_All code follows PSR-1, PSR-2, PSR-4, PSR-5, PSR-11 and PSR-12 coding standards._