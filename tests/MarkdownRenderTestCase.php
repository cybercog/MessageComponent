<?php declare(strict_types = 1);
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
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testItalicRender()
    {
        static::assertEquals('_italic_', $this->render('<i>italic</i>'), 'Italic generic markdown render');
    }

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
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testBoldRender()
    {
        static::assertEquals('**bold**', $this->render('<b>bold</b>'), 'Bold generic markdown render');
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testStrokeRender()
    {
        static::assertEquals('~~stroke~~', $this->render('<s>stroke</s>'), 'Strike generic markdown render');
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testImageRender()
    {
        static::assertEquals(
            '![UrlAndTitle](UrlAndTitle)',
            $this->render('<img>UrlAndTitle</img>'),
            'Image generic markdown render'
        );
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testImageWithUrlRender()
    {
        static::assertEquals(
            '![Title](http://site.ru)',
            $this->render('<img src="http://site.ru">Title</img>'),
            'Image with url generic markdown render'
        );
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testImageWithTitleAndUrlRender()
    {
        static::assertEquals(
            '![Title](http://site.ru)',
            $this->render('<img src="http://site.ru" title="Title" />'),
            'Image with url and title generic markdown render'
        );
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testLinkRender()
    {
        static::assertEquals(
            '[UrlAndTitle](UrlAndTitle)',
            $this->render('<a>UrlAndTitle</a>'),
            'Link markdown generic render'
        );
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testLinkWithUrlRender()
    {
        static::assertEquals(
            '[Title](http://site.ru)',
            $this->render('<a href="http://site.ru">Title</a>'),
            'Link with url generic markdown render'
        );
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testLinkWithTitleAndUrlRender()
    {
        static::assertEquals(
            '[Title](http://site.ru)',
            $this->render('<a href="http://site.ru" title="Title" />'),
            'Link with url and title generic render'
        );
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testHorizontalLineRender()
    {
        static::assertEquals(
            "\n\n" . '---' . "\n",
            $this->render('<hr />'),
            'Horizontal delimiter generic markdown render'
        );

        static::assertEquals(
            "\n\n" . '---' . "\n",
            $this->render("\n" . '<hr />'),
            'Horizontal delimiter generic markdown render with skipping eol'
        );
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testHeadersRender()
    {
        static::assertEquals(
            '# H1' . "\n",
            $this->render('<h1>H1</h1>'),
            'Header level 1 generic markdown render'
        );

        static::assertEquals(
            '## H2' . "\n",
            $this->render('<h2>H2</h2>'),
            'Header level 2 generic markdown render'
        );

        static::assertEquals(
            '### H3' . "\n",
            $this->render('<h3>H3</h3>'),
            'Header level 3 generic markdown render'
        );

        static::assertEquals(
            '#### H4' . "\n",
            $this->render('<h4>H4</h4>'),
            'Header level 4 generic markdown render'
        );

        static::assertEquals(
            '##### H5' . "\n",
            $this->render('<h5>H5</h5>'),
            'Header level 5 generic markdown render'
        );

        static::assertEquals(
            '###### H6' . "\n",
            $this->render('<h6>H6</h6>'),
            'Header level 6 generic markdown render'
        );
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testListRender()
    {
        static::assertEquals(
            "\n" .
            '- list item' . "\n",
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
            '_italic_' . "\n" .
            '- list item' . "\n",
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
            "\n" .
            '- list item' . "\n" .
            '- list item' . "\n",
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
            '_italic_' . "\n" .
            '- list item' . "\n" .
            '  - level2' . "\n\n",
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
        static::assertEquals('`code`', $this->render('<code>code</code>'));
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
    public function testMultilineFromSingleLineAndLanguageCodeRender()
    {
        static::assertEquals(
            '```php' . "\n" .
                'code' . "\n" .
            '```',
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
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testCodeRenderInsulation()
    {
        static::assertEquals(
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
        static::assertEquals(
            '_italic **bold** ~~stroke~~_**bold**',
            $this->render('<i>italic <b>bold</b> <s>stroke</s></i><b>bold</b>')
        );

        static::assertEquals(
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
        static::assertEquals(
            '> Blockquote' . "\n\n" . 'message after',
            $this->render('<quote>Blockquote</quote>message after')
        );

        static::assertEquals(
            '> Blockquote _italic_' . "\n\n" . 'message after',
            $this->render('<quote>Blockquote <i>italic</i></quote>message after')
        );
    }
}
