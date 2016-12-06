<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Render\Tree;

use Serafim\MessageComponent\Render\Render;

/**
 * Class Node
 * @package Serafim\MessageComponent\Render\Tree
 */
class Node implements DomElementInterface
{
    /**
     * @var \DOMElement
     */
    private $root;

    /**
     * @var Render
     */
    private $renderer;

    /**
     * Node constructor.
     * @param \DOMElement $dom
     * @param Render $renderer
     */
    public function __construct($dom, Render $renderer)
    {
        $this->root = $dom;
        $this->renderer = $renderer;
    }

    /**
     * @return \Generator|DomElementInterface[]
     */
    public function getIterator(): \Generator
    {
        foreach ($this->root->childNodes as $node) {
            $class = $node instanceof \DOMText ? Text::class : Node::class;

            yield new $class($node, $this->renderer);
        }
    }

    /**
     * @return string
     */
    public function render(): string
    {
        $output = '';

        foreach ($this->getIterator() as $node) {
            $output .= $node->render();
        }

        return $this->renderer->renderDomElement($this->root, $output);
    }
}
