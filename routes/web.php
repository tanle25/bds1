<?php

use App\Http\Controllers\Admin\BillController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\CustomerLoginController;
use App\Http\Controllers\Auth\FacebookController;
use App\Http\Controllers\Customer\AdvisoryController;
use App\Http\Controllers\Customer\CustomerProfileController;
use App\Http\Controllers\Customer\CustomerRechargeController;
use App\Http\Controllers\Customer\FeaturedPostController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\PostController as CustomerPostController;
use App\Http\Controllers\Customer\ProjectController as ProjectCustomerController;
use App\Http\Controllers\Customer\RealtyPostController;
use App\Http\Controllers\Customer\RealtyTagController;
use App\Http\Controllers\Image\ImageUploadController;
use App\Http\Controllers\ProvinceController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('realty', function () {
    return view('customer/pages/realty');
});

Route::get('tim-kiem', [RealtyPostController::class, 'getRealtyPosts'])->name('customer.realty_post.get_list')->middleware('filter_query');
Route::get('bat-dong-san/{slug}', [RealtyPostController::class, 'show'])->name('customer.realty_post.show');

Route::get('realty-details', function () {
    return view('customer/pages/realty-details');
});

Route::post('register', [CustomerLoginController::class, 'register'])->name('customer.login.register');
Route::get('login', [CustomerLoginController::class, 'showLoginForm'])->name('customer.login.show');
Route::post('login', [CustomerLoginController::class, 'authenticate'])->name('customer.login.post');
Route::get('logout', [CustomerLoginController::class, 'logout'])->name('customer.logout');

Route::get('forgot-password', [CustomerLoginController::class, 'showResetForm'])->name('customer.password.request');
Route::post('forgot-password', [CustomerLoginController::class, 'sendRequestMail'])->name('customer.password.send_request_mail');

Route::get('reset-password/{token}', [CustomerLoginController::class, 'showResetPasswordForm'])->name('customer.password.reset');
Route::post('reset-password/update', [CustomerLoginController::class, 'updatePassword'])->name('customer.password.update');

//facebook login
Route::get('auth/facebook', [FacebookController::class, 'redirectToFacebook']);
Route::get('auth/facebook/callback', [FacebookController::class, 'handleFacebookCallback']);

// Province, district, communes route
Route::get('get-district-of-province/{province_code}', [ProvinceController::class, 'getDistrictsByProvince'])->name('customer.province.get_district');
Route::get('get-commune-of-district/{district_code}', [ProvinceController::class, 'getCommunesByDistrict'])->name('customer.province.get_commune');
Route::get('get-project-of-district/{district_code}', [ProvinceController::class, 'getProjectsByDistrict'])->name('customer.province.get_project');

// Image upload routes
Route::post('image/store', [ImageUploadController::class, 'store'])->name('image.store');
Route::post('image/destroy', [ImageUploadController::class, 'destroy'])->name('image.destroy');

Route::get('admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login.show');
Route::post('admin/login', [AdminLoginController::class, 'authenticate'])->name('admin.login.post');

Route::group(['middleware' => 'auth:web'], function () {
    // Account controller
    Route::get('/tai-khoan', [CustomerProfileController::class, 'showInformation'])->name('customer.profile.information');
    Route::post('/tai-khoan', [CustomerProfileController::class, 'updateInformation'])->name('customer.profile.information.store');
    // Acount recharge
    Route::get('/tai-khoan/nap-tien', [CustomerRechargeController::class, 'showForm'])->name('customer.recharge.index');
    Route::post('/tai-khoan/nap-tien', [CustomerRechargeController::class, 'recharge'])->name('customer.recharge.recharge');

    Route::get('/tai-khoan/xac-nhan-nap-tien/{id}', [BillController::class, 'showBillConfirm'])->name('customer.bill.confirm');
    // Acount recharge
    Route::get('/tai-khoan/so-du', [CustomerRechargeController::class, 'showAccountBalance'])->name('customer.profile.account_balance.index');

    // Customer realty post controller
    Route::get('dang-tin', [RealtyPostController::class, 'showForm'])->name('customer.realty_post.show_form');
    Route::post('dang-tin', [RealtyPostController::class, 'store'])->name('customer.realty_post.store');
    Route::get('quan-ly-tin-dang', [RealtyPostController::class, 'showListCustomer'])->name('customer.realty_post.show_list_customer');
    Route::get('sua-tin-dang/{id}', [RealtyPostController::class, 'edit'])->name('customer.realty_post.edit');
    Route::post('sua-tin-dang/{id}', [RealtyPostController::class, 'update'])->name('customer.realty_post.update');
    // Featured Realty Post
    Route::get('featured', [FeaturedPostController::class, 'index'])->name('customer.featured_post.index');
    Route::post('featured/add', [FeaturedPostController::class, 'addRealtyToUserFeatured'])->name('customer.featured_post.add');
    Route::post('featured/remove', [FeaturedPostController::class, 'removeRealtyFromUserFeatured'])->name('customer.featured_post.remove');
    Route::get('tin-da-luu', [FeaturedPostController::class, 'showListFrontend'])->name('customer.featured_post.show_list');

    // get geo
    Route::get('get-geo-by-name', [LocationController::class, 'getGeoByName'])->name('customer.location.get_geo_by_name');
});

Route::get('/v2/{any}', function () {
    return view('app.main');
});

// Payment callback
Route::get('payment/callback', [CustomerRechargeController::class, 'thirdPartyCallback'])->name('customer.payment.callback_from_online_payment');

//advisory controller
Route::post('/advisory/send-request-to-realty-owner', [AdvisoryController::class, 'sendRequestToRealtyOwner'])->name('customer.advisory.send_request_to_realty_owner');

// Post controller
Route::get('/tin-tuc', [CustomerPostController::class, 'index'])->name('customer.post.index');
Route::get('tin-tuc/tag/{slug}', [CustomerPostController::class, 'getPostByTag'])->name('customer.post_tag.get_all');
Route::get('/tin-tuc/{cat_slug}', [CustomerPostController::class, 'showByCategory'])->name('customer.post.show_by_category');
Route::get('/tin-tuc/{cat_slug}/{post_slug}', [CustomerPostController::class, 'show'])->name('customer.post.show');

Route::get('/lien-he', [ContactController::class, 'showFrontend'])->name('admin.class_request.show_frontend');

Route::get('du-an{search_slug}', [ProjectCustomerController::class, 'index'])->name('customer.project.index');
Route::get('du-an/{slug}', [ProjectCustomerController::class, 'show'])->name('customer.project.show');
Route::get('tag/{slug}', [RealtyTagController::class, 'getRealtyByTag'])->name('customer.realty_tag.get_all');
Route::get('/{search_slug}', [RealtyPostController::class, 'searchByParam'])->name('customer.realty_post.search_by_param');

Route::get('/v2/{any}', function () {
    return view('app.main');
});