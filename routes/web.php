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

Route::get('/', 'HomeController@index');

// Auth
Auth::routes();
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

// User
Route::resource('user', 'UserController')->only(['edit', 'update']);
Route::get('/user/{user}/{name?}/animelist', 'UserController@animelist')->name('user.animelist');
Route::get('/user/{user}/{name?}/likes', 'UserController@likes')->name('user.likes');

// Anime
Route::post('/anime/search', 'AnimeController@search')->name('anime.search');
Route::post('/anime/{anime}/save', 'AnimeController@save')->name('anime.save');
Route::get('/anime/{anime}/{title?}', 'AnimeController@show')->name('anime.show');

// Savelist
Route::post('/user/{user}/savelist', 'SavelistController@store')->name('user.savelist.store');

// Others
Route::get('/character/{character}/{title?}', 'CharacterController@show')->name('character.show');
Route::get('/actor/{actor}/{title?}', 'ActorController@show')->name('actor.show');
Route::get('/staff/{staff}/{title?}', 'StaffController@show')->name('staff.show');

Route::group(['middleware' => 'admin'], function () {
	Route::get('/tempMethod', 'BotController@tempMethod');

	// Scrape Bangumi
	Route::get('/scrapeBangumi', 'BotController@scrapeBangumi');
	Route::get('/scrapeBangumiList', 'BotController@scrapeBangumiList');
	Route::get('/importBangumiAnimeSource', 'BotController@importBangumiAnimeSource');
	Route::get('/checkBangumiCompanies', 'BotController@checkBangumiCompanies');
	Route::get('/mergeBangumiCompanies', 'BotController@mergeBangumiCompanies');
	Route::get('/importBangumiCompanies', 'BotController@importBangumiCompanies');
	Route::get('/checkBangumiAnimesLinkable', 'BotController@checkBangumiAnimesLinkable');
	Route::get('/importBangumiAnimesLinkable', 'BotController@importBangumiAnimesLinkable');

	Route::get('/scrapeMalAnimes', 'BotController@scrapeMalAnimes');
	Route::get('/scrapeMalCompanies', 'BotController@scrapeMalCompanies');
	Route::get('/scrapeMalAnimeCompanies', 'BotController@scrapeMalAnimeCompanies');
	Route::get('/scrapeMalCompaniesAnimeables', 'BotController@scrapeMalCompaniesAnimeables');
	Route::get('/scrapeMalStaffs', 'BotController@scrapeMalStaffs');
	Route::get('/scrapeMalStaffRoles', 'BotController@scrapeMalStaffRoles');
});