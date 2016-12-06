<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Adapter;

use Serafim\MessageComponent\Manager;
use Serafim\MessageComponent\Parser\Parser;
use Serafim\MessageComponent\Render\Render;

/**
 * Class AbstractAdapter
 * @package Serafim\MessageComponent\Adapter
 */
abstract class AbstractAdapter implements AdapterInterface
{
    /**
     * @var Render
     */
    protected $renderer;

    /**
     * @var Parser
     */
    protected $parser;

    /**
     * @var array
     */
    protected $nodeRenderers = [];

    /**
     * @var array
     */
    protected $nodeParsers = [];

    /**
     * AbstractAdapter constructor.
     * @param Manager $manager
     * @param array $options
     */
    public function __construct(Manager $manager, array $options = [])
    {
        $this->parser = new Parser($manager);
        $this->renderer = new Render($manager);

        $this->registerNodeParsers();
        $this->registerNodeRenderers();
    }

    /**
     * @return void
     */
    private function registerNodeRenderers()
    {
        foreach ($this->nodeRenderers as $class => $tags) {
            $this->renderer->nodeRender((array)$tags, new $class);
        }
    }

    /**
     * @return void
     */
    private function registerNodeParsers()
    {
        foreach ($this->nodeParsers as $class => $tags) {
            $this->parser->nodeParser(new $class);
        }
    }

    /**
     * @param string $message
     * @return string
     */
    public function render(string $message): string
    {
        return $this->renderer->render($message);
    }

    /**
     * @param string $message
     * @return string
     */
    public function parse(string $message): string
    {
        return $this->parser->parse($message);
    }
}
