<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Unit;

use Serafim\MessageComponent\Query;
use Serafim\MessageComponent\Render\Code;
use Serafim\MessageComponent\Render\Quote;
use Serafim\MessageComponent\Render\User;

/**
 * Class GitterAdapterTestCase
 * @package Serafim\MessageComponent\Unit
 */
class QueryTestCase extends AbstractTests
{
    /**
     * @var string|null
     */
    private $cache;

    /**
     * @return Query
     * @throws \Serafim\MessageComponent\Dom\Exception\TagRedefineException
     */
    private function query(): Query
    {
        if ($this->cache === null) {
            $this->cache = file_get_contents(__DIR__ . '/tpl/example.html');
        }
        return new Query($this->cache);
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\Dom\Exception\TagRedefineException
     */
    public function testFindUser()
    {
        /** @var User $user */
        foreach($this->query()->find('user') as $user) {
            $this->assertInstanceOf(User::class, $user);

            $this->assertEquals('Vasya', $user->getLogin());
        }
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\Dom\Exception\TagRedefineException
     */
    public function testFindCode()
    {
        /** @var Code $code */
        foreach ($this->query()->find('code') as $code) {
            $this->assertInstanceOf(Code::class, $code);

            $this->assertTrue($code->isMultiline());
            $this->assertFalse($code->hasLanguage());
        }
    }

    /**
     * @return void
     * @throws \Serafim\MessageComponent\Dom\Exception\TagRedefineException
     */
    public function testFindById()
    {
        foreach($this->query()->findBy('id', 'quote') as $quote) {
            $this->assertInstanceOf(Quote::class, $quote);
        }

        $this->assertInstanceOf(Quote::class, $this->query()->findOneBy('id', 'quote'));

        $this->assertInstanceOf(Quote::class, $this->query()->getById('quote'));
    }
}
