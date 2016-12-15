<?php declare(strict_types = 1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Dom;

use Serafim\MessageComponent\Dom\Parser\TokenInterface;
use Serafim\MessageComponent\Parser\PreProcessor;

/**
 * Class Parser
 * @package Serafim\MessageComponent\Dom
 */
class Parser
{
    /**
     * @var array|TokenInterface[]
     */
    private $tokens = [];

    /**
     * Parser constructor.
     */
    public function __construct()
    {
        $this->addToken(new PreProcessor());
    }

    /**
     * @param TokenInterface $token
     * @return $this|Parser
     */
    public function addToken(TokenInterface $token): Parser
    {
        $this->tokens[] = $token;

        return $this;
    }

    /**
     * @param string $text
     * @return string
     */
    public function parse(string $text): string
    {
        foreach ($this->tokens as $token) {
            $text = preg_replace_callback($token->getRule(), function (array $matches) use ($token) {
                $scope = array_shift($matches);
                return $token->transform($scope, ...array_values($matches));
            }, $text);
        }

        return $text;
    }
}