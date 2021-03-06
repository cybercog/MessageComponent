<?php declare(strict_types = 1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Adapter;

use Serafim\MessageComponent\Render\Github;
use Serafim\MessageComponent\Render\Markdown;
use Serafim\MessageComponent\Render\Text;

/**
 * Class GitHubAdapter
 * @package Serafim\MessageComponent\Adapter
 */
class GitHubAdapter extends AbstractAdapter
{
    /**
     * @var array
     */
    protected $textRenderers = [
        // Common
        Text\BasicMarkdownEscape::class,
        Text\HtmlEntitiesDecoder::class,
        // Custom
        Github\EscapeAdvancedSyntax::class,
    ];

    /**
     * @var array
     */
    protected $nodeRenderers = [
        // Custom tags
        Github\User::class             => 'user',
        // Common markdown
        Markdown\Italic::class         => 'i',
        Markdown\Bold::class           => 'b',
        Markdown\Stroke::class         => 's',
        Markdown\Link::class           => 'a',
        Markdown\Code::class           => 'code',
        Markdown\Quote::class          => 'quote',
        Markdown\Header::class         => ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
        Markdown\HorizontalLine::class => 'hr',
        Markdown\ListItem::class       => 'li',
        Markdown\Image::class          => 'img',
    ];
}
