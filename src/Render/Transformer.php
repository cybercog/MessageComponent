<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Render;

/**
 * Class Transformer
 * @package Serafim\MessageComponent\Render
 */
class Transformer
{
    /**
     * @var NodeRenderInterface
     */
    private $unprocessableRender;

    /**
     * @var NodeRenderInterface
     */
    private $textRender;

    /**
     * @var array|NodeRenderInterface[]
     */
    private $transformers = [];

    /**
     * Transformer constructor.
     */
    public function __construct()
    {
        $this->unprocessableRender = new UnprocessableNodeRender();
    }

    /**
     * @param string|array $names
     * @param NodeRenderInterface $render
     * @return $this|Transformer
     */
    public function nodeRender($names, NodeRenderInterface $render): Transformer
    {
        foreach ((array)$names as $name) {
            $this->transformers[mb_strtolower($name)] = $render;
        }

        return $this;
    }

    /**
     * @return array|NodeRenderInterface[]
     */
    public function getNodeRenders()
    {
        return $this->transformers;
    }

    /**
     * @param NodeRenderInterface $render
     * @return $this|Transformer
     */
    public function textRender(NodeRenderInterface $render): Transformer
    {
        $this->textRender = $render;

        return $this;
    }

    /**
     * @param \DOMElement|\DOMText $dom
     * @param string $text
     * @return string
     */
    public function render($dom, string $text): string
    {
        if ($dom instanceof \DOMText) {
            return $this->textRender->render($dom, $text);
        }

        $render = $this->getRenderer($dom);

        if ($render->isInsulatedRender()) {
            return $render->render($dom, $this->innerHtml($dom));
        }

        return $render->render($dom, $text);
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
     * @param \DOMElement $element
     * @return NodeRenderInterface
     */
    private function getRenderer(\DOMElement $element): NodeRenderInterface
    {
        return $this->transformers[mb_strtolower($element->tagName)]
            ?? $this->unprocessableRender;
    }
}
