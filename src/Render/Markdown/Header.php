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
 * Class Header
 * @package Serafim\MessageComponent\Render\Markdown
 */
class Header extends DomElement
{
    /**
     * @return string
     */
    public function render(): string
    {
        $level = substr($this->name, 1);

        return str_repeat('#', (int)$level) . ' ' . $this->text . "\n";
    }
}
