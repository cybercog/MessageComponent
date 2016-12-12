<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Unit;

use Serafim\MessageComponent\Adapter\PhpBBAdapter;
use Serafim\MessageComponent\Manager;

/**
 * Class PhpBBRenderTestCase
 * @package Serafim\MessageComponent\Unit
 */
class PhpBBRenderTestCase extends AbstractRenderTests
{
    /**
     * @param string $body
     * @return string
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function render(string $body): string
    {
        return (new Manager())->addAdapter(PhpBBAdapter::class)->render($body);
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testItalicRender()
    {
        static::assertEquals('[i]italic[/i]', $this->render('<i>italic</i>'));
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testBoldRender()
    {
        static::assertEquals('[b]bold[/b]', $this->render('<b>bold</b>'));
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testStrokeRender()
    {
        static::assertEquals('[s]stroke[/s]', $this->render('<s>stroke</s>'));
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testImageRender()
    {
        static::assertEquals('[img]UrlAndTitle[/img]', $this->render('<img>UrlAndTitle</img>'));
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testImageWithUrlRender()
    {
        static::assertEquals('[img]http://site.ru[/img]', $this->render('<img src="http://site.ru">Title</img>'));
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testImageWithTitleAndUrlRender()
    {
        static::assertEquals('[img]http://site.ru[/img]', $this->render('<img src="http://site.ru" title="Title" />'));
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testLinkRender()
    {
        static::assertEquals('[url=UrlAndTitle]UrlAndTitle[/url]', $this->render('<a>UrlAndTitle</a>'));
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testLinkWithUrlRender()
    {
        static::assertEquals('[url=http://site.ru]Title[/url]', $this->render('<a href="http://site.ru">Title</a>'));
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testLinkWithTitleAndUrlRender()
    {
        static::assertEquals(
            '[url=http://site.ru]Title[/url]',
            $this->render('<a href="http://site.ru" title="Title" />')
        );
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testHorizontalLineRender()
    {
        static::assertEquals("\n\n", $this->render('<hr />'));
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testHeadersRender()
    {
        static::assertEquals('[size=170]H1[/size]', $this->render('<h1>H1</h1>'));
        static::assertEquals('[size=142]H2[/size]', $this->render('<h2>H2</h2>'));
        static::assertEquals('[size=114]H3[/size]', $this->render('<h3>H3</h3>'));
        static::assertEquals('[size=86]H4[/size]', $this->render('<h4>H4</h4>'));
        static::assertEquals('[size=58]H5[/size]', $this->render('<h5>H5</h5>'));
        static::assertEquals('[size=30]H6[/size]', $this->render('<h6>H6</h6>'));
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testListRender()
    {
        static::assertEquals(
            '[list]' . "\n" .
            '  [*] list item' . "\n" .
            '[/list]' . "\n",
            $this->render('<li>list item</li>')
        );
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testListWithMixedRender()
    {
        static::assertEquals(
            '[i]italic[/i][list]' . "\n" .
            '  [*] list item' . "\n" .
            '[/list]' . "\n",
            $this->render('<i>italic</i><li>list item</li>')
        );
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testSeveralItemsListRender()
    {
        static::assertEquals(
            '[list]' . "\n" .
            '  [*] list item' . "\n" .
            '  [*] list item' . "\n" .
            '[/list]' . "\n",
            $this->render('<li>list item</li><li>list item</li>')
        );
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testNestedListRender()
    {
        static::assertEquals(
            '[i]italic[/i][list]' . "\n" .
            '  [*] list item' . "\n" .
            '  [list]' . "\n" .
            '    [*] level2' . "\n" .
            '  [/list]' . "\n" .
            '[/list]' . "\n",
            $this->render('<i>italic</i><li>list item<li>level2</li></li>')
        );
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testNestedListWithMixedBodyRender()
    {
        static::assertEquals(
            '[i]italic[/i][list]' . "\n" .
            '  [*] [i]asdasd[/i] list item' . "\n" .
            '  [list]' . "\n" .
            '    [*] level2-1' . "\n" .
            '    [*] level2-2' . "\n" .
            '  [/list]' . "\n" .
            '[/list]' . "\n",
            $this->render('<i>italic</i><li><i>asdasd</i> list item<li>level2-1</li><li>level2-2</li></li>')
        );
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testInlineCodeRender()
    {
        static::assertEquals('[code]code[/code]', $this->render('<code>code</code>'));
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
        static::assertEquals(
            '[code]' . "\n" .
                'code' . "\n" .
            '[/code]',
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
    public function testMultilineFromSingleLineAndLanguageCodeRender()
    {
        static::assertEquals(
            '[code=php]code[/code]',
            $this->render('<code lang="php">code</code>')
        );
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testMultilineWithLanguageCodeRender()
    {
        static::assertEquals(
            '[code=php]' . "\n" .
                'code' . "\n" .
            '[/code]',
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
    public function testCodeRenderInsulation()
    {
        static::assertEquals(
            '[code]' . "\n" .
                '<b>This text will not be rendered as bold</b>' . "\n" .
                '<i>This text will not be rendered as italic or <s>stroke or <b>bold</b></s></i>' . "\n" .
            '[/code]',

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
        static::assertEquals(
            '[i]italic [b]bold[/b] [s]stroke[/s][/i][b]bold[/b]',
            $this->render('<i>italic <b>bold</b> <s>stroke</s></i><b>bold</b>')
        );
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testQuoteRender()
    {
        static::assertEquals(
            '[quote]Blockquote [i]italic[/i][/quote]message after',
            $this->render('<quote>Blockquote <i>italic</i></quote>message after')
        );

        static::assertEquals(
            '[quote]Blockquote[/quote]message after',
            $this->render('<quote>Blockquote</quote>message after')
        );
    }
}