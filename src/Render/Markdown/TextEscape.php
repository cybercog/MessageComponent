<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Render\Markdown;

use Serafim\MessageComponent\Render\TextEscapeInterface;

/**
 * Class TextEscape
 * @package Serafim\MessageComponent\Render\Markdown
 */
class TextEscape implements TextEscapeInterface
{
    /**
     * @param \DOMText $text
     * @param string $body
     * @return string
     */
    public function escape(\DOMText $text, string $body): string
    {
        // \s\s => \s
        $body = preg_replace('/  /u', ' ', $body);
        // Escape code
        $body = preg_replace('/`/u', '\\`', $body);
        // Escape italic
        $body = preg_replace('/(?P<char>(?:_|\*))(.+?)(?P=char)/isu', '\\\$1$2\\\$1', $body);
        // Escape bold
        $body = preg_replace('/\*\*(.+?)\*\*/su', '*\\*$1*\\*', $body);
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
