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

// AdminLTE v3 and all the useful plugins
mix.copy('node_modules/admin-lte/dist/js/adminlte.*', 'public/vendor/AdminLTE/js');
mix.copy('node_modules/admin-lte/dist/css', 'public/vendor/AdminLTE/css');

// Bootstrap 4 & JQuery
mix.copyDirectory('node_modules/admin-lte/plugins/bootstrap', 'public/vendor/AdminLTE/bootstrap');
mix.copyDirectory('node_modules/admin-lte/plugins/jquery', 'public/vendor/AdminLTE/jquery');

// summernote
mix.copy('node_modules/admin-lte/plugins/summernote/*.css', 'public/vendor/AdminLTE/plugins/summernote');
mix.copy('node_modules/admin-lte/plugins/summernote/*.js', 'public/vendor/AdminLTE/plugins/summernote');
mix.copyDirectory('node_modules/admin-lte/plugins/summernote/font', 'public/vendor/AdminLTE/plugins/summernote/font');
mix.copyDirectory('node_modules/admin-lte/plugins/summernote/lang', 'public/vendor/AdminLTE/plugins/summernote/lang');

// Select2
mix.copyDirectory('node_modules/admin-lte/plugins/select2', 'public/vendor/AdminLTE/plugins/select2');
mix.copy('node_modules/admin-lte/plugins/select2-bootstrap4-theme/*.css', 'public/vendor/AdminLTE/plugins/select2');

// Datatables
mix.copyDirectory('node_modules/admin-lte/plugins/datatables', 'public/vendor/AdminLTE/plugins/datatables');
mix.copyDirectory('node_modules/admin-lte/plugins/datatables-bs4', 'public/vendor/AdminLTE/plugins/datatables-bs4');
mix.copyDirectory('node_modules/admin-lte/plugins/datatables-responsive', 'public/vendor/AdminLTE/plugins/datatables-responsive');

// Date Range Picker
mix.copy('node_modules/admin-lte/plugins/daterangepicker/daterangepicker.*', 'public/vendor/AdminLTE/plugins/daterangepicker');

// Bootstrap Icons
mix.copyDirectory('node_modules/bootstrap-icons/font', 'public/vendor/bootstrap-icons');

// Jasny Bootstrap - File uploads
mix.copyDirectory('node_modules/jasny-bootstrap/dist', 'public/vendor/jasny-bootstrap');

// Repeatable Fields
mix.copy('node_modules/repeatable-fields/repeatable-fields.js', 'public/vendor/repeatable-fields')
    .minify('public/vendor/repeatable-fields/repeatable-fields.js');

// App JS
mix.js('resources/js/app.js', 'public/js');
