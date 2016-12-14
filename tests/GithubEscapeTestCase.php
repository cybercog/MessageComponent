<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Unit;

use Serafim\MessageComponent\Adapter\GitHubAdapter;
use Serafim\MessageComponent\Manager;

/**
 * Class GithubEscapeTestCase
 * @package Serafim\MessageComponent\Unit
 */
class GithubEscapeTestCase extends MarkdownEscapeTestCase
{
    /**
     * @param string $text
     * @return string
     * @throws \Serafim\MessageComponent\DI\AdapterNotFoundException
     */
    final public function render(string $text): string
    {
        return (new Manager())->on(GitHubAdapter::class)->render($text);
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
    public function testEscapeTaskList()
    {
        // Positive
        static::assertEquals('\- [ ] task', $this->render('- [ ] task'));
        static::assertEquals('\- [x] task', $this->render('- [x] task'));
        static::assertEquals('\- [] not a task but list item', $this->render('- [] not a task but list item'));

        // Negative
        static::assertEquals('not a - [ ] task', $this->render('not a - [ ] task'));
        static::assertEquals('-[ ] not a task', $this->render('-[ ] not a task'));
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
    public function testEscapeCommits()
    {
        // Positive
        static::assertEquals('`@23f54a3`', $this->render('@23f54a3'));

        static::assertEquals(
            '`@16c999e8c71134401a78d4d46435517b2271d6ac`',
            $this->render('@16c999e8c71134401a78d4d46435517b2271d6ac')
        );

        static::assertEquals(
            'Commit `@16c999e8c71134401a78d4d46435517b2271d6ac`',
            $this->render('Commit @16c999e8c71134401a78d4d46435517b2271d6ac')
        );
    }
}
