<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Dom;

use Serafim\MessageComponent\Dom\Node\DomNodeInterface;
use Serafim\MessageComponent\Dom\Node\NodeInterface;
use Serafim\MessageComponent\Render as Tag;
use Serafim\MessageComponent\Dom\Node\DomElement;
use Serafim\MessageComponent\Dom\Render\Renderer;
use Serafim\MessageComponent\Dom\Node\TextElement;

/**
 * Class Document
 * @package Serafim\MessageComponent\Dom
 */
class Document
{
    /**
     * @var array
     */
    private $domNodes = [];

    /**
     * @var array
     */
    private $textNodes = [
        TextElement::class,
    ];

    /**
     * @var Renderer
     */
    private $renderer;

    /**
     * @var array
     */
    private $defaults = [
        Tag\Italic::class         => 'i',
        Tag\Bold::class           => 'b',
        Tag\Stroke::class         => 's',
        Tag\Link::class           => 'a',
        Tag\Code::class           => 'code',
        Tag\Quote::class          => 'quote',
        Tag\Header::class         => ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
        Tag\User::class           => 'user',
        Tag\HorizontalLine::class => 'hr',
        Tag\ListItem::class       => 'li',
        Tag\Image::class          => 'img',
        Tag\Date::class           => 'date'
    ];

    /**
     * Document constructor.
     * @throws \Serafim\MessageComponent\Dom\Exception\TagRedefineException
     */
    public function __construct()
    {
        $this->renderer = new Renderer($this);

        foreach ($this->defaults as $tag => $names) {
            $this->dom($tag)->as(...(array)$names);
        }
    }

    /**
     * @param string $class
     * @return NodeRegistrar
     */
    public function dom(string $class): NodeRegistrar
    {
        return new NodeRegistrar($this, $class, $this->domNodes);
    }

    /**
     * @param string $class
     * @return Document
     */
    public function text(string $class): Document
    {
        $this->textNodes[] = $class;

        return $this;
    }

    /**
     * @param string $body
     * @return string
     */
    public function render(string $body): string
    {
        return $this->parseDom($body)->render();
    }

    /**
     * @param string $body
     * @return DomNodeInterface
     */
    public function parseDom(string $body): DomNodeInterface
    {
        return $this->renderer->parseDom($body);
    }

    /**
     * @param \DOMElement $element
     * @return NodeInterface
     */
    public function wrap(\DOMElement $element): NodeInterface
    {
        $class = $this->findRegisteredTag($element->tagName);

        return new $class($this, $element);
    }

    /**
     * @return array
     */
    public function getDomElements(): array
    {
        return $this->domNodes;
    }

    /**
     * @param string $name
     * @return string
     */
    public function findRegisteredTag(string $name): string
    {
        return $this->domNodes[strtolower($name)] ?? DomElement::class;
    }

    /**
     * @return array
     */
    public function getTextNodes(): array
    {
        return $this->textNodes;
    }
}
