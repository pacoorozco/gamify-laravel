<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/** ------------------------------------------
 *  Route model binding
 *  ------------------------------------------
 */
Route::bind('user', function ($value) {
    return \Gamify\User::where('username', $value)->first();
});

Route::bind('question', function ($value) {
    return \Gamify\Question::where('shortname', $value)->first();
});

Route::model('users', '\Gamify\User');
Route::model('badges', '\Gamify\Badge');
Route::model('levels', '\Gamify\Level');
Route::model('questions', '\Gamify\Question');
Route::model('choices', '\Gamify\QuestionChoice');
Route::model('actions', '\Gamify\QuestionAction');

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
//Route::get('auth/register', 'Auth\AuthController@getRegister');
//Route::post('auth/register', 'Auth\AuthController@postRegister');

/** ------------------------------------------
 * Authenticated routes
 *
 * Routes that need to be authenticated
 *  ------------------------------------------
 */
Route::group(['middleware' => 'auth'], function () {

    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
    Route::get('/dashboard', ['as' => 'dashboard', 'uses' => 'HomeController@index']);

    // Profiles
    Route::get('user', 'UserController@show');
    Route::get('user/{user}', ['as' => 'profile', 'uses' => 'UserController@show']);
    Route::post('user/{user}', 'UserController@update');

    Route::get('questions', ['as' => 'questions.index', 'uses' => 'QuestionController@index']);
    Route::get('questions/{question}', ['as' => 'questions.show', 'uses' => 'QuestionController@show']);
    Route::post('questions/{question}', ['as' => 'questions.store', 'uses' => 'QuestionController@store']);
});


/** ------------------------------------------
 * Admin routes
 *
 * Routes that User needs to be administrator
 *  ------------------------------------------
 */
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {

    Route::get('/', ['as' => 'admin-home', 'uses' => 'Admin\AdminQuestionController@index']);

    /** ------------------------------------------
     *  Users
     *  ------------------------------------------
     */
    // Datatables Ajax route.
    Route::get('users/data', ['as' => 'admin.users.data', 'uses' => 'Admin\AdminUserController@data']);

    // Our special delete confirmation route - uses the show/details view.
    Route::get('users/{users}/delete', ['as' => 'admin.users.delete', 'uses' => 'Admin\AdminUserController@delete']);

    // Pre-baked resource controller actions for index, create, store,
    // show, edit, update, destroy
    Route::resource('users', 'Admin\AdminUserController');

    /** ------------------------------------------
     *  Badges
     *  ------------------------------------------
     */
    // Datatables Ajax route.
    // NOTE: We must define this route first as it is more specific than
    // the default show resource route for /badges/{badge_id}
    Route::get('badges/data', ['as' => 'admin.badges.data', 'uses' => 'Admin\AdminBadgeController@data']);

    // Pre-baked resource controller actions for index, create, store,
    // show, edit, update, destroy
    Route::resource('badges', 'Admin\AdminBadgeController');

    // Our special delete confirmation route - uses the show/details view.
    // NOTE: For model biding above to work - the plural paramameter {badges} needs
    // to be used.
    Route::get('badges/{badges}/delete', ['as' => 'admin.badges.delete', 'uses' => 'Admin\AdminBadgeController@delete']);

    /** ------------------------------------------
     *  Levels
     *  ------------------------------------------
     */
    // Datatables Ajax route.
    // NOTE: We must define this route first as it is more specific than
    // the default show resource route for /levels/{level_id}
    Route::get('levels/data', ['as' => 'admin.levels.data', 'uses' => 'Admin\AdminLevelController@data']);

    // Pre-baked resource controller actions for index, create, store,
    // show, edit, update, destroy
    Route::resource('levels', 'Admin\AdminLevelController');

    // Our special delete confirmation route - uses the show/details view.
    // NOTE: For model biding above to work - the plural paramameter {badges} needs
    // to be used.
    Route::get('levels/{levels}/delete', ['as' => 'admin.levels.delete', 'uses' => 'Admin\AdminLevelController@delete']);

    /** ------------------------------------------
     *  Question management
     *  ------------------------------------------
     */

    // DataTables Ajax route.
    Route::get('questions/data', ['as' => 'admin.questions.data', 'uses' => 'Admin\AdminQuestionController@data']);

    // Our special delete confirmation route - uses the show/details view.
    Route::get('questions/{questions}/delete', ['as' => 'admin.questions.delete', 'uses' => 'Admin\AdminQuestionController@delete']);

    Route::resource('questions', 'Admin\AdminQuestionController');

    // Nest routes to deal with choices
    Route::resource('questions.choices', 'Admin\AdminQuestionChoiceController', ['except' => array('index', 'show')]);

    // Nest routes to deal with actions
    Route::resource('questions.actions', 'Admin\AdminQuestionActionController', ['only' => array('create', 'store', 'destroy')]);

});