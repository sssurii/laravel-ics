<?php

/**
 * Cancel Event Example
 * 
 * This example shows how to cancel an existing event invitation.
 * Important: Use the same UID as the original invitation!
 */

require __DIR__ . '/../vendor/autoload.php';

use INSAN\ICS\ICS;

// Use the SAME UID as the original invitation
$original_uid = 'event-123-original';

$cancel_properties = [
    'uid' => $original_uid, // MUST be the same as original
    'sequence' => 1, // Increment from original (original was 0)
    'summary' => 'Team Meeting - CANCELLED',
    'description' => 'This meeting has been cancelled.',
    'location' => 'Conference Room A',
    'dtstart' => '2024-12-25 09:00',
    'dtend' => '2024-12-25 10:00',
];

$ics = new ICS($cancel_properties);

// Set the organizer (same as original)
$ics->setOrganizer('John Doe', 'john.doe@example.com');

// Mark the event as cancelled
$ics->markEventCancel();

// Generate ICS content
$ics_content = $ics->toString();

// Output to browser
header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename="meeting-cancelled.ics"');
echo $ics_content;

// When sending via email, recipients who accepted the original invitation
// will automatically see the cancellation in their calendars
