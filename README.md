# gamify - A gamification platform to implement any serious game mechanic. The core of Game of Work!

## Presentation

gamify is the core of [Game of Work](https://gow.upcnet.es) application. It's a gamification platform created by **Emilio Ampudia** (eampudia _at_ gmail.com) and **Paco Orozco** (paco _at_ pacoorozco.info). 

This project was born while we were creating **Game of Work**, _aka GoW!_, a gamification platform to implement a levels & badge game at [UPCnet](http://www.upcnet.es). We wanted to teach, learn and share some fun with our colleagues, so we created a game work based on questions about our organization (process, services, teams...).

It's a Laravel 5 application, based on the PHP5 & mysql original [gamify](https://github.com/pacoorozco/gamify) version.

As much as possible, we have tried to keep a clean code to work everywhere out of the box. You are not obliged to use our tools and are free to change the code in order to use it at your own feeling.

## Disclaimer

This is not, yet, **production code**. I'm working in order to finish ASAP, in my personal free time, so be patient or contact me in order to give me your help. If you need a production ready app see [gamify](https://github.com/pacoorozco/gamify).

## Changelog

See [CHANGELOG](https://github.com/pacoorozco/gamify-l5/blob/master/CHANGELOG) file in order to know what changes are implemented in every version.

## Requirements

* PHP >= 5.5.9
* PHP [mcrypt extension](http://php.net/manual/en/book.mcrypt.php)
* A [supported relational database](http://laravel.com/docs/5.0/database#introduction) and corresponding PHP extension
* [Composer](https://getcomposer.org/download/)

## Installation

1. Clone the repository locally

    ```bash
    $ git clone https://github.com/pacoorozco/gamify-l5.git gamify
    ```

2. [Install dependencies](https://getcomposer.org/doc/01-basic-usage.md#installing-dependencies) with: 

    ```bash
    $ cd gamify
    $ composer install
    ```

3. Copy [`.env.example`](https://github.com/pacoorozco/gamify-l5/blob/master/.env.example) to `.env` and modify its contents to reflect your local environment.
4. [Run database migrations](http://laravel.com/docs/5.0/migrations#running-migrations). If you want to include seed data, add a `--seed` flag.

    ```bash
    php artisan migrate --env=local
    ```
5. Configure a web server, such as the [built-in PHP web server](http://php.net/manual/en/features.commandline.webserver.php), to use the `public` directory as the document root.

	```bash
    php -S localhost:8080 -t public
    ```

Then enjoy !

## Reporting issues

If you have issues with **gamify**, you can report them with the [GitHub issues module](https://github.com/pacoorozco/gamify/issues).

Please remember to provide as much information as you can.

## License

**gamify** is released as free software under [GPLv2](http://www.gnu.org/licenses/gpl-2.0.html)

## Authors

* Emilio Ampudia (eampudia _at_ gmail.com)
* [Paco Orozco](http://pacoorozco.info) (paco _at_ pacoorozco.info)
