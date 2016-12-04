<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Dom;

use Serafim\MessageComponent\Render\Transformer;

/**
 * Interface NodeInterface
 * @package Serafim\MessageComponent\Dom
 */
interface NodeInterface extends \IteratorAggregate
{
    /**
     * NodeInterface constructor.
     * @param $dom
     * @param Transformer $transformer
     */
    public function __construct($dom, Transformer $transformer);

    /**
     * @param array $parameters
     * @return string
     */
    public function render(array $parameters = []): string;
}
