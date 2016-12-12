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
 * Class Code
 * @package Serafim\MessageComponent\Render\Markdown
 */
class Code extends Tag\Code
{
    /**
     * @return string
     */
    public function render(): string
    {
        if ($this->hasLanguage() || $this->isMultiline()) {
            return $this->multiline($this->getLanguage());
        }

        return '`' . $this->html . '`';
    }

    /**
     * @param string $language
     * @return string
     */
    private function multiline(string $language): string
    {
        return
            '```' . $language . "\n" .
                trim($this->html, "\n") . "\n" .
            '```';
    }
}
