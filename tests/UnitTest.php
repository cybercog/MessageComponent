<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Unit;

use \PHPUnit_Framework_TestCase as UnitTestCase;
use Serafim\MessageComponent\Adapter\AdapterInterface;
use Serafim\MessageComponent\Manager;
use Serafim\MessageComponent\Message;

/**
 * Class UnitTest
 * @package Serafim\MessageComponent\Unit
 */
abstract class UnitTest extends UnitTestCase
{
    /**
     * @return AdapterInterface
     */
    abstract protected function getAdapter(): AdapterInterface;

    /**
     * @return \Serafim\MessageComponent\Manager
     */
    protected function manager()
    {
        return $this->getManagerFor($this->getAdapter());
    }

    /**
     * @param string $text
     * @param array $parameters
     * @return string
     */
    protected function render(string $text, array $parameters = [])
    {
        return $this->getRenderFor($this->getAdapter(), $text, $parameters);
    }

    /**
     * @param AdapterInterface $adapter
     * @return Manager
     */
    protected function getManagerFor(AdapterInterface $adapter)
    {
        return new Manager($adapter);
    }

    /**
     * @param AdapterInterface $adapter
     * @param string $message
     * @param array $parameters
     * @return string
     */
    protected function getRenderFor(AdapterInterface $adapter, string $message, array $parameters = [])
    {
        return $this->getManagerFor($adapter)->render($adapter->getName(), new Message($message, $parameters));
    }
}
