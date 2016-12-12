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
use Serafim\MessageComponent\Render as Tag;

/**
 * Class AbstractAdapter
 * @package Serafim\MessageComponent\Adapter
 */
abstract class AbstractAdapter implements AdapterInterface
{
    /**
     * @var Document
     */
    private $renderer;

    /**
     * @var array
     */
    protected $nodeRenderers = [];

    /**
     * @var array
     */
    protected $textRenderers = [];

    /**
     * AbstractAdapter constructor.
     * @param Manager $manager
     * @throws \Serafim\MessageComponent\Dom\Exception\TagRedefineException
     * @throws \LogicException
     */
    public function __construct(Manager $manager)
    {
        $this->renderer = new Document();

        $this->registerTextRenderers();
        $this->registerNodeRenderers();
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
    private function registerTextRenderers()
    {
        foreach ($this->textRenderers as $class) {
            $this->renderer->text($class);
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
}
