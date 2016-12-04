<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Dom;

use Serafim\MessageComponent\Render\Transformer;

/**
 * Class Node
 * @package Serafim\MessageComponent\Dom
 */
class Node implements NodeInterface
{
    /**
     * @var \DOMElement
     */
    private $root;

    /**
     * @var Transformer
     */
    private $transformer;

    /**
     * Node constructor.
     * @param \DOMElement $dom
     * @param Transformer $transformer
     */
    public function __construct($dom, Transformer $transformer)
    {
        $this->root = $dom;
        $this->transformer = $transformer;
    }

    /**
     * @return \Generator|NodeInterface[]
     */
    public function getIterator(): \Generator
    {
        foreach ($this->root->childNodes as $node) {
            $class = $node instanceof \DOMText ? Text::class : Node::class;
            yield new $class($node, $this->transformer);
        }
    }

    /**
     * @param array $parameters
     * @return string
     */
    public function render(array $parameters = []): string
    {
        $output = '';

        foreach ($this->getIterator() as $node) {
            $output .= $node->render($parameters);
        }

        return $this->transformer->render($this->root, $output);
    }
}
