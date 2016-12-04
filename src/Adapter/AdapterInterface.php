<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Adapter;

use Serafim\MessageComponent\Message;

/**
 * Interface AdapterInterface
 * @package Serafim\MessageComponent\Adapter
 */
interface AdapterInterface
{
    /**
     * @param Message $message
     * @return string
     */
    public function render(Message $message): string;

    /**
     * @return string
     */
    public function getName(): string;
}
