<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Dom;

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
     * Document constructor.
     */
    public function __construct()
    {
        $this->renderer = new Renderer($this);
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
        return $this->renderer->render($body);
    }

    /**
     * @return array
     */
    public function getDomElements(): array
    {
        return $this->domNodes;
    }

    /**
     * @param string $tag
     * @return string
     */
    public function findTag(string $tag): string
    {
        return $this->domNodes[strtolower($tag)] ?? DomElement::class;
    }

    /**
     * @return array
     */
    public function getTextNodes(): array
    {
        return $this->textNodes;
    }
}
