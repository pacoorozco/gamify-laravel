# gamify - A gamification platform to implement any serious game mechanic

[![Build Status](https://travis-ci.org/pacoorozco/gamify-l5.svg)](https://travis-ci.org/pacoorozco/gamify-l5)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/pacoorozco/gamify-l5/badges/quality-score.png)](https://scrutinizer-ci.com/g/pacoorozco/gamify-l5)
[![Code Coverage](https://scrutinizer-ci.com/g/pacoorozco/gamify-l5/badges/coverage.png)](https://scrutinizer-ci.com/g/pacoorozco/gamify-l5)
[![License](https://img.shields.io/github/license/pacoorozco/gamify-l5.svg)](https://github.com/pacoorozco/gamify-l5/blob/master/LICENSE)
[![Laravel Version](https://img.shields.io/badge/Laravel-5.2-orange.svg)](https://laravel.com/docs/5.2)
[![GitHub release](https://img.shields.io/github/release/pacoorozco/probind.svg?style=flat-square)](https://github.com/pacoorozco/probind/releases)

## Presentation

**Game of Work**, _aka GoW!_, was a gamification platform created by **Emilio Ampudia** (eampudia _at_ gmail.com) and **Paco Orozco** (paco _at_ pacoorozco.info). 

We wanted to teach, learn and share some fun with our colleagues, so we created a game based on questions about our organization (process, services, teams...). This was the birth of **gamify**, a platform implementing a levels & badge game at [UPCnet](https://www.upcnet.es).

After that I've been developing it as a _pet project_. Nowadays, it's a [Laravel](https://laravel.com) application, based on the deprecated PHP5 [original version](https://github.com/pacoorozco/gamify).

As much as possible, I've tried to keep a clean code to work everywhere out of the box. You are not obliged to use my tools and you are free to change the code in order to use it at your own feeling.

## Disclaimer - It's ready for production, but no doc

> It's fully working and you can play with it, but it lacks of some documentation. I'm working in order to improve it, in my personal free time, so be patient or contact me in order to give me your help.

## Changelog

See [CHANGELOG](https://github.com/pacoorozco/gamify-l5/blob/master/CHANGELOG) file in order to know what changes are implemented in every version.

## How to run gamify

There are two methods in order to run **gamify**:

* [Method 1](#docker-method): Using [Docker](https://www.docker.com/) containers. **This is the quickest way**
* [Method 2](#local-server-method): Using PHP you can serve the code locally.

### Docker method

This will create several [Docker](https://www.docker.com/) containers to implement all **gamify** needs. An application server, a web server and a database server.

Prior this installation, you **need to have installed** this software:

* [Docker](https://www.docker.com/)

1. Clone the repository locally

    ```bash
    $ git clone https://github.com/pacoorozco/gamify-l5.git gamify
    $ cd gamify
    ```
1. Install PHP dependencies with:

    > **NOTE**: You don't need to install neither _PHP_ nor _Composer_, we are going to use a [Composer image](https://hub.docker.com/_/composer/) instead.

    ```bash
    $ docker run --rm --interactive --tty \
          --volume $PWD:/app \
          --user $(id -u):$(id -g) \
          composer install
    ```

1. Copy [`.env.example`](https://github.com/pacoorozco/gamify-l5/blob/master/.env.example) to `.env`.

    > **NOTE**: You don't need to touch anything from this file. It works with default settings.

1. Start all containers with [Docker Compose](https://docs.docker.com/compose/)

    ```bash
    $ docker-compose build
    $ docker-compose up -d
    ```

1. Seed database in order to play with some data

    ```bash
    $ docker-compose exec app php artisan key:generate 
    $ docker-compose exec app php artisan migrate --seed
    ```
    
1. Go to `http://localhost`. Enjoy!

   > **NOTE**: Default credentials are `admin/admin` or `user/user`.

### Local server method

This will use PHP to serve this application locally.

Prior this installation, you **need to have installed** this software:

* PHP 7.1+ installed locally
* [Composer](https://getcomposer.org/download/)
* PHP extensions/modules installed: `php-mbstring php-xml`

1. Clone the repository locally

    ```bash
    $ git clone https://github.com/pacoorozco/gamify-l5.git gamify
    ```

1. [Install dependencies](https://getcomposer.org/doc/01-basic-usage.md#installing-dependencies) with: 

    ```bash
    $ cd gamify
    $ composer install
    ```

1. Copy [`.env.example`](https://github.com/pacoorozco/gamify-l5/blob/master/.env.example) to `.env` and modify its contents to reflect your local environment.
1. [Run database migrations](http://laravel.com/docs). If you want to include seed data, add a `--seed` flag.

    ```bash
    php artisan migrate --env=local
    ```
    
1. Configure a web server, such as the [built-in PHP web server](http://php.net/manual/en/features.commandline.webserver.php), to use the `public` directory as the document root.

	```bash
    php -S localhost:8080 -t public
    ```
    
1. Go to `http://localhost:8000`. Enjoy!

   > **NOTE**: Default credentials are `admin/admin` or `user/user`.

## Reporting issues

If you have issues with **gamify**, you can report them with the [GitHub issues module](https://github.com/pacoorozco/gamify-l5/issues).

## Contributing

Please see [CONTRIBUTE](https://github.com/pacoorozco/gamify-l5/blob/master/CONTRIBUTE.md) for details.

## License

**gamify** is released as free software under [GPLv2](http://www.gnu.org/licenses/gpl-2.0.html)

## Authors

**gamify** was originally developed by Emilio Ampudia and [Paco Orozco](https://pacoorozco.info) as part of a game in UPCnet. Later, the [original version](https://github.com/pacoorozco/gamify) was migrated to Laravel.

See [contributor list](https://github.com/pacoorozco/gamify-l5/graphs/contributors) for a complete list of contributors.

