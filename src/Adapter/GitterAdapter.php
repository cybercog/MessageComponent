<?php declare(strict_types = 1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Adapter;

use Serafim\MessageComponent\Parser\Gitter as GitterParser;
use Serafim\MessageComponent\Parser\Markdown as MdParser;
use Serafim\MessageComponent\Render\Gitter as GitterRender;
use Serafim\MessageComponent\Render\Markdown as MdRender;
use Serafim\MessageComponent\Render\Text;

/**
 * Class GitterAdapter
 * @package Serafim\MessageComponent\Adapter
 */
class GitterAdapter extends AbstractAdapter
{
    /**
     * @var array
     */
    protected $textRenderers = [
        // Common
        Text\BasicMarkdownEscape::class,
        Text\HtmlEntitiesDecoder::class,
        // Custom
        GitterRender\EscapeAdvancedSyntax::class,
    ];

    /**
     * @var array
     */
    protected $nodeRenderers = [
        // Custom tags
        GitterRender\User::class       => 'user',
        // Common markdown
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
    ];

    /**
     * @var array
     */
    protected $tokenParsers = [
        MdParser\Bold::class,
        MdParser\Italic::class,
        MdParser\Stroke::class,
        MdParser\Image::class,
        MdParser\Link::class,
        MdParser\Quote::class,
        MdParser\Code::class,
        MdParser\Header::class,
        MdParser\TitleHeader::class,
        MdParser\HorizontalLine::class,
        MdParser\ListItem::class,
        GitterParser\User::class,
    ];
}
