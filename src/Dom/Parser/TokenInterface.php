<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Dom\Parser;

/**
 * Interface TokenInterface
 * @package Serafim\MessageComponent\Dom\Parser
 */
interface TokenInterface
{
    /**
     * @return string
     */
    public function getRule(): string;

    /**
     * @param string $scope
     * @param string[] ...$groups
     * @return string
     */
    public function transform(string $scope, string ...$groups): string;
}