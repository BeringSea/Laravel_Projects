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

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');

// javna ruta za post sa izmenjenim imenom rute

Route::get('/post/{id}', ['as'=>'home.post','uses'=>'AdminPostsController@post']);

// javna ruta za brisanje vise izabranih slika

Route::delete('admin/delete/media',['as'=>'admin.delete.media','uses'=>'AdminMediasController@deleteMedia']);

Route::group(['middleware'=>'admin'],function (){

    Route::get('/admin',function (){

        return view('admin.index');

    });


    Route::resource('admin/users','AdminUsersController');

    // za sad postovi dostupni samo za administratore
    Route::resource('admin/posts','AdminPostsController');

    Route::resource('admin/categories', 'AdminCategoriesController');

    Route::resource('admin/media','AdminMediasController');


    Route::resource('admin/comments','PostCommentsController');

    Route::resource('admin/comment/replies','CommentRepliesController');

});

Route::group(['middleware'=>'auth'],function (){

    Route::post('comment/reply','CommentRepliesController@createReply');

});


