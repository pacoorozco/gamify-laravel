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

use Gamify\Http\Controllers\Admin\AdminBadgeController;
use Gamify\Http\Controllers\Admin\AdminLevelController;
use Gamify\Http\Controllers\Admin\AdminQuestionActionController;
use Gamify\Http\Controllers\Admin\AdminQuestionController;
use Gamify\Http\Controllers\Admin\AdminRewardController;
use Gamify\Http\Controllers\Admin\AdminUserController;
use Gamify\Http\Controllers\Auth\ChangePasswordController;
use Gamify\Http\Controllers\Auth\LoginController;
use Gamify\Http\Controllers\Auth\SocialAccountController;
use Gamify\Http\Controllers\HomeController;
use Gamify\Http\Controllers\QuestionController;
use Gamify\Http\Controllers\UserController;
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
 *  ------------------------------------------
 */

/* ------------------------------------------
 * Authentication routes
 *
 * Routes to be authenticated
 *  ------------------------------------------
 */
// Login Routes...
Route::get('login',
    [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login',
    [LoginController::class, 'login']);

// Logout Routes...
Route::post('logout',
    [LoginController::class, 'logout'])->name('logout');

// Registration Routes...
/* DISABLED
Route::get('register',
    [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register',
    [RegisterController::class, 'register']);
*/

// Password Change Routes...
Route::get('password/change',
    [ChangePasswordController::class, 'showChangePasswordForm'])->name('password.change');
Route::post('password/change',
    [ChangePasswordController::class, 'change']);

// Password Reset Routes...
/* DISABLED
Route::get('password/reset',
    [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email',
    [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}',
    [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset',
    [ResetPasswordController::class, 'reset'])->name('password.update');
*/

// Password Confirmation Routes...
/* DISABLED
Route::get('password/confirm',
    [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
Route::post('password/confirm',
    [ConfirmPasswordController::class, 'confirm']);
*/

// Email Verification Routes...
/* DISABLED
Route::get('email/verify',
    [VerificationController::class, 'show'])->name('verification.notice');
Route::get('email/verify/{id}/{hash}',
    [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('email/resend',
    [VerificationController::class, 'resend'])->name('verification.resend');
*/

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
)->name('social.callback');

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
