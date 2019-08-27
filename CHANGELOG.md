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