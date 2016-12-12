<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Unit;

use Serafim\MessageComponent\Adapter\GitterAdapter;
use Serafim\MessageComponent\Manager;

/**
 * Class GitterEscapeTestCase
 * @package Serafim\MessageComponent\Unit
 */
class GitterEscapeTestCase extends MarkdownEscapeTestCase
{
    /**
     * @param string $text
     * @return string
     */
    final public function render(string $text): string
    {
        return (new Manager())->addAdapter(GitterAdapter::class)->render($text);
    }

    /**
     * @return void
     */
    public function testEscapeCommands()
    {
        $this->assertEquals('`/collapse`', $this->render('/collapse'));
        $this->assertEquals('Not a /command', $this->render('Not a /command'));
    }

    /**
     * @return void
     */
    public function testEscapeUser()
    {
        $this->assertEquals('`@user`', $this->render('@user'));
        $this->assertEquals('\``@user`\`', $this->render('`@user`'));
    }

    /**
     * @return void
     */
    public function testEscapeIssueLink()
    {
        // Positive
        $this->assertEquals('`#1`', $this->render('#1'));
        $this->assertEquals('\``#1`\`', $this->render('`#1`'));
        $this->assertEquals('\# 1', $this->render('# 1'));

        // Negative
        $this->assertEquals('#test', $this->render('#test'));
    }

    /**
     * @return void
     */
    public function testEscapeLatex()
    {
        $this->assertEquals('`$$test$$`', $this->render('$$test$$'));
        $this->assertEquals('\``$$test$$`\`', $this->render('`$$test$$`'));
    }
}
