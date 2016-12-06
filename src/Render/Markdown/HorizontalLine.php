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
 * Class HorizontalLine
 * @package Serafim\MessageComponent\Render\Markdown
 */
class HorizontalLine implements NodeRenderInterface
{
    /**
     * @return bool
     */
    public function isInsulatedRender(): bool
    {
        return false;
    }

    /**
     * @param \DOMElement|\DOMText $dom
     * @param string $body
     * @return string
     */
    public function render($dom): string
    {
        return "\n---\n";
    }
}
