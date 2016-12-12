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
     */
    public function render(string $body): string
    {
        return (new Manager())->addAdapter(PhpBBAdapter::class)->render($body);
    }

    /**
     * @return void
     */
    public function testItalicRender()
    {
        $this->assertEquals('[i]italic[/i]', $this->render('<i>italic</i>'));
    }

    /**
     * @return void
     */
    public function testBoldRender()
    {
        $this->assertEquals('[b]bold[/b]', $this->render('<b>bold</b>'));
    }

    /**
     * @return void
     */
    public function testStrokeRender()
    {
        $this->assertEquals('[s]stroke[/s]', $this->render('<s>stroke</s>'));
    }

    /**
     * @return void
     */
    public function testImageRender()
    {
        $this->assertEquals('[img]UrlAndTitle[/img]', $this->render('<img>UrlAndTitle</img>'));
    }

    /**
     * @return void
     */
    public function testImageWithUrlRender()
    {
        $this->assertEquals('[img]http://site.ru[/img]', $this->render('<img src="http://site.ru">Title</img>'));
    }

    /**
     * @return void
     */
    public function testImageWithTitleAndUrlRender()
    {
        $this->assertEquals('[img]http://site.ru[/img]', $this->render('<img src="http://site.ru" title="Title" />'));
    }

    /**
     * @return void
     */
    public function testLinkRender()
    {
        $this->assertEquals('[url=UrlAndTitle]UrlAndTitle[/url]', $this->render('<a>UrlAndTitle</a>'));
    }

    /**
     * @return void
     */
    public function testLinkWithUrlRender()
    {
        $this->assertEquals('[url=http://site.ru]Title[/url]', $this->render('<a href="http://site.ru">Title</a>'));
    }

    /**
     * @return void
     */
    public function testLinkWithTitleAndUrlRender()
    {
        $this->assertEquals('[url=http://site.ru]Title[/url]',
            $this->render('<a href="http://site.ru" title="Title" />'));
    }

    /**
     * @return void
     */
    public function testHorizontalLineRender()
    {
        $this->assertEquals("\n\n", $this->render('<hr />'));
    }

    /**
     * @return void
     */
    public function testHeadersRender()
    {
        $this->assertEquals('[size=170]H1[/size]', $this->render('<h1>H1</h1>'));
        $this->assertEquals('[size=142]H2[/size]', $this->render('<h2>H2</h2>'));
        $this->assertEquals('[size=114]H3[/size]', $this->render('<h3>H3</h3>'));
        $this->assertEquals('[size=86]H4[/size]',  $this->render('<h4>H4</h4>'));
        $this->assertEquals('[size=58]H5[/size]',  $this->render('<h5>H5</h5>'));
        $this->assertEquals('[size=30]H6[/size]',  $this->render('<h6>H6</h6>'));
    }

    /**
     * @return void
     */
    public function testListRender()
    {
        $this->assertEquals(
            '[list]' . "\n" .
            '  [*] list item' . "\n" .
            '[/list]' . "\n",
            $this->render('<li>list item</li>')
        );
    }

    /**
     * @return void
     */
    public function testListWithMixedRender()
    {
        $this->assertEquals(
            '[i]italic[/i][list]' . "\n" .
            '  [*] list item' . "\n" .
            '[/list]' . "\n",
            $this->render('<i>italic</i><li>list item</li>')
        );
    }

    /**
     * @return void
     */
    public function testSeveralItemsListRender()
    {
        $this->assertEquals(
            '[list]' . "\n" .
            '  [*] list item' . "\n" .
            '  [*] list item' . "\n" .
            '[/list]' . "\n",
            $this->render('<li>list item</li><li>list item</li>')
        );
    }

    /**
     * @return void
     */
    public function testNestedListRender()
    {
        $this->assertEquals(
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
     */
    public function testNestedListWithMixedBodyRender()
    {
        $this->assertEquals(
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
     */
    public function testInlineCodeRender()
    {
        $this->assertEquals('[code]code[/code]', $this->render('<code>code</code>'));
    }

    /**
     * @return void
     */
    public function testDateRender()
    {
        static::assertEquals('2042-02-02 00:00:00', $this->render('<date>2042-02-02</date>'));
        static::assertEquals('2042-02-02T00:00:00+00:00', $this->render('<date format="rfc3339">2042-02-02</date>'));
    }

    /**
     * @return void
     */
    public function testMultilineCodeRender()
    {
        $this->assertEquals(
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
     */
    public function testMultilineFromSingleLineAndLanguageCodeRender()
    {
        $this->assertEquals(
            '[code=php]code[/code]',
            $this->render('<code lang="php">code</code>')
        );
    }

    /**
     * @return void
     */
    public function testMultilineWithLanguageCodeRender()
    {
        $this->assertEquals(
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
     */
    public function testCodeRenderInsulation()
    {
        $this->assertEquals(
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
     */
    public function testMixedStylesRender()
    {
        $this->assertEquals(
            '[i]italic [b]bold[/b] [s]stroke[/s][/i][b]bold[/b]',
            $this->render('<i>italic <b>bold</b> <s>stroke</s></i><b>bold</b>')
        );
    }

    /**
     * @return void
     */
    public function testQuoteRender()
    {
        $this->assertEquals(
            '[quote]Blockquote [i]italic[/i][/quote]message after',
            $this->render('<quote>Blockquote <i>italic</i></quote>message after')
        );

        $this->assertEquals(
            '[quote]Blockquote[/quote]message after',
            $this->render('<quote>Blockquote</quote>message after')
        );
    }
}