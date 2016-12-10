<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Render\Markdown;

use Serafim\MessageComponent\Dom\Node\DomElement;

/**
 * Class Code
 * @package Serafim\MessageComponent\Render\Markdown
 */
class Code extends DomElement
{
    /**
     * @return string
     */
    public function render(): string
    {
        $lang = $this->getLanguage();

        if ($lang !== '' || str_contains($this->html, "\n")) {
            return $this->multiline($lang);
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

    /**
     * @return string
     */
    private function getLanguage(): string
    {
        if ($this->dom->hasAttribute('lang')) {
            return $this->dom->getAttribute('lang');
        }

        return '';
    }
}
