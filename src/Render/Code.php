<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Render;

use Serafim\MessageComponent\Dom\Node\DomElement;

/**
 * Class Code
 * @package Serafim\MessageComponent\Render
 */
class Code extends DomElement
{
    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->attr('lang', '');
    }

    /**
     * @return bool
     */
    public function hasLanguage(): bool
    {
        return $this->getLanguage() !== '';
    }

    /**
     * @return bool
     */
    public function isMultiline(): bool
    {
        return false !== strpos($this->html, "\n");
    }
}
