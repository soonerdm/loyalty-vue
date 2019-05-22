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

/*Route::get('/', function () {
    return view('home');
});
*/

Auth::routes();

Route::get('/', 'RSAController@index');

Route::get('/ava_coupons', 'RSAController@get_coupons');

Route::post('/clip_offer', 'RSAController@clip_offer');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/my_coupons', 'RSAController@get_user_clips');

Route::Post('validate', 'RSAController@validate_user');

Route::Post('register', 'RSAController@register_user');
