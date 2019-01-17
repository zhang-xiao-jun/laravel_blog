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


Route::get('/',function () {
    return redirect('/blog');
});

Route::get('/blog','BlogController@index')->name('blog.home');
Route::get('/blog/{slug}','BlogController@showPost')->name('blog.detail');

//后台路由
Route::get('/admin',function () {
    return redirect('/admin/post');
});

Route::middleware('auth')->namespace('Admin')->group(function () {
    Route::resource('admin/post','PostController',['expect'=>'show']);
    Route::resource('admin/tag','TagController',['expect'=>'show']);
    Route::get('admin/upload','UploadController@index');

    Route::post('admin/upload/file','UploadController@uploadFile');
    Route::delete('admin/upload.file','UploadController@deleteFile');
    Route::post('admin/upload/folder','UploadController@createFolder');
    Route::delete('admin/upload/folder','UploadController@deleteFolder');
});

//资源路由
/*动作

             URI	                行为	路       由名称
GET	        /photos	                index	    photos.index
GET	        /photos/create	        create	    photos.create
POST	    /photos	                store	    photos.store
GET	        /photos/{photo}	        show	    photos.show
GET	        /photos/{photo}/edit	edit	    photos.edit
PUT/PATCH	/photos/{photo}	        update	    photos.update
DELETE	    /photos/{photo}*/



//登录退出
Route::get('/login','Auth\LoginController@showLoginForm')->name('login');
Route::post('/login','Auth\LoginController@login');
Route::get('/logout','Auth\LoginController@loggedout')->name('logout');
