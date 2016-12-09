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


_All code follows PSR-1, PSR-2, PSR-4, PSR-5, PSR-11 and PSR-12 coding standards._ 