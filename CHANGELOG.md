# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/) and this project adheres to [Semantic Versioning](https://semver.org/).

## Unreleased

## 1.0.1 - 2019-03-02

### Added
- Add issue templates to make issue submitting easier.

### Fixed
- Fix sidebar toggle button
- Fix issue #39. **Authorisation was broken**. 

## 1.0.0 - 2019-01-07

This is a **major update**, so it has changes that breaks compatibility with previous versions. 

> **IMPORTANT**: Application has been migrated to [Laravel 5.5](https://laravel.com/docs/5.5/).

### Added
- This `CHANGELOG` file to keep changes between versions.
- Docker support to be able to run this application in containers. **DO NOT USE THIS CONTAINERS IN PRODUCTION.**
- Added NPM module to deal with [AdminLTE](https://adminlte.io/) theme dependency.
- Added [Laravel Mix](https://github.com/JeffreyWay/laravel-mix) to build assets in this application.
- Added folder structure to begin application testing support.
- Added [Scrutinizer](https://scrutinizer-ci.com) code style checks and test coverage.
- Added [StyleCI](https://styleci.io/) to automatically merge any style fixes into the application repository. This allows us to focus on the content of the contribution and not the code style.
- Added [Laravel IDE Helper](https://github.com/barryvdh/laravel-ide-helper) to allow auto-completion on IDE.
- Added Laravel Dusk for testing.

### Changed
- CI has been migrated to [Travis CI COM](https://travis-ci.com/).
- Some fields has been renamed:
  - Model: Badge, `amount` is now `required_repetitions`.
  - Model: Level, `amount` is now `required_points`.
  - Pivot tables: `Badge-Users`, `amount` is now `repetitions`.
- Move DataTables to `public/vendor`.
- Composer versions to be compliant with [Laravel 5.5](https://laravel.com/docs/5.5/). 
- Travis is using PHP 7.2 image to do the builds.
- `README` has been updated adding information about the project, authors and _"how to run this application"_.
- Move al CSS and JS to `public/vendor`, so now it's part of this code.
- Update CSS and JS paths in `views` to use new `public/vendor` folder.
- Updated `LICENSE` to [GNU GPL v3.0 or later](https://spdx.org/licenses/GPL-3.0-or-later.html).

### Removed
- Removed [Homestead](https://laravel.com/docs/5.5/homestead) support in favor of docker containers. If you still want to use it, please follow [this instructions](https://laravel.com/docs/5.5/homestead).
- Removed cached item that were present in `.gitignore`.
- Removed `bower` as Javascript dependency manager.
