<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Render\Slack;

use Serafim\MessageComponent\Render as Tag;

/**
 * Class Code
 * @package Serafim\MessageComponent\Render\Slack
 */
class Code extends Tag\Code
{
    public function render(): string
    {

        if ($this->isMultiline()) {
            $prefix = $this->prefixRequired() ? "\n" : '';
            return $prefix . '```' . "\n" . trim($this->html) . "\n" . '```';
        }

        $prefix = $this->prefixRequired() ? ' ' : '';
        return $prefix . '`' . $this->html . '`';
    }

    /**
     * @return bool
     */
    private function prefixRequired()
    {
        if (!$this->dom->previousSibling) {
            return false;
        }

        $text = $this->dom->previousSibling->textContent;

        return rtrim($text) === $text;
    }
}