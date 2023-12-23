<?php

use Illuminate\Support\Facades\Route;

// AdminPanel Controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategorySubController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VariationController;
use App\Http\Controllers\BlogController;

//Website Controllers
use App\Http\Controllers\Website\WebsiteController;
use App\Http\Controllers\Website\MyAccount\MyAccountController;
use App\Http\Controllers\Website\Cart\CartController;
use App\Http\Controllers\Website\Cart\CheckoutController;
use Illuminate\Support\Facades\DB;

//Middlewares
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CustomerMiddleware;
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


// view()->composer(['*'], function ($view) {
//     $categories = DB::table('categories')->get();
//     $view->with([
//         'categories' => $categories
//     ]);
// });

View::composer(['*'], function ($view) {
    $categories = DB::table('categories')->get();
    $view->with([
        'categories' => $categories
    ]);
});



// Route::group(['prefix' => 'Admin', 'middleware'=> 'AdminMiddleware'],function(){
Route::group(['middleware' => 'CustomerMiddleware'], function () {
    Route::get('/Checkout', [CheckoutController::class, 'Checkout'])->name('Checkout');
    Route::post('/CheckoutLoginFlow', [CheckoutController::class, 'CheckoutLoginFlow'])->name('CheckoutLoginFlow');
    Route::post('/CheckOutDetail', [CheckoutController::class, 'CheckOutDetail'])->name('CheckOutDetail');
    Route::post('/CheckOutDetailUpdate', [CheckoutController::class, 'CheckOutDetailUpdate'])->name('CheckOutDetailUpdate');
    Route::post('/PlaceOrder', [CheckoutController::class, 'PlaceOrder'])->name('PlaceOrder');

    Route::post('/CodPlaceOrder', [CheckoutController::class, 'CodPlaceOrder'])->name('CodPlaceOrder');
    // Route::post('/razorpay.payment.store', [CheckoutController::class, 'RazorPayPayment'])->name('razorpay.payment.store');
    Route::post('/ProcessRazorPayPayment', [CheckoutController::class, 'ProcessRazorPayPayment'])->name('ProcessRazorPayPayment');

    Route::get('/MyAccount', [MyAccountController::class, 'MyAccount'])->name('MyAccount');
    Route::post('PrimaryAddressStore', [MyAccountController::class, 'PrimaryAddressStore'])->name('PrimaryAddressStore');
    Route::get('/ManageAddresses', [MyAccountController::class, 'ManageAddresses'])->name('ManageAddresses');
    Route::get('/EditAddress/{customer_address_id}/', [MyAccountController::class, 'EditAddress'])->name('EditAddress');
    Route::get('/OrderHistory', [MyAccountController::class, 'OrderHistory'])->name('OrderHistory');
    Route::get('/RemoveAddress', [MyAccountController::class, 'RemoveAddress'])->name('RemoveAddress');
    Route::get('/SetAsDefault', [MyAccountController::class, 'SetAsDefault'])->name('SetAsDefault');

    Route::get('/Invoice', [CheckoutController::class, 'Invoice'])->name('Invoice');
    Route::get('/OrderConfirm', [CheckoutController::class, 'OrderConfirm'])->name('OrderConfirm');
});

Route::get('/result/{slug?}/{id?}', [WebsiteController::class, 'products'])->name('result');

// Route::get('/result/{categorySlug?}/{subcategorySlug?}', [WebsiteController::class, 'products'])->name('result');
// Route::get('/result/{id}', [WebsiteController::class, 'productsByBrands']);
// Route::get('result/{id}', [WebsiteController::class, 'productsByBrands'])->name('result');


//Website Controller Home page
// Route::get('/result/{categorySlug?}/{subcategorySlug?}/{id?}', [WebsiteController::class, 'products'])
//     ->where(['categorySlug' => '[\w\-]+', 'subcategorySlug' => '[\w\-]+', 'id' => '[\w\-]+'])
//     ->name('result');


Route::get('/', [WebsiteController::class, 'Home'])->name('Home');


Route::get('/GetSalePrice', [WebsiteController::class, 'GetSalePrice'])->name('GetSalePrice');
// Route::get('/product/{productSlug}/{SubCategorySlug}', [WebsiteController::class, 'productdetails'])->name('product');
Route::get('/product/{productSlug}/', [WebsiteController::class, 'productdetails'])->name('product');
Route::get('/ListView/{productSlug}/', [WebsiteController::class, 'ListView'])->name('ListView');
Route::get('/SortProductByNumber', [WebsiteController::class, 'SortProductByNumber'])->name('SortProductByNumber');


//CartController Cart Item Page
Route::post('/AddToCart', [CartController::class, 'AddToCart'])->name('AddToCart');
Route::get('/ViewCart', [CartController::class, 'ViewCart'])->name('ViewCart');
Route::get('/RemoveFromCart', [CartController::class, 'RemoveFromCart'])->name('RemoveFromCart');

Route::get('/UpdateCart', [CartController::class, 'UpdateCart'])->name('UpdateCart');

//CheckoutContoller Routes Checkout Page
// Route::get('/Checkout', [CheckoutController::class, 'Checkout'])->name('Checkout');
// Route::post('/CheckoutLoginFlow', [CheckoutController::class, 'CheckoutLoginFlow'])->name('CheckoutLoginFlow');
// Route::post('/CheckOutDetail', [CheckoutController::class, 'CheckOutDetail'])->name('CheckOutDetail');
// Route::post('/CheckOutDetailUpdate', [CheckoutController::class, 'CheckOutDetailUpdate'])->name('CheckOutDetailUpdate');
// Route::post('/PlaceOrder', [CheckoutController::class, 'PlaceOrder'])->name('PlaceOrder');

// Route::post('/CodPlaceOrder', [CheckoutController::class, 'CodPlaceOrder'])->name('CodPlaceOrder');
// // Route::post('/razorpay.payment.store', [CheckoutController::class, 'RazorPayPayment'])->name('razorpay.payment.store');
// Route::post('/ProcessRazorPayPayment', [CheckoutController::class, 'ProcessRazorPayPayment'])->name('ProcessRazorPayPayment');

// MyAccountController Routes Handles Login rgistraion of customer
Route::get('/Login', [MyAccountController::class, 'Login'])->name('Login');
Route::get('/Signup', [MyAccountController::class, 'NewRegistration'])->name('Signup');
Route::post('/CustomerLogin', [MyAccountController::class, 'CustomerLogin'])->name('CustomerLogin');
Route::post('/AddNewCustomer', [MyAccountController::class, 'RegisterCustomer'])->name('AddNewCustomer');
Route::get('Logout', [MyAccountController::class, 'Logout'])->name('Logout');

// My Account Seciton


// Websites Routes Ended Here



// Admin Panel Routes Started

Route::get('Admin/Login', [AuthController::class, 'AdminLogin'])->name('AdminLogin');
Route::get('Admin/Logout', [AuthController::class, 'AdminLogout'])->name('AdminLogout');
Route::post('Admin/LoginStore', [AuthController::class, 'AdminLoginStore'])->name('AdminLoginStore');

Route::group(['prefix' => 'Admin', 'middleware' => 'AdminMiddleware'], function () {

    //Dashboard Routes
    Route::get('Dashboard', [AuthController::class, 'Dashboard'])->name('Dashboard');

    //Category Routes

    Route::post('CategoryStore', [CategoryController::class, 'CategoryStore'])->name('CategoryStore');
    Route::get('CategoryShow', [CategoryController::class, 'CategoryShow'])->name('CategoryShow');
    Route::get('CategoryEdit', [CategoryController::class, 'CategoryEdit'])->name('CategoryEdit');
    // routes/web.php
    // Route::get('FetchSubCategory/{slug}', [CategoryController::class, 'fetchSubCategory'])->name('FetchSubCategory');
    Route::get('Category', [CategoryController::class, 'Category'])->name('Category');
    Route::get('Category/{categoryId}', [CategoryController::class, 'SubCategoryShow'])->name('SubCategoryShow');
    // Route::get('subcategories/{categoryId}', [CategoryController::class, 'SubCategoryShow'])->name('SubCategoryShow');

    Route::get('CategoryRemove', [CategoryController::class, 'CategoryRemove'])->name('CategoryRemove');


    // Route::get('CategorySubFetch', [CategorySubController::class, 'CategorySubFetch'])->name('CategorySubFetch');
    // Route::get('CategorySubEdit', [CategorySubController::class, 'CategorySubEdit'])->name('CategorySubEdit');
    // Route::get('SubCategoryDelete', [CategorySubController::class, 'SubCategoryDelete'])->name('SubCategoryDelete');
    // Route::post('CategorySubStore', [CategorySubController::class, 'CategorySubStore'])->name('CategorySubStore');

    //Slider Routes
    Route::get('/Slider', [SliderController::class, 'Slider'])->name('Slider');
    Route::post('/SliderStore', [SliderController::class, 'SliderStore'])->name('SliderStore');
    Route::get('/SliderShow', [SliderController::class, 'SliderShow'])->name('SliderShow');
    Route::get('/SliderEdit', [SliderController::class, 'SliderEdit'])->name('SliderEdit');
    Route::get('/SliderDelete', [SliderController::class, 'SliderDelete'])->name('SliderDelete');

    //Attributes Routes
    Route::get('Attribute', [AttributeController::class, 'Attribute'])->name('Attribute');
    Route::post('AttributeStore', [AttributeController::class, 'AttributeStore'])->name('AttributeStore');
    Route::get('AttributeShow', [AttributeController::class, 'AttributeShow'])->name('AttributeShow');
    Route::get('AttributeEdit', [AttributeController::class, 'AttributeEdit'])->name('AttributeEdit');
    Route::get('AttributeRemove', [AttributeController::class, 'AttributeRemove'])->name('AttributeRemove');

    //Brand Routes
    Route::get('Brand', [BrandController::class, 'Brand'])->name('Brand');
    Route::post('BrandStore', [BrandController::class, 'BrandStore'])->name('BrandStore');
    Route::get('BrandShow', [BrandController::class, 'BrandShow'])->name('BrandShow');
    Route::get('BrandEdit', [BrandController::class, 'BrandEdit'])->name('BrandEdit');
    Route::get('BrandRemove', [BrandController::class, 'BrandRemove'])->name('BrandRemove');
    //variation Routes
    Route::get('variation', [variationController::class, 'variation'])->name('variation');
    Route::post('VariationStore', [variationController::class, 'VariationStore'])->name('VariationStore');
    Route::get('VariationShow', [variationController::class, 'VariationShow'])->name('VariationShow');
    Route::get('VariationEdit', [variationController::class, 'VariationEdit'])->name('VariationEdit');
    Route::get('VariationRemove', [variationController::class, 'VariationRemove'])->name('VariationRemove');

    //Discount Routes
    Route::get('Discount', [DiscountController::class, 'Discount'])->name('Discount');
    Route::post('DiscountStore', [DiscountController::class, 'DiscountStore'])->name('DiscountStore');
    Route::get('DiscountShow', [DiscountController::class, 'DiscountShow'])->name('DiscountShow');
    Route::get('DiscountEdit', [DiscountController::class, 'DiscountEdit'])->name('DiscountEdit');
    Route::get('DiscountRemove', [DiscountController::class, 'DiscountRemove'])->name('DiscountRemove');

    //Routes For Variation
    Route::get('Variation', [VariationController::class, 'Variation'])->name('Variation');

    //Product Routes
    Route::get('ProductForm', [ProductController::class, 'ProductForm'])->name('ProductForm');
    Route::get('Product', [ProductController::class, 'Product'])->name('Product');
    Route::post('ProductStore', [ProductController::class, 'ProductStore'])->name('ProductStore');
    Route::get('UpdateProductThambnail', [ProductController::class, 'UpdateProductThambnail'])->name('UpdateProductThambnail');
    Route::get('ProductShow', [ProductController::class, 'ProductShow'])->name('ProductShow');
    Route::get('ProductEdit', [ProductController::class, 'ProductEdit'])->name('ProductEdit');
    Route::get('ProductRemove', [ProductController::class, 'ProductRemove'])->name('ProductRemove');
    Route::get('ProductData/{id}', [ProductController::class, 'ProductData'])->name('ProductData');
    Route::get('GetChildrenCategory', [ProductController::class, 'GetChildrenCategory'])->name('GetChildrenCategory');

    //Blog
    Route::get('Blog', [BlogController::class, 'Blog'])->name('Blog');
    Route::get('BlogFetch', [BlogController::class, 'BlogFetch'])->name('BlogFetch');
    Route::get('BlogEdit', [BlogController::class, 'BlogEdit'])->name('BlogEdit');
    Route::get('BlogDelete', [BlogController::class, 'BlogDelete'])->name('BlogDelete');
    Route::post('BlogStore', [BlogController::class, 'BlogStore'])->name('BlogStore');

    //Product Attribute Route
    Route::get('ProductAttributeAdd', [ProductController::class, 'ProductAttributeAdd'])->name('ProductAttributeAdd');
    Route::get('ProductAttributeRemove', [ProductController::class, 'ProductAttributeRemove'])->name('ProductAttributeRemove');

    //Product Variation Route
    Route::post('ProductVariationAdd', [ProductController::class, 'ProductVariationAdd'])->name('ProductVariationAdd');
    Route::get('ProductVariationRemove', [ProductController::class, 'ProductVariationRemove'])->name('ProductVariationRemove');

    //Product Image Route
    Route::post('ProductImageAdd', [ProductController::class, 'ProductImageAdd'])->name('ProductImageAdd');
    Route::get('ProductImageRemove', [ProductController::class, 'ProductImageRemove'])->name('ProductImageRemove');
});
