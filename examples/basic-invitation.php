<?php

/**
 * Basic Event Invitation Example (Standalone)
 * 
 * This example shows how to create a simple event invitation with ICS
 * without requiring Laravel.
 */

require __DIR__ . '/../vendor/autoload.php';

use INSAN\ICS\ICS;

// Optional: Custom configuration (if needed)
$config = [
    'DAY_LIGHT_SAVING' => false,
    'DAY_LIGHT_SAVING_START_MONTH' => '03',
    'DAY_LIGHT_SAVING_END_MONTH' => '10',
    'DAY_LIGHT_SAVING_OFFSET' => '1 hours',
];

// Create a basic event
$event_properties = [
    'uid' => uniqid(),
    'sequence' => 0,
    'summary' => 'Team Meeting',
    'description' => 'Monthly team sync to discuss project updates and goals.',
    'location' => 'Conference Room A',
    'dtstart' => '2024-12-25 09:00',
    'dtend' => '2024-12-25 10:00',
    'status' => 'CONFIRMED',
    'url' => 'https://meet.example.com/team-meeting',
];

// Create ICS instance (config is optional, uses defaults if not provided)
$ics = new ICS($event_properties, $config);

// Set the organizer
$ics->setOrganizer('John Doe', 'john.doe@example.com');

// Add attendees
$ics->addAttendee('alice@example.com', 'Alice Smith', 'REQ-PARTICIPANT', 'TRUE');
$ics->addAttendee('bob@example.com', 'Bob Johnson', 'OPT-PARTICIPANT', 'TRUE');

// Generate ICS content
$ics_content = $ics->toString();

// Output to browser (for testing)
header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename="meeting.ics"');
echo $ics_content;

// Or save to file
// file_put_contents('meeting.ics', $ics_content);

// Or send via email (using any mail library)
// mail('recipient@example.com', 'Event Invitation', 'Please see attached', ...);
