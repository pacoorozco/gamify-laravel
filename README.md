# gamify - A gamification platform to implement any serious game mechanic

[![Testing with MySQL](https://github.com/pacoorozco/gamify-laravel/actions/workflows/run-tests.yml/badge.svg)](https://github.com/pacoorozco/gamify-laravel/actions/workflows/run-tests.yml)
[![codecov](https://codecov.io/gh/pacoorozco/gamify-laravel/branch/main/graph/badge.svg?token=ugLXCazFWC)](https://codecov.io/gh/pacoorozco/gamify-laravel)
[![License](https://img.shields.io/github/license/pacoorozco/gamify-laravel.svg)](LICENSE)
[![Laravel Version](https://img.shields.io/badge/Laravel-8.x-orange.svg)](https://laravel.com/docs/8.x)
[![GitHub release](https://img.shields.io/github/release/pacoorozco/gamify-laravel.svg?style=flat-square)](https://github.com/pacoorozco/gamify-laravel/releases)

## Presentation

**Game of Work**, _aka GoW!_, was a gamification platform created by **Emilio Ampudia** (eampudia _at_ gmail.com) and **Paco Orozco** (paco _at_ pacoorozco.info). 

We wanted to teach, learn and share some fun with our colleagues, so we created a game based on questions about our organization (process, services, teams...). This was the birth of **gamify**, a platform implementing a levels & badge game at [UPCnet](https://www.upcnet.es).

After that I've been developing it as a _pet project_. Nowadays, it's a [Laravel](https://laravel.com) application, based on the deprecated PHP5 [original version](https://github.com/pacoorozco/gamify).

As much as possible, I've tried to keep a clean code to work everywhere out of the box. You are not obliged to use my tools and you are free to change the code in order to use it at your own feeling.

## Disclaimer - It's ready for production, but no doc

> It's fully working and you can play with it, but it lacks of some documentation. I'm working in order to improve it, in my personal free time, so be patient or contact me in order to give me your help.

## Changelog

See [CHANGELOG](CHANGELOG.md) file in order to know what changes are implemented in every version.

## How to run gamify

This will create several [Docker](https://www.docker.com/) containers to implement all **gamify** needs. An application server, a web server and a database server.

Prior this installation, you **need to have installed** this software:

* [Docker](https://www.docker.com/)
* [Docker Compose](https://docs.docker.com/compose/)

1. Clone the repository locally

    ```bash
    $ git clone https://github.com/pacoorozco/gamify-laravel.git gamify
    $ cd gamify
    ```
1. Copy [`.env.example`](.env.example) to `.env`.

    > **NOTE**: You don't need to touch anything from this file. It works with default settings.

1. Start all containers with [Docker Compose](https://docs.docker.com/compose/)

    > **NOTE**: You **must** export the `DOCKER_APP_UID` variable if your user ID is different from `1000`. This will allow the docker to get permissions over your files.

    ```bash
    $ export DOCKER_APP_UID="$(id -u)"
    $ docker-compose build
    $ docker-compose up -d
    ```

1. Install dependencies with:

    ```bash
    $ docker-compose exec app composer install
    ```

1. Seed database in order to play with some data

    ```bash
    $ docker-compose exec app php artisan key:generate 
    $ docker-compose exec app php artisan migrate:fresh --seed
    ```
    
1. Go to `http://localhost`. Enjoy!

   > **NOTE**: Default credentials are `admin@example.com/admin` or `user@example.com/user`

## Reporting issues

If you have issues with **gamify**, you can report them with the [GitHub issues module](https://github.com/pacoorozco/gamify-laravel/issues).

## Contributing

Please see [CONTRIBUTE](CONTRIBUTE.md) for details.

## License

**gamify** is released as free software under [GNU GPL v3.0 or later](https://spdx.org/licenses/GPL-3.0-or-later.html)

## Authors

**gamify** was originally developed by Emilio Ampudia and [Paco Orozco](https://pacoorozco.info) as part of a game in UPCnet. Later, the [original version](https://github.com/pacoorozco/gamify) was migrated to Laravel.

See [contributor list](https://github.com/pacoorozco/gamify-laravel/graphs/contributors) for a complete list of contributors.

