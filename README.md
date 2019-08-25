# laravel-ics
Laravel package to create iCalendar/ICS files.

## Installation
Install using composer:

	`composer require sssurii/laravel-ics`


## Usage
1. For Laravel 5.6 or above, simply load class:

	`use INSAN\ICS\ICS;`

2. For laravel 5.5 or below, open your `config/app.php` and add below line under 'providers':

```
/*
 * Package Service Providers...
 */

INSAN\ICS\ICSServiceProvider::class,
```
Then simply load class as above case above.

3. Use package class as below:

Set various event details, pass properties as array while initializing class:
```
	$ics_file = new ICS([
	            'uid' => uniqid(),
	            'sequence' => 0,
	            'description' => 'Event Invitation via email.',
	            'dtstart' => date('Y-m-d 09:00'),
	            'dtend' => date('Y-m-d 10:00'),
	            'summary' => 'This is an event invitation sent through email.',
	            'location' => 'VR Punjab, S.A.S Nagar, Chandigarh',
	            'url' => 'www.example.com',
	        ]);
	return $ics_file->toString();
```
Some optional properties can be set as below, like set organizer details
```
	//Optional
	$ics_file->setOrganizer('Surinder', 'sssurii.dev@gmail.com');
```
If you want cancel already sent invitation, use below code:

```
	//Optional
	$ics_file->markEventCancel();
```

## Help / Support
For bug reports, please [open an issue on GitHub](https://github.com/sssurii/laravel-ics/issues/new).