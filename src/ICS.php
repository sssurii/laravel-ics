<?php

namespace INSAN\ICS;

use DateTime;
use DateTimeZone;

class ICS
{
    protected const DATETIME_FORMAT = 'Ymd\THis\Z';
    protected const DATE_FORMAT = 'Y-m-d';

    protected array $properties = [];

    private string $organiser = '';

    private array $available_properties = [
        'categories',
        'priority',
        'description',
        'dtend',
        'dtstart',
        'location',
        'summary',
        'url',
        'uid',
        'sequence',
        'status',
        'transp',
        'class',
    ];

    private array $header_properties = [
        'BEGIN:VCALENDAR',
        'VERSION:2.0',
        'PRODID:-//hacksw/handcal//NONSGML v1.0//EN',
        'CALSCALE:GREGORIAN',
        'METHOD:REQUEST',
        'BEGIN:VEVENT',
    ];

    public function __construct(array $properties = [])
    {
        $this->set($properties, false);
    }

    public function set(array|string $properties, mixed $value = null): void
    {
        if (is_array($properties)) {
            foreach ($properties as $attribute => $val) {
                $this->set($attribute, $val);
            }
        } else {
            if (in_array($properties, $this->available_properties)) {
                $this->properties[$properties] = $this->sanitizeValue((string) $value, $properties);
            }
        }
    }

    public function toString(): string
    {
        $rows = $this->buildICSProperties();
        return implode("\r\n", $rows);
    }

    private function buildICSProperties(): array
    {
        $ics_properties = $this->getDefaultHeaderProperties();

        $ics_properties = $this->appendProperties($ics_properties);

        if ($this->getOrganizer()) {
            $ics_properties[] = $this->getOrganizer();
        }

        $ics_properties = $this->addDefaultFooterProperties($ics_properties);
        return $ics_properties;
    }

    private function sanitizeValue(string $value, string $attribute): string
    {
        switch ($attribute) {
            case 'dtend':
            case 'dtstamp':
            case 'dtstart':
                $value = $this->formatTimestamp($value);
                break;
            default:
                $value = $this->escapeString($value);
        }
        return $value;
    }

    private function formatTimestamp(string $timestamp): string
    {
        $datetime = new DateTime($timestamp);
        
        // If daylight saving is enabled and configured
        if (config('ics.DAY_LIGHT_SAVING', false)) {
            $dayLightStartMonth = config('ics.DAY_LIGHT_SAVING_START_MONTH', '03');
            $dayLightEndMonth = config('ics.DAY_LIGHT_SAVING_END_MONTH', '10');
            $offset = config('ics.DAY_LIGHT_SAVING_OFFSET', '1 hours');
            
            $year = $datetime->format('Y');
            $dayLightStart = strtotime("last sunday of {$year}-{$dayLightStartMonth}");
            $dayLightEnd = strtotime("last sunday of {$year}-{$dayLightEndMonth}");
            
            $currentTimestamp = $datetime->getTimestamp();
            
            if ($currentTimestamp >= $dayLightStart && $currentTimestamp <= $dayLightEnd) {
                $datetime->modify("-{$offset}");
            }
        }
        
        // Convert to UTC for ICS format
        $datetime->setTimezone(new DateTimeZone('UTC'));
        
        return $datetime->format(self::DATETIME_FORMAT);
    }

    private function escapeString(string $str): string
    {
        return preg_replace('/([\,;])/', '\\\$1', $str);
    }

    public function setOrganizer(string $name, string $email): void
    {
        $this->organiser = 'ORGANIZER;CN=' . $name . ':MAILTO:' . $email;
    }

    public function getOrganizer(): string
    {
        return $this->organiser;
    }

    public function markEventCancel(): void
    {
        $method_key = array_search('METHOD:REQUEST', $this->header_properties);

        if ($method_key !== false) {
            $this->header_properties[$method_key] = 'METHOD:CANCEL';
        }
    }

    private function getDefaultHeaderProperties(): array
    {
        return $this->header_properties;
    }

    private function appendProperties(array $ics_properties): array
    {
        $properties = $this->buildProperties();

        foreach ($properties as $attribute => $value) {
            $ics_properties[] = "$attribute:$value";
        }

        return $ics_properties;
    }

    private function buildProperties(): array
    {
        $properties = [];
        foreach ($this->properties as $attribute => $value) {
            $properties[strtoupper($attribute)] = $value;
        }

        $properties['DTSTAMP'] = $this->formatTimestamp('now');
        $properties['UID'] = $properties['UID'] ?? uniqid();
        return $properties;
    }

    private function addDefaultFooterProperties(array $ics_properties): array
    {
        $ics_properties[] = 'END:VEVENT';
        $ics_properties[] = 'END:VCALENDAR';

        return $ics_properties;
    }
}
