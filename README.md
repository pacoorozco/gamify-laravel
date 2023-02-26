# gamify - A gamification platform to implement any serious game mechanic

[![Testing with MySQL](https://github.com/pacoorozco/gamify-laravel/actions/workflows/run-tests.yml/badge.svg)](https://github.com/pacoorozco/gamify-laravel/actions/workflows/run-tests.yml)
[![codecov](https://codecov.io/gh/pacoorozco/gamify-laravel/branch/main/graph/badge.svg?token=ugLXCazFWC)](https://codecov.io/gh/pacoorozco/gamify-laravel)
[![License](https://img.shields.io/github/license/pacoorozco/gamify-laravel.svg)](LICENSE)
[![Laravel Version](https://img.shields.io/badge/Laravel-10.x-orange.svg)](https://laravel.com/docs/10.x)
[![GitHub release](https://img.shields.io/github/release/pacoorozco/gamify-laravel.svg?style=flat-square)](https://github.com/pacoorozco/gamify-laravel/releases)

## Presentation

**Game of Work**, _aka GoW!_, was a gamification platform created by **Emilio Ampudia** (eampudia _at_ gmail.com) and **Paco Orozco** (paco _at_ pacoorozco.info). 

We wanted to teach, learn and share some fun with our colleagues, so we created a game based on questions about our organization (process, services, teams...). This was the birth of **gamify**, a platform implementing a levels & badge game at [UPCnet](https://www.upcnet.es).

As much as possible, I've tried to keep a clean code to work everywhere out of the box. You are not obliged to use my tools and you are free to change the code in order to use it at your own feeling.

## Disclaimer - It's ready for production, but no doc

> It's fully working and you can play with it, but it lacks of some documentation. I'm working in order to improve it, in my personal free time, so be patient or contact me in order to give me your help.

## Changelog

See [CHANGELOG](CHANGELOG.md) file in order to know what changes are implemented in every version.

## How to run gamify

[Laravel Sail](https://laravel.com/docs/10.x/sail) is a light-weight command-line interface for interacting with
Laravel's default Docker development environment. This will create several containers to implement the application needs. An
application server and a database server.

Prior to this installation, you **need to have installed** this software:

* [Docker](https://www.docker.com/)

1. Clone the repository locally

    ```
    git clone https://github.com/pacoorozco/gamify-laravel.git gamify
    cd gamify
    ```

2. Copy [`.env.example`](.env.example) to `.env`.

   > **NOTE**: You don't need to touch anything from this file. It works with default settings.

3. Install PHP dependencies with:

   > **NOTE**: You don't need to install neither _PHP_ nor _Composer_, we are going to use
   a [Composer image](https://hub.docker.com/_/composer/) instead.

    ```
    docker run --rm \                  
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php80-composer:latest \
    composer install --ignore-platform-reqs
    ```

4. Start all containers with the `sail` command.

    ```
    ./vendor/bin/sail up -d
    ```

5. Seed database in order to play with some data

    ```
    php artisan key:generate 
    php artisan migrate --seed
    ```

   **If you are using Sail, you should execute those commands using Sail**:

    ```
   # Running Artisan commands within Laravel Sail...
   sail artisan key:generate 
   sail artisan migrate --seed
    ```

6. Point your browser to `http://localhost`. Enjoy!

   > **NOTE**: Default credentials are `admin@domain.local/admin` or `player@domain.local/player`

## Reporting issues

If you have issues with **gamify**, you can report them with the [GitHub issues module](https://github.com/pacoorozco/gamify-laravel/issues).

## Contributing

Please see [CONTRIBUTE](CONTRIBUTE.md) for details.

## License

**gamify** is released as free software under [GNU GPL v3.0 or later](https://spdx.org/licenses/GPL-3.0-or-later.html)

## Authors

**gamify** was originally developed by Emilio Ampudia and [Paco Orozco](https://pacoorozco.info) as part of a game in UPCnet. Later, the [original version](https://github.com/pacoorozco/gamify) was migrated to Laravel.

See [contributor list](https://github.com/pacoorozco/gamify-laravel/graphs/contributors) for a complete list of contributors.

