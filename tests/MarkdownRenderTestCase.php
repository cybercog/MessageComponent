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

/**
 * Class MarkdownRenderTestCase
 * @package Serafim\MessageComponent\Unit
 */
class MarkdownRenderTestCase extends AbstractRenderTests
{
    /**
     * @param string $text
     * @return string
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function render(string $text): string
    {
        return (new Manager())->addAdapter(MarkdownAdapter::class)->render($text);
    }

    /**
     * @return void
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
     */
    public function testStrokeRender()
    {
        $this->assertEquals('~~stroke~~', $this->render('<s>stroke</s>'));
    }

    /**
     * @return void
     */
    public function testImageRender()
    {
        $this->assertEquals('![UrlAndTitle](UrlAndTitle)', $this->render('<img>UrlAndTitle</img>'));
    }

    /**
     * @return void
     */
    public function testImageWithUrlRender()
    {
        $this->assertEquals('![Title](http://site.ru)', $this->render('<img src="http://site.ru">Title</img>'));
    }

    /**
     * @return void
     */
    public function testImageWithTitleAndUrlRender()
    {
        $this->assertEquals('![Title](http://site.ru)', $this->render('<img src="http://site.ru" title="Title" />'));
    }

    /**
     * @return void
     */
    public function testLinkRender()
    {
        $this->assertEquals('[UrlAndTitle](UrlAndTitle)', $this->render('<a>UrlAndTitle</a>'));
    }

    /**
     * @return void
     */
    public function testLinkWithUrlRender()
    {
        $this->assertEquals('[Title](http://site.ru)', $this->render('<a href="http://site.ru">Title</a>'));
    }

    /**
     * @return void
     */
    public function testLinkWithTitleAndUrlRender()
    {
        $this->assertEquals('[Title](http://site.ru)', $this->render('<a href="http://site.ru" title="Title" />'));
    }

    /**
     * @return void
     */
    public function testHorizontalLineRender()
    {
        $this->assertEquals("\n" . '---' . "\n", $this->render('<hr />'));
    }

    /**
     * @return void
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
     */
    public function testListRender()
    {
        $this->assertEquals(
            "\n" .
            '- list item' . "\n",
            $this->render('<li>list item</li>')
        );
    }

    /**
     * @return void
     */
    public function testListWithMixedRender()
    {
        $this->assertEquals(
            '_italic_' . "\n" .
            '- list item' . "\n",
            $this->render('<i>italic</i><li>list item</li>')
        );
    }

    /**
     * @return void
     */
    public function testSeveralItemsListRender()
    {
        $this->assertEquals(
            "\n" .
            '- list item' . "\n" .
            '- list item' . "\n",
            $this->render('<li>list item</li><li>list item</li>')
        );
    }

    /**
     * @return void
     */
    public function testNestedListRender()
    {
        $this->assertEquals(
            '_italic_' . "\n" .
            '- list item' . "\n" .
            '  - level2' . "\n\n",
            $this->render('<i>italic</i><li>list item<li>level2</li></li>')
        );
    }

    /**
     * @return void
     */
    public function testNestedListWithMixedBodyRender()
    {
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
     */
    public function testInlineCodeRender()
    {
        $this->assertEquals('`code`', $this->render('<code>code</code>'));
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
     */
    public function testMultilineFromSingleLineAndLanguageCodeRender()
    {
        $this->assertEquals(
            '```php' . "\n" .
            'code' . "\n" .
            '```',
            $this->render('<code lang="php">code</code>')
        );
    }

    /**
     * @return void
     */
    public function testMultilineWithLanguageCodeRender()
    {
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
    }

    /**
     * @return void
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