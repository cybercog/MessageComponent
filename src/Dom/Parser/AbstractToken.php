<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Dom\Parser;

/**
 * Class AbstractToken
 * @package Serafim\MessageComponent\Dom\Parser
 */
abstract class AbstractToken implements TokenInterface
{
    /**
     * @param string $name
     * @param string $body
     * @param array $attributes
     * @return string
     */
    protected function tag(string $name, string $body = '', array $attributes = []): string
    {
        $name = htmlspecialchars($name);

        $prefix = '<' . $name . $this->stringifyAttributes($attributes);
        if ($body) {
            return $prefix . '>' . $body . '</' . $name . '>';
        }

        return $prefix . ' />';
    }

    /**
     * @param array $attributes
     * @return string
     */
    private function stringifyAttributes(array $attributes = []): string
    {
        if (count($attributes)) {
            $attr = $this->attributesToArray($attributes);
            return (count($attr) ? ' ' : '') . implode(' ', $attr);
        }

        return '';
    }

    /**
     * @param array $attributes
     * @return array
     */
    private function attributesToArray(array $attributes = []): array
    {
        $attributesData = [];
        foreach ($attributes as $key => $value) {
            if ($value) {
                $attributesData[] = $key . '="' . htmlspecialchars($value) . '"';
            }
        }
        return $attributesData;
    }
}