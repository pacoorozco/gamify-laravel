<?php
/**
 * Gamify - Gamification platform to implement any serious game mechanic.
 *
 * Copyright (c) 2018 by Paco Orozco <paco@pacoorozco.info>
 *
 * This file is part of some open source application.
 *
 * Licensed under GNU General Public License 3.0.
 * Some rights reserved. See LICENSE, AUTHORS.
 *
 * @author             Paco Orozco <paco@pacoorozco.info>
 * @copyright          2018 Paco Orozco
 * @license            GPL-3.0 <http://spdx.org/licenses/GPL-3.0>
 *
 * @link               https://github.com/pacoorozco/gamify-laravel
 */

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* -------------------------------------------
 *  Route model binding.
 *
 *  @see RouteServiceProvider
 *  ------------------------------------------.
 */

/* ------------------------------------------
 * Authentication routes
 *
 * Routes to be authenticated
 *  ------------------------------------------
 */
Auth::routes();
// Use this one instead, if you want to disable registration
// Auth::routes(['register' => false]);

/* ------------------------------------------
 * Authenticated routes
 *
 * Routes that need to be authenticated
 *  ------------------------------------------
 */
Route::middleware(['auth'])->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('dashboard', 'HomeController@index')->name('dashboard');
    Route::get('rankings/', 'HomeController@data')->name('ranking');
        //->middleware('ajax');


    // Profiles
    Route::get('users/{username}', 'UserController@show')->name('profiles.show');
    Route::post('users/{username}', 'UserController@update')->name('profiles.update');

    Route::get('questions', 'QuestionController@index')->name('questions.index');
    Route::get('questions/{questionname}', 'QuestionController@show')->name('questions.show');
    Route::post('questions/{questionname}', 'QuestionController@answer')->name('questions.answer');
});

/* ------------------------------------------
 * Admin routes
 *
 * Routes that User needs to be administrator
 *  ------------------------------------------
 */
Route::prefix('admin')->middleware(['can:access-dashboard'])->name('admin.')->group(function () {
    Route::get('/', 'Admin\AdminDashboardController@index')->name('home');

    /* ------------------------------------------
     *  Users
     *  ------------------------------------------
     */
    // Datatables Ajax route.
    Route::get('users/data', 'Admin\AdminUserController@data')->name('users.data');

    // Our special delete confirmation route - uses the show/details view.
    Route::get('users/{users}/delete', 'Admin\AdminUserController@delete')->name('users.delete');

    // Pre-baked resource controller actions for index, create, store,
    // show, edit, update, destroy
    Route::resource('users', 'Admin\AdminUserController');

    /* ------------------------------------------
     *  Badges
     *  ------------------------------------------
     */
    // Datatables Ajax route.
    // NOTE: We must define this route first as it is more specific than
    // the default show resource route for /badges/{badge_id}
    Route::get('badges/data', 'Admin\AdminBadgeController@data')->name('badges.data');

    // Our special delete confirmation route - uses the show/details view.
    // NOTE: For model biding above to work - the plural parameter {badges} needs
    // to be used.
    Route::get('badges/{badges}/delete', 'Admin\AdminBadgeController@delete')->name('badges.delete');

    // Pre-baked resource controller actions for index, create, store,
    // show, edit, update, destroy
    Route::resource('badges', 'Admin\AdminBadgeController');

    /* ------------------------------------------
     *  Levels
     *  ------------------------------------------
     */
    // Datatables Ajax route.
    // NOTE: We must define this route first as it is more specific than
    // the default show resource route for /levels/{level_id}
    Route::get('levels/data', 'Admin\AdminLevelController@data')->name('levels.data');

    // Our special delete confirmation route - uses the show/details view.
    // NOTE: For model biding above to work - the plural parameter {badges} needs
    // to be used.
    Route::get('levels/{levels}/delete', 'Admin\AdminLevelController@delete')->name('levels.delete');

    // Pre-baked resource controller actions for index, create, store,
    // show, edit, update, destroy
    Route::resource('levels', 'Admin\AdminLevelController');

    /* ------------------------------------------
     *  Question management
     *  ------------------------------------------
     */

    // DataTables Ajax route.
    Route::get('questions/data', 'Admin\AdminQuestionController@data')->name('questions.data');

    // Our special delete confirmation route - uses the show/details view.
    // NOTE: For model biding above to work - the plural parameter {questions} needs
    // to be used.
    Route::get('questions/{questions}/delete', 'Admin\AdminQuestionController@delete')->name('questions.delete');

    // Nest routes to deal with actions
    Route::resource('questions.actions', 'Admin\AdminQuestionActionController',
        ['only' => ['create', 'store', 'destroy']]);

    // Pre-baked resource controller actions for index, create, store,
    // show, edit, update, destroy
    Route::resource('questions', 'Admin\AdminQuestionController');

    /* ------------------------------------------
     *  Give Experience / Badge
     *  ------------------------------------------
     */
    Route::get('rewards', 'Admin\AdminRewardController@index')->name('rewards.index');
    Route::post('rewards/experience',
        'Admin\AdminRewardController@giveExperience')->name('rewards.experience');
    Route::post('rewards/badge',
        'Admin\AdminRewardController@giveBadge')->name('rewards.badge');
});
