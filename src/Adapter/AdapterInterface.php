<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Adapter;

use Serafim\MessageComponent\Manager;

/**
 * Interface AdapterInterface
 * @package Serafim\MessageComponent\Adapter
 */
interface AdapterInterface
{
    /**
     * AdapterInterface constructor.
     * @param Manager $manager
     */
    public function __construct(Manager $manager);

    /**
     * @param string $message
     * @return string
     */
    public function render(string $message): string;

    /**
     * @return string
     */
    public function getName(): string;
}
