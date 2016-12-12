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
     * @var AdapterInterface|null
     */
    private $current;

    /**
     * @param string[] ...$adapters
     * @return Manager
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function addAdapter(string ...$adapters): Manager
    {
        $lastAdapterName = null;

        foreach ($adapters as $adapter) {
            /** @var AdapterInterface $instance */
            $instance = new $adapter($this);

            $lastAdapterName = $name = $instance->getName();

            $this->adapters[$name] = $instance;
        }

        return $this->on($lastAdapterName);
    }

    /**
     * @param string $message
     * @return string
     * @throws AdapterNotFoundException
     */
    public function render(string $message)
    {
        if ($this->current === null) {
            throw new AdapterNotFoundException('Can not resolve adapter');
        }

        return $this->current->render($message);
    }

    /**
     * @param string $adapterName
     * @return Manager
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function on(string $adapterName): Manager
    {
        $this->current = $this->get($adapterName);

        return $this;
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
