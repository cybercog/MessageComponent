<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent;

use Serafim\MessageComponent\Adapter\AdapterInterface;

/**
 * Class Message
 * @package Serafim\MessageComponent
 */
class Manager
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
     * @param string $adapterName
     * @param Message $message
     * @return string
     * @throws \InvalidArgumentException
     */
    public function render(string $adapterName, Message $message)
    {
        $adapter = $this->getAdapter($adapterName);

        if ($adapter === null) {
            throw new \InvalidArgumentException('Unavailable adapter ' . $adapterName);
        }

        return $adapter->render($message);
    }

    /**
     * @param string $adapterName
     * @return AdapterInterface|null
     */
    public function getAdapter(string $adapterName)
    {
        return $this->adapters[$adapterName] ?? null;
    }
}
