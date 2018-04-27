<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\Route;


//<?php
//
//use Illuminate\Http\Request;
//
///*
//|--------------------------------------------------------------------------
//| API Routes
//|--------------------------------------------------------------------------
//|
//| Here is where you can register API routes for your application. These
//| routes are loaded by the RouteServiceProvider within a group which
//| is assigned the "api" middleware group. Enjoy building your API!
//|
//*/
//
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});





Route::group([
    'namespace' => 'Weixin',
    'prefix' => 'weixin',
    'middleware' => [
        'web',
    ],
], function ($api) {
    //公众号授权及操作路由
    Route::any('company/auth', 'AuthController@auth');//授权事件
    Route::any('event', 'AuthController@event');//微信被动事件回调
    Route::any('target/{cid}/auth', 'AuthController@targetAuth');//微信授权成功后跳转回页面
    Route::any('user/{cid}/auth', 'AuthController@userAuthCallback');//微信用戶网页授权成功后跳转回页面
    Route::any('payment/notify', 'AuthController@notify');//微信用戶网页授权成功后跳转回页面
    Route::get('create/menu', 'AuthController@createMenu');//微信用戶网页授权成功后跳转回页面
    Route::get('get/news/lists', 'AuthController@getNews');//获取微信素材


    //微信下单页面
    Route::get('orders/{cid}/index', 'OrderController@index');//微信下单首页
    Route::get('orders/select/product', 'OrderController@selectProduct');//微信选项产品
    Route::get('orders/select/fault', 'OrderController@selectFault');//微信选择故障类型
    Route::get('orders/create', 'OrderController@create');//微信下单页面
    Route::get('orders/success/{id}', 'OrderController@success');//下单成功页面
    Route::get('orders/show/{id}', 'OrderController@show');//工单详情页面
    Route::get('orders/search/site', 'OrderController@getSites');//搜索网点
    //测试


    //下单
    Route::post('order/create', 'OrderController@store');
    Route::match(['get', 'post'], 'order/update', 'OrderController@update');
    Route::get('payment/{id}', 'OrderController@payment');
    Route::get('pay/polling', 'OrderController@polling');//轮询

});


Route::group([
    'namespace' => 'Weixin',
    'prefix' => 'weixin',
    'middleware' => [
        'web',
        'wechat.oauth',
    ],
], function () {
    Route::get('orders/xiadan', 'OrderController@xiadan');
});


Route::group([
    'namespace' => 'Api',
], function ($api) {
    //公众号授权及操作路由
    Route::any('order/payment/notify', 'OrderController@notify'); //完成工单支付回调
//    Route::post('order/{id}/payment', 'OrderController@payment'); //完成工单输入金额
//    Route::get('order/payment/polling', 'OrderController@polling'); //查询工单支付状态

});


Route::group([
    'namespace' => 'Api',
    'middleware' => 'signature',
], function ($api) {
    Route::post('auth/sms', 'AuthController@sms');
    Route::post('auth/repwd', 'AuthController@repwd');
    Route::post('auth/login', 'AuthController@login');
    Route::get('auth/upgrade', 'AuthController@upgrade');
    Route::get('auth/sysinfo', 'AuthController@sysinfo');
    Route::post('auth/mobile', 'AuthController@mobileVerify');
    Route::post('auth/code', 'AuthController@verifyCode');
    Route::post('auth/push', 'AuthController@testpush');


    //测试
});

Route::group([
    'namespace' => 'Api',
    'middleware' => [
//        'signature',
        'auth'
    ],
], function ($api) {
    Route::get('user/info', 'UserController@info');
    Route::get('user/platform', 'UserController@getWorkPlatform');
    Route::get('/user/{orderId}/read', 'UserController@setOrderRead');
    Route::post('user/repwd', 'UserController@repwd');

    Route::get('permissions', 'PermissionController@lists');
    Route::get('permission/user', 'PermissionController@getUserPermissions');

    Route::post('msg/setread', 'MessageController@setMsgReadFlag');
    Route::get('msgs', 'MessageController@lists');

    Route::get('order/{id}', 'OrderController@show');
    Route::get('order/{id}/del', 'OrderController@del');
    Route::post('order/{id}/confirm', 'OrderController@confirm');

    Route::post('order/{id}/payment', 'OrderController@payment'); //完成工单输入金额
    Route::get('order/payment/polling', 'OrderController@polling'); //查询工单支付状态

    Route::post('order/{id}/cancel', 'OrderController@cancel');
    Route::post('order/create', 'OrderController@create');
    Route::match(['get', 'post'], 'orders/lists', 'OrderController@lists');
    Route::get('orders/starlists', 'OrderController@getStarLists');
    Route::get('order/{id}/star', 'OrderController@setStarOrder');
    Route::get('order/{id}/delstar', 'OrderController@delStarOrder');
    Route::post('order/{id}/booking', 'OrderController@booking');
    Route::post('order/{id}/handle', 'OrderController@handle');
    Route::post('order/{id}/assign', 'OrderController@assign');
    Route::post('order/{id}/reset-assign', 'OrderController@resetAssign');
    Route::post('order/{id}/dispatch', 'OrderController@dispatchSite');
    Route::post('order/{id}/reset-dispatch', 'OrderController@resetDispatchSite');
    Route::post('order/{id}/dispatch-third', 'OrderController@dispatchThirdService');
    Route::match(['get', 'post'], 'order/{id}/edit', 'OrderController@edit');
    Route::match(['get', 'post'], 'order/{id}/third', 'OrderController@thirdService');
    Route::get('order/{id}/start', 'OrderController@startService');
    Route::get('order/{id}/processing', 'OrderController@processing');
    Route::post('order/{id}/message', 'OrderController@insertOrderMessage');
    Route::get('order/{id}/message', 'OrderController@logMessage');


    Route::get('company/assign/lists', 'UserController@getAssignPeopleLists');
    Route::get('company/service/contents', 'CompanyController@getServiceContent');
    Route::get('company/productcats', 'ProductController@getProductCats');
    Route::get('company/{catId}/products', 'ProductController@getProducts');
    Route::get('company/{productId}/parts', 'ProductController@getProductParts');
    Route::get('company/{productCatsId}/malfunctions', 'ProductController@getMalfunctions');
    Route::get('company/services', 'CompanyController@getCompanyServiceInfo');
    Route::get('company/{orderId}/service-project', 'CompanyController@getProjects');
    Route::get('company/service-technicals', 'CompanyController@getCompanyServiceTechnicals');
    Route::get('company/third-services', 'CompanyController@getThirdServices');
    Route::get('company/fees', 'CompanyController@getFees');
    Route::get('company/{productId}/docs', 'ProductController@getProductDocs');
    Route::get('company/expresses', 'CompanyController@getExpresses');


    Route::post('customer/create', 'CustomerController@create');
    Route::get('customer/{customerId}/products', 'ProductController@getCustomerProducts');
    Route::get('customer/{id}/productinfo', 'CustomerController@getProductInfo');

    Route::get('part/{id}/del', 'PartController@delPart');
    Route::post('part/{id}/apply', 'PartController@applyPart');
    Route::post('part/{id}/confirm', 'PartController@confirmPart');
    Route::post('part/{id}/back', 'PartController@backPart');
    Route::post('part/{id}/back-confirm', 'PartController@backPartConfirm');
    Route::post('part/{id}/worker-confirm', 'PartController@workPartConfirm');

    Route::get('fee/{id}/del', 'FeeController@delFee');
    Route::post('fee/{id}/apply', 'FeeController@applyFee');
    Route::post('fee/{id}/confirm', 'FeeController@confirmFee');


    Route::get('project/{id}/del', 'ProjectController@delProject');
    Route::post('project/{id}/apply', 'ProjectController@applyProject');
    Route::post('project/{id}/confirm', 'ProjectController@confirmProject');

    Route::post('user/search', 'UserController@search');

    Route::post('file/upload', 'SystemFileController@upload');
    Route::post('feedback', 'FeedbackController@feedback');

});


Route::group([
    'namespace'  => 'MerchantApi',
    'middleware' => [
//        'signature',
//        'auth'
    ],
], function ($api)
{
    Route::post('merchant/auth/login','AuthController@login');
    Route::post('merchant/auth/repwd','AuthController@repwd');
    Route::post('merchant/auth/mobileverify','AuthController@mobileVerify');
    Route::post('merchant/auth/code','AuthController@verifyCode');
    Route::post('merchant/auth/sms','AuthController@sms');


    Route::get('merchant/auth/push','AuthController@push');
    Route::get('merchant/auth/update','AuthController@update');
    Route::get('merchant/auth/logout','AuthController@logout');
});


