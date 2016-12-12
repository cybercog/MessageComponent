<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Unit;

use Serafim\MessageComponent\Adapter\MarkdownAdapter;
use Serafim\MessageComponent\Manager;
use Serafim\MessageComponent\Unit\Support\MarkdownEscapeTestsTrait;

/**
 * Class MarkdownEscapeTestCase
 * @package Serafim\MessageComponent\Unit
 */
class MarkdownEscapeTestCase extends AbstractRenderTests
{
    use MarkdownEscapeTestsTrait;

    /**
     * @param string $text
     * @return string
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function render(string $text): string
    {
        return (new Manager())->addAdapter(MarkdownAdapter::class)->render($text);
    }
}
