<?php
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

use Gamify\Http\Controllers\Account\ChangePasswordController;
use Gamify\Http\Controllers\Account\ProfileController;
use Gamify\Http\Controllers\Admin\AdminBadgeController;
use Gamify\Http\Controllers\Admin\AdminBadgeDataTablesController;
use Gamify\Http\Controllers\Admin\AdminLevelController;
use Gamify\Http\Controllers\Admin\AdminLevelDataTablesController;
use Gamify\Http\Controllers\Admin\AdminQuestionActionController;
use Gamify\Http\Controllers\Admin\AdminQuestionController;
use Gamify\Http\Controllers\Admin\AdminRewardController;
use Gamify\Http\Controllers\Admin\AdminUserController;
use Gamify\Http\Controllers\Admin\AdminUserDataTablesController;
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

Route::prefix('account')->middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('profiles.show', ['username' => Auth::user()->username]);
    })->name('account.index');

    Route::get('password', [ChangePasswordController::class, 'index'])->name('account.password.index');
    Route::post('password', [ChangePasswordController::class, 'update'])->name('account.password.update');

    Route::get('edit', [ProfileController::class, 'edit'])->name('account.profile.edit');
    Route::put('edit', [ProfileController::class, 'update'])->name('account.profile.update');
});

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

    Route::put(
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
        ->get('users/data', AdminUserDataTablesController::class)
        ->name('users.data');

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
        ->get('badges/data', AdminBadgeDataTablesController::class)
        ->name('badges.data');

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
        ->get('levels/data', AdminLevelDataTablesController::class)
        ->name('levels.data');

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
        [AdminRewardController::class, 'index']
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
