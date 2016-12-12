<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Render\Text;

use Serafim\MessageComponent\Dom\Node\TextElement;

/**
 * Class HtmlEntitiesDecoder
 * @package Serafim\MessageComponent\Render\Text
 */
class HtmlEntitiesDecoder extends TextElement
{
    /**
     * @return string
     */
    public function render(): string
    {
        return htmlspecialchars_decode($this->text);
    }
}
