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
 * Class HorizontalLine
 * @package Serafim\MessageComponent\Render\Markdown
 */
class HorizontalLine extends Tag\HorizontalLine
{
    /**
     * @return string
     */
    public function render(): string
    {
        $prefix = $this->endsWithNl() ? '' : "\n";
        return $prefix . "\n---\n";
    }

    /**
     * @return bool
     */
    private function endsWithNl(): bool
    {
        $prev = '';
        if ($this->dom->previousSibling) {
            $prev = $this->dom->previousSibling->textContent;
        }

        return $prev !== '' && $prev[strlen($prev) - 1] === "\n";
    }
}
