# Changelog

All notable changes to `laravel-ics` will be documented in this file.

## [Unreleased]

### Changed
- **BREAKING (minor)**: ICS constructor now accepts optional second parameter `$config` for standalone usage
- Removed `orchestra/testbench` dependency - package now works standalone without Laravel
- Refactored to not depend on Laravel's `config()` helper
- Simplified test suite - now uses plain PHPUnit instead of Orchestra Testbench
- Updated CI/CD workflow to test across PHP versions only (no longer testing Laravel matrix)
- Package can now be used in non-Laravel PHP projects

### Added
- Standalone configuration support via constructor parameter
- Tests for custom configuration parameter
- Documentation for standalone usage

### Removed
- Orchestra Testbench dependency (reduces package weight significantly)
- Laravel-specific feature tests (ServiceProvider still works with Laravel)

**Migration Guide:**
- Existing Laravel users: No changes needed! Package works the same way.
- Standalone users: Can now pass config as second parameter: `new ICS($props, $config)`

---

## [1.0.0] - Previous Release

### Added
- Attendee support with `addAttendee()` method
- Support for attendee roles (REQ-PARTICIPANT, OPT-PARTICIPANT, NON-PARTICIPANT)
- RSVP configuration for attendees
- Comprehensive test suite with PHPUnit (20+ test cases)
- PHPStan for static code analysis
- Laravel Pint for code formatting
- Modern GitHub Actions CI/CD workflow
- Support for Laravel 9.x, 10.x, and 11.x
- Support for PHP 8.0, 8.1, 8.2, and 8.3
- Additional ICS properties: `status`, `transp`, `class`
- Comprehensive documentation in README
- MIT License file
- CHANGELOG file
- CONTRIBUTING guide
- Example files for common use cases

### Changed
- Improved composer.json with proper version constraints
- Enhanced type safety with proper type hints
- Fixed bug in `markEventCancel()` method (array_search strict comparison)
- Improved timezone handling in `formatTimestamp()` method
- Service provider now properly merges config
- Updated README with comprehensive examples and documentation
- Modernized package structure following Laravel best practices

### Fixed
- Fixed daylight saving time calculation logic
- Fixed config merging in service provider
- Fixed method signatures with proper type declarations

## [1.0.0] - 2024-02-12

### Added
- Initial release
- Basic ICS file generation
- Event invitation support
- Event cancellation support
- Organizer support
- Daylight saving time configuration
