<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Render\BBCode;

use Serafim\MessageComponent\Render as Tag;

/**
 * Class ListItem
 * @package Serafim\MessageComponent\Render\BBCode
 */
class ListItem extends Tag\ListItem
{
    /**
     * @return string
     */
    public function render(): string
    {
        $space  = str_repeat('  ', $this->getNestingLevel());

        $prefix = $this->getPrefix($space);
        $suffix = $this->getSuffix($space);

        return $prefix .
            $space . '  [*] ' . $this->text . "\n" .
        $suffix;
    }

    /**
     * @param string $space
     * @return string
     */
    private function getPrefix(string $space): string
    {
        $prefix = '';
        if ($this->isFirstItem()) {
            $prefix = $space . '[list]' . "\n";

            if ($this->getNestingLevel()) {
                $prefix = "\n" . $prefix;
            }
        }

        return $prefix;
    }

    /**
     * @param string $space
     * @return string
     */
    private function getSuffix(string $space): string
    {
        $suffix = '';
        if ($this->isLastItem()) {
            $suffix = $space . '[/list]';

            if (!$this->getNestingLevel()) {
                $suffix .= "\n";
            }
        }

        return $suffix;
    }
}
