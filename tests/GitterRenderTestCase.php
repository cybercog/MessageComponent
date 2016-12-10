<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Unit;

use Carbon\Carbon;
use Serafim\MessageComponent\Adapter\GitterMarkdown;
use Serafim\MessageComponent\Manager;

/**
 * Class GitterAdapterTestCase
 * @package Serafim\MessageComponent\Unit
 */
class GitterAdapterTestCase extends UnitTest
{
    /**
     * @param string $text
     * @return string
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    protected function render(string $text): string
    {
        return (new Manager())
            ->addAdapter(GitterMarkdown::class)
            ->render('gitter', $text);
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testItalicRender()
    {
        $this->assertEquals('_italic_', $this->render('<i>italic</i>'));
    }

    /**
     * @return void
     */
    public function testBoldRender()
    {
        $this->assertEquals('**bold**', $this->render('<b>bold</b>'));
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testStrokeRender()
    {
        $this->assertEquals('~~stroke~~', $this->render('<s>stroke</s>'));
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testImageRender()
    {
        $this->assertEquals('![UrlAndTitle](UrlAndTitle)', $this->render('<img>UrlAndTitle</img>'));
        $this->assertEquals('![Title](http://site.ru)', $this->render('<img src="http://site.ru">Title</img>'));
        $this->assertEquals('![Title](http://site.ru)', $this->render('<img src="http://site.ru" title="Title" />'));
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testLinkRender()
    {
        $this->assertEquals('[UrlAndTitle](UrlAndTitle)', $this->render('<a>UrlAndTitle</a>'));
        $this->assertEquals('[Title](http://site.ru)', $this->render('<a href="http://site.ru">Title</a>'));
        $this->assertEquals('[Title](http://site.ru)', $this->render('<a href="http://site.ru" title="Title" />'));
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testHorizontalLineRender()
    {
        $this->assertEquals("\n" . '---' . "\n", $this->render('<hr />'));
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testHeadersRender()
    {
        $this->assertEquals('# H1' . "\n", $this->render('<h1>H1</h1>'));
        $this->assertEquals('## H2' . "\n", $this->render('<h2>H2</h2>'));
        $this->assertEquals('### H3' . "\n", $this->render('<h3>H3</h3>'));
        $this->assertEquals('#### H4' . "\n", $this->render('<h4>H4</h4>'));
        $this->assertEquals('##### H5' . "\n", $this->render('<h5>H5</h5>'));
        $this->assertEquals('###### H6' . "\n", $this->render('<h6>H6</h6>'));
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testListRender()
    {
        $this->assertEquals(
            "\n" .
            '- list item' . "\n",
            $this->render('<li>list item</li>')
        );

        $this->assertEquals(
            "\n" .
            '- list item' . "\n" .
            '- list item' . "\n",
            $this->render('<li>list item</li><li>list item</li>')
        );

        $this->assertEquals(
            '_italic_' . "\n" .
            '- list item' . "\n",
            $this->render('<i>italic</i><li>list item</li>')
        );
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testNestedListRender()
    {
        $this->assertEquals(
            '_italic_' . "\n" .
            '- list item' . "\n" .
            '  - level2' . "\n\n",
            $this->render('<i>italic</i><li>list item<li>level2</li></li>')
        );

        $this->assertEquals(
            '_italic_' . "\n" .
            '- _asdasd_ list item' . "\n" .
            '  - level2-1' . "\n" .
            '  - level2-2' . "\n" .
            "\n",
            $this->render('<i>italic</i><li><i>asdasd</i> list item<li>level2-1</li><li>level2-2</li></li>')
        );
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testInlineCodeRender()
    {
        $this->assertEquals('`code`', $this->render('<code>code</code>'));
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testDateRender()
    {
        static::assertEquals('2042-02-02 00:00:00', $this->render('<date>2042-02-02</date>'));
        static::assertEquals('2042-02-02T00:00:00+00:00', $this->render('<date format="rfc3339">2042-02-02</date>'));
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testMultilineCodeRender()
    {
        $this->assertEquals(
            '```php' . "\n" .
                'code' . "\n" .
            '```',
            $this->render('<code lang="php">code</code>')
        );

        $this->assertEquals(
            '```php' . "\n" .
                'code' . "\n" .
            '```',
            $this->render(
                '<code lang="php">' . "\n" .
                    'code' . "\n" .
                '</code>'
            )
        );

        $this->assertEquals(
            '```' . "\n" .
                'code' . "\n" .
            '```',
            $this->render(
                '<code>' . "\n" .
                    'code' . "\n" .
                '</code>'
            )
        );
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testCodeRenderInsulation()
    {
        $this->assertEquals(
            '```' . "\n" .
                '<b>This text will not be rendered as bold</b>' . "\n" .
                '<i>This text will not be rendered as italic or <s>stroke or <b>bold</b></s></i>' . "\n" .
            '```',

            $this->render(
                '<code>' . "\n" .
                    '<b>This text will not be rendered as bold</b>' . "\n" .
                    '<i>This text will not be rendered as italic or <s>stroke or <b>bold</b></s></i>' . "\n" .
                '</code>'
            )
        );
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testMixedStylesRender()
    {
        $this->assertEquals(
            '_italic **bold** ~~stroke~~_**bold**',
            $this->render('<i>italic <b>bold</b> <s>stroke</s></i><b>bold</b>')
        );

        $this->assertEquals(
            '_italic\_ **bold** ~~\*\*stroke~~_**\`bold**',
            $this->render('<i>italic_ <b>bold</b> <s>**stroke</s></i><b>`bold</b>')
        );
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testQuoteRender()
    {
        $this->assertEquals(
            '> Blockquote _italic_' . "\n\n" . 'message after',
            $this->render('<quote>Blockquote <i>italic</i></quote>message after')
        );

        $this->assertEquals(
            '> Blockquote' . "\n\n" . 'message after',
            $this->render('<quote>Blockquote</quote>message after')
        );
    }
}
