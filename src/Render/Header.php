<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Render;

use Serafim\MessageComponent\Dom\Node\DomElement;

/**
 * Class Header
 * @package Serafim\MessageComponent\Render
 */
class Header extends DomElement
{
    /**
     * @return int
     */
    public function getLevel(): int
    {
        $level = (int)substr($this->name, 1);

        return min(max($level, 1), 6);
    }
}
