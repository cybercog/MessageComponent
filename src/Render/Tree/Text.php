<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Render\Tree;

use Serafim\MessageComponent\Render\Render;

/**
 * Class Text
 * @package Serafim\MessageComponent\Render\Tree
 */
class Text implements DomElementInterface
{
    /**
     * @var \DOMText
     */
    private $textNode;

    /**
     * @var Render
     */
    private $render;

    /**
     * Text constructor.
     * @param \DOMText $dom
     * @param Render $render
     */
    public function __construct($dom, Render $render)
    {
        $this->textNode = $dom;
        $this->render = $render;
    }

    /**
     * @return string
     */
    public function render(): string
    {
        return $this->render->renderDomElement($this->textNode, $this->textNode->textContent);
    }
}
