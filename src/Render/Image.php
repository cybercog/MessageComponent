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
 * Class Image
 * @package Serafim\MessageComponent\Render
 */
class Image extends DomElement
{
    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->attr('title', $this->html);
    }

    /**
     * @return string
     */
    public function getUrl() : string
    {
        return $this->attr('src', $this->html);
    }
}
