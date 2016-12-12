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
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    final public function render(string $text): string
    {
        return (new Manager())->addAdapter(GitterAdapter::class)->render($text);
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testEscapeCommands()
    {
        static::assertEquals('`/collapse`', $this->render('/collapse'));
        static::assertEquals('Not a /command', $this->render('Not a /command'));
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testEscapeUser()
    {
        static::assertEquals('`@user`', $this->render('@user'));
        static::assertEquals('\``@user`\`', $this->render('`@user`'));
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testEscapeIssueLink()
    {
        // Positive
        static::assertEquals('`#1`', $this->render('#1'));
        static::assertEquals('\``#1`\`', $this->render('`#1`'));
        static::assertEquals('\# 1', $this->render('# 1'));

        // Negative
        static::assertEquals('#test', $this->render('#test'));
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    public function testEscapeLatex()
    {
        static::assertEquals('`$$test$$`', $this->render('$$test$$'));
        static::assertEquals('\``$$test$$`\`', $this->render('`$$test$$`'));
    }
}
