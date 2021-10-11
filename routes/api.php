<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// user Api
Route::post('user/register', 'Api\UserController@register');
Route::post('user/login', 'Api\UserController@login');
Route::post('user/profile', 'Api\UserController@profile');
Route::post('user/user_list', 'Api\UserController@user_list');
Route::post('user/forgot_password', 'Api\UserController@forgot_password');
Route::post('user/privacy', 'Api\UserController@privacy');
Route::post('user/my_edited_post', 'Api\UserController@my_edited_post');
Route::post('user/my_favorite_post', 'Api\UserController@my_favorite_post');


// Category Api
Route::post('category/category_add', 'Api\CategoryController@category_add');
Route::post('category/category_list', 'Api\CategoryController@category_list');
Route::post('category/category_delete', 'Api\CategoryController@category_delete');
Route::post('category/category_images_add', 'Api\CategoryController@category_images_add');
Route::post('category/category_images_delete', 'Api\CategoryController@category_images_delete');
Route::post('category/category_images_list', 'Api\CategoryController@category_images_list');
Route::post('category/favourite', 'Api\CategoryController@favourite');
Route::post('category/favourite_list', 'Api\CategoryController@favourite_list');

//post api
Route::post('post/latest_post', 'Api\PostController@latest_post');
Route::post('post/total_share_download', 'Api\PostController@total_share_download');
Route::post('post/all_list', 'Api\PostController@all_list');
Route::post('post/add_user_action', 'Api\PostController@add_user_action');

Route::post('ad/active_ad', 'Api\PostController@active_ad');
