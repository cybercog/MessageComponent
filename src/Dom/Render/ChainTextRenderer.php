<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Dom\Render;

use Serafim\MessageComponent\Dom\Document;
use Serafim\MessageComponent\Dom\Node\TextElement;
use Serafim\MessageComponent\Dom\Node\NodeInterface;

/**
 * Class ChainTextRenderer
 * @package Serafim\MessageComponent\Dom\Render
 */
class ChainTextRenderer extends TextElement
{
    /**
     * RecursiveTextRenderer constructor.
     * @param \DOMText $element
     */
    public function __construct(Document $document, \DOMText $element)
    {
        parent::__construct($document, $element);
    }

    /**
     * @return string
     */
    public function render(): string
    {
        foreach ($this->document->getTextNodes() as $textNode) {
            /** @var NodeInterface $instance */
            $instance = new $textNode($this->document, $this->dom);

            $this->dom->textContent = $instance->render();
        }

        return $this->dom->textContent;
    }
}
