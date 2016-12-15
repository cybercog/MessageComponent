<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Parser\Gitter;

use Serafim\MessageComponent\Dom\Parser\AbstractToken;

/**
 * Class User
 * @package Serafim\MessageComponent\Parser\Gitter
 */
class User extends AbstractToken
{
    /**
     * @return string
     */
    public function getRule(): string
    {
        return '/@([a-z0-9\-_]+)/iu';
    }

    /**
     * @param string $scope
     * @param string[] ...$groups
     * @return string
     */
    public function transform(string $scope, string ...$groups): string
    {
        return $this->tag('user', $groups[0]);
    }
}