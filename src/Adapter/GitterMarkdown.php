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
            ->textRender(new Markdown\TextRender())
            ->nodeRender(['i', 'italic'], new Markdown\Italic())
            ->nodeRender(['b', 'bold', 'strong'], new Markdown\Bold())
            ->nodeRender(['s', 'stroke', 'remove', 'delete'], new Markdown\Stroke())
            ->nodeRender(['a', 'link', 'url'], new Markdown\Link())
            ->nodeRender(['code', 'kbd', 'pre'], new Markdown\Code())
            ->nodeRender(['quote', 'blockquote'], new Markdown\Quote())
            ->nodeRender(['h1', 'h2', 'h3', 'h4', 'h5', 'h6'], new Markdown\Header())
            ->nodeRender(['user', 'profile', 'account'], new Markdown\User())
            ->nodeRender(['hr', 'line', 'delimiter'], new Markdown\HorizontalLine())
            ->nodeRender(['li', 'list', 'item'], new Markdown\ListItem())
            ->nodeRender(['img', 'image'], new Markdown\Image());
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
        $dom = $message->getBody();

        $parser = new Node($dom, $this->transformer);

        return $parser->render($message->getParameters());
    }
}
