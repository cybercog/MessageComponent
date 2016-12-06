<?php declare(strict_types = 1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Adapter;

use Serafim\MessageComponent\Manager;
use Serafim\MessageComponent\Render\Markdown;
use Serafim\MessageComponent\Render\Render;
use Serafim\MessageComponent\Render\Tree\DomElementInterface;

/**
 * Class GitterMarkdown
 * @package Serafim\MessageComponent\Adapter
 */
class GitterMarkdown extends AbstractAdapter
{
    /**
     * @var array
     */
    protected $nodeRenderers = [
        Markdown\TextRender::class     => DomElementInterface::TEXT_NODE_NAME,
        Markdown\Italic::class         => ['i', 'italic'],
        Markdown\Bold::class           => ['b', 'bold', 'strong'],
        Markdown\Stroke::class         => ['s', 'stroke', 'remove', 'delete'],
        Markdown\Link::class           => ['a', 'link', 'url'],
        Markdown\Code::class           => ['code', 'pre', 'kbd'],
        Markdown\Quote::class          => ['quote', 'blockquote'],
        Markdown\Header::class         => ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
        Markdown\User::class           => ['user', 'profile', 'account'],
        Markdown\HorizontalLine::class => ['hr', 'line', 'delimiter'],
        Markdown\ListItem::class       => ['li', 'list', 'item'],
        Markdown\Image::class          => ['img', 'image'],
    ];

    /**
     * @var string
     */
    protected $textRenderer = Markdown\TextRender::class;


    /**
     * @param string $message
     * @return string
     * @throws \LogicException
     */
    public function parse(string $message): string
    {
        return $this->parser->parse($message);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'gitter';
    }
}
