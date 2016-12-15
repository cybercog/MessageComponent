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
 * Class Quote
 * @package Serafim\MessageComponent\Parser\Markdown
 */
class Quote extends AbstractToken
{
    /**
     * @return string
     */
    public function getRule(): string
    {
        return '/(^(?:>|&gt;) ?.+?)((?:\R{2,}\w)|\Z)/msu';
    }

    /**
     * @param string $scope
     * @param string[] ...$groups
     * @return string
     */
    public function transform(string $scope, string ...$groups): string
    {
        $body = preg_replace('/^(>|&gt;)\s*/imu', '', array_shift($groups));

        return $this->tag('quote', $body) . array_shift($groups);
    }
}