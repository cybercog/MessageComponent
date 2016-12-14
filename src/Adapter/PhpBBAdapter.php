<?php declare(strict_types = 1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Adapter;

use Serafim\MessageComponent\Render\BBCode;
use Serafim\MessageComponent\Render\Text;

/**
 * Class PhpBBAdapter
 * @package Serafim\MessageComponent\Adapter
 */
class PhpBBAdapter extends AbstractAdapter
{
    /**
     * @var array
     */
    protected $textRenderers = [
        // Common
        Text\HtmlEntitiesDecoder::class,
        // BB codes can not be escaped =(
    ];

    /**
     * @var array
     */
    protected $nodeRenderers = [
        BBCode\User::class           => 'user',
        BBCode\Italic::class         => 'i',
        BBCode\Bold::class           => 'b',
        BBCode\Stroke::class         => 's',
        BBCode\Link::class           => 'a',
        BBCode\Code::class           => 'code',
        BBCode\Quote::class          => 'quote',
        BBCode\Header::class         => ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
        BBCode\HorizontalLine::class => 'hr',
        BBCode\ListItem::class       => 'li',
        BBCode\Image::class          => 'img',
    ];
}
