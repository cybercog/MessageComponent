<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Dom;

use Serafim\MessageComponent\Render\Transformer;

/**
 * Class Text
 * @package Serafim\MessageComponent\Dom
 */
class Text implements NodeInterface
{
    use ParametersInjectorTrait;

    /**
     * @var \DOMText
     */
    private $text;

    /**
     * @var Transformer
     */
    private $transformer;

    /**
     * Text constructor.
     * @param \DOMText $dom
     * @param Transformer $transformer
     */
    public function __construct($dom, Transformer $transformer)
    {
        $this->text = $dom;
        $this->transformer = $transformer;
    }

    /**
     * @param array $parameters
     * @return string
     */
    public function render(array $parameters = []): string
    {
        return $this->transformer
            ->render($this->text,
                $this->injectParameters($this->text->textContent, $parameters)
            );
    }

    /**
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator();
    }
}
