# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/) and this project adheres to [Semantic Versioning](https://semver.org/).

## Unreleased
### Added
- Possibility to obtain/assign badges based on events (question has been answered, user is logged in...) ([#161][i161])
- Possibility to schedule question publication. ([#152][i152])
- Presenter to `Question` model. Removes several partial views.
### Changed
- View on question edit form to make it simpler.
- Use `SocialProviders/okta` from packagist instead of GitHub.
- Upgrade requirements to PHP 7.4. 
- Add [docker-php-extension-installer](https://github.com/mlocati/docker-php-extension-installer) to install PHP extensions in docker.
### Fixed
- Badge images were not working on 'local' storage. ([#162][i162])
- Choices were not shown on validation errors. Dynamic Form fields is using [repeatable-fields](https://github.com/Rhyzz/repeatable-fields).
### Deprecated
- QuestionChoice's `correct` model attribute. Use `isCorrect()` and scope `correct()` to get the same functionality than before.
### Removed
- QuestionChoice's `correct` field has been removed from the model. This field was not used in favor of `score` field. The removal is **backward compatible** and you can still use `correct` attribute, that it's **deprecated**.

[i161]: https://github.com/pacoorozco/gamify-laravel/issues/161
[i162]: https://github.com/pacoorozco/gamify-laravel/issues/162
[i152]: https://github.com/pacoorozco/gamify-laravel/issues/152

## 2.4.1 - 2020-05-05
### Changed
- Small refactors to add more testability.
- Added more tests.

## 2.4.0 - 2020-04-26

### Added
- Two new widgets on admin dashboard: Latest published questions & latest registered users.
- Add user status to the profile information.
- User's metrics on 'Play' section. ([#132][i132])

### Changed
- Profile look and feel.
- Question forms are now responsible.
- Update dependencies. 

[i132]: https://github.com/pacoorozco/gamify-laravel/issues/132

## 2.3.2 - 2020-04-23

### Fixed
- Add link to each question. Make hidden questions linkable. ([#120][i120]) 
- Document properly 'Question name'. ([#124][i124])
- Hidden questions where not labelled. ([#122][i122])
- Bug when user was accessing to a published question. ([#121][i121])

[i120]: https://github.com/pacoorozco/gamify-laravel/issues/120
[i124]: https://github.com/pacoorozco/gamify-laravel/issues/124
[i122]: https://github.com/pacoorozco/gamify-laravel/issues/122
[i121]: https://github.com/pacoorozco/gamify-laravel/issues/121

## 2.3.1 - 2020-04-22

### Fixed
- Bug when creating a new user. ([#117][i117])

[i117]: https://github.com/pacoorozco/gamify-laravel/issues/117

## 2.3.0 - 2020-04-15

### Added
- Trusted proxies configuration through environment variables. See `config/trustedproxies.php`.
- `composer build` to create distributable files of the application.
### Fixed
- Remove API default route closure. It was buggy on production.

## 2.2.0 - 2020-04-10

### Added
- Horizontal scaling: session & cache on Redis and uploads on S3. ([#103][i103])
- Support to custom views under `resources/views/custom`. ([#102][i102])
- AWS S3 support for image uploads.
- Image management to Badges, Levels & Avatars. ([#92][i92], [#96][i96], [#99][i99]) 
### Fixed
- Fix some typos and broken links.
- Fix Admin dashboard render errors. ([#88][i88])
- Fix deletion of the default level. ([#33][i33])

[i103]: https://github.com/pacoorozco/gamify-laravel/issues/103
[i102]: https://github.com/pacoorozco/gamify-laravel/issues/102
[i99]: https://github.com/pacoorozco/gamify-laravel/issues/99
[i96]: https://github.com/pacoorozco/gamify-laravel/issues/96
[i92]: https://github.com/pacoorozco/gamify-laravel/issues/92
[i88]: https://github.com/pacoorozco/gamify-laravel/issues/88
[i33]: https://github.com/pacoorozco/gamify-laravel/issues/33

## 2.1.0 - 2020-03-27

### Added
- Social login links. Since this version it's possible to sign in using a third party service such as Facebook, Twitter or Github. ([#83][i83]) 
### Fixed
- `UserProfile` validation on updates.
- Wrong redirection after login.
- Defaults for `avatar` on `User` creation.

[i83]: https://github.com/pacoorozco/gamify-laravel/issues/83

## 2.0.0 - 2020-03-25

> **Note**: This application has been updated to use [Laravel 6.x](https://laravel.com/docs). It's still backwards compatibility, but database needs to be updated too. Some tests have been added but coverage is still very low.

### Added
- Ensure that users select at least one answer before proceeding. ([#79][i79]) 
- Two composer commands: `test` and `test-coverage`.

[i79]: https://github.com/pacoorozco/gamify-laravel/issues/79

### Changed
- **Important**: This application has been upgraded to [Laravel 6](https://laravel.com/docs). A lot of refactors has been done in order to adopt Laravel 6.x best practices. 
([#66][i66])
- Refactors to reduce the number of queries. 
- Change the editor from TinyMCE to [Bootstrap-wysihtml5](https://github.com/bootstrap-wysiwyg/bootstrap3-wysiwyg). ([#36][i36]) 
- Reputation is handled by Events. Added `experience` attribute to the User model. ([#72][i72], [#73][i73])
- Repository name has been changed to `gamify-laravel`, current URL is https://github.com/pacoorozco/gamify-laravel.
### Fixed
- Database migration / seed on fresh installation. ([#77][i77])
- `docker-compose build` was throwing an error, so docker was not working. ([#61][i61])

[i36]: https://github.com/pacoorozco/gamify-laravel/issues/36
[i61]: https://github.com/pacoorozco/gamify-laravel/issues/61
[i66]: https://github.com/pacoorozco/gamify-laravel/issues/66
[i72]: https://github.com/pacoorozco/gamify-laravel/issues/72
[i73]: https://github.com/pacoorozco/gamify-laravel/issues/73
[i77]: https://github.com/pacoorozco/gamify-laravel/issues/77

### Removed
- Dusk tests. They were not working properly.

## 1.0.3 - 2019-06-15

### Fixed
- Fix routing problem affecting answering questions (#45)

### Changed
- Change the URL verb from `/user/` to `/users/`, to make it coherent with the rest.

## 1.0.2 - 2019-06-15

### Fixed
- Fix default credentials documentation (#44)
- Bump version documentation updated

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
