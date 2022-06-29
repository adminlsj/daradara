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

Auth::routes();
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::post('/like', 'VideoController@like')->name('video.like');
Route::post('/save', 'VideoController@save')->name('video.save');
Route::post('/unsave', 'VideoController@unsave')->name('video.unsave');
Route::post('/addTags', 'VideoController@addTags')->name('video.addTags');
Route::post('/removeTags', 'VideoController@removeTags')->name('video.removeTags');

Route::post('/createComment', 'VideoController@createComment')->name('video.createComment');
Route::post('/replyComment', 'VideoController@replyComment')->name('video.replyComment');
Route::post('/deleteComment', 'VideoController@deleteComment')->name('video.deleteComment');
Route::post('/commentLike', 'VideoController@commentLike')->name('comment.like');
Route::get('/loadComment', 'VideoController@loadComment')->name('comment.loadComment');
Route::get('/loadReplies', 'VideoController@loadReplies')->name('comment.loadReplies');

Route::get('/playlists', 'UserController@indexPlaylist')->name('playlist.index');
Route::get('/playlist', 'UserController@showPlaylist')->name('playlist.show');
Route::post('/createPlaylist', 'UserController@createPlaylist')->name('playlist.create');
Route::post('/addPlaylist', 'UserController@addPlaylist')->name('playlist.add');
Route::put('/playlist/{playlist}', 'UserController@updatePlaylist')->name('playlist.update');
Route::post('/deletePlayitem', 'UserController@deletePlayitem')->name('playitem.delete');

Route::get('/about', 'HomeController@about');
Route::get('/contact', 'HomeController@contact');
Route::get('/terms', 'HomeController@terms');
Route::get('/policies', 'HomeController@policies');
Route::get('/copyright', 'HomeController@copyright');
Route::get('/2257', 'HomeController@p2257');

Route::get('/setVideoDuration', 'BotController@setVideoDuration');
Route::post('/getVideosData', 'BotController@getVideosData');
Route::post('/getWatchesData', 'BotController@getWatchesData');

Route::resource('user', 'UserController')->only(['edit', 'update']);
Route::get('/userReport', 'HomeController@userReport')->name('email.userReport');
Route::get('/user/{user}/upload', 'UserController@userEditUpload')->name('user.userEditUpload');
Route::post('/user/{user}/userUpdateUpload', 'UserController@userUpdateUpload')->name('user.userUpdateUpload');

Route::get('/watch', 'VideoController@watch')->name('video.watch');
Route::get('/download', 'VideoController@download')->name('video.download');
Route::get('/list', 'HomeController@list')->name('home.list');
Route::get('/search', ['as' => 'home.search', 'uses' => 'HomeController@search']);

Route::get('/previews/{preview}', 'PreviewController@show');

Route::get('/comics', 'ComicController@index')->name('comic.index');
Route::get('/comics/search', 'ComicController@search')->name('comic.search');
Route::get('/comics/{column}', 'ComicController@showTags')->name('comic.showTags');
Route::get('/comic/{comic}', 'ComicController@showCover')->name('comic.showCover');
Route::get('/comic/{comic}/{page}', 'ComicController@showContent')->name('comic.showContent');
Route::get('/{column}/{value}/{time?}', 'ComicController@searchTags')->name('comic.searchTags');
Route::get('/getRandomComic', 'ComicController@getRandomComic')->name('comic.random');

Route::group(['middleware' => 'admin'], function () {
	Route::get('/tempMethod', 'BotController@tempMethod');
	Route::get('/reset', 'BotController@reset');

	Route::get('/comments', 'BotController@comments');
	Route::get('/views', 'BotController@views');

	Route::get('/updateHembed', 'BotController@updateHembed');
	Route::get('/addHembedSource', 'BotController@addHembedSource');
	Route::get('/addBalancerSource', 'BotController@addBalancerSource');
	Route::get('/updateVod', 'BotController@updateVod');

	Route::get('/updateSpankbang', 'BotController@updateSpankbang');
	Route::get('/updateSpankbangErrors', 'BotController@updateSpankbangErrors');
	Route::get('/checkSpankbangOutdate', 'BotController@checkSpankbangOutdate');
	Route::get('/checkSpankbangOutdateEmergent', 'BotController@checkSpankbangOutdateEmergent');
	Route::get('/checkSpankbangUpdate', 'BotController@checkSpankbangUpdate');

	Route::get('/updateSpankbangSc', 'BotController@updateSpankbangSc');

	Route::get('/updateYoujizz', 'BotController@updateYoujizz');
	Route::get('/updateYoujizzDownloads', 'BotController@updateYoujizzDownloads');

	Route::get('/updateXvideos', 'BotController@updateXvideos');

	Route::get('/checkHetznerServers', 'BotController@checkHetznerServers');

	Route::get('/checkMotherless', 'BotController@checkMotherless');

	Route::get('/uploadRule34', 'BotController@uploadRule34');
	Route::get('/importRule34', 'BotController@importRule34');
	Route::get('/translateRule34', 'BotController@translateRule34');
	Route::get('/updateRule34Sd', 'BotController@updateRule34Sd');

	Route::get('/uploadCosplayjav', 'BotController@uploadCosplayjav');
	Route::get('/translateCosplayjav', 'BotController@translateCosplayjav');

	Route::get('/uploadHtmlNhentai', 'BotController@uploadHtmlNhentai');
	Route::post('/uploadNhentai', 'BotController@uploadNhentai')->name('nhentai.upload');;
	Route::get('/translateNhentaiTag', 'BotController@translateNhentaiTag');

	Route::get('/uploadComicFrom431', 'ComicController@uploadComicFrom431');

	Route::get('/clearLaravelLogs', 'BotController@clearLaravelLogs');

	Route::get('/checkAvbebeEporner', 'BotController@checkAvbebeEporner');
	Route::get('/checkAvbebeMotherless', 'BotController@checkAvbebeMotherless');
	Route::get('/checkAvbebeOdysee', 'BotController@checkAvbebeOdysee');
	Route::get('/checkAvbebeYoujizz', 'BotController@checkAvbebeYoujizz');
	Route::get('/checkAvbebeXvideos', 'BotController@checkAvbebeXvideos');
	Route::get('/checkAvbebeFembed', 'BotController@checkAvbebeFembed');
	Route::get('/checkAvbebeMp4', 'BotController@checkAvbebeMp4');
	Route::get('/checkAvbebeM3u8', 'BotController@checkAvbebeM3u8');
	Route::get('/checkAvbebeOthers', 'BotController@checkAvbebeOthers');
	Route::get('/downloadAvbebeM3u8', 'BotController@downloadAvbebeM3u8');

	Route::get('/editM3u8', 'BotController@editM3u8');
	Route::post('/updateM3u8', 'BotController@updateM3u8')->name('m3u8.update');;
	Route::get('/editCaptions', 'BotController@editCaptions');
	Route::post('/updateCaptions', 'BotController@updateCaptions')->name('bot.updateCaptions');
	Route::post('/checkCaptions', 'BotController@checkCaptions')->name('bot.checkCaptions');
});