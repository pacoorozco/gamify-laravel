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

use Gamify\Http\Controllers\Admin\AdminBadgeController;
use Gamify\Http\Controllers\Admin\AdminLevelController;
use Gamify\Http\Controllers\Admin\AdminQuestionActionController;
use Gamify\Http\Controllers\Admin\AdminQuestionController;
use Gamify\Http\Controllers\Admin\AdminRewardController;
use Gamify\Http\Controllers\Admin\AdminUserController;
use Gamify\Http\Controllers\Auth\SocialAccountController;
use Gamify\Http\Controllers\HomeController;
use Gamify\Http\Controllers\QuestionController;
use Gamify\Http\Controllers\UserController;
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
/*Auth::routes([
    'register' => false,  // User registration
    'verify' => false, // E-mail verification
    'reset' => false, // Reset password
]);*/

/* ------------------------------------------
 * Social authentication routes
 *  ------------------------------------------
 */
Route::get(
    'login/{provider}',
    [SocialAccountController::class, 'redirectToProvider']
)->name('social.login');
Route::get(
    'login/{provider}/callback',
    [SocialAccountController::class, 'handleProviderCallback']
)->name('social.callback');;

/* ------------------------------------------
 * Authenticated routes
 *
 * Routes that need to be authenticated
 *  ------------------------------------------
 */
Route::middleware(['auth'])->group(function () {
    Route::get(
        '/',
        [HomeController::class, 'index']
    )->name('home');
    Route::get(
        'dashboard',
        [HomeController::class, 'index']
    )->name('dashboard');

    // Profiles
    Route::get(
        'users/{username}',
        [UserController::class, 'show']
    )->name('profiles.show');
    Route::post(
        'users/{username}',
        [UserController::class, 'update']
    )->name('profiles.update');

    Route::get(
        'questions',
        [QuestionController::class, 'index']
    )->name('questions.index');
    Route::get(
        'questions/{questionname}',
        [QuestionController::class, 'show']
    )->name('questions.show');
    Route::post(
        'questions/{questionname}',
        [QuestionController::class, 'answer']
    )->name('questions.answer');
});

/* ------------------------------------------
 * Admin routes
 *
 * Routes that User needs to be administrator
 *  ------------------------------------------
 */
Route::middleware(['can:access-dashboard'])->prefix('admin')->name('admin.')->group(function () {
    Route::get(
        '/',
        [\Gamify\Http\Controllers\Admin\AdminDashboardController::class, 'index']
    )->name('home');

    /* ------------------------------------------
     *  Users
     *  ------------------------------------------
     */
    // Datatables Ajax route.
    Route::middleware(['only.ajax'])
        ->get(
            'users/data',
            [AdminUserController::class, 'data']
        )->name('users.data');

    // Our special delete confirmation route - uses the show/details view.
    Route::get(
        'users/{users}/delete',
        [AdminUserController::class, 'delete']
    )->name('users.delete');

    // Pre-baked resource controller actions for index, create, store,
    // show, edit, update, destroy
    Route::resource('users', AdminUserController::class);

    /* ------------------------------------------
     *  Badges
     *  ------------------------------------------
     */
    // Datatables Ajax route.
    // NOTE: We must define this route first as it is more specific than
    // the default show resource route for /badges/{badge_id}
    Route::middleware(['only.ajax'])
        ->get(
            'badges/data',
            [AdminBadgeController::class, 'data']
        )->name('badges.data');

    // Our special delete confirmation route - uses the show/details view.
    // NOTE: For model biding above to work - the plural parameter {badges} needs
    // to be used.
    Route::get(
        'badges/{badges}/delete',
        [AdminBadgeController::class, 'delete']
    )->name('badges.delete');

    // Pre-baked resource controller actions for index, create, store,
    // show, edit, update, destroy
    Route::resource('badges', AdminBadgeController::class);

    /* ------------------------------------------
     *  Levels
     *  ------------------------------------------
     */
    // Datatables Ajax route.
    // NOTE: We must define this route first as it is more specific than
    // the default show resource route for /levels/{level_id}
    Route::middleware(['only.ajax'])
        ->get(
            'levels/data',
            [AdminLevelController::class, 'data']
        )->name('levels.data');

    // Our special delete confirmation route - uses the show/details view.
    // NOTE: For model biding above to work - the plural parameter {badges} needs
    // to be used.
    Route::get(
        'levels/{levels}/delete',
        [AdminLevelController::class, 'delete']
    )->name('levels.delete');

    // Pre-baked resource controller actions for index, create, store,
    // show, edit, update, destroy
    Route::resource('levels', AdminLevelController::class);

    /* ------------------------------------------
     *  Question management
     *  ------------------------------------------
     */

    // DataTables Ajax route.
    Route::middleware(['only.ajax'])
        ->get(
            'questions/data',
            [AdminQuestionController::class, 'data']
        )->name('questions.data');

    // Our special delete confirmation route - uses the show/details view.
    // NOTE: For model biding above to work - the plural parameter {questions} needs
    // to be used.
    Route::get(
        'questions/{questions}/delete',
        [AdminQuestionController::class, 'delete']
    )->name('questions.delete');

    // Nest routes to deal with actions
    Route::resource('questions.actions', AdminQuestionActionController::class)
        ->only([
            'create', 'store', 'destroy',
        ]);

    // Pre-baked resource controller actions for index, create, store,
    // show, edit, update, destroy
    Route::resource('questions', AdminQuestionController::class);

    /* ------------------------------------------
     *  Give Experience / Badge
     *  ------------------------------------------
     */
    Route::get(
        'rewards',
        [AdminRewardController::class, '@index']
    )->name('rewards.index');
    Route::post(
        'rewards/experience',
        [AdminRewardController::class, 'giveExperience']
    )->name('rewards.experience');
    Route::post(
        'rewards/badge',
        [AdminRewardController::class, 'giveBadge']
    )->name('rewards.badge');
});
