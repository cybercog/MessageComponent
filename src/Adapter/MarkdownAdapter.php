<?php declare(strict_types = 1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Adapter;

use Serafim\MessageComponent\Parser\Markdown as MdParser;
use Serafim\MessageComponent\Render\Markdown as MdRender;
use Serafim\MessageComponent\Render\Text\BasicMarkdownEscape;
use Serafim\MessageComponent\Render\Text\HtmlEntitiesDecoder;

/**
 * Class MarkdownAdapter
 * @package Serafim\MessageComponent\Adapter
 */
class MarkdownAdapter extends AbstractAdapter
{
    /**
     * @var array
     */
    protected $textRenderers = [
        BasicMarkdownEscape::class,
        HtmlEntitiesDecoder::class,
    ];

    /**
     * @var array
     */
    protected $nodeRenderers = [
        MdRender\Italic::class         => 'i',
        MdRender\Bold::class           => 'b',
        MdRender\Stroke::class         => 's',
        MdRender\Link::class           => 'a',
        MdRender\Code::class           => 'code',
        MdRender\Quote::class          => 'quote',
        MdRender\Header::class         => ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
        MdRender\HorizontalLine::class => 'hr',
        MdRender\ListItem::class       => 'li',
        MdRender\Image::class          => 'img',
        MdRender\User::class           => 'user',
    ];

    /**
     * @var array
     */
    protected $tokenParsers = [
        // "**bold**"
        // "__bold__"
        MdParser\Bold::class,

        // "*italic*"
        // "_italic_"
        // !!! Must be registered after MdParser\Bold::class
        MdParser\Italic::class,

        // "~~stroke~~"
        MdParser\Stroke::class,

        // "![title](url)"
        MdParser\Image::class,

        // "[title](url)"
        // !!! Must be registered after MdParser\Image::class
        MdParser\Link::class,

        // "> Quote"
        MdParser\Quote::class,

        // "`code`"
        // "```lang \ncode\n```"
        // "```\ncode\n```"
        MdParser\Code::class,

        // "# Header"
        MdParser\Header::class,

        // "Header\n----"
        MdParser\TitleHeader::class,

        // "---"
        // !!! Must be registered after MdParser\TitleHeader::class
        MdParser\HorizontalLine::class,

        // "- List item"
        // !!! Must be registered after MdParser\HorizontalLine::class
        MdParser\ListItem::class,

        // "[//]: Comment"
        MdParser\Comment::class,
    ];
}