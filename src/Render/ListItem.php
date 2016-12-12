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
 * Class ListItem
 * @package Serafim\MessageComponent\Render
 */
class ListItem extends DomElement
{
    /**
     * @return int
     */
    public function getNestingLevel(): int
    {
        $level = 0;
        $current = $this->dom;

        while ($current->parentNode && $current->parentNode->tagName === $this->name) {
            $level++;
            $current = $current->parentNode;
        }

        return $level;
    }

    /**
     * @return bool
     */
    public function isFirstItem(): bool
    {
        return !(
            $this->dom->previousSibling &&
            $this->dom->previousSibling instanceof \DOMElement &&
            $this->name === $this->dom->previousSibling->tagName
        );
    }
}
