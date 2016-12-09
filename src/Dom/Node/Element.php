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
 * Class Element
 * @package Serafim\MessageComponent\Dom\Node
 */
abstract class Element implements NodeInterface
{
    /**
     * @var \DOMElement|\DOMText
     */
    protected $dom;

    /**
     * @var Document
     */
    protected $document;

    /**
     * Element constructor.
     * @param Document $document
     * @param \DOMText|\DOMElement $dom
     */
    public function __construct(Document $document, $dom)
    {
        $this->dom = $dom;
        $this->document = $document;
    }

    /**
     * @return Document
     */
    public function getDocument(): Document
    {
        return $this->document;
    }

    /**
     * @return \DOMElement|\DOMText
     */
    public function getDomElement()
    {
        return $this->dom;
    }

    /**
     * @return string
     */
    public function render(): string
    {
        return $this->dom->textContent;
    }
}
