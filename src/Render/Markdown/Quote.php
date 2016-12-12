<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Render\Markdown;

use Serafim\MessageComponent\Render as Tag;

/**
 * Class Quote
 * @package Serafim\MessageComponent\Render\Markdown
 */
class Quote extends Tag\Quote
{
    /**
     * @return string
     */
    public function render(): string
    {
        $out = '>' . str_replace("\n", "\n>", $this->text);

        // Normalize quote
        $out = preg_replace('/^>\s*(\w+)/iu', '> $1', $out);

        return $out . "\n\n";
    }
}
