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
//    return view('welcome');
    return view('home.home');
});
/*进入后台首页*/
Route::group(['middleware'=>'islogin','prefix'=>'admin','namespace'=>'Admin'],function ()
{

    Route::get(                    'index','IndexController@index');
    Route::get(                    'info','IndexController@info');
    Route::match(['get','post'],   'user/create','UserController@create');
    Route::get(                    'user/lists','UserController@lists');
    Route::match( ['get','post'],  'article/cates/create','CateArticleController@cates');
    Route::get(                    'article/cates/index','CateArticleController@catesIndex');
    Route::post(                   'article/cates/del/{id}','CateArticleController@delCate');
    Route::match( ['get','post'],  'article/create','ArticleController@articleAdd');
    Route::get(                    'article/list','ArticleController@articleList');
    Route::post(                    'upload','UploadController@upload');
    Route::get(                    'role/list','RoleController@roleList');
    Route::match( ['get','post'],  'role/create','RoleController@roleAdd');
    Route::match( ['get','post'],  'permission/create','PermissionController@permissionAdd');
    Route::get(                    'permission/list','PermissionController@permissionList');
});
Route::match(['get','post'],'/admin/login','Auth\LoginController@login');
Route::get(                 '/admin/yzm','Auth\LoginController@yzm');
//Route::get('admin/jm','Auth\LoginController@jm');

/*推送*/
Route::match(['get','post'],'admin/push','Admin\PushController@push');

/*app接口*/
Route::group(['prefix' => 'swagger'], function () {
    Route::get('json', 'SwaggerController@getJSON');
    Route::get('my-data', 'SwaggerController@getMyData');
});
/*短信发送接口*/
Route::get('admin/nexmo','NemoxSms\SmsController@sendsms');
Route::get('admin/yunpian','NemoxSms\SmsController@ypSendsms');


/*引入vue测试*/
Route::get('vue','Admin\ArticleController@vue');
Route::get('user/axios','Admin\ArticleController@axios');