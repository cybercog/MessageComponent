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
 * Interface TextNodeInterface
 * @package Serafim\MessageComponent\Dom\Node
 */
interface TextNodeInterface extends NodeInterface
{
    /**
     * TextNodeInterface constructor.
     * @param Document $document
     * @param \DOMText $text
     */
    public function __construct(Document $document, \DOMText $text);
}
