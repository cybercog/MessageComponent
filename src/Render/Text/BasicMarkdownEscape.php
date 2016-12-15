<?php declare(strict_types = 1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Render\Text;

use Serafim\MessageComponent\Dom\Node\TextElement;

/**
 * Class BasicMarkdownEscape
 * @package Serafim\MessageComponent\Render\Markdown\Text
 */
class BasicMarkdownEscape extends TextElement
{
    /**
     * @var array
     */
    protected $escapes = [
        'specialChars',
        'horizontalDelimiter',
        'headers',
        'links',
        'lists',
    ];

    /**
     * @return string
     */
    public function render(): string
    {
        $body = $this->text;

        foreach ($this->escapes as $method) {
            $body = $this->{$method}($body);
        }

        return $body;
    }

    /**
     * Escape blocks.
     * Chars:
     *  - "_": Italic text
     *  - "*": Alter italic and bold text
     *  - "`": Inline code
     *  - "~": Stroke text
     *
     * @param string $body
     * @param array $chars
     * @return string
     */
    protected function specialChars(string $body, array $chars = ['_', '\*', '~', '`']): string
    {
        $namedPattern = 'char';

        $regex = sprintf('/(?P<%s>(?:%s)+)/iu', $namedPattern, implode('|', $chars));

        return preg_replace_callback($regex, function ($matches) use ($namedPattern) {
            $char = current(str_split($matches[$namedPattern]));

            return str_replace($char, '\\' . $char, $matches[0]);
        }, $body);
    }

    /**
     * Escape horizontal line
     *
     * @param string $body
     * @return string
     */
    protected function horizontalDelimiter(string $body): string
    {
        return preg_replace('/\-\-(\-)+(\s*)$/u', '\-\-\-$2', $body);
    }

    /**
     * Escape headers
     *
     * @param string $body
     * @return string
     */
    protected function headers(string $body): string
    {
        return preg_replace('/\n*^(?!\w\s+)(#+\s+)/iu', '\\\\$1', $body);
    }

    /**
     * Escape links and images
     *
     * @param string $body
     * @return string
     */
    protected function links(string $body): string
    {
        return preg_replace('/\[(.*?)\]\((.*?)\)/su', '\\[$1\\]\\($2\\)', $body);
    }

    /**
     * Escape lists
     *
     * @param string $body
     * @return string
     */
    protected function lists(string $body): string
    {
        return preg_replace('/^(\s*>)?(\s*)(\-)\s+(.+?)/iu', '$1$2\\\\$3 $4', $body);
    }
}
