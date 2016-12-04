<?php declare(strict_types = 1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Str;
use Serafim\MessageComponent\Dom\ParametersInjectorTrait;

/**
 * Class Message
 * @package Serafim\MessageComponent
 */
class Message implements Renderable, \Countable, \IteratorAggregate
{
    use ParametersInjectorTrait;

    /**
     * @var \DOMElement
     */
    private $body;

    /**
     * @var array
     */
    private $parameters;

    /**
     * @var string
     */
    private $rendered;

    /**
     * Message constructor.
     * @param string $content
     * @param array $parameters
     */
    public function __construct(string $content, array $parameters = [])
    {
        $this->body = $this->loadDom($content);

        $this->parameters = $parameters;
    }

    /**
     * @param string $body
     * @return \DOMElement
     */
    private function loadDom(string $body): \DOMElement
    {
        $document = new \DOMDocument('1.0', 'utf-8');
        $document->loadXML('<root>' . $body . '</root>');

        return $document->childNodes->item(0);
    }

    /**
     * @param string $key
     * @param $value
     * @return $this|Message
     */
    public function with(string $key, $value): Message
    {
        $this->parameters[$key] = $value;
        $this->rendered = null;

        return $this;
    }

    /**
     * @return \DOMElement
     */
    public function getBody(): \DOMElement
    {
        return $this->body;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @return \Generator|string[]
     */
    public function bytes(): \Generator
    {
        $body = $this->render();

        /** @noinspection ForeachInvariantsInspection */
        for ($i = 0, $len = $this->length(); $i < $len; ++$i) {
            /** @noinspection OffsetOperationsInspection */
            yield $i => $body{$i}; // Using `bytes{N}` instead `bytes[N]` will be a little more faster
        }
    }

    /**
     * @return string
     */
    public function render(): string
    {
        if ($this->rendered === null) {
            $this->rendered = $this->injectParameters($this->body->textContent, $this->parameters);
        }

        return $this->rendered;
    }

    /**
     * @return int
     */
    public function length(): int
    {
        return Str::length((string)$this);
    }

    /**
     * @param int $chars
     * @return \Generator|Message[]
     */
    public function wrap(int $chars): \Generator
    {
        $buffer = '';

        foreach ($this->chars() as $char) {
            $buffer .= $char;

            if ($buffer >= $chars) {
                yield new static($buffer, $this->parameters);
                $buffer = '';
            }
        }

        yield new static($buffer, $this->parameters);
    }

    /**
     * @return \Generator|string[]
     */
    public function chars(): \Generator
    {
        for ($i = 0, $len = $this->length(); $i < $len; ++$i) {
            yield $i => mb_substr((string)$this, $i, 1);
        }
    }

    /**
     * @param \string[] ...$words
     * @return bool
     */
    public function startsWith(string ...$words): bool
    {
        return Str::startsWith((string)$this, $words);
    }

    /**
     * @param int $words
     * @param string $endWith
     * @return Message
     */
    public function wordsLimit(int $words, string $endWith = '...'): Message
    {
        return new static(Str::words((string)$this, $words, $endWith), $this->parameters);
    }

    /**
     * @param int $words
     * @param string $endWith
     * @return Message
     */
    public function charsLimit(int $words, string $endWith = '...'): Message
    {
        return new static(Str::limit((string)$this, $words, $endWith), $this->parameters);
    }

    /**
     * @return Message
     */
    public function lowerCase(): Message
    {
        return new static(Str::lower((string)$this), $this->parameters);
    }

    /**
     * @return Message
     */
    public function upperCase(): Message
    {
        return new static(Str::upper((string)$this), $this->parameters);
    }

    /**
     * @param \string[] ...$words
     * @return bool
     */
    public function endsWith(string ...$words): bool
    {
        return Str::endsWith((string)$this, $words);
    }

    /**
     * @param \string[] ...$content
     * @return bool
     */
    public function contains(string ...$content): bool
    {
        return Str::contains((string)$this, $content);
    }

    /**
     * @param \string[] ...$patterns
     * @return bool
     */
    public function match(string ...$patterns): bool
    {
        foreach ($patterns as $pattern) {
            if (!$this->like(sprintf('^%s$', $pattern))) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param \string[] ...$patterns
     * @return bool
     */
    public function like(string ...$patterns): bool
    {
        foreach ($patterns as $pattern) {
            if (!preg_match(sprintf('/%s/isu', $pattern), (string)$this)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return \Generator|Message[]
     */
    public function sentences(): \Generator
    {
        foreach (preg_split('/(\n|:[a-z_]+:|\.|\){2,})/iu', (string)$this) as $text) {
            if (trim($text)) {
                yield new static($text, $this->parameters);
            }
        }
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->render();
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return $this->length();
    }

    /**
     * @return \Generator
     */
    public function getIterator(): \Generator
    {
        yield from $this->chars();
    }
}
