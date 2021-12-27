<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Console\Input\Input;
use Illuminate\Support\Facades\Session;

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

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){ //...

        Route::get('design' , function (){
           return view('dashboard.design');
        });



//        Route::get('rest' , 'HomeController@rest');
    Route::get('home', function () {
        return redirect()->route('/');
    });

    Auth::routes(['verify' => true]);

//    Route::get('/home', 'HomeController@index')->name('home');
//    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/','front\homeController@home')->name('/');
//    Route::get('/account','front\homeController@account')->name('account');
    Route::get('/cart','front\homeController@cart')->name('cart');
    Route::get('/post/{id}','front\homeController@post')->name('post');
    Route::get('/category/{type}/{id}','front\homeController@category')->name('category');
    Route::get('/new_arrive','front\homeController@new_arrive')->name('new');
    Route::get('/offers','front\homeController@offers')->name('offer');
    Route::get('/checkout','front\homeController@checkout')->name('checkout');
    Route::group(['middleware' => ['auth']], function () {
        Route::get('/myaccount', 'front\homeController@myaccount')->name('myaccount');
        Route::post('users/data/update/{id}','front\homeController@updateUser')->name('update.user');
        Route::get('/myorder','front\orderController@index')->name('myorder');
        Route::get('/wishlists/products','Backend\WishListController@index')->name('wishlist.view');

    });
    Route::get('/payment','front\homeController@payment')->name('payment');
    Route::get('/policy','front\homeController@policy')->name('policy');
    Route::get('/product/{id}','front\homeController@product')->name('product');
//    Route::get('/index','front\homeController@home')->name('index');

//    Route::get('/forget-password', 'ForgotPasswordController@getEmail');
//    Route::post('/forget-password', 'ForgotPasswordController@postEmail');
//    Route::get('/reset-password/{token}', 'ResetPasswordController@getPassword');
//    Route::post('/reset-password', 'ResetPasswordController@updatePassword');

    Route::get('forget-password', 'Auth\ForgotPasswordController@showForgetPasswordForm')->name('forget.password.get');
    Route::post('forget-password',  'Auth\ForgotPasswordController@submitForgetPasswordForm')->name('forget.password.post');
    Route::get('reset-password/{token}',  'Auth\ForgotPasswordController@showResetPasswordForm')->name('reset.password.get');
    Route::post('reset-password', 'Auth\ForgotPasswordController@submitResetPasswordForm')->name('reset.password.post');

//    TODO :: DASHBOARD ROUTES


//wishList routes
    Route::get('/wishlist', 'Backend\WishListController@store')->name('wishlist.store');
//    Route::get('/wishlist/products', 'Backend\WishListController@index')->name('wishlist.products.index');
    Route::delete('/wishlist', 'Backend\WishListController@destroy')->name('wishlist.destroy');
//wishList routes End
    Route::get('/searching' ,'front\homeController@store');
    //
    Route::get('/cookie/set/{country}','CookieController@setCookie')->name('cookie.set');
    Route::get('/cookie/get','CookieController@getCookie')->name('cookie.get');

    Route::get('/add-to-cart/{id}','front\homeController@getAddToCart')->name('product.addToCart');
    Route::post('/addToCart','front\CartController@addToCart')->name('add.to.cart');
    Route::get('/viewFromCart','front\CartController@viewFromCart')->name('view.from.cart');
    Route::post('/removeFromCart','front\CartController@reduceFromCart')->name('reduce.from.cart');
    Route::get('/removeFromCart/{product}/{height}','front\CartController@removeFromCart')->name('remove.from.cart');
    Route::get('/removeFromShoppingCart/{product}/{height}','front\CartController@removeFromShoppingCart')->name('remove.from.shopping.cart');
    Route::get('/pay_now/{order_id}','front\CartController@payNow')->name('pay.now');


    Route::get('/shopping-cart','front\homeController@getCart')->name('product.shoppingCart');
    Route::get('/contact_us_user','front\homeController@contactUs')->name('contact.us');
    Route::post('/contact_us_user','front\homeController@contactUsStore')->name('contact.us');
    Route::get('/getHeights','front\CartController@getHeights')->name('get.heights');
    Route::post('/getCities','front\CartController@getCities')->name('get.cities');
    Route::post('/getDelivery','front\CartController@getDelivery')->name('get.delivery');
    Route::post('/checkCategory','front\homeController@checkCat')->name('check.cat');

    Route::post('/order/store','front\CartController@store')->name('order.store');
    Route::get('payment_callback' , 'front\CartController@callBackUrl');
    Route::get('payment_error' , 'front\CartController@errorUrl');
    Route::get('/coupon/store','front\CouponController@store')->name('coupon.store');
    Route::delete('/coupon','front\CouponController@destroy')->name('coupon.destroy');


    Route::group(['middleware' => ['adminAuth' ,  'role:admin']], function () {
        Route::resource('users','Backend\UserController');
        Route::get('users/destroy/{id}','Backend\UserController@destroy')->name('users.destroy');
        Route::get('admins/destroy/{id}','Backend\AdminController@destroy');
//        Route::get('users/destroy/{id}','Backend\UserController@destroy')->name('users.destroy');
        Route::get('basic_categories/destroy/{id}','Backend\BasicCategoryController@destroy');
        Route::get('size_guides/destroy/{id}','Backend\SizeGuideController@destroy');
        Route::get('countries/destroy/{id}','Backend\CountryController@destroy');
        Route::get('colors/destroy/{id}','Backend\ColorController@destroy');
        Route::get('cities/destroy/{id}','Backend\CityController@destroy');
        Route::get('cities/view/{country_id}','Backend\CountryController@cities')->name('cities.view');
        Route::resource('pages','Backend\PagesController');
        Route::resource('admins','Backend\AdminController');
        Route::resource('settings','Backend\SettingsController');
        Route::resource('basic_categories','Backend\BasicCategoryController');
        Route::resource('size_guides','Backend\SizeGuideController');
        Route::resource('categories','Backend\CategoryController');
        Route::resource('currencies','Backend\CurrencyController');
        Route::resource('countries','Backend\CountryController');
        Route::resource('colors','Backend\ColorController');
        Route::resource('cities','Backend\CityController');
        Route::resource('sliders','Backend\sliderController');
        Route::resource('sizes','Backend\SizeController');
        Route::resource('heights','Backend\HeightController');
        Route::resource('products','Backend\ProductController');
        Route::resource('contact_us','Backend\ContactUsController');
        Route::resource('orders','Backend\OrderController');
        Route::get('/order/notpaid','Backend\OrderController@not_paid')->name('noorders');
        Route::resource('posts','Backend\PostController');
        Route::resource('news','Backend\NewsController');
        Route::resource('coupons','Backend\CouponController');
//islam 26 august



        Route::get('/product_galaries/{id}', 'Backend\productGalaryController@index')->name("product_galaries.index");
        Route::post('/product_galaries/store/{id}', 'Backend\productGalaryController@store')->name("product_galaries.store");
        Route::delete('/product_galaries/destroy/{id}', 'Backend\productGalaryController@destroy')->name("product_galaries.destroy");
        Route::get('/news/destroy/{id}', 'Backend\NewsController@destroy')->name("news.destroy");
        Route::get('/coupons/destroy/{id}', 'Backend\CouponController@destroy')->name("coupons.destroy");
        Route::get('/posts/destroy/{id}', 'Backend\PostController@destroy')->name("posts.destroy");


        Route::get('/ajax-subcat','Backend\ProductController@ajaxcat');


        Route::get('cities/view/{country_id}' ,'Backend\CountryController@cities')->name('cities.view');
        Route::get('items/view/{order_id}' ,'Backend\OrderController@items')->name('order.items.view');
        Route::get('order/receive/{order_id}' ,'Backend\OrderController@receive')->name('orders.received');
        Route::post('custom_users/update','Backend\UserController@updateUser')->name('users.update.user');
//<<<<<<< Updated upstream
        Route::post('custom_admins/update','Backend\AdminController@updateAdmin')->name('admins.update.admin');
        Route::post('custom_countries/update/{id}','Backend\CountryController@updateCountry')->name('countries.update.country');
        Route::post('custom_colors/update/{id}','Backend\ColorController@updateColor')->name('colors.update.color');
        Route::post('custom_cities/update/{id}','Backend\CityController@updateCity')->name('cities.update.city');
        Route::post('custom_pages/update/{id}','Backend\PagesController@updatePage')->name('pages.update.page');
        Route::post('custom_basic_categories/update/{id}','Backend\BasicCategoryController@updateBasicCategory')->name('basic_categories.update.basic_category');
        Route::post('custom_sizes_guide/update/{id}','Backend\SizeGuideController@updateSizeGuide')->name('size_guides.update.size_guide');
        Route::post('custom_categories/update/{id}','Backend\CategoryController@updateCategory')->name('categories.update.category');
        Route::post('custom_settings/update/{id}','Backend\SettingsController@updateSetting')->name('settings.update.setting');
        Route::post('custom_sliders/update/{id}','Backend\sliderController@updateSlider')->name('sliders.update.slider');
        Route::post('custom_sizes/update/{id}','Backend\SizeController@updateSize')->name('sizes.update.size');
        Route::post('custom_heights/update/{id}','Backend\HeightController@updateHeight')->name('heights.update.height');
        Route::post('custom_products/update/{id}','Backend\ProductController@updateProduct')->name('products.update.product');
        Route::post('custom_posts/update/{id}','Backend\PostController@updatePost')->name('posts.update.post');
        Route::post('custom_news/update/{id}','Backend\NewsController@updateNews')->name('news.update.news');
//=======
        Route::post('currencies_users/update','Backend\CurrencyController@updateCurrency')->name('currencies.update.currency');
//>>>>>>> Stashed changes
        Route::get('admin' , 'Backend\AdminController@admin')->name('admin');
    });

    Route::get('admin/login' , 'HomeController@adminLogin');
    Route::post('admin/login' , 'HomeController@loginAdmin')->name('admin.login');

});
