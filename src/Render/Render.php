<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Render;

use Serafim\MessageComponent\Manager;
use Serafim\MessageComponent\Render\Tree\DomElementInterface;
use Serafim\MessageComponent\Render\Tree\Node;

/**
 * Class RenderRender
 * @package Serafim\MessageComponent\Render
 */
class Render
{
    /**
     * Render DOM node "as is"
     *
     * @var NodeRenderInterface
     */
    private $unprocessableRender;

    /**
     * Render other node renderers
     *
     * @var array|NodeRenderInterface[]
     */
    private $nodeRenderers = [];

    /**
     * @var Manager
     */
    private $manager;

    /**
     * Render constructor.
     * @param Manager $manager
     */
    public function __construct(Manager $manager)
    {
        $this->unprocessableRender = new class extends AbstractNodeRender {};
        $this->manager = $manager;
    }

    /**
     * @param string|array $names
     * @param NodeRenderInterface $render
     * @return $this|Render
     */
    public function nodeRender($names, NodeRenderInterface $render): Render
    {
        foreach ((array)$names as $name) {
            $this->nodeRenderers[mb_strtolower($name)] = $render;
        }

        return $this;
    }

    /**
     * @return Manager
     */
    public function getManager(): Manager
    {
        return $this->manager;
    }

    /**
     * @return array|NodeRenderInterface[]
     */
    public function getNodeRenders()
    {
        return $this->nodeRenderers;
    }

    /**
     * @param string $message
     * @return string
     */
    public function render(string $message): string
    {
        return (new Node($this->makeXmlDom($message), $this))->render();
    }

    /**
     * @param string $message
     * @return \DOMElement
     */
    private function makeXmlDom(string $message): \DOMElement
    {
        $document = new \DOMDocument('1.0', 'utf-8');
        $document->loadXML('<root>' . $message . '</root>');

        return $document->childNodes->item(0);
    }

    /**
     * @param \DOMElement|\DOMText $dom
     * @param string $processed
     * @return string
     */
    public function renderDomElement($dom, string $processed): string
    {

        $name = $dom instanceof \DOMText ? DomElementInterface::TEXT_NODE_NAME : $dom->tagName;

        $node = $this->getRenderer($name);

        if ($node->isInsulatedRender()) {
            $processed = $this->innerHtml($dom);

            $insulatedDomElement = $dom->ownerDocument->createElement($dom->tagName);

            /** @var \DOMAttr $attr */
            foreach ($dom->attributes as $attr) {
                $insulatedDomElement->setAttributeNode($attr);
            }

            $dom = $insulatedDomElement;
        }

        $dom->textContent = $processed;

        return $node->render($dom);
    }


    /**
     * @param \DOMElement $dom
     * @return string
     */
    private function innerHtml(\DOMElement $dom): string
    {
        $body = '';

        /** @var \DOMText $childNode */
        foreach ($dom->childNodes as $childNode) {
            $body .= $childNode->ownerDocument->saveXML($childNode);
        }

        return $body;
    }

    /**
     * @param $tagName
     * @return NodeRenderInterface
     */
    private function getRenderer(string $tagName): NodeRenderInterface
    {
        return $this->nodeRenderers[mb_strtolower($tagName)] ?? $this->unprocessableRender;
    }
}
