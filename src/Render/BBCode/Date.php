<?php declare(strict_types = 1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Render\BBCode;

use Serafim\MessageComponent\Render as Tag;

/**
 * Class Date
 * @package Serafim\MessageComponent\Render
 */
class Date extends Tag\Date
{
    /**
     * @return string
     */
    public function render(): string
    {
        return '[date=' . $this->format($this->getDate(), 'rfc3339') . ']' .
            $this->text .
        '[/date]';
    }
}
