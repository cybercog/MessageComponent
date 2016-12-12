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
 * Class GithubRenderTestCase
 * @package Serafim\MessageComponent\Unit
 */
class GithubRenderTestCase extends MarkdownRenderTestCase
{
    /**
     * @param string $text
     * @return string
     */
    final public function render(string $text): string
    {
        return (new Manager())->addAdapter(GitHubAdapter::class)->render($text);
    }

    /**
     * @return void
     */
    public function testUserRender()
    {
        $this->assertEquals('@UserLogin', $this->render('<user>UserLogin</user>'));
        $this->assertEquals('@UserLogin', $this->render('<user login="UserLogin">Vasya Pupkin</user>'));
    }
}
