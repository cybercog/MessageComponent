<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Parser\Markdown;

use Serafim\MessageComponent\Dom\Parser\AbstractToken;

/**
 * Class HorizontalLine
 * @package Serafim\MessageComponent\Parser\Markdown
 */
class HorizontalLine extends AbstractToken
{
    /**
     * @return string
     */
    public function getRule(): string
    {
        return '/(\-{2,})\s*(.*?)$/imu';
    }

    /**
     * @param string $scope
     * @param string[] ...$groups
     * @return string
     */
    public function transform(string $scope, string ...$groups): string
    {
        $size = strlen(array_shift($groups));

        if (trim($groups[0])) {
            return $scope;

        } elseif ($size > 2) {
            return $this->tag('hr');
        }

        return '–';
    }
}