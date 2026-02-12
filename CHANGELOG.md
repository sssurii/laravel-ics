# Changelog

All notable changes to `laravel-ics` will be documented in this file.

## [Unreleased]

### Added
- Comprehensive test suite with PHPUnit
- PHPStan for static code analysis
- Laravel Pint for code formatting
- Modern GitHub Actions CI/CD workflow
- Support for Laravel 9.x, 10.x, and 11.x
- Support for PHP 8.0, 8.1, 8.2, and 8.3
- Additional ICS properties: `status`, `transp`, `class`
- Comprehensive documentation in README
- MIT License file
- This CHANGELOG file

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
