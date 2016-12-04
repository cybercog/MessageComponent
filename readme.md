# Message Component

[![Build Status](https://travis-ci.org/SerafimArts/MessageComponent.svg?branch=master)](https://travis-ci.org/SerafimArts/MessageComponent)

Multiplatform message render component.

## Example:

```php
use Serafim\MessageComponent\{ Manager, Message };
use Serafim\MessageComponent\Adapter\GitterMarkdown;

$manager = new Manager();
$manager->addAdapter(new GitterMarkdown());

$message = new Message('<user>SerafimArts</user> says `<i>{{ message }}!</i>`', [
    'message' => 'hello'
]);

$out = $manager->render('gitter', $message);
// $out = '@SerafimArts says \`_hello_\`';
```