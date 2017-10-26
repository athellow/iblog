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

Route::get('/', function () {
    return view('welcome');
});

//前台模块
Route::group(['middleware'=>'web'],function ($router)
{

    Auth::routes();

    Route::get('/home', 'HomeController@index')->name('home');
});

//后台模块
Route::group(['prefix' => 'admin','namespace' => 'Admin', 'middleware'=>'web'],function ($router)
{

    $router->get('lang/{locale}', 'LanguageController@setLocale')->name('admin.lang');

    $router->get('login', 'LoginController@showLoginForm')->name('admin.login');
    $router->post('login', 'LoginController@login');
    /*$router->get('register', 'LoginController@showRegister')->name('admin.register');
    $router->post('register', 'LoginController@register');*/
    $router->post('logout', 'LoginController@logout')->name('admin.logout');
    $router->post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    $router->get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');     //发送重置密码邮件的表单页面
    $router->post('password/reset', 'ResetPasswordController@reset');
    $router->get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('admin.password.reset');

    $router->any('/', 'IndexController@index');
    $router->any('index', 'IndexController@index');
    $router->any('info', 'IndexController@info');
});
