<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Dom\Node;

use Serafim\MessageComponent\Dom\Document;

/**
 * Interface NodeInterface
 * @package Serafim\MessageComponent\Dom\Node
 */
interface NodeInterface
{
    /**
     * @return string
     */
    public function render(): string;
}
