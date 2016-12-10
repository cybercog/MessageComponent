<?php declare(strict_types = 1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Render\Common;

use Carbon\Carbon;
use Serafim\MessageComponent\Dom\Exception\InvalidTagAttributeException;
use Serafim\MessageComponent\Dom\Node\DomElement;

/**
 * Class Date
 * @package Serafim\MessageComponent\Render\Common
 */
class Date extends DomElement
{
    /**
     * @var string
     */
    const DEFAULT_FORMAT = 'date-time';

    /**
     * @var array
     */
    private $formats = [
        'date'           => 'toDateString',
        'formatted-date' => 'toFormattedDateString',
        'time'           => 'toTimeString',
        'date-time'      => 'toDateTimeString',
        'day-date-time'  => 'toDayDateTimeString',
        'atom'           => 'toAtomString',
        'cookie'         => 'toCookieString',
        'iso8601'        => 'toIso8601String',
        'rfc822'         => 'toRfc822String',
        'rfc850'         => 'toRfc850String',
        'rfc1036'        => 'toRfc1036String',
        'rfc1123'        => 'toRfc1123String',
        'rfc2822'        => 'toRfc2822String',
        'rfc3339'        => 'toRfc3339String',
        'rss'            => 'toRssString',
        'w3c'            => 'toW3cString',
    ];

    /**
     * @return string
     * @throws \Serafim\MessageComponent\Dom\Exception\InvalidTagAttributeException
     */
    public function render(): string
    {
        $format = $this->getFormat();
        return $this->getDate()->{$format}();
    }

    /**
     * @return \DateTimeZone
     */
    private function getTimeZone(): \DateTimeZone
    {
        return new \DateTimeZone('UTC');
    }

    /**
     * @return Carbon
     */
    private function getDate(): Carbon
    {
        try {
            return Carbon::parse($this->html, $this->getTimeZone());
        } catch (\Throwable $e) {
            return Carbon::now($this->getTimeZone());
        }
    }

    /**
     * @return string
     * @throws \Serafim\MessageComponent\Dom\Exception\InvalidTagAttributeException
     */
    public function getFormat(): string
    {
        if ($this->dom->hasAttribute('format')) {
            $format = strtolower($this->dom->getAttribute('format'));

            if (!isset($this->formats[$format])) {
                $formats = implode(', ', array_keys($this->formats));
                $message = sprintf('Invalid format attribute value %s. Value can me one of %s', $format, $formats);
                throw new InvalidTagAttributeException($message);
            }

            return $this->formats[$format];
        }

        return $this->formats[static::DEFAULT_FORMAT];
    }
}