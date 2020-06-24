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

Route::resource('blog', 'BlogController');

Auth::routes();
Route::resource('user', 'UserController');
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
Route::post('users/{user}/storeAvatar', 'UserController@storeAvatar');

Route::get('/tempMethod', 'HomeController@tempMethod');
Route::get('/youtubeBot', 'HomeController@youtubeBot');
Route::get('/updateVideos', 'HomeController@updateVideos');
Route::get('/uploadPendingVideos', 'HomeController@uploadPendingVideos');
Route::get('/createDummyVideos', 'HomeController@createDummyVideos');
Route::get('/youtubePre', 'HomeController@youtubePre');
Route::get('/editSingleton', 'HomeController@editSingleton');
Route::post('/uploadSingleton', 'HomeController@uploadSingleton')->name('video.uploadSingleton');

Route::get('/subscribes', 'VideoController@subscribeIndex')->name('video.subscribes');
Route::post('/subscribe', 'VideoController@subscribe')->name('video.subscribe');
Route::post('/unsubscribe', 'VideoController@unsubscribe')->name('video.unsubscribe');
Route::get('/tag', 'VideoController@subscribeTag')->name('video.subscribeTag');

Route::post('/like', 'VideoController@like')->name('video.like');
Route::post('/unlike', 'VideoController@unlike')->name('video.unlike');

Route::post('/save', 'VideoController@save')->name('video.save');
Route::post('/unsave', 'VideoController@unsave')->name('video.unsave');

Route::post('/createComment', 'VideoController@createComment')->name('video.createComment');
Route::post('/deleteComment', 'VideoController@deleteComment')->name('video.deleteComment');

Route::get('/about', 'HomeController@about');
Route::get('/contact', 'HomeController@contact');
Route::get('/terms', 'HomeController@terms');
Route::get('/policies', 'HomeController@policies');
Route::get('/copyright', 'HomeController@copyright');
Route::get('/video-copyright', 'VideoController@copyright');
Route::get('/check', 'HomeController@check');
Route::get('/checkSubscribes', 'HomeController@checkSubscribes');
Route::get('/checkZeroSubscribes', 'HomeController@checkZeroSubscribes');
Route::get('/bccToSrt', 'HomeController@bccToSrt');
Route::get('/categoryEdit', 'HomeController@categoryEdit')->name('category.edit');
Route::post('/categoryUpdate', 'HomeController@categoryUpdate')->name('category.update');
Route::get('/singleNewCreate', 'HomeController@singleNewCreate')->name('single.create');
Route::post('/singleNewStore', 'HomeController@singleNewStore')->name('single.store');
Route::get('/sitemap.xml', 'HomeController@sitemap');
Route::get('/getSource', 'VideoController@getSource');
Route::get('/getSourceQQ', 'UserController@getSourceQQ');
Route::get('/createGetSource', 'VideoController@createGetSource');
Route::get('/loadPlaylist', 'VideoController@loadPlaylist')->name('video.loadPlaylist');
Route::get('/loadTagList', 'VideoController@loadTagList');
Route::get('/loadBloglist', 'BlogController@loadBloglist')->name('blog.loadBloglist');

Route::get('/loadHomeTagList', 'HomeController@loadHomeTagList');
Route::get('/userReport', 'HomeController@userReport')->name('email.userReport');
Route::get('/userStartUpload', 'UserController@userStartUpload')->name('email.userStartUpload');
Route::get('/user/{user}/upload', 'UserController@userEditUpload')->name('user.userEditUpload');
Route::post('/user/{user}/userUpdateUpload', 'UserController@userUpdateUpload')->name('user.userUpdateUpload');
Route::get('/user/{user}/{genre?}', 'UserController@show')->name('user.show');
Route::get('/channel/{genre}', 'HomeController@genre')->name('genre.index');
Route::get('/channel/{genre}/loadTagList', 'VideoController@loadChannelVideos');

Route::get('/copyrightReport', 'HomeController@copyrightReport')->name('email.copyrightReport');

Route::get('/trending', 'VideoController@watch')->name('video.trending');

Route::get('/rank', 'VideoController@explore')->name('video.rank');
Route::get('/rank/loadTagList', 'VideoController@loadRankVideos');
Route::get('/newest', 'VideoController@explore')->name('video.newest');
Route::get('/newest/loadTagList', 'VideoController@loadNewestVideos');
Route::get('/recommend', 'VideoController@recommend')->name('video.recommend');
Route::get('/recommend/loadTagList', 'VideoController@loadRecommendVideos');
Route::get('/playlist', 'VideoController@playlist')->name('video.playlist');
Route::get('/{genre}/{title}', 'VideoController@intro')->name('video.intro');

Route::get('/watch', 'VideoController@watch')->name('video.watch');
Route::get('/blog', 'BlogController@show')->name('blog.read');
Route::get('/search', ['as' => 'video.search', 'uses' => 'VideoController@search']);
Route::get('/search-google', ['as' => 'video.searchGoogle', 'uses' => 'VideoController@searchGoogle']);