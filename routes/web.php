<?php

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

Route::resource('blog', 'BlogController');
Route::get('/', 'BlogController@index');
Route::get('/contact', 'BlogController@index@contact');
Route::get('/policy', 'BlogController@policy');
Route::post('/sendMail/{status}', 'BlogController@sendMail');

Auth::routes();
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::resource('user', 'UserController');
Route::post('users/{user}/storeAvatar', 'UserController@storeAvatar');
Route::get('users/{user}/savedJobsIndex', ['as' => 'user.savedJobsIndex', 'uses' => 'UserController@savedJobsIndex']);