<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Render\Markdown;

use Serafim\MessageComponent\Render as Tag;

/**
 * Class User
 * @package Serafim\MessageComponent\Render\Markdown
 */
class User extends Tag\User
{
    /**
     * @return string
     */
    public function render(): string
    {
        return '_@' . $this->getLogin() . '_';
    }
}
