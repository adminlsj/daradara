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

// Route::get('/jav', 'JavController@index')->name('jav.home');;
// Route::get('/jav/watch', 'JavController@watch')->name('jav.watch');
// Route::get('/jav/search', 'JavController@search')->name('jav.search');

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
	Route::get('/addCdn77Source', 'BotController@addCdn77Source');
	Route::get('/addCdn77SourceTemp', 'BotController@addCdn77SourceTemp');
	Route::get('/updateVod', 'BotController@updateVod');

	Route::get('/updateSpankbang', 'BotController@updateSpankbang');
	Route::get('/updateSpankbangErrors', 'BotController@updateSpankbangErrors');
	Route::get('/checkSpankbangOutdate', 'BotController@checkSpankbangOutdate');
	Route::get('/checkSpankbangOutdateEmergent', 'BotController@checkSpankbangOutdateEmergent');
	Route::get('/checkSpankbangUpdate', 'BotController@checkSpankbangUpdate');

	Route::get('/updateSpankbangSc', 'BotController@updateSpankbangSc');

	Route::get('/updateCdn77', 'BotController@updateCdn77');

	Route::get('/updateYoujizz', 'BotController@updateYoujizz');
	Route::get('/updateYoujizzDownloads', 'BotController@updateYoujizzDownloads');
	Route::get('/updateYoujizzDownloadsSc', 'BotController@updateYoujizzDownloadsSc');
	Route::get('/updateYoujizzErrors', 'BotController@updateYoujizzErrors');
	Route::get('/checkYoujizz', 'BotController@checkYoujizz');

	Route::get('/updateXvideos', 'BotController@updateXvideos');

	Route::get('/checkHetznerServers', 'BotController@checkHetznerServers');

	Route::get('/checkMotherless', 'BotController@checkMotherless');

	Route::get('/removeAddedTags', 'BotController@removeAddedTags')->name('tag.remove');;
	Route::get('/includeAddedTags', 'BotController@includeAddedTags')->name('tag.include');;

	Route::get('/uploadRule34', 'BotController@uploadRule34');
	Route::get('/importRule34', 'BotController@importRule34');
	Route::get('/translateRule34', 'BotController@translateRule34');
	Route::get('/updateRule34Sd', 'BotController@updateRule34Sd');

	Route::get('/uploadCosplayjav', 'BotController@uploadCosplayjav');
	Route::get('/translateCosplayjav', 'BotController@translateCosplayjav');

	Route::get('/uploadHtmlNhentai', 'BotController@uploadHtmlNhentai');
	Route::post('/uploadNhentai', 'BotController@uploadNhentai')->name('nhentai.upload');;
	Route::get('/translateNhentaiTag', 'BotController@translateNhentaiTag');

	Route::get('/renameComicImages', 'ComicController@renameComicImages');
	Route::get('/uploadComicFrom431', 'ComicController@uploadComicFrom431');

	Route::get('/uploadHscangku', 'BotController@uploadHscangku');
	Route::get('/updateEmptySd', 'BotController@updateEmptySd');
	Route::get('/updateWithMissav', 'BotController@updateWithMissav');
	Route::get('/updateWithJable', 'BotController@updateWithJable');
	Route::get('/updateWithAvbebe', 'BotController@updateWithAvbebe');
	Route::get('/uploadHscangkuShirouto', 'BotController@uploadHscangkuShirouto');
	Route::get('/downloadPosters', 'BotController@downloadPosters');
	Route::get('/updateBlankPosters', 'BotController@updateBlankPosters');
	Route::get('/updateMissavImgur', 'BotController@updateMissavImgur');
	Route::get('/imgurToJsdelivr', 'BotController@imgurToJsdelivr');
	Route::get('/updateShiroutoPlaylist', 'BotController@updateShiroutoPlaylist');
	Route::get('/downloadShiroutoImgur', 'BotController@downloadShiroutoImgur');
	Route::get('/shiroutoImgurToJsdelivr', 'BotController@shiroutoImgurToJsdelivr');

	Route::get('/downloadFromCdn77', 'BotController@downloadFromCdn77');
	Route::get('/downloadFromImgur', 'BotController@downloadFromImgur');
	Route::get('/downloadFromJsdelivr', 'BotController@downloadFromJsdelivr');
	Route::get('/imageToWnacg', 'BotController@imageToWnacg');
	Route::get('/imageToCdn77', 'BotController@imageToCdn77');

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
	Route::get('/checkAvbebe3D', 'BotController@checkAvbebe3D');
	Route::get('/downloadAvbebeM3u8', 'BotController@downloadAvbebeM3u8');
	Route::get('/downloadAvbebeMp4', 'BotController@downloadAvbebeMp4');

	Route::get('/editM3u8', 'BotController@editM3u8');
	Route::post('/updateM3u8', 'BotController@updateM3u8')->name('m3u8.update');;
	Route::get('/editCaptions', 'BotController@editCaptions');
	Route::post('/updateCaptions', 'BotController@updateCaptions')->name('bot.updateCaptions');
	Route::post('/checkCaptions', 'BotController@checkCaptions')->name('bot.checkCaptions');
});