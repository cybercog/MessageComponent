<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Dom;

/**
 * Class ParametersInjectorTrait
 * @package Serafim\MessageComponent\Dom
 */
trait ParametersInjectorTrait
{
    /**
     * @var string
     */
    protected $openTag = '{{';

    /**
     * @var string
     */
    protected $closeTag = '}}';

    /**
     * @param string $text
     * @param array $parameters
     * @return string
     */
    protected function injectParameters(string $text, array $parameters): string
    {
        $pattern = sprintf('/%s\s*%s\s*%s/isu', $this->openTag, '%s', $this->closeTag);

        foreach ($parameters as $param => $value) {
            $text = preg_replace(sprintf($pattern, preg_quote($param)), $value, $text);
        }

        return $text;
    }
}
