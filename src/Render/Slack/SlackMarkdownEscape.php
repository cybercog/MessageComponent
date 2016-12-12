<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Render\Slack;

use Serafim\MessageComponent\Render\Text\BasicMarkdownEscape;

/**
 * Class SlackMarkdownEscape
 * @package Serafim\MessageComponent\Render\Slack
 */
class SlackMarkdownEscape extends BasicMarkdownEscape
{
    /**
     * @var array
     */
    protected $escapes = [
        // 'horizontalDelimiter',   # Slack does not support horizontal delimiter line
        // 'headers',               # Slack does not support headers
        // 'links',                 # Slack does not support images and links
        'specialChars',
        'lists',
    ];
}