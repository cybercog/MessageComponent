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
use Serafim\MessageComponent\Unit\Support\MarkdownEscapeTestsTrait;

/**
 * Class GithubEscapeTestCase
 * @package Serafim\MessageComponent\Unit
 */
class GithubEscapeTestCase extends AbstractRenderTests
{
    use MarkdownEscapeTestsTrait;

    /**
     * @param string $text
     * @return string
     */
    public function render(string $text): string
    {
        return (new Manager())->addAdapter(GitHubAdapter::class)->render($text);
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
    public function testEscapeTaskList()
    {
        // Positive
        $this->assertEquals('\- [ ] task', $this->render('- [ ] task'));
        $this->assertEquals('\- [x] task', $this->render('- [x] task'));
        $this->assertEquals('\- [] not a task but list item', $this->render('- [] not a task but list item'));

        // Negative
        $this->assertEquals('not a - [ ] task', $this->render('not a - [ ] task'));
        $this->assertEquals('-[ ] not a task', $this->render('-[ ] not a task'));
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
    public function testEscapeCommits()
    {
        // Positive
        $this->assertEquals('`@23f54a3`', $this->render('@23f54a3'));
        $this->assertEquals('`@16c999e8c71134401a78d4d46435517b2271d6ac`', $this->render('@16c999e8c71134401a78d4d46435517b2271d6ac'));
        $this->assertEquals('Commit `@16c999e8c71134401a78d4d46435517b2271d6ac`', $this->render('Commit @16c999e8c71134401a78d4d46435517b2271d6ac'));
    }
}
