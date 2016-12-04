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
 * Class User
 * @package Serafim\MessageComponent\Render\Markdown
 */
class User implements NodeRenderInterface
{
    /**
     * @param \DOMElement $dom
     * @param string $body
     * @return string
     */
    public function render(\DOMElement $dom, string $body): string
    {
        return '@' . $body;
    }
}
