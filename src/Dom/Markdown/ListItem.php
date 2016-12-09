<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Dom\Markdown;


use Serafim\MessageComponent\Dom\Node\DomElement;

/**
 * Class ListItem
 * @package Serafim\MessageComponent\Dom\Markdown
 */
class ListItem extends DomElement
{
    /**
     * @return string
     */
    public function render(): string
    {
        $isСontinuation = $this->isСontinuationOfList();
        $nestingLevel   = $this->getNestedLevel();

        $prefix  = $isСontinuation ? '' : "\n";
        $prefix .= str_repeat('  ', $nestingLevel);

        return $prefix . '- ' . $this->text . "\n";
    }

    /**
     * @return int
     */
    private function getNestedLevel(): int
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
     * 1) Has previous tag
     * 2) Previous tag is not looks like current
     *
     * @return bool
     */
    private function isСontinuationOfList()
    {
        return
            $this->dom->previousSibling &&
            $this->dom->previousSibling instanceof \DOMElement &&
            $this->name === $this->dom->previousSibling->tagName;
    }
}
