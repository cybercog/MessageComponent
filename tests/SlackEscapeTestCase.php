<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Unit;

use Carbon\Carbon;
use Serafim\MessageComponent\Adapter\SlackAdapter;
use Serafim\MessageComponent\Manager;

/**
 * Class SlackEscapeTestCase
 * @package Serafim\MessageComponent\Unit
 */
class SlackEscapeTestCase extends MarkdownEscapeTestCase
{
    /**
     * @param string $text
     * @return string
     */
    final public function render(string $text): string
    {
        return (new Manager())->on(SlackAdapter::class)->render($text);
    }

    /**
     * @return void
     */
    public function testEscapeHeaders()
    {
        static::assertEquals('# h1', $this->render('# h1'), 'Headers will not be escaped. Slack does not support it');
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testEscapeHorizontalLine()
    {
        $msg = 'Horizontal delimiter will not be escaped. Slack does not support it';

        static::assertEquals('---', $this->render('---'), $msg);
        static::assertEquals('--', $this->render('--'), $msg);
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testEscapeImage()
    {
        $msg = 'Markdown image will not be escaped. Slack does not support it';

        static::assertEquals('![image](image)', $this->render('![image](image)'), $msg);
        static::assertEquals('not image](not image)', $this->render('not image](not image)'), $msg);
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testEscapeLink()
    {
        $msg = 'Markdown link will not be escaped. Slack does not support it';

        static::assertEquals('[url](url)', $this->render('[url](url)'), $msg);
    }
}
