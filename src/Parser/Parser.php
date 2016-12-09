<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Parser;

use Serafim\MessageComponent\Manager;

/**
 * Class Parser
 * @package Serafim\MessageComponent\Parser
 */
class Parser
{
    /**
     * @var Manager
     */
    private $manager;

    /**
     * Parser constructor.
     * @param Manager $manager
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param NodeParserInterface $parser
     * @throws \LogicException
     */
    public function nodeParser(NodeParserInterface $parser)
    {
        throw new \LogicException(__METHOD__ . ' not implemented yet');
    }

    /**
     * @param string $message
     * @return string
     */
    public function parse(string $message): string
    {
        return '';
    }
}
