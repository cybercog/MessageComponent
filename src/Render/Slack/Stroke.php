<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Render\Slack;

use Serafim\MessageComponent\Render as Tag;

/**
 * Class Stroke
 * @package Serafim\MessageComponent\Render\Slack
 */
class Stroke extends Tag\Stroke
{
    /**
     * @return string
     */
    public function render(): string
    {
        return '~' . $this->text . '~';
    }
}