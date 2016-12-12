<?php
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Dom;

/**
 * Class XmlParser
 * @package Serafim\MessageComponent\Dom
 */
class XmlParser
{
    /**
     * @var array
     */
    private $validParsedXml = ['<?xml', '<!doctype'];

    /**
     * @var string
     */
    private $charset = 'utf-8';

    /**
     * @param string $charset
     * @return $this
     */
    public function setCharset(string $charset)
    {
        $this->charset = $charset;

        return $this;
    }

    /**
     * @param string $body
     * @return \DOMElement
     */
    public function create(string $body): \DOMElement
    {
        return $this->isCanBeParsedAsXml($body)
            ? $this->parseAsXml($body)
            : $this->parseAsXmlLikeString($body);
    }

    /**
     * @param string $body
     * @return \DOMElement
     */
    public function parseAsXml(string $body): \DOMElement
    {
        $document = $this->createDocument();
        $document->loadXML($body);

        return $document->documentElement;
    }

    /**
     * @param string $body
     * @return \DOMElement
     */
    public function parseAsXmlLikeString(string $body): \DOMElement
    {
        $document = $this->createDocument();
        $document->loadXML('<root>' . $body . '</root>');

        return $document->childNodes->item(0);
    }

    /**
     * @return \DOMDocument
     */
    private function createDocument(): \DOMDocument
    {
        return new \DOMDocument('1.0', $this->charset);
    }

    /**
     * @param string $body
     * @return bool
     */
    private function isCanBeParsedAsXml(string $body): bool
    {
        foreach ((array)$this->validParsedXml as $needle) {
            if (0 === strpos($body, (string)$needle)) {
                return true;
            }
        }

        return false;
    }
}
