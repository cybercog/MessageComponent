<?php declare(strict_types = 1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Adapter;

use Serafim\MessageComponent\Render\Markdown;
use Serafim\MessageComponent\Render\Common;

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
        // Text
        Markdown\TextRender::class     => self::TEXT_NODE,
        // Markdown
        Markdown\Italic::class         => 'i',
        Markdown\Bold::class           => 'b',
        Markdown\Stroke::class         => 's',
        Markdown\Link::class           => 'a',
        Markdown\Code::class           => 'code',
        Markdown\Quote::class          => 'quote',
        Markdown\Header::class         => ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
        Markdown\User::class           => 'user',
        Markdown\HorizontalLine::class => 'hr',
        Markdown\ListItem::class       => 'li',
        Markdown\Image::class          => 'img',
        // Common
        Common\Date::class             => 'date'
    ];

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
