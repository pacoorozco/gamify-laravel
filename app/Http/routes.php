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
Route::bind('user', function($value) {
    return \Gamify\User::where('username', $value)->first();
});
Route::model('users', 'User');
Route::model('badges', 'Badge');
Route::model('levels', 'Level');
Route::model('questions', 'Question');
Route::model('choices', 'QuestionChoice');

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
Route::group(['middleware' => 'auth'], function() {

    Route::get('/',  ['as' => 'home', 'uses' => 'HomeController@showWelcome']);
    Route::get('/home',  ['as' => 'home', 'uses' => 'HomeController@showWelcome']);

    // Profiles
    Route::get('user',                  'UserController@show');
    Route::get('user/{user}', ['as' => 'profile', 'uses' => 'UserController@show']);
    Route::post('user/{user}',         'UserController@update');

    Route::get('question', 'QuestionController@index');
});


/** ------------------------------------------
 * Admin routes
 *
 * Routes that User needs to be administrator
 *  ------------------------------------------
 */
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {

    Route::get('/', ['as' => 'admin-home', 'uses' => 'AdminQuestionController@index']);

    /** ------------------------------------------
     *  Users
     *  ------------------------------------------
     */
    // Datatables Ajax route.
    Route::get('users/data', ['as' => 'admin.users.data', 'uses' => 'AdminUserController@data']);

    // Our special delete confirmation route - uses the show/details view.
    Route::get('users/{users}/delete', ['as' => 'admin.users.delete', 'uses' => 'AdminUserController@delete']);

    // Pre-baked resource controller actions for index, create, store,
    // show, edit, update, destroy
    Route::resource('users',                'AdminUserController');

    /** ------------------------------------------
     *  Badges
     *  ------------------------------------------
     */
    // Datatables Ajax route.
    // NOTE: We must define this route first as it is more specific than
    // the default show resource route for /badges/{badge_id}
    Route::get('badges/data', ['as' => 'admin.badges.data', 'uses' => 'AdminBadgeController@data']);

    // Pre-baked resource controller actions for index, create, store,
    // show, edit, update, destroy
    Route::resource('badges',                'AdminBadgeController');

    // Our special delete confirmation route - uses the show/details view.
    // NOTE: For model biding above to work - the plural paramameter {badges} needs
    // to be used.
    Route::get('badges/{badges}/delete', ['as' => 'admin.badges.delete', 'uses' => 'AdminBadgeController@delete']);

    /** ------------------------------------------
     *  Levels
     *  ------------------------------------------
     */
    // Datatables Ajax route.
    // NOTE: We must define this route first as it is more specific than
    // the default show resource route for /levels/{level_id}
    Route::get('levels/data', ['as' => 'admin.levels.data', 'uses' => 'AdminLevelController@data']);

    // Pre-baked resource controller actions for index, create, store,
    // show, edit, update, destroy
    Route::resource('levels',                'AdminLevelController');

    // Our special delete confirmation route - uses the show/details view.
    // NOTE: For model biding above to work - the plural paramameter {badges} needs
    // to be used.
    Route::get('levels/{levels}/delete', ['as' => 'admin.levels.delete', 'uses' => 'AdminLevelController@delete']);

    /** ------------------------------------------
     *  Question management
     *  ------------------------------------------
     */

    // DataTables Ajax route.
    Route::get('questions/data', ['as' => 'admin.questions.data', 'uses' => 'AdminQuestionController@data']);

    // Our special delete confirmation route - uses the show/details view.
    Route::get('questions/{questions}/delete', ['as' => 'admin.questions.delete', 'uses' => 'AdminQuestionController@delete']);

    Route::resource('questions',         'AdminQuestionController');

    // Nest routes to deal with choices
    Route::resource('questions.choice', 'AdminQuestionChoicesController', ['except' => array('index', 'show')]);

});