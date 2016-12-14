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
 * Class SlackRenderTestCase
 * @package Serafim\MessageComponent\Unit
 */
class SlackRenderTestCase extends MarkdownRenderTestCase
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
    public function testUserRender()
    {
        static::assertEquals('<@uid|name> hello!', $this->render('<user uid="uid">name</user> hello!'));
    }

    /**
     * @return void
     */
    public function testLinkRender()
    {
        static::assertEquals('<UrlAndTitle>', $this->render('<a>UrlAndTitle</a>'));
    }

    /**
     * @return void
     */
    public function testLinkWithUrlRender()
    {
        static::assertEquals('<http://site.ru|Title>', $this->render('<a href="http://site.ru">Title</a>'));
    }

    /**
     * @return void
     */
    public function testLinkWithTitleAndUrlRender()
    {
        static::assertEquals('<http://site.ru|Title>', $this->render('<a href="http://site.ru" title="Title" />'));
    }

    /**
     * @return void
     */
    public function testDateRender()
    {
        $date = Carbon::createFromDate('2016', '12', '13');

        static::assertEquals(
            sprintf('<!date^%s^%s|%s>', $date->timestamp, '{date_num} {time_secs}', $date->toDateTimeString()),
            $this->render(sprintf('<date>%s</date>', $date->format('Y-m-d H:i:s')))
        );
    }

    /**
     * @return void
     */
    public function testMultilineFromSingleLineAndLanguageCodeRender()
    {
        static::assertEquals(
            '`code`',
            $this->render('<code lang="php">code</code>')
        );
    }

    /**
     * @return void
     */
    public function testMultilineWithLanguageCodeRender()
    {
        static::assertEquals(
            '```' . "\n" .
                'code' . "\n" .
            '```',
            $this->render(
                '<code lang="php">' . "\n" .
                    'code' . "\n" .
                '</code>'
            )
        );
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testImageRender()
    {
        static::assertEquals(
            'http://site.ru/img.jpg',
            $this->render('<img>http://site.ru/img.jpg</img>'),
            'Slack image render'
        );
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testImageWithUrlRender()
    {
        static::assertEquals(
            'http://site.ru/img.jpg',
            $this->render('<img src="http://site.ru/img.jpg">Title</img>'),
            'Slack image with url render'
        );
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testImageWithTitleAndUrlRender()
    {
        static::assertEquals(
            'http://site.ru/img.jpg',
            $this->render('<img src="http://site.ru/img.jpg" title="Title" />'),
            'Slack image with url and link render'
        );
    }
}
