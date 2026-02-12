<?php

/**
 * Laravel Mail Integration Example
 * 
 * This example shows how to send an ICS event invitation via Laravel's Mail system.
 */

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use INSAN\ICS\ICS;

class EventInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $eventData;

    /**
     * Create a new message instance.
     */
    public function __construct(array $eventData)
    {
        $this->eventData = $eventData;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        // Create ICS file
        $ics = new ICS([
            'uid' => $this->eventData['uid'],
            'sequence' => 0,
            'summary' => $this->eventData['title'],
            'description' => $this->eventData['description'],
            'location' => $this->eventData['location'],
            'dtstart' => $this->eventData['start_time'],
            'dtend' => $this->eventData['end_time'],
            'status' => 'CONFIRMED',
        ]);

        // Set organizer
        $ics->setOrganizer(
            $this->eventData['organizer_name'],
            $this->eventData['organizer_email']
        );

        // Add attendees if provided
        if (isset($this->eventData['attendees'])) {
            foreach ($this->eventData['attendees'] as $attendee) {
                $ics->addAttendee(
                    $attendee['email'],
                    $attendee['name'] ?? '',
                    $attendee['role'] ?? 'REQ-PARTICIPANT',
                    $attendee['rsvp'] ?? 'TRUE'
                );
            }
        }

        $ics_content = $ics->toString();

        return $this->subject('Event Invitation: ' . $this->eventData['title'])
                    ->view('emails.event-invitation')
                    ->attachData($ics_content, 'invitation.ics', [
                        'mime' => 'text/calendar; charset=UTF-8; method=REQUEST'
                    ]);
    }
}

// Usage in your controller:
/*
use App\Mail\EventInvitation;
use Illuminate\Support\Facades\Mail;

$eventData = [
    'uid' => uniqid(),
    'title' => 'Team Meeting',
    'description' => 'Monthly team sync',
    'location' => 'Conference Room A',
    'start_time' => '2024-12-25 09:00',
    'end_time' => '2024-12-25 10:00',
    'organizer_name' => 'John Doe',
    'organizer_email' => 'john@example.com',
    'attendees' => [
        ['email' => 'alice@example.com', 'name' => 'Alice Smith'],
        ['email' => 'bob@example.com', 'name' => 'Bob Johnson'],
    ]
];

Mail::to('alice@example.com')
    ->cc('bob@example.com')
    ->send(new EventInvitation($eventData));
*/
