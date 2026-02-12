# Laravel ICS

[![Latest Version on Packagist](https://img.shields.io/packagist/v/sssurii/laravel-ics.svg?style=flat-square)](https://packagist.org/packages/sssurii/laravel-ics)
[![Total Downloads](https://img.shields.io/packagist/dt/sssurii/laravel-ics.svg?style=flat-square)](https://packagist.org/packages/sssurii/laravel-ics)

Lightweight PHP library to create iCalendar/ICS files. Works standalone or with Laravel. Send event invitations via Email and can cancel or update already sent invitation.

## Features

- ✅ Create ICS/iCalendar files
- ✅ Send event invitations via email
- ✅ Cancel existing invitations
- ✅ Update existing invitations
- ✅ Support for organizers and attendees
- ✅ Configurable RSVP and attendee roles
- ✅ **Works standalone or with Laravel**
- ✅ Lightweight - no heavy dependencies
- ✅ Optional Laravel integration (9.x, 10.x, 11.x)
- ✅ PHP 8.0+ support
- ✅ Comprehensive test coverage

## Requirements

- PHP 8.0 or higher
- Laravel 9.x, 10.x, or 11.x (optional - only if using Laravel integration)

## Installation

Install using composer:

```bash
composer require sssurii/laravel-ics
```

### Laravel Integration (Optional)

If you're using Laravel, the package will automatically register via package discovery.

To publish the config file, run:

```bash
php artisan vendor:publish --provider="INSAN\ICS\ICSServiceProvider" --tag=config
```

This will create a `config/ics.php` file where you can configure daylight saving time settings.

## Usage

### Basic Usage (Standalone)

```php
use INSAN\ICS\ICS;

// Set event properties
$event_properties = [
    'uid' => uniqid(),
    'sequence' => 0,
    'description' => 'Event Invitation via email.',
    'dtstart' => '2024-12-25 09:00',
    'dtend' => '2024-12-25 10:00',
    'summary' => 'This is an event invitation sent through email.',
    'location' => 'VR Punjab, S.A.S Nagar, Chandigarh',
    'url' => 'https://www.example.com',
];

$ics_file = new ICS($event_properties);
$ics_content = $ics_file->toString();
```

### With Custom Configuration

```php
use INSAN\ICS\ICS;

// Pass custom configuration as second parameter
$config = [
    'DAY_LIGHT_SAVING' => true,
    'DAY_LIGHT_SAVING_START_MONTH' => '03',
    'DAY_LIGHT_SAVING_END_MONTH' => '10',
    'DAY_LIGHT_SAVING_OFFSET' => '1 hours',
];

$ics_file = new ICS($event_properties, $config);
$ics_content = $ics_file->toString();
```

**Note:** When using Laravel, the config is automatically loaded from `config/ics.php`. In standalone mode, you can pass it directly or use the defaults.

### Setting Organizer

```php
$ics_file = new ICS($event_properties);
$ics_file->setOrganizer('Surinder Singh', 'sssurii.dev@gmail.com');
$ics_content = $ics_file->toString();
```

### Adding Attendees

```php
$ics_file = new ICS($event_properties);
$ics_file->setOrganizer('Surinder Singh', 'sssurii.dev@gmail.com');

// Add required attendees
$ics_file->addAttendee('alice@example.com', 'Alice Smith', 'REQ-PARTICIPANT', 'TRUE');

// Add optional attendees
$ics_file->addAttendee('bob@example.com', 'Bob Johnson', 'OPT-PARTICIPANT', 'TRUE');

// Add attendee without name
$ics_file->addAttendee('charlie@example.com');

$ics_content = $ics_file->toString();
```

### Canceling an Invitation

To cancel an already sent invitation, use the same `uid` that was used in the original invitation:

```php
$cancel_properties = [
    'uid' => 'same-uid-as-original-event',
    'sequence' => 1, // Increment sequence for updates/cancellations
    'summary' => 'This is an event invitation sent through email.',
    'dtstart' => '2024-12-25 09:00',
    'dtend' => '2024-12-25 10:00',
];

$ics_file = new ICS($cancel_properties);
$ics_file->markEventCancel();
$ics_content = $ics_file->toString();
```

**Note:** Always use the same `uid` when canceling or updating an event.

### Sending via Email

You can attach the ICS content to your email. Here's an example using Laravel's Mail facade:

```php
use Illuminate\Support\Facades\Mail;
use INSAN\ICS\ICS;

$ics_file = new ICS($event_properties);
$ics_file->setOrganizer('Your Name', 'your@email.com');
$ics_content = $ics_file->toString();

Mail::send('emails.invitation', $data, function($message) use ($ics_content) {
    $message->to('recipient@example.com')
            ->subject('Event Invitation');
    
    $message->attachData($ics_content, 'invitation.ics', [
        'mime' => 'text/calendar; charset=UTF-8; method=REQUEST'
    ]);
});
```

### Available Properties

The following properties are supported:

| Property | Description | Example |
|----------|-------------|---------|
| `uid` | Unique identifier for the event | `'event-123'` or `uniqid()` |
| `sequence` | Sequence number (increment for updates) | `0`, `1`, `2` |
| `summary` | Event title/summary | `'Team Meeting'` |
| `description` | Event description | `'Monthly team sync'` |
| `location` | Event location | `'Conference Room A'` |
| `dtstart` | Start date and time | `'2024-12-25 09:00'` |
| `dtend` | End date and time | `'2024-12-25 10:00'` |
| `url` | Related URL | `'https://example.com'` |
| `status` | Event status | `'CONFIRMED'`, `'TENTATIVE'`, `'CANCELLED'` |
| `categories` | Event categories | `'MEETING'`, `'WORK'` |
| `priority` | Priority (0-9) | `0` (undefined) to `9` (highest) |
| `transp` | Time transparency | `'TRANSPARENT'`, `'OPAQUE'` |
| `class` | Access classification | `'PUBLIC'`, `'PRIVATE'`, `'CONFIDENTIAL'` |

### Dynamic Property Setting

You can also set properties after creating the ICS instance:

```php
$ics_file = new ICS();
$ics_file->set('summary', 'New Event');
$ics_file->set('location', 'New Location');

// Or set multiple at once
$ics_file->set([
    'summary' => 'Another Event',
    'location' => 'Another Location',
    'dtstart' => '2024-12-26 10:00',
    'dtend' => '2024-12-26 11:00',
]);
```

## Configuration

The config file (`config/ics.php`) allows you to configure daylight saving time settings:

```php
return [
    // Enable if sending invites from a daylight saving region
    'DAY_LIGHT_SAVING' => env('DAY_LIGHT_SAVING', false),
    
    // Month when daylight saving starts (e.g., '03' for March)
    'DAY_LIGHT_SAVING_START_MONTH' => env('DAY_LIGHT_SAVING_START_MONTH', '03'),
    
    // Month when daylight saving ends (e.g., '10' for October)  
    'DAY_LIGHT_SAVING_END_MONTH' => env('DAY_LIGHT_SAVING_END_MONTH', '10'),
    
    // Offset for daylight saving (e.g., '1 hours')
    'DAY_LIGHT_SAVING_OFFSET' => '1 hours',
];
```

You can also set these in your `.env` file (Laravel only):

```env
DAY_LIGHT_SAVING=false
DAY_LIGHT_SAVING_START_MONTH=03
DAY_LIGHT_SAVING_END_MONTH=10
```

### Standalone Configuration

In standalone mode (without Laravel), pass configuration directly:

```php
$config = [
    'DAY_LIGHT_SAVING' => false,
    'DAY_LIGHT_SAVING_START_MONTH' => '03',
    'DAY_LIGHT_SAVING_END_MONTH' => '10',
    'DAY_LIGHT_SAVING_OFFSET' => '1 hours',
];

$ics = new ICS($event_properties, $config);
```

## Version Compatibility

| Component | Version | Notes |
|-----------|---------|-------|
| PHP | 8.0 - 8.3 | Required |
| Laravel | 9.x, 10.x, 11.x | Optional - for Laravel integration only |
| Standalone | Any | Works without Laravel |

**The package works standalone without Laravel!** Laravel integration is optional and provides automatic config loading via the ServiceProvider.

## Testing

```bash
composer test
```

## Code Quality

Run static analysis:
```bash
composer analyse
```

Format code:
```bash
composer format
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## Security

If you discover any security related issues, please email sssurii.dev@gmail.com instead of using the issue tracker.

## Credits

- [Surinder Singh](https://github.com/sssurii)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

## Help / Support

For bug reports, please [open an issue on GitHub](https://github.com/sssurii/laravel-ics/issues/new).
