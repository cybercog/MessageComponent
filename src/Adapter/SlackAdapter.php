<?php declare(strict_types = 1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Adapter;

use Serafim\MessageComponent\Render\Markdown;
use Serafim\MessageComponent\Render\Slack;
use Serafim\MessageComponent\Render\Text;

/**
 * Class SlackAdapter
 * @package Serafim\MessageComponent\Adapter
 */
class SlackAdapter extends AbstractAdapter
{
    /**
     * @var array
     */
    protected $textRenderers = [
        // Custom escaping
        Slack\SlackMarkdownEscape::class,
        // Common
        Text\HtmlEntitiesDecoder::class,
    ];

    /**
     * @var array
     */
    protected $nodeRenderers = [
        // Custom tags
        Slack\User::class              => 'user',
        Slack\Link::class              => 'a',
        Slack\Date::class              => 'date',
        Slack\Code::class              => 'code',
        Slack\Image::class             => 'img',
        Slack\Bold::class              => 'b',
        Slack\Stroke::class            => 's',
        // Common markdown
        Markdown\Italic::class         => 'i',
        Markdown\Quote::class          => 'quote',
        Markdown\Header::class         => ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
        Markdown\HorizontalLine::class => 'hr',
        Markdown\ListItem::class       => 'li',
    ];
}
