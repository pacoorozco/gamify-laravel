/**
 * Gamify - Gamification platform to implement any serious game mechanic.
 *
 * Copyright (c) 2018 by Paco Orozco <paco@pacoorozco.info>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * Some rights reserved. See LICENSE and AUTHORS files.
 *
 * @author             Paco Orozco <paco@pacoorozco.info>
 * @copyright          2018 Paco Orozco
 * @license            GPL-3.0 <http://spdx.org/licenses/GPL-3.0>
 *
 * @link               https://github.com/pacoorozco/gamify-laravel
 */

let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.copyDirectory('node_modules/admin-lte/dist', 'public/vendor/AdminLTE');
mix.copyDirectory('node_modules/admin-lte/plugins', 'public/vendor/AdminLTE/plugins');
mix.copyDirectory('node_modules/admin-lte/bower_components/bootstrap/dist', 'public/vendor/AdminLTE/bootstrap');
mix.copyDirectory('node_modules/admin-lte/bower_components/jquery/dist', 'public/vendor/AdminLTE/jquery');
mix.copyDirectory('node_modules/admin-lte/bower_components/datatables.net/js', 'public/vendor/AdminLTE/plugins/datatables');
mix.copyDirectory('node_modules/admin-lte/bower_components/datatables.net-bs/js', 'public/vendor/AdminLTE/plugins/datatables');
mix.copyDirectory('node_modules/admin-lte/bower_components/datatables.net-bs/css', 'public/vendor/AdminLTE/plugins/datatables');
mix.copyDirectory('node_modules/admin-lte/bower_components/select2/dist', 'public/vendor/AdminLTE/plugins/select2');
mix.copyDirectory('node_modules/jasny-bootstrap/dist', 'public/vendor/jasny-bootstrap');
mix.copyDirectory('node_modules/jquery-datetimepicker/build', 'public/vendor/jquery-datetimepicker');
mix.copy('node_modules/repeatable-fields/repeatable-fields.js', 'public/vendor/repeatable-fields/')
    .minify('public/vendor/repeatable-fields/repeatable-fields.js');



