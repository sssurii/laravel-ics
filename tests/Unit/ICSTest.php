<?php

namespace INSAN\ICS\Tests\Unit;

use INSAN\ICS\ICS;
use INSAN\ICS\Tests\TestCase;

class ICSTest extends TestCase
{
    public function test_can_create_ics_instance(): void
    {
        $ics = new ICS();
        $this->assertInstanceOf(ICS::class, $ics);
    }

    public function test_can_create_ics_with_properties(): void
    {
        $properties = [
            'uid' => 'test-uid-123',
            'description' => 'Test Event Description',
            'summary' => 'Test Event',
            'location' => 'Test Location',
        ];

        $ics = new ICS($properties);
        $output = $ics->toString();

        $this->assertStringContainsString('UID:test-uid-123', $output);
        $this->assertStringContainsString('DESCRIPTION:Test Event Description', $output);
        $this->assertStringContainsString('SUMMARY:Test Event', $output);
        $this->assertStringContainsString('LOCATION:Test Location', $output);
    }

    public function test_generates_valid_ics_format(): void
    {
        $properties = [
            'uid' => 'test-event',
            'summary' => 'Test Event',
            'dtstart' => '2024-01-01 10:00',
            'dtend' => '2024-01-01 11:00',
        ];

        $ics = new ICS($properties);
        $output = $ics->toString();

        $this->assertStringContainsString('BEGIN:VCALENDAR', $output);
        $this->assertStringContainsString('VERSION:2.0', $output);
        $this->assertStringContainsString('BEGIN:VEVENT', $output);
        $this->assertStringContainsString('END:VEVENT', $output);
        $this->assertStringContainsString('END:VCALENDAR', $output);
        $this->assertStringContainsString('METHOD:REQUEST', $output);
    }

    public function test_can_set_organizer(): void
    {
        $ics = new ICS([
            'uid' => 'test-event',
            'summary' => 'Test Event',
        ]);

        $ics->setOrganizer('John Doe', 'john@example.com');
        $output = $ics->toString();

        $this->assertStringContainsString('ORGANIZER;CN=John Doe:MAILTO:john@example.com', $output);
    }

    public function test_can_mark_event_as_cancelled(): void
    {
        $ics = new ICS([
            'uid' => 'test-event',
            'summary' => 'Test Event',
        ]);

        $ics->markEventCancel();
        $output = $ics->toString();

        $this->assertStringContainsString('METHOD:CANCEL', $output);
        $this->assertStringNotContainsString('METHOD:REQUEST', $output);
    }

    public function test_escapes_special_characters(): void
    {
        $ics = new ICS([
            'uid' => 'test-event',
            'description' => 'Test, with; special characters',
        ]);

        $output = $ics->toString();

        $this->assertStringContainsString('DESCRIPTION:Test\, with\; special characters', $output);
    }

    public function test_generates_unique_uid_if_not_provided(): void
    {
        $ics = new ICS([
            'summary' => 'Test Event',
        ]);

        $output = $ics->toString();

        $this->assertStringContainsString('UID:', $output);
    }

    public function test_includes_dtstamp(): void
    {
        $ics = new ICS([
            'uid' => 'test-event',
            'summary' => 'Test Event',
        ]);

        $output = $ics->toString();

        $this->assertStringContainsString('DTSTAMP:', $output);
    }

    public function test_can_set_properties_after_construction(): void
    {
        $ics = new ICS();
        $ics->set('summary', 'New Event');
        $ics->set('location', 'New Location');

        $output = $ics->toString();

        $this->assertStringContainsString('SUMMARY:New Event', $output);
        $this->assertStringContainsString('LOCATION:New Location', $output);
    }

    public function test_can_set_multiple_properties_at_once(): void
    {
        $ics = new ICS();
        $ics->set([
            'summary' => 'Batch Event',
            'location' => 'Batch Location',
            'description' => 'Batch Description',
        ]);

        $output = $ics->toString();

        $this->assertStringContainsString('SUMMARY:Batch Event', $output);
        $this->assertStringContainsString('LOCATION:Batch Location', $output);
        $this->assertStringContainsString('DESCRIPTION:Batch Description', $output);
    }

    public function test_formats_timestamps_correctly(): void
    {
        $ics = new ICS([
            'uid' => 'test-event',
            'dtstart' => '2024-01-01 10:00:00',
            'dtend' => '2024-01-01 11:00:00',
        ]);

        $output = $ics->toString();

        // Should contain formatted timestamps in UTC format
        $this->assertMatchesRegularExpression('/DTSTART:\d{8}T\d{6}Z/', $output);
        $this->assertMatchesRegularExpression('/DTEND:\d{8}T\d{6}Z/', $output);
    }

    public function test_supports_additional_properties(): void
    {
        $ics = new ICS([
            'uid' => 'test-event',
            'summary' => 'Test Event',
            'status' => 'CONFIRMED',
            'transp' => 'OPAQUE',
            'class' => 'PUBLIC',
            'priority' => '5',
        ]);

        $output = $ics->toString();

        $this->assertStringContainsString('STATUS:CONFIRMED', $output);
        $this->assertStringContainsString('TRANSP:OPAQUE', $output);
        $this->assertStringContainsString('CLASS:PUBLIC', $output);
        $this->assertStringContainsString('PRIORITY:5', $output);
    }
}
