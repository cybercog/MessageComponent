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
 * Class Header
 * @package Serafim\MessageComponent\Render\Markdown
 */
class Header implements NodeRenderInterface
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
        $level = substr($dom->tagName, 1);

        return str_repeat('#', (int)$level) . ' ' . $dom->textContent . "\n";
    }
}
