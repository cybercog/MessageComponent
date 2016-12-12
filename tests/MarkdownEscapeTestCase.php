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
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testEscapeItalic()
    {
        static::assertEquals('\_italic\_', $this->render('_italic_'));
        static::assertEquals('\*italic\*', $this->render('*italic*'));
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testEscapeBold()
    {
        static::assertEquals('\_\_bold\_\_', $this->render('__bold__'));
        static::assertEquals('\*\*bold\*\*', $this->render('**bold**'));
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testEscapeStroke()
    {
        static::assertEquals('\~\~stroke\~\~', $this->render('~~stroke~~'));
        static::assertEquals('\~escaped but not a stroke\~', $this->render('~escaped but not a stroke~'));
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testEscapeImage()
    {
        static::assertEquals('!\[image\]\(image\)', $this->render('![image](image)'));
        static::assertEquals('not image](not image)', $this->render('not image](not image)'));
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testEscapeLink()
    {
        static::assertEquals('\[url\]\(url\)', $this->render('[url](url)'));
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testEscapeHorizontalLine()
    {
        static::assertEquals('\-\-\-', $this->render('---'));
        static::assertEquals('--', $this->render('--'));
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testEscapeHeaders()
    {
        static::assertEquals('\# h1', $this->render('# h1'));
        static::assertEquals('\## h1', $this->render('## h1'));
        static::assertEquals('\### h1', $this->render('### h1'));
        static::assertEquals('\#### h1', $this->render('#### h1'));
        static::assertEquals('\##### h1', $this->render('##### h1'));
        static::assertEquals('\###### h1', $this->render('###### h1'));

        static::assertEquals('Not # a ## header', $this->render('Not # a ## header'));
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testEscapeListItem()
    {
        static::assertEquals('\- List element', $this->render('- List element'));
        static::assertEquals('\- [] List element', $this->render('- [] List element'));
        static::assertEquals('> \- List element in quote', $this->render('> - List element in quote'));
        static::assertEquals('Not - a - list - element', $this->render('Not - a - list - element'));
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testEscapeListAlterItem()
    {
        static::assertEquals('\* List element', $this->render('* List element'));
        static::assertEquals('\* [] List element', $this->render('* [] List element'));
        static::assertEquals('> \* List element in quote', $this->render('> * List element in quote'));
        static::assertEquals('Not \* a \* list \* element', $this->render('Not * a * list * element'));
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testEscapeCode()
    {
        static::assertEquals('\`some\`', $this->render('`some`'));
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testEscapeMultilineCode()
    {
        // With language
        static::assertEquals(
            '\\`\\`\\`lang' . "\n" . 'code' . "\n" . '\\`\\`\\`',
            $this->render('```lang' . "\n" . 'code' . "\n" . '```')
        );

        // Without language
        static::assertEquals(
            '\\`\\`\\`' . "\n" . 'code' . "\n" . '\\`\\`\\`',
            $this->render('```' . "\n" . 'code' . "\n" . '```')
        );
    }
}
