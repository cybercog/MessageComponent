<?php declare(strict_types = 1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Adapter;

use Serafim\MessageComponent\Dom\Node;
use Serafim\MessageComponent\Message;
use Serafim\MessageComponent\Render\ {
    Markdown, Transformer
};

/**
 * Class GitterMarkdown
 * @package Serafim\MessageComponent\Adapter
 */
class GitterMarkdown implements AdapterInterface
{
    /**
     * @var Transformer
     */
    private $transformer;

    /**
     * GitterMarkdown constructor.
     */
    public function __construct()
    {
        $this->transformer = (new Transformer())
            ->escape(new Markdown\TextEscape())
            ->node(['blockquote', 'quote'], new Markdown\Quote())
            ->node(['h1', 'h2', 'h3', 'h4', 'h5', 'h6'], new Markdown\Header())
            ->node('user', new Markdown\User())
            ->node(['img', 'image'], new Markdown\Image());
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'gitter';
    }

    /**
     * @param Message $message
     * @return string
     */
    public function render(Message $message): string
    {
        $parser = new Node($message->getBody(), $this->transformer);

        return $parser->render($message->getParameters());
    }
}
