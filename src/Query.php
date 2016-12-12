<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent;

use Serafim\MessageComponent\Dom\Document;
use Serafim\MessageComponent\Dom\Node\NodeInterface;
use Serafim\MessageComponent\Dom\NodeRegistrar;
use Serafim\MessageComponent\Dom\XmlParser;

/**
 * Class Query
 * @package Serafim\MessageComponent
 */
class Query
{
    /**
     * @var \DOMElement
     */
    private $dom;

    /**
     * @var Document
     */
    private $document;

    /**
     * Query constructor.
     * @param string $body
     * @throws \Serafim\MessageComponent\Dom\Exception\TagRedefineException
     */
    public function __construct(string $body)
    {
        $this->dom = (new XmlParser())->create($body);
        $this->document = new Document();
    }

    /**
     * @param string $tag
     * @return NodeRegistrar
     */
    public function dom(string $tag): NodeRegistrar
    {
        return $this->document->dom($tag);
    }

    /**
     * @param string $id
     * @return null|NodeInterface
     */
    public function getById(string $id)
    {
        return $this->findOneBy('id', $id);
    }

    /**
     * @param string $attr
     * @param string|null $value
     * @return \Generator|NodeInterface[]
     */
    public function findBy(string $attr, string $value = null): \Generator
    {
        $value = $value === null ? '' : sprintf("='%s'", $value);

        yield from $this->xpath(sprintf('*[@%s%s]', $attr, $value));
    }

    /**
     * @param string $attr
     * @param string|null $value
     * @return NodeInterface|null
     */
    public function findOneBy(string $attr, string $value = null)
    {
        /** @noinspection LoopWhichDoesNotLoopInspection */
        foreach ($this->findBy($attr, $value) as $tag) {
            return $tag;
        }

        return null;
    }

    /**
     * @param string $path
     * @return NodeInterface[]|\Generator
     */
    public function xpath(string $path): \Generator
    {
        $xpath = new \DOMXPath($this->dom->ownerDocument);

        foreach ($xpath->query($path) as $item) {
            yield $this->wrap($item);
        }
    }

    /**
     * @param string $tagName
     * @return \Generator|NodeInterface[]
     */
    public function find(string $tagName): \Generator
    {
        foreach ($this->dom->getElementsByTagName($tagName) as $item) {
            yield $this->wrap($item);
        }
    }

    /**
     * @param \DOMElement|null $element
     * @return null|NodeInterface
     */
    private function wrap(\DOMElement $element = null)
    {
        if ($element === null) {
            return null;
        }

        return $this->document->wrap($element);
    }
}
