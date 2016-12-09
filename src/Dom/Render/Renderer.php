<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Dom\Render;

use Illuminate\Support\Str;
use Serafim\MessageComponent\Dom\Document;
use Serafim\MessageComponent\Dom\Node\DomElement;
use Serafim\MessageComponent\Dom\Node\DomNodeInterface;
use Serafim\MessageComponent\Dom\Node\TextElement;

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
     * Renderer constructor.
     * @param Document $document
     */
    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    /**
     * @param string $body
     * @return string
     */
    public function render(string $body): string
    {
        return $this->make($this->createXml($body))->render();
    }

    /**
     * @param \DOMText|\DOMElement $element
     * @return DomNodeInterface|TextElement
     */
    private function make($element)
    {
        if ($element instanceof \DOMText) {
            return new RecursiveTextRenderer($this->document, $element);
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
        $class = $this->document->findTag($element->tagName);
        return new $class($this->document, $element);
    }

    /**
     * @param string $body
     * @return \DOMElement
     */
    private function createXml(string $body): \DOMElement
    {
        $document = new \DOMDocument('1.0', 'utf-8');

        if (Str::startsWith($body, ['<?xml', '<!doctype'])) {
            $document->loadXML($body);
            return $document->documentElement;
        }

        $document->loadXML('<root>' . $body . '</root>');
        return $document->childNodes->item(0);
    }
}
