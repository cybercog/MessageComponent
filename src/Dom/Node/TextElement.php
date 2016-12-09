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
 * Class TextElement
 * @package Serafim\MessageComponent\Dom\Node
 */
class TextElement extends Element implements TextNodeInterface
{
    /**
     * TextElement constructor.
     * @param Document $document
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
        return htmlspecialchars_decode($this->dom->textContent);
    }
}
