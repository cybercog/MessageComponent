<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Dom\Node;

use Serafim\MessageComponent\Dom\Document;

/**
 * Class DomElement
 * @package Serafim\MessageComponent\Dom\Node
 *
 * @property-read string $text
 * @property-read string $html
 * @property-read string $name
 */
class DomElement extends Element implements DomNodeInterface
{
    /**
     * @var array
     */
    private $children = [];

    /**
     * @var string|null
     */
    private $renderTextCache;

    /**
     * @var string|null
     */
    private $renderHtmlCache;

    /**
     * DomElement constructor.
     * @param Document $document
     * @param \DOMElement $element
     */
    public function __construct(Document $document, \DOMElement $element)
    {
        parent::__construct($document, $element);
    }

    /**
     * @return string
     */
    public function render(): string
    {
        return $this->innerText();
    }

    /**
     * @return string
     */
    protected function innerText(): string
    {
        if ($this->renderTextCache === null) {
            $this->renderTextCache = '';
            foreach ($this->getChildren() as $child) {
                $this->renderTextCache .= $child->render();
            }
        }

        return $this->renderTextCache;
    }

    /**
     * @param string $name
     * @param string $value
     * @return \DOMElement|$this
     */
    public function setAttribute(string $name, string $value): \DOMElement
    {
        $this->dom->setAttribute($name, $value);

        return $this;
    }

    /**
     * @return string
     */
    private function innerHtml(): string
    {
        if ($this->renderHtmlCache === null) {
            $this->renderHtmlCache = '';

            /** @var \DOMText $childNode */
            foreach ($this->dom->childNodes as $childNode) {
                $this->renderHtmlCache .= $childNode->ownerDocument->saveXML($childNode);
            }
        }

        return $this->renderHtmlCache;
    }

    /**
     * @param string $name
     * @param string|null $default
     * @return string|null
     */
    protected function attr(string $name, string $default = null)
    {
        if ($this->dom->hasAttribute($name)) {
            return $this->dom->getAttribute($name);
        }

        return $default;
    }

    /**
     * @param NodeInterface $node
     */
    public function append(NodeInterface $node)
    {
        $this->children[] = $node;
    }

    /**
     * @return \Traversable|NodeInterface[]
     */
    public function getChildren(): \Traversable
    {
        return new \ArrayIterator($this->children);
    }

    /**
     * @param string $property
     * @return string
     */
    public function __get(string $property)
    {
        switch ($property) {
            case 'html':
                return $this->innerHtml();
            case 'text':
                return $this->innerText();
            case 'name':
                return $this->dom->tagName;
        }

        return null;
    }
}
