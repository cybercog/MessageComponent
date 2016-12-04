<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Unit;

use Serafim\MessageComponent\Adapter\GitterMarkdown;

/**
 * Class GitterAdapterTestCase
 * @package Serafim\MessageComponent\Unit
 */
class GitterAdapterTestCase extends UnitTest
{
    /**
     * @return \Serafim\MessageComponent\Manager
     */
    protected function manager()
    {
        return $this->getManagerFor(new GitterMarkdown());
    }

    /**
     * @param string $text
     * @param array $parameters
     * @return string
     */
    protected function render(string $text, array $parameters = [])
    {
        return $this->getRenderFor(new GitterMarkdown(), $text, $parameters);
    }

    public function testEscapeItalic()
    {
        $this->assertEquals('\_italic\_', $this->render('_italic_'));
        $this->assertEquals('\*italic\*', $this->render('*italic*'));
    }

    public function testEscapeBold()
    {
        $this->assertEquals('\*\*bold\*\*', $this->render('**bold**'));
    }

    public function testEscapeImage()
    {
        $this->assertEquals('!\[image\]\(image\)', $this->render('![image](image)'));
        $this->assertEquals('not image](not image)', $this->render('not image](not image)'));
    }

    public function testEscapeLink()
    {
        $this->assertEquals('\[url\]\(url\)', $this->render('[url](url)'));
    }

    public function testEscapeHorizontalLine()
    {
        $this->assertEquals('\-\-\-', $this->render('---'));
        $this->assertEquals('--', $this->render('--'));
    }

    public function testEscapeHeaders()
    {
        $this->assertEquals('\# h1', $this->render('# h1')      );
        $this->assertEquals('\## h1', $this->render('## h1')     );
        $this->assertEquals('\### h1', $this->render('### h1')    );
        $this->assertEquals('\#### h1', $this->render('#### h1')   );
        $this->assertEquals('\##### h1', $this->render('##### h1')  );
        $this->assertEquals('\###### h1', $this->render('###### h1') );

        $this->assertEquals('Not # a ## header', $this->render('Not # a ## header'));
    }

    public function testEscapeLine()
    {
        $this->assertEquals('\- List element', $this->render('- List element'));
        $this->assertEquals('> \- List element in quote', $this->render('> - List element in quote'));
        $this->assertEquals('Not - a - list - element', $this->render('Not - a - list - element'));
    }

    public function testEscapeCode()
    {
        $this->assertEquals('\`some\`', $this->render('`some`'));
    }


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
