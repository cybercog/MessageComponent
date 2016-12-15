<?php declare(strict_types = 1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Parser\Markdown;

use Serafim\MessageComponent\Dom\Parser\AbstractToken;

/**
 * Class Code
 * @package Serafim\MessageComponent\Parser\Markdown
 */
class Code extends AbstractToken
{
    /**
     * @return string
     */
    public function getRule(): string
    {
        return '/`{1,3}(\w+\n)?(.*?)`{1,3}/isu';
    }

    /**
     * @param string $scope
     * @param string[] ...$groups
     * @return string
     */
    public function transform(string $scope, string ...$groups): string
    {
        $lang = array_shift($groups);

        return $this->tag('code', array_shift($groups), [
            'lang' => trim($lang)
        ]);
    }
}