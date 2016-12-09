<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Adapter;

use Serafim\MessageComponent\Manager;
use Serafim\MessageComponent\Dom\Document;
use Serafim\MessageComponent\Parser\Parser;

/**
 * Class AbstractAdapter
 * @package Serafim\MessageComponent\Adapter
 */
abstract class AbstractAdapter implements AdapterInterface
{
    /**
     * @var string
     */
    const TEXT_NODE = ':text';

    /**
     * @var Document
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
     * @throws \Serafim\MessageComponent\Dom\TagRedefineException
     */
    public function __construct(Manager $manager, array $options = [])
    {
        $this->parser = new Parser($manager);
        $this->renderer = new Document();

        $this->registerNodeParsers();
        $this->registerNodeRenderers();
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\Dom\TagRedefineException
     */
    private function registerNodeRenderers()
    {
        foreach ($this->nodeRenderers as $class => $tags) {
            if ($tags === self::TEXT_NODE) {
                $this->renderer->text($class);
            } else {
                $this->renderer->dom($class)->as(...(array)$tags);
            }
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
