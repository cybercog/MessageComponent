<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Render;

/**
 * Interface NodeRenderInterface
 * @package Serafim\MessageComponent\Render
 */
interface NodeRenderInterface
{
    /**
     * @return bool
     */
    public function isInsulatedRender(): bool;

    /**
     * @param \DOMElement|\DOMText $dom
     * @param string $body
     * @return string
     */
    public function render($dom, string $body): string;
}
