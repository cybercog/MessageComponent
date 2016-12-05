<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Render\Markdown;


use Serafim\MessageComponent\Render\NodeRenderInterface;

/**
 * Class ListItem
 * @package Serafim\MessageComponent\Render\Markdown
 */
class ListItem implements NodeRenderInterface
{
    /**
     * @return bool
     */
    public function isInsulatedRender(): bool
    {
        return false;
    }

    /**
     * @param \DOMElement $dom
     * @param string $body
     * @return string
     */
    public function render($dom, string $body): string
    {
        $isСontinuation = $this->isСontinuationOfList($dom);
        $nestingLevel   = $this->getNestedLevel($dom);

        $prefix  = $isСontinuation ? '' : "\n";
        $prefix .= str_repeat('  ', $nestingLevel);

        return $prefix . '- ' . $body . "\n";
    }

    /**
     * @param \DOMElement $dom
     * @return int
     */
    private function getNestedLevel(\DOMElement $dom): int
    {
        $level = 0;
        $current = $dom;

        while ($current->parentNode && $current->parentNode->tagName === $dom->tagName) {
            $level++;
            $current = $current->parentNode;
        }

        return $level;
    }

    /**
     * 1) Has previous tag
     * 2) Previous tag is not looks like current
     *
     * @param \DOMElement $dom
     * @return bool
     */
    private function isСontinuationOfList(\DOMElement $dom)
    {
        return
            $dom->previousSibling &&
            $dom->previousSibling instanceof \DOMElement &&
            $dom->tagName === $dom->previousSibling->tagName;
    }
}
