<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Render\Markdown;

use Serafim\MessageComponent\Dom\Node\DomElement;

/**
 * Class Image
 * @package Serafim\MessageComponent\Render\Markdown
 */
class Image extends DomElement
{
    /**
     * @return string
     */
    public function render(): string
    {
        list($title, $url) = [$this->prepareTitle(), $this->prepareUrl()];

        return sprintf('![%s](%s)', $title, $url);
    }

    /**
     * @return string
     */
    private function prepareTitle(): string
    {
        if ($this->dom->hasAttribute('title')) {
            return $this->dom->getAttribute('title');
        }

        return $this->html;
    }

    /**
     * @return string
     */
    private function prepareUrl() : string
    {
        return $this->dom->hasAttribute('src')
            ? $this->dom->getAttribute('src')
            : $this->html;
    }
}