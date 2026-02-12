# Why Orchestra/Testbench Was Removed

## Question
"why using orchestra/testbench?"

## Answer

Orchestra/Testbench has been **removed** from this package to make it lighter and more versatile.

## The Problem

Previously, the package depended on `orchestra/testbench` (a 20+ MB dependency) just to test Laravel integration. This had several downsides:

1. **Heavy Dependency**: Orchestra/Testbench pulls in the entire Laravel framework just for testing
2. **Laravel-Only**: Made the package seem like it only works with Laravel
3. **Slow Tests**: Bootstrap time for Laravel environment added overhead
4. **Overkill**: Most tests were just testing the ICS class directly, not Laravel features

## The Solution

The package has been refactored to be **standalone-first** with optional Laravel integration:

### What Changed

**Before:**
```php
// ICS class depended on Laravel's config() helper
if (config('ics.DAY_LIGHT_SAVING', false)) {
    // ...
}
```

**After:**
```php
// ICS class has its own config
public function __construct(array $properties = [], array $config = [])
{
    $this->config = array_merge([
        'DAY_LIGHT_SAVING' => false,
        // ... defaults
    ], $config);
}
```

### Benefits

1. ✅ **Lighter Package**: Removed 20+ MB dependency
2. ✅ **Standalone Usage**: Works in any PHP project, not just Laravel
3. ✅ **Faster Tests**: Plain PHPUnit, no Laravel bootstrap
4. ✅ **Simpler CI/CD**: No need to test multiple Laravel versions
5. ✅ **Still Laravel-Compatible**: ServiceProvider handles config automatically

## Usage Examples

### Standalone (No Laravel)
```php
use INSAN\ICS\ICS;

$config = [
    'DAY_LIGHT_SAVING' => false,
    'DAY_LIGHT_SAVING_START_MONTH' => '03',
    'DAY_LIGHT_SAVING_END_MONTH' => '10',
    'DAY_LIGHT_SAVING_OFFSET' => '1 hours',
];

$ics = new ICS($event_properties, $config);
```

### With Laravel
```php
use INSAN\ICS\ICS;

// Config automatically loaded from config/ics.php via ServiceProvider
$ics = new ICS($event_properties);
```

## Backward Compatibility

✅ **No breaking changes for Laravel users!** The package still works exactly the same in Laravel applications. The ServiceProvider automatically loads config from `config/ics.php`.

## Testing

**Before:**
- Required Orchestra/Testbench
- Tests extended `Orchestra\Testbench\TestCase`
- Needed Laravel environment setup

**After:**
- Uses plain PHPUnit
- Tests extend `PHPUnit\Framework\TestCase`
- No Laravel dependency in tests

## Conclusion

Orchestra/Testbench was removed because:
1. It was unnecessarily heavy for a simple ICS generation library
2. The package doesn't actually need Laravel to function
3. The same functionality can be achieved with simpler, lighter code
4. It makes the package more accessible to non-Laravel users

The package is now **truly lightweight** while maintaining full Laravel compatibility through optional integration.
