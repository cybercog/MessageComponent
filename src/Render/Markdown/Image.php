<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Render\Markdown;

use Serafim\MessageComponent\Render\NodeRenderInterface;

/**
 * Class Image
 * @package Serafim\MessageComponent\Render\Markdown
 */
class Image implements NodeRenderInterface
{
    /**
     * @return bool
     */
    public function isInsulatedRender(): bool
    {
        return false;
    }

    /**
     * @param \DOMElement $dom
     * @return string
     */
    public function render($dom): string
    {
        $title = $this->prepareTitle($dom, $dom->textContent);
        $url   = $this->prepareUrl($dom, $dom->textContent);

        return sprintf('![%s](%s)', $title, $url);
    }

    /**
     * @param \DOMElement $dom
     * @param string $body
     * @return string
     */
    private function prepareTitle(\DOMElement $dom, string $body): string
    {
        if ($dom->hasAttribute('title')) {
            return $dom->getAttribute('title');

        } else if ($dom->hasAttribute('alt')) {
            return $dom->getAttribute('alt');
        }

        return $body;
    }

    /**
     * @param \DOMElement $dom
     * @param string $body
     * @return string
     */
    private function prepareUrl(\DOMElement $dom, string $body) : string
    {
        return $dom->hasAttribute('src')
            ? $dom->getAttribute('src')
            : $body;
    }
}
