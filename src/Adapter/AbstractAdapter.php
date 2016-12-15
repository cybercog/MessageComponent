<?php declare(strict_types = 1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Adapter;

use Serafim\MessageComponent\Dom\Document;
use Serafim\MessageComponent\Dom\Parser;
use Serafim\MessageComponent\Manager;
use Serafim\MessageComponent\Render as Tag;

/**
 * Class AbstractAdapter
 * @package Serafim\MessageComponent\Adapter
 */
abstract class AbstractAdapter implements AdapterInterface
{
    /**
     * @var array
     */
    protected $nodeRenderers = [];
    /**
     * @var array
     */
    protected $textRenderers = [];
    /**
     * @var array
     */
    protected $tokenParsers = [];
    /**
     * @var Document
     */
    private $renderer;
    /**
     * @var Parser
     */
    private $parser;

    /**
     * AbstractAdapter constructor.
     * @param Manager $manager
     * @throws \Serafim\MessageComponent\Dom\Exception\TagRedefineException
     * @throws \LogicException
     */
    public function __construct(Manager $manager)
    {
        $this->renderer = new Document();
        $this->parser = new Parser();

        $this->registerTextRenderers();
        $this->registerNodeRenderers();
        $this->registerTokenParsers();
    }

    /**
     * @return void
     */
    private function registerTextRenderers()
    {
        foreach ($this->textRenderers as $class) {
            $this->renderer->text($class);
        }
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\Dom\Exception\TagRedefineException
     */
    private function registerNodeRenderers()
    {
        foreach ($this->nodeRenderers as $class => $tags) {
            $this->renderer->dom($class)->instead(...(array)$tags);
        }
    }

    /**
     * @return void
     */
    private function registerTokenParsers()
    {
        foreach ($this->tokenParsers as $key => $token) {
            if (is_int($key)) {
                $this->parser->addToken(new $token);
            } else {
                $this->parser->addToken(new $key(...$token));
            }

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
