<?php

/**
 * Basic Event Invitation Example
 * 
 * This example shows how to create a simple event invitation with ICS.
 */

require __DIR__ . '/../vendor/autoload.php';

use INSAN\ICS\ICS;

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

$ics = new ICS($event_properties);

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

// Or send via email
// Mail::send(...);
