<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Dom\Markdown;

use Serafim\MessageComponent\Dom\Node\DomElement;

/**
 * Class Link
 * @package Serafim\MessageComponent\Dom\Markdown
 */
class Link extends DomElement
{
    /**
     * @return string
     */
    public function render(): string
    {
        list($title, $url) = [$this->prepareTitle(), $this->prepareUrl()];

        return sprintf('[%s](%s)', $title, $url);
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
        if ($this->dom->hasAttribute('href')) {
            return $this->dom->getAttribute('href');

        } else if ($this->dom->hasAttribute('src')) {
            return $this->dom->getAttribute('src');
        }

        return $this->html;
    }
}
