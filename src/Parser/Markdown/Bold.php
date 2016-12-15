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
 * Class Bold
 * @package Serafim\MessageComponent\Parser\Markdown
 */
class Bold extends AbstractToken
{
    /**
     * @return string
     */
    public function getRule(): string
    {
        return '/(?P<bold>(?:\*\*|__))(.+?)(?P=bold)/imu';
    }

    /**
     * @param string $scope
     * @param string[] ...$groups
     * @return string
     */
    public function transform(string $scope, string ...$groups): string
    {
        return $this->tag('b', $groups[2]);
    }
}