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
     * @param string $userName
     * @return User|$this
     */
    public function setVisibleName(string $userName): User
    {
        $this->dom->textContent = $userName;

        return $this;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->attr('login', $this->html);
    }

    /**
     * @param string $login
     * @return User|$this
     */
    public function setLogin(string $login): User
    {
        $this->setAttribute('login', $login);

        return $this;
    }

    /**
     * @return string
     */
    public function getIdentify(): string
    {
        return $this->attr('uid', $this->getLogin());
    }

    /**
     * @param string $id
     * @return User|$this
     */
    public function setIdentify(string $id): User
    {
        $this->setAttribute('uid', $id);

        return $this;
    }
}
