<?php declare(strict_types=1);
/**
 * This file is part of MessageComponent package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Serafim\MessageComponent\Render\Slack;

use Carbon\Carbon;
use Serafim\MessageComponent\Render as Tag;

/**
 * Class Date
 * @package Serafim\MessageComponent\Render\Slack
 */
class Date extends Tag\Date
{
    /**
     * @return string
     */
    public function render(): string
    {
        $date      = $this->getDate();
        $formatted = $this->format($date, $this->getFormat());

        return sprintf('<!date^%s^%s|%s>', $date->timestamp, $this->getSlackFormat(), $formatted);
    }

    /**
     * @return string
     * @throws \Serafim\MessageComponent\Dom\Exception\InvalidTagAttributeException
     */
    protected function getSlackFormat(): string
    {
        switch ($this->getFormat()) {
            case 'date':
                return '{date_num}';
            case 'formatted-date':
                return '{date_short}';
            case 'time':
                return '{time_secs}';
            case 'date-time':
                return '{date_num} {time_secs}';
            case 'day-date-time':
                return '{date_long} {time}';
        }

        return '{date} at {time}';
    }
}