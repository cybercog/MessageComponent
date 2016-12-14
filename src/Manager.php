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
     * @param string $adapter
     * @return Manager
     */
    public function create(string $adapter): Manager
    {
        /** @var AdapterInterface $instance */
        $instance = new $adapter($this);

        $this->adapters[$adapter] = $instance;

        return $this->on($adapter);
    }

    /**
     * @param string $message
     * @return string
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function render(string $message)
    {
        if ($this->current === null) {
            throw new AdapterNotFoundException('Can not resolve adapter');
        }

        return $this->current->render($message);
    }

    /**
     * @param string $adapter
     * @return Manager
     */
    public function on(string $adapter): Manager
    {
        $this->current = $this->get($adapter);

        return $this;
    }

    /**
     * @param string $adapter
     * @return AdapterInterface|null
     */
    public function get(string $adapter)
    {
        if (!$this->has($adapter)) {
            $this->create($adapter);
        }

        return $this->adapters[$adapter];
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
