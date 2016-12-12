<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Unit;

/**
 * Class AbstractRenderTests
 * @package Serafim\MessageComponent\Unit
 */
abstract class AbstractRenderTests extends AbstractTests
{
    /**
     * @param string $body
     * @return string
     */
    abstract public function render(string $body): string;
}
