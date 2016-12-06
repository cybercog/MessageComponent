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
 * Class Quote
 * @package Serafim\MessageComponent\Render\Markdown
 */
class Quote implements NodeRenderInterface
{
    /**
     * @return bool
     */
    public function isInsulatedRender(): bool
    {
        return false;
    }

    /**
     * @var bool
     */
    private $strict;

    /**
     * Quote constructor.
     * @param bool $strict Disable double "\n" after blockquote
     */
    public function __construct(bool $strict = false)
    {
        $this->strict = $strict;
    }

    /**
     * @param \DOMElement $dom
     * @return string
     */
    public function render($dom): string
    {
        $out = '>' . str_replace("\n", "\n>", $dom->textContent);

        // Normalize quote
        $out = preg_replace('/^>\s*(\w+)/iu', '> $1', $out);

        return $out . ($this->strict ? '' : "\n\n");
    }
}
