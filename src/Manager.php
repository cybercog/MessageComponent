<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent;

use Serafim\MessageComponent\DI\AdapterNotFoundException;
use Serafim\MessageComponent\DI\ContainerInterface;
use Serafim\MessageComponent\Adapter\AdapterInterface;
use Serafim\MessageComponent\Render\ParametersInjector;

/**
 * Class Message
 * @package Serafim\MessageComponent
 */
class Manager implements ContainerInterface
{
    /**
     * @var array|AdapterInterface[]
     */
    private $adapters = [];

    /**
     * @param string $adapter
     * @param array $options
     * @return Manager|$this
     */
    public function addAdapter(string $adapter, array $options = []): Manager
    {
        /** @var AdapterInterface $instance */
        $instance = new $adapter($this, $options);

        $this->adapters[$instance->getName()] = $instance;

        return $this;
    }

    /**
     * @param string $adapter
     * @param string $message
     * @return string
     * @throws AdapterNotFoundException
     */
    public function render(string $adapter, string $message)
    {
        return $this->get($adapter)->render($message);
    }

    /**
     * @param string $adapter
     * @return AdapterInterface|null
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function get(string $adapter)
    {
        if ($this->has($adapter)) {
            return $this->adapters[$adapter];
        }

        throw new AdapterNotFoundException('Unavailable adapter ' . $adapter);
    }

    /**
     * @param string $adapter
     * @return bool
     */
    public function has(string $adapter): bool
    {
        return array_key_exists($adapter, $this->adapters);
    }
}
