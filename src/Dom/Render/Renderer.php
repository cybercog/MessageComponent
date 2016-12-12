<?php declare(strict_types = 1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Dom\Render;

use Serafim\MessageComponent\Dom\Document;
use Serafim\MessageComponent\Dom\Node\DomNodeInterface;
use Serafim\MessageComponent\Dom\Node\TextElement;
use Serafim\MessageComponent\Dom\XmlParser;

/**
 * Class Renderer
 * @package Serafim\MessageComponent\Dom\Render
 */
class Renderer
{
    /**
     * @var Document
     */
    private $document;

    /**
     * @var XmlParser
     */
    private $parser;

    /**
     * Renderer constructor.
     * @param Document $document
     */
    public function __construct(Document $document)
    {
        $this->document = $document;
        $this->parser = new XmlParser();
    }

    /**
     * @param string $body
     * @return string
     */
    public function render(string $body): string
    {
        return $this->parseDom($body)->render();
    }

    /**
     * @param string $body
     * @return DomNodeInterface
     */
    public function parseDom(string $body): DomNodeInterface
    {
        return $this->make($this->parser->create($body));
    }

    /**
     * @param \DOMText|\DOMElement $element
     * @return DomNodeInterface|TextElement
     */
    private function make($element)
    {
        if ($element instanceof \DOMText) {
            return new ChainTextRenderer($this->document, $element);
        }

        /** @var DomNodeInterface $node */
        $node = $this->findElementRenderer($element);

        foreach ($element->childNodes as $child) {
            $node->append($this->make($child));
        }

        return $node;
    }

    /**
     * @param \DOMElement $element
     * @return DomNodeInterface
     */
    private function findElementRenderer(\DOMElement $element): DomNodeInterface
    {
        $class = $this->document->findRegisteredTag($element->tagName);

        return new $class($this->document, $element);
    }
}
