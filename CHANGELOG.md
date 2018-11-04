# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/) and this project adheres to [Semantic Versioning](https://semver.org/).

## Unreleased
### Added
- This `CHANGELOG` file to keep changes between versions.
- Docker support to be able to run this application in containers. **DO NOT USE THIS CONTAINERS IN PRODUCTION.**

### Changed
- Application has been migrated to [Laravel 5.2](https://laravel.com/docs/5.2/).
- Travis is using PHP 7.1 image to do the builds.
- `README` has been updated adding information about the project, authors and "how to run this application".

### Removed
- Removed [Homestead](https://laravel.com/docs/5.2/homestead) support in favor of docker containers. If you still want to use it, please follow [this instructions](https://laravel.com/docs/5.2/homestead).
