<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Render\BBCode;

use Serafim\MessageComponent\Render as Tag;

/**
 * Class Header
 * @package Serafim\MessageComponent\Render\BBCode
 */
class Header extends Tag\Header
{
    /**
     * @var int
     */
    private $minSize = 30;

    /**
     * @var int
     */
    private $maxSize = 200;

    /**
     * @return string
     */
    public function render(): string
    {
        $size = $this->getSize($this->getLevel());

        return '[size=' . $size . ']' . $this->text . '[/size]';
    }

    /**
     * @param int $level
     * @return int
     */
    private function getSize(int $level): int
    {
        return $this->step() * (6 - $level) + $this->minSize;
    }

    /**
     * @return int
     */
    private function step(): int
    {
        return (int)floor(($this->maxSize - $this->minSize) / 6);
    }
}
