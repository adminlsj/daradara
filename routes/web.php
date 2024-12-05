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
Route::get('/user/{user}/{name?}/animelist/{savelist}/{title?}', 'UserController@animelistShow')->name('user.animelist.show');
Route::get('/user/{user}/{name?}/likes', 'UserController@likes')->name('user.likes');

// Anime
Route::get('/anime/search', 'AnimeController@search')->name('anime.search');
Route::post('/anime/{anime}/save', 'AnimeController@save')->name('anime.save');
Route::get('/anime/{anime}/{title?}', 'AnimeController@show')->name('anime.show');
Route::get('/anime/{anime}/{title?}/episodes', 'AnimeController@show')->name('anime.episodes');
Route::get('/anime/{anime}/{title?}/characters', 'AnimeController@show')->name('anime.characters');
Route::get('/anime/{anime}/{title?}/staff', 'AnimeController@show')->name('anime.staff');
Route::get('/anime/{anime}/{title?}/comments', 'AnimeController@show')->name('anime.comments');

// Savelist
Route::post('/user/{user}/savelist', 'SavelistController@store')->name('user.savelist.store');
Route::put('/user/{user}/savelist/{savelist}', 'SavelistController@update')->name('user.savelist.update');
Route::delete('/user/{user}/savelist/{savelist}', 'SavelistController@destroy')->name('user.savelist.destroy');

// Others
Route::get('/character/{character}/{title?}', 'CharacterController@show')->name('character.show');
// Route::get('/actor/{actor}/{title?}', 'ActorController@show')->name('actor.show');
Route::get('/staff/{staff}/{title?}', 'StaffController@show')->name('staff.show');
Route::get('/company/{company}/{title?}', 'CompanyController@show')->name('company.show');

Route::group(['middleware' => 'admin'], function () {
	Route::get('/tempMethod', 'BotController@tempMethod');

	// Scrape Bangumi
	Route::get('/scrapeBangumi', 'BotController@scrapeBangumi');
	Route::get('/scrapeBangumiList', 'BotController@scrapeBangumiList');
	Route::get('/scrapeBangumiEpisodes', 'BotController@scrapeBangumiEpisodes');
	Route::get('/importBangumiAnimeSource', 'BotController@importBangumiAnimeSource');
	Route::get('/checkBangumiCompanies', 'BotController@checkBangumiCompanies');
	Route::get('/mergeBangumiCompanies', 'BotController@mergeBangumiCompanies');
	Route::get('/importBangumiCompanies', 'BotController@importBangumiCompanies');
	Route::get('/checkBangumiAnimesLinkable', 'BotController@checkBangumiAnimesLinkable');
	Route::get('/importBangumiAnimesLinkable', 'BotController@importBangumiAnimesLinkable');

	Route::get('/scrapeMalAnimes', 'BotController@scrapeMalAnimes');
	Route::get('/scrapeMalRelatedAnimes', 'BotController@scrapeMalRelatedAnimes');
	Route::get('/scrapeMalEpisodes', 'BotController@scrapeMalEpisodes');
	Route::get('/scrapeMalCompanies', 'BotController@scrapeMalCompanies');
	Route::get('/scrapeMalAnimeCompanies', 'BotController@scrapeMalAnimeCompanies');
	Route::get('/scrapeMalCompaniesAnimeables', 'BotController@scrapeMalCompaniesAnimeables');
	Route::get('/scrapeMalStaffs', 'BotController@scrapeMalStaffs');
	Route::get('/scrapeMalStaffRoles', 'BotController@scrapeMalStaffRoles');
});