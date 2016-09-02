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

Route::get('/',function(){
    return view('welcome');
});


    Route::get('login','View\MemberController@toLogin');
    Route::get('register','View\MemberController@toRegister');
    Route::get('category','View\BookController@category');
    Route::get('book/category_id/{category_id}','View\BookController@bookList');
    Route::get('product/content/{book_id}','View\BookController@toproduct');
    Route::get('cart/cartview','View\CartController@cartView');

Route::group(['prefix' => 'service'], function () {
    Route::get('validatecode/create', 'Service\ValidateController@create');
    Route::post('validatephone/send', 'Service\ValidateController@sendSMS');
    Route::post('register', 'Service\MemberController@register');
    Route::post('login', 'Service\MemberController@login');
    
    Route::post('book/validate_email', 'Service\ValidateController@validateEmail');
    
    Route::get('category/parent_id/{parent_id}','Service\BookController@cateList');
    
    Route::get('cart/add/{book_id}','Service\CartController@addCart');
    Route::get('cart/deletecart','Service\CartController@deleteCart');
});


Route::group(['middleware' => ['check.login']], function () {
    
    Route::post('order/commit','View\OrderController@orderCommit');
    Route::get('order/orderlist','View\OrderController@orderList');

});



Route::get('admin/login', 'Admin\ManagerController@toAdminLogin');
Route::post('admin/service/login', 'Admin\ManagerController@adminLogin');
Route::group(['middleware' => 'check.adminLogin', 'prefix'=>'admin','namespace'=>'Admin'], 
    function () {
    
    Route::group(['prefix'=>'service'], function () {

        
        Route::get('exit', 'ManagerController@toExit');

        Route::post('category/add', 'CategoryController@categoryAdd');
        Route::post('category/delete', 'CategoryController@categoryDel');
        Route::post('category/edit', 'CategoryController@categoryEdit');
        
        Route::post('product/add', 'ProductController@productAdd');
        Route::post('product/edit', 'ProductController@productEdit');
        Route::post('product/delete', 'ProductController@productDelete');
        
        Route::post('order/edit', 'OrderController@orderEdit');

        Route::post('member/edit', 'MemberController@memberEdit');

        /************图片和文件上传*********************/
        Route::post('upload/{type}', 'UploadController@uploadFile');

        

    });
    
    
    Route::get('index', 'IndexController@toIndex');
    Route::get('info', 'IndexController@toInfo');
    
    Route::get('category', 'CategoryController@toCategory');
    Route::get('category_add', 'CategoryController@toCategoryAdd');
    Route::get('category/edit', 'CategoryController@toCategoryEdit');


   

    Route::get('product', 'ProductController@toProduct');
    Route::get('product_info', 'ProductController@toProductInfo');
    Route::get('product_add', 'ProductController@toProductAdd');
    Route::get('product_edit', 'ProductController@toProductEdit');
    
    
    Route::get('order', 'OrderController@toOrder');
    Route::get('order/info', 'OrderController@orderInfo');
    Route::get('order/edit', 'OrderController@toOrderEdit');

    Route::get('member', 'MemberController@toMember');
    Route::get('member/edit', 'MemberController@toMemberEdit');

});