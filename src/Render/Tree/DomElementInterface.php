<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Render\Tree;

use Illuminate\Contracts\Support\Renderable;
use Serafim\MessageComponent\Render\Render;

/**
 * Interface DomElementInterface
 * @package Serafim\MessageComponent\Render\Tree
 */
interface DomElementInterface extends Renderable
{
    /**
     * @var string
     */
    const TEXT_NODE_NAME = 'text';

    /**
     * DomElementInterface constructor.
     * @param $dom
     * @param Render $transformer
     */
    public function __construct($dom, Render $transformer);
}
