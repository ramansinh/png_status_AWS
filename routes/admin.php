<?php

//Route::get('/home', function () {
//    $users[] = Auth::user();
//    $users[] = Auth::guard()->user();
//    $users[] = Auth::guard('admin')->user();
//
//    //dd($users);
//
//    return view('admin.home');
//})->name('home');
//

Route::get('home','Admin\HomeController@home');
Route::resource('category','Admin\CategoryController');
Route::resource('user','Admin\UserController');
Route::resource('image','Admin\ImageController');
Route::resource('setting','Admin\SettingController');
Route::resource('privacy','Admin\PrivacyController');


Route::get('profile','Admin\ProfileController@profile');
Route::post('profile_store','Admin\ProfileController@profile_store')->name('profile_store');


