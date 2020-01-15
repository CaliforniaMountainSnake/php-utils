# Changelog
The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]
### Added
### Changed
### Deprecated
### Removed
### Fixed
### Security


## [1.0.7] - 2020-01-15
### Added
- Added the Utils class that contains all util traits. Sometimes you just need to have an object that can do all needed work without creating the own class.

## [1.0.6] - 2019-10-11
### Added
- Added ArrayUtils::get_array_value_or_null() method.

## [1.0.5] - 2019-09-20
### Added
- Added the support of json request body in the CurlUtils::httpQuery().
- Added the CurlHttpMethods::postJson() method.
### Changed
- Added the ext-mbstring dependence in the composer.json.

## [1.0.4] - 2019-09-09
### Added
- Added the support of PATCH and OPTIONS http queries.
- Added the ArrayUtils::array_values_recursive() method.
### Changed
- The CurlUtilsTest has been improved.
### Fixed
- Fix the PUT (and ony other except GET/POST) request execution.

## [1.0.3] - 2019-08-28
### Added
- Added the ArrayUtils::array_keys_recursive() method.

## [1.0.2] - 2019-08-27
### Added
- CurlUtils now can successfully execute post requests with multidimensional params' arrays with files (and get requests with multidimensional params' arrays).
- Added tests that check execution of queries with multidimensional arrays and files.
- Added the ArrayUtils::modify_array_recursive() method that allows to change values AND KEYS in the given array recursively keeping the array order.
- Added this changelog.
### Changed
- Minimum php version has been reduced from 7.3.1 to 7.1.
- Composer dependencies has been updated.
- Source code files have been formatted.

[1.0.7]: https://github.com/CaliforniaMountainSnake/php-utils/compare/1.0.6...1.0.7
[1.0.6]: https://github.com/CaliforniaMountainSnake/php-utils/compare/1.0.5...1.0.6
[1.0.5]: https://github.com/CaliforniaMountainSnake/php-utils/compare/1.0.4...1.0.5
[1.0.4]: https://github.com/CaliforniaMountainSnake/php-utils/compare/1.0.3...1.0.4
[1.0.3]: https://github.com/CaliforniaMountainSnake/php-utils/compare/1.0.2...1.0.3
[1.0.2]: https://github.com/CaliforniaMountainSnake/php-utils/compare/1.0.1...1.0.2
[1.0.1]: https://github.com/CaliforniaMountainSnake/php-utils/compare/1.0.0...1.0.1
