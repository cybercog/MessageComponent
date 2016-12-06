<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Parser\Markdown;

use Serafim\MessageComponent\Parser\NodeParserInterface;

/**
 * Class Header
 * @package Serafim\MessageComponent\Parser\Markdown
 */
class Header implements NodeParserInterface
{
    public function parse($dom): string
    {
        throw new \LogicException(__METHOD__ . ' not implemented yet');
    }
}
