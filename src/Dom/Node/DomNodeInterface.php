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
 * Interface DomNodeInterface
 * @package Serafim\MessageComponent\Dom\Node
 */
interface DomNodeInterface extends NodeInterface
{
    /**
     * DomNodeInterface constructor.
     * @param Document $document
     * @param \DOMElement $element
     */
    public function __construct(Document $document, \DOMElement $element);

    /**
     * @param NodeInterface $node
     * @return void
     */
    public function append(NodeInterface $node);

    /**
     * @return \Traversable
     */
    public function getChildren(): \Traversable;
}
