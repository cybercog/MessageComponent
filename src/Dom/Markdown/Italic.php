<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Dom\Markdown;

use Serafim\MessageComponent\Dom\Node\DomElement;

/**
 * Class Italic
 * @package Serafim\MessageComponent\Dom\Markdown
 */
class Italic extends DomElement
{
    /**
     * @return string
     */
    public function render(): string
    {
        return '_' . $this->text . '_';
    }
}
