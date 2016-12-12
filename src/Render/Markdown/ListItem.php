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
 * Class ListItem
 * @package Serafim\MessageComponent\Render\Markdown
 */
class ListItem extends Tag\ListItem
{
    /**
     * @return string
     */
    public function render(): string
    {
        $prefix  = $this->isFirstItem() ? "\n" : '';
        $prefix .= str_repeat('  ', $this->getNestingLevel());

        return $prefix . '- ' . $this->text . "\n";
    }
}
