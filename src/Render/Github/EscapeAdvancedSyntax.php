<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Render\Github;

use Serafim\MessageComponent\Dom\Node\TextElement;

/**
 * Class EscapeAdvancedSyntax
 * @package Serafim\MessageComponent\Render\Github
 */
class EscapeAdvancedSyntax extends TextElement
{
    /**
     * @return string
     */
    public function render(): string
    {
        $body = $this->text;

        $body = $this->escapeUser($body);
        $body = $this->escapeIssues($body);

        return $body;
    }

    /**
     * [AT]UserName will be escaped as <code>[AT]UserName</code>
     *
     * @param string $body
     * @return string
     */
    protected function escapeUser(string $body): string
    {
        return preg_replace('/@(\w+)/iu', '`@$1`', $body);
    }

    /**
     * Escape issue link like a "#ID"
     *
     * @param string $body
     * @return string
     */
    protected function escapeIssues(string $body): string
    {
        return preg_replace('/#(\d+)/iu', '`#$1`', $body);
    }
}
