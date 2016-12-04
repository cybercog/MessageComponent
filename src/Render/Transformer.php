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
     * @var TextEscapeInterface|null
     */
    private $textEscape;

    /**
     * @var array|NodeRenderInterface[]
     */
    private $transformers = [];

    /**
     * Transformer constructor.
     */
    public function __construct()
    {
        $this->textEscape = new class implements TextEscapeInterface {
            public function escape(\DOMText $text, string $body): string
            {
                return $body;
            }
        };
    }

    /**
     * @param string|array $names
     * @param NodeRenderInterface $render
     * @return $this|Transformer
     */
    public function node($names, NodeRenderInterface $render): Transformer
    {
        foreach ((array)$names as $name) {
            $this->transformers[mb_strtolower($name)] = $render;
        }

        return $this;
    }

    /**
     * @param TextEscapeInterface $render
     * @return $this|Transformer
     */
    public function escape(TextEscapeInterface $render): Transformer
    {
        $this->textEscape = $render;

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
            return $this->textEscape->escape($dom, $text);
        }

        return $this->getRenderer($dom)->render($dom, $text);
    }

    /**
     * @param \DOMElement $element
     * @return NodeRenderInterface
     */
    private function getRenderer(\DOMElement $element): NodeRenderInterface
    {
        return $this->transformers[mb_strtolower($element->tagName)]
            ?? new class implements NodeRenderInterface {
                public function render(\DOMElement $dom, string $body): string
                {
                    return $body;
                }
            };
    }
}
