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
 * Class Code
 * @package Serafim\MessageComponent\Render\Markdown
 */
class Code implements NodeRenderInterface
{
    /**
     * @return bool
     */
    public function isInsulatedRender(): bool
    {
        return true;
    }

    /**
     * @param \DOMElement|\DOMText $dom
     * @param string $body
     * @return string
     */
    public function render($dom, string $body): string
    {
        $lang = $this->getLanguage($dom);

        if ($lang !== '' || str_contains($body, "\n")) {
            return $this->renderMultiline($lang, $body);
        }

        return '`' . $body . '`';
    }

    /**
     * @param string $language
     * @param string $body
     * @return string
     */
    private function renderMultiline(string $language, string $body)
    {
        return
            '```' . $language . "\n" .
                trim($body, "\n") . "\n" .
            '```';
    }

    /**
     * @param \DOMElement $element
     * @return string
     */
    private function getLanguage(\DOMElement $element): string
    {
        if ($element->hasAttribute('lang')) {
            return $element->getAttribute('lang');
        }

        return '';
    }
}
