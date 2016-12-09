<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Dom\Markdown;

use Serafim\MessageComponent\Dom\Node\TextElement;

/**
 * Class TextRender
 * @package Serafim\MessageComponent\Dom\Markdown
 */
class TextRender extends TextElement
{
    /**
     * @return string
     */
    public function render(): string
    {
        $body = $this->dom->textContent;

        // \s\s => \s
        $body = preg_replace('/  /u', ' ', $body);
        // Escape italic, bold, inline code and stroke
        $body = preg_replace_callback('/(?P<char>(?:_|\*|~|`)+)/iu', function($matches) {
            $char = current(str_split($matches['char']));
            return str_replace($char, '\\' . $char, $matches[0]);
        }, $body);
        // Escape horizontal line
        $body = preg_replace('/\-\-(\-)+(\s*)$/u', '\-\-\-$2', $body);
        // Escape headers
        $body = preg_replace('/\n*^(?!\w\s+)(#)/iu', '\\#', $body);
        // Escape links and images
        $body = preg_replace('/\[(.*?)\]\((.*?)\)/su', '\\[$1\\]\\($2\\)', $body);
        // Escape lists
        $body = preg_replace('/^(\s*>)?(\s*)(\-)\s*(\w+)/iu', '$1$2\\\\$3 $4', $body);

        return $body;
    }
}
