<?php

use Illuminate\Support\Facades\Route;

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
use App\Http\Controllers\Website\WebsiteController;
use App\Http\Controllers\Website\MyAccount\MyAccountController;
use Illuminate\Support\Facades\DB;
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

View::composer(['*'], function ($view) {
    $categories = DB::table('categories')->get();


    $view->with([
        'categories' => $categories
    ]);
});

Route::get('/', [WebsiteController::class, 'Home'])->name('Home');
Route::get('/result/{slug}/{sub_slug?}', [WebsiteController::class, 'products'])->name('result');
Route::get('/ProductDtails/{slug}', [WebsiteController::class, 'productdetails'])->name('productdetails');
Route::get('/Login', [MyAccountController::class, 'Login'])->name('Login');

Route::get('/Admin/Login', [AuthController::class, 'AdminLogin']);

Route::prefix('Admin')->group(function () {
    Route::get('Dashboard', [AuthController::class, 'Dashboard'])->name('Dashboard');

    //Category Routes
    Route::get('Category', [CategoryController::class, 'Category'])->name('Category');
    Route::post('CategoryStore', [CategoryController::class, 'CategoryStore'])->name('CategoryStore');
    Route::get('CategoryShow', [CategoryController::class, 'CategoryShow'])->name('CategoryShow');
    Route::get('CategoryEdit', [CategoryController::class, 'CategoryEdit'])->name('CategoryEdit');
    Route::get('CategoryRemove', [CategoryController::class, 'CategoryRemove'])->name('CategoryRemove');

    Route::get('CategorySub', [CategorySubController::class, 'CategorySub'])->name('CategorySub');
    Route::get('CategorySubFetch', [CategorySubController::class, 'CategorySubFetch'])->name('CategorySubFetch');
    Route::get('CategorySubEdit', [CategorySubController::class, 'CategorySubEdit'])->name('CategorySubEdit');
    Route::get('SubCategoryDelete', [CategorySubController::class, 'SubCategoryDelete'])->name('SubCategoryDelete');
    Route::post('CategorySubStore', [CategorySubController::class, 'CategorySubStore'])->name('CategorySubStore');

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
