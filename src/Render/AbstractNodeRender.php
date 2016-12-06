<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Render;

/**
 * Class AbstractNodeRender
 * @package Serafim\MessageComponent\Render
 */
abstract class AbstractNodeRender implements NodeRenderInterface
{
    /**
     * @return bool
     */
    public function isInsulatedRender(): bool
    {
        return false;
    }

    /**
     * @param \DOMElement|\DOMText $text
     * @return string
     */
    public function render($text): string
    {
        return $text->textContent;
    }
}
