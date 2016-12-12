<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Render;

use Serafim\MessageComponent\Dom\Node\DomElement;

/**
 * Class User
 * @package Serafim\MessageComponent\Render
 */
class User extends DomElement
{
    /**
     * @return string
     */
    public function getVisibleName(): string
    {
        return $this->html;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->attr('login', $this->html);
    }

    /**
     * @return string
     */
    public function getIdentify(): string
    {
        return $this->attr('identify', $this->getLogin());
    }
}
