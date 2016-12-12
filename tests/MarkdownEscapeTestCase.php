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
 * Class MarkdownEscapeTestCase
 * @package Serafim\MessageComponent\Unit
 */
class MarkdownEscapeTestCase extends AbstractRenderTests
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
    public function testEscapeItalic()
    {
        $this->assertEquals('\_italic\_', $this->render('_italic_'));
        $this->assertEquals('\*italic\*', $this->render('*italic*'));
    }

    /**
     * @return void
     */
    public function testEscapeBold()
    {
        $this->assertEquals('\_\_bold\_\_', $this->render('__bold__'));
        $this->assertEquals('\*\*bold\*\*', $this->render('**bold**'));
    }

    /**
     * @return void
     */
    public function testEscapeStroke()
    {
        $this->assertEquals('\~\~stroke\~\~', $this->render('~~stroke~~'));
        $this->assertEquals('\~escaped but not a stroke\~', $this->render('~escaped but not a stroke~'));
    }

    /**
     * @return void
     */
    public function testEscapeImage()
    {
        $this->assertEquals('!\[image\]\(image\)', $this->render('![image](image)'));
        $this->assertEquals('not image](not image)', $this->render('not image](not image)'));
    }

    /**
     * @return void
     */
    public function testEscapeLink()
    {
        $this->assertEquals('\[url\]\(url\)', $this->render('[url](url)'));
    }

    /**
     * @return void
     */
    public function testEscapeHorizontalLine()
    {
        $this->assertEquals('\-\-\-', $this->render('---'));
        $this->assertEquals('--', $this->render('--'));
    }

    /**
     * @return void
     */
    public function testEscapeHeaders()
    {
        $this->assertEquals('\# h1', $this->render('# h1'));
        $this->assertEquals('\## h1', $this->render('## h1'));
        $this->assertEquals('\### h1', $this->render('### h1'));
        $this->assertEquals('\#### h1', $this->render('#### h1'));
        $this->assertEquals('\##### h1', $this->render('##### h1'));
        $this->assertEquals('\###### h1', $this->render('###### h1'));

        $this->assertEquals('Not # a ## header', $this->render('Not # a ## header'));
    }

    /**
     * @return void
     */
    public function testEscapeListItem()
    {
        $this->assertEquals('\- List element', $this->render('- List element'));
        $this->assertEquals('\- [] List element', $this->render('- [] List element'));
        $this->assertEquals('> \- List element in quote', $this->render('> - List element in quote'));
        $this->assertEquals('Not - a - list - element', $this->render('Not - a - list - element'));
    }

    /**
     * @return void
     */
    public function testEscapeListAlterItem()
    {
        $this->assertEquals('\* List element', $this->render('* List element'));
        $this->assertEquals('\* [] List element', $this->render('* [] List element'));
        $this->assertEquals('> \* List element in quote', $this->render('> * List element in quote'));
        $this->assertEquals('Not \* a \* list \* element', $this->render('Not * a * list * element'));
    }

    /**
     * @return void
     */
    public function testEscapeCode()
    {
        $this->assertEquals('\`some\`', $this->render('`some`'));
    }

    /**
     * @return void
     */
    public function testEscapeMultilineCode()
    {
        // With language
        $this->assertEquals(
            '\\`\\`\\`lang' . "\n" . 'code' . "\n" . '\\`\\`\\`',
            $this->render('```lang' . "\n" . 'code' . "\n" . '```')
        );

        // Without language
        $this->assertEquals(
            '\\`\\`\\`' . "\n" . 'code' . "\n" . '\\`\\`\\`',
            $this->render('```' . "\n" . 'code' . "\n" . '```')
        );
    }
}
