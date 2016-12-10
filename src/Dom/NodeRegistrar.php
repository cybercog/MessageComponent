<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Dom;

use Serafim\MessageComponent\Dom\Exception\TagRedefineException;

/**
 * Class NodeRegistrar
 * @package Serafim\MessageComponent\Dom
 *
 * @property-get Document $and
 */
class NodeRegistrar
{
    /**
     * @var array
     */
    private $domNodes;

    /**
     * @var string
     */
    private $node;

    /**
     * @var Document
     */
    private $document;

    /**
     * NodeRegistrar constructor.
     * @param Document $document
     * @param string $node
     * @param array $domNodes
     */
    public function __construct(Document $document, string $node, array &$domNodes)
    {
        $this->document = $document;
        $this->domNodes = &$domNodes;
        $this->node = $node;
    }

    /**
     * @param \string[] ...$tags
     * @return $this
     * @throws TagRedefineException
     */
    public function as(string ...$tags)
    {
        foreach ($tags as $tag) {
            if (array_key_exists($tag, $this->domNodes)) {
                $message = 'Tag <%s> already registered for %s';
                throw new TagRedefineException(sprintf($message, $tag, $this->domNodes[$tag]));
            }

            $this->instead($tag);
        }

        return $this;
    }

    /**
     * @param string $tag
     * @return NodeRegistrar
     */
    public function instead(string $tag): NodeRegistrar
    {
        $this->domNodes[strtolower($tag)] = $this->node;

        return $this;
    }

    /**
     * @param string $name
     * @return Document
     */
    public function __get(string $name)
    {
        switch ($name) {
            case 'and':
                return $this->document;
        }

        return null;
    }
}
