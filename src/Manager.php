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
     * Manager constructor.
     * @param AdapterInterface[] ...$adapters
     */
    public function __construct(AdapterInterface ...$adapters)
    {
        foreach ($adapters as $adapter) {
            $this->addAdapter($adapter);
        }
    }

    /**
     * @param AdapterInterface $adapter
     * @return $this|Manager
     */
    public function addAdapter(AdapterInterface $adapter): Manager
    {
        $this->adapters[$adapter->getName()] = $adapter;

        return $this;
    }

    /**
     * @param string $adapter
     * @param Message $message
     * @return string
     * @throws AdapterNotFoundException
     */
    public function render(string $adapter, Message $message)
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
