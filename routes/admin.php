<?php

use App\Http\Controllers\Admin\AdminManagerController;
use App\Http\Controllers\Admin\AdvertismentController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\BillController;
use App\Http\Controllers\Admin\CommuneController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DistrictController;
use App\Http\Controllers\Admin\FilemanagerController;
use App\Http\Controllers\Admin\GroundController;
use App\Http\Controllers\Admin\HelperServiceController;
use App\Http\Controllers\Admin\HomeController as HomeAdminController;
use App\Http\Controllers\Admin\MenuCategoryController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\PostCategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\PostRankController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ProvinceController;
use App\Http\Controllers\Admin\RealtyPostController as AdminRealtyPostController;
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Admin\SlugController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\ThemeOptionController;
use App\Http\Controllers\Admin\WebConfigController;
use App\Http\Controllers\Admin\WidgetController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\CrawController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {

    Route::get('logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    Route::get('forgot-password', [AdminLoginController::class, 'showResetForm'])->name('admin.password.request');
    Route::post('forgot-password', [AdminLoginController::class, 'sendRequestMail'])->name('admin.password.send_request_mail');

    Route::get('reset-password/{token}', [AdminLoginController::class, 'showResetPasswordForm'])->name('admin.password.reset');

    Route::get('dashboard', [HomeAdminController::class, 'index'])->name('admin.dashboard');

    // slug
    Route::post('slug/get', [SlugController::class, 'create'])->name('admin.slug.create');

    //Realty Post
    Route::get('realty-post', [AdminRealtyPostController::class, 'index'])->name('admin.realty_post.index');
    Route::get('realty-post/create', [AdminRealtyPostController::class, 'create'])->name('admin.realty_post.create');
    Route::post('realty-post/create', [AdminRealtyPostController::class, 'store'])->name('admin.realty_post.store');
    Route::get('realty-post/edit/{id}', [AdminRealtyPostController::class, 'edit'])->name('admin.realty_post.edit');
    Route::post('realty-post/edit/{id}', [AdminRealtyPostController::class, 'update'])->name('admin.realty_post.update');
    Route::post('realty-post/destroy/{id}', [AdminRealtyPostController::class, 'destroy'])->name('admin.realty_post.destroy');
    Route::get('realty-post/list', [AdminRealtyPostController::class, 'list'])->name('admin.realty_post.list');
    // post rank controller
    Route::get('post-rank', [PostRankController::class, 'index'])->name('admin.post_rank.index');
    Route::get('post-rank/create', [PostRankController::class, 'create'])->name('admin.post_rank.create');
    Route::post('post-rank/create', [PostRankController::class, 'store'])->name('admin.post_rank.store');
    Route::get('post-rank/edit/{id}', [PostRankController::class, 'edit'])->name('admin.post_rank.edit');
    Route::post('post-rank/edit/{id}', [PostRankController::class, 'update'])->name('admin.post_rank.update');
    Route::get('post-rank/destroy/{id}', [PostRankController::class, 'destroy'])->name('admin.post_rank.destroy');
    // widget
    // widget controller
    Route::get('widget', [WidgetController::class, 'index'])->name('admin.widget.index');
    Route::get('widget/store', [WidgetController::class, 'store'])->name('admin.widget.store');
    Route::get('widget/destroy', [WidgetController::class, 'destroy'])->name('admin.widget.destroy');
    // File manager
    Route::group(['prefix' => 'laravel-filemanager'], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });
    Route::get('filemanager', [FileManagerController::class, 'index'])->name('admin.filemanager.index');
    //post controler
    Route::get('post', [PostController::class, 'index'])->name('admin.post.index');
    Route::get('post/create', [PostController::class, 'create'])->name('admin.post.create');
    Route::post('post/create', [PostController::class, 'store'])->name('admin.post.store');
    Route::get('post/edit/{id}', [PostController::class, 'edit'])->name('admin.post.edit');
    Route::post('post/edit/{id}', [PostController::class, 'update'])->name('admin.post.update');
    Route::get('post/destroy/{id}', [PostController::class, 'destroy'])->name('admin.post.destroy');
    Route::get('post/list', [PostController::class, 'list'])->name('admin.post.list');
    // post category controller
    Route::get('post-category', [PostCategoryController::class, 'index'])->name('admin.post_category.index');
    Route::get('post-category/create', [PostCategoryController::class, 'create'])->name('admin.post_category.create');
    Route::post('post-category/create', [PostCategoryController::class, 'store'])->name('admin.post_category.store');
    Route::get('post-category/edit/{id}', [PostCategoryController::class, 'edit'])->name('admin.post_category.edit');
    Route::post('post-category/edit/{id}', [PostCategoryController::class, 'update'])->name('admin.post_category.update');
    Route::get('post-category/destroy/{id}', [PostCategoryController::class, 'destroy'])->name('admin.post_category.destroy');
    //Seo management
    Route::get('seo', [SeoController::class, 'index'])->name('admin.seo.index');
    Route::post('seo/store', [SeoController::class, 'store'])->name('admin.seo.store');
    Route::get('seo/get-detail', [SeoController::class, 'getDetails'])->name('admin.seo.get_detail');
    Route::post('seo/destroy/{id}', [SeoController::class, 'destroy'])->name('admin.seo.destroy');
    Route::get('seo/update-sitemap', [SeoController::class, 'updateSitemap'])->name('admin.seo.update_sitemap');
    // Menu category
    Route::get('menu-category', [MenuCategoryController::class, 'index'])->name('admin.menu_category.index');
    Route::get('menu-category/create', [MenuCategoryController::class, 'create'])->name('admin.menu_category.create');
    Route::post('menu-category/store', [MenuCategoryController::class, 'store'])->name('admin.menu_category.store');
    Route::get('menu-category/edit/{id}', [MenuCategoryController::class, 'edit'])->name('admin.menu_category.edit');
    Route::post('menu-category/update/{id}', [MenuCategoryController::class, 'update'])->name('admin.menu_category.update');
    Route::get('menu-category/destroy/{id}', [MenuCategoryController::class, 'destroy'])->name('admin.menu_category.destroy');
    // Menu ediotr
    Route::get('menu', [MenuController::class, 'index'])->name('admin.menu.index');
    Route::post('menu/store', [MenuController::class, 'store'])->name('admin.menu.store');
    Route::post('menu/update', [MenuController::class, 'update'])->name('admin.menu.update');
    Route::post('menu/save-tree', [MenuController::class, 'saveTree'])->name('admin.menu.save_tree');
    Route::post('menu/destroy', [MenuController::class, 'destroy'])->name('admin.menu.destroy');
    // Theme options
    Route::get('theme-options', [ThemeOptionController::class, 'index'])->name('admin.theme_option.index');
    Route::post('theme-options/store', [ThemeOptionController::class, 'store'])->name('admin.theme_option.store');
    // Webconfig
    Route::get('web-config', [WebConfigController::class, 'index'])->name('admin.web_config.index');
    Route::post('web-config/store', [WebConfigController::class, 'store'])->name('admin.web_config.store');

    Route::get('web-config/social', [WebConfigController::class, 'getSocialForm'])->name('admin.web_config.get_social_form');
    // Bill controller
    Route::get('bill', [BillController::class, 'listBillAdmin'])->name('admin.bill.admin_list');
    Route::get('bill/edit/{id}', [BillController::class, 'edit'])->name('admin.bill.edit');
    Route::post('bill/edit/{id}', [BillController::class, 'update'])->name('admin.bill.update');

    Route::get('bill/destroy/{id}', [BillController::class, 'destroy'])->name('admin.bill.destroy');

    //Project controller
    Route::get('project', [ProjectController::class, 'index'])->name('admin.project.index');
    Route::get('project/create', [ProjectController::class, 'create'])->name('admin.project.create');
    Route::post('project/create', [ProjectController::class, 'store'])->name('admin.project.store');
    Route::get('project/edit/{id}', [ProjectController::class, 'edit'])->name('admin.project.edit');
    Route::post('project/edit/{id}', [ProjectController::class, 'update'])->name('admin.project.update');
    Route::post('project/destroy/{id}', [ProjectController::class, 'destroy'])->name('admin.project.destroy');
    Route::get('project/list', [ProjectController::class, 'list'])->name('admin.project.list');

    //Ground controller
    Route::get('ground/{project_id}', [GroundController::class, 'index'])->name('admin.ground.index');
    Route::post('ground/create', [GroundController::class, 'store'])->name('admin.ground.store');
    Route::get('ground/edit/{id}', [GroundController::class, 'edit'])->name('admin.ground.edit');
    Route::post('ground/edit/{id}', [GroundController::class, 'update'])->name('admin.ground.update');
    Route::post('ground/destroy/{id}', [GroundController::class, 'destroy'])->name('admin.ground.destroy');

    // Tag controller
    Route::get('tag', [TagController::class, 'index'])->name('admin.tag.index');
    Route::get('tag/create', [TagController::class, 'create'])->name('admin.tag.create');
    Route::post('tag/create', [TagController::class, 'store'])->name('admin.tag.store');
    Route::get('tag/edit/{id}', [TagController::class, 'edit'])->name('admin.tag.edit');
    Route::post('tag/edit/{id}', [TagController::class, 'update'])->name('admin.tag.update');
    Route::post('tag/destroy/{id}', [TagController::class, 'destroy'])->name('admin.tag.destroy');
    Route::get('tag/list', [TagController::class, 'list'])->name('admin.tag.list');

    //Bank controller
    Route::get('bank', [BankController::class, 'index'])->name('admin.bank.index');
    Route::get('bank/create', [BankController::class, 'create'])->name('admin.bank.create');
    Route::post('bank/create', [BankController::class, 'store'])->name('admin.bank.store');
    Route::get('bank/edit/{id}', [BankController::class, 'edit'])->name('admin.bank.edit');
    Route::post('bank/edit/{id}', [BankController::class, 'update'])->name('admin.bank.update');
    Route::get('bank/destroy/{id}', [BankController::class, 'destroy'])->name('admin.bank.destroy');

    //Advertisment controller
    Route::get('advertisment', [AdvertismentController::class, 'index'])->name('admin.advertisment.index');
    Route::get('advertisment/create', [AdvertismentController::class, 'create'])->name('admin.advertisment.create');
    Route::post('advertisment/create', [AdvertismentController::class, 'store'])->name('admin.advertisment.store');
    Route::get('advertisment/edit/{id}', [AdvertismentController::class, 'edit'])->name('admin.advertisment.edit');
    Route::post('advertisment/edit/{id}', [AdvertismentController::class, 'update'])->name('admin.advertisment.update');
    Route::get('advertisment/destroy/{id}', [AdvertismentController::class, 'destroy'])->name('admin.advertisment.destroy');

    //Partner controller
    Route::get('partner', [PartnerController::class, 'index'])->name('admin.partner.index');
    Route::get('partner/create', [PartnerController::class, 'create'])->name('admin.partner.create');
    Route::post('partner/create', [PartnerController::class, 'store'])->name('admin.partner.store');
    Route::get('partner/edit/{id}', [PartnerController::class, 'edit'])->name('admin.partner.edit');
    Route::post('partner/edit/{id}', [PartnerController::class, 'update'])->name('admin.partner.update');
    Route::get('partner/destroy/{id}', [PartnerController::class, 'destroy'])->name('admin.partner.destroy');

    // Online class request
    Route::get('contact', [ContactController::class, 'index'])->name('admin.contacts.index');
    Route::get('contact/list', [ContactController::class, 'list'])->name('admin.contacts.list');
    Route::get('contact/edit/{id}', [ContactController::class, 'edit'])->name('admin.contacts.edit');
    Route::post('contact/edit/{id}', [ContactController::class, 'update'])->name('admin.contacts.update');
    Route::post('contact/destroy/{id}', [ContactController::class, 'destroy'])->name('admin.contacts.destroy');

    //Admin manager
    Route::get('admin-manager', [AdminManagerController::class, 'index'])->name('admin.admin_manager.index');
    Route::get('admin-manager/create', [AdminManagerController::class, 'create'])->name('admin.admin_manager.create');
    Route::post('admin-manager/create', [AdminManagerController::class, 'store'])->name('admin.admin_manager.store');
    Route::get('admin-manager/edit/{id}', [AdminManagerController::class, 'edit'])->name('admin.admin_manager.edit');
    Route::post('admin-manager/edit/{id}', [AdminManagerController::class, 'update'])->name('admin.admin_manager.update');
    Route::post('admin-manager/destroy/{id}', [AdminManagerController::class, 'destroy'])->name('admin.admin_manager.destroy');
    Route::get('admin-manager/list', [AdminManagerController::class, 'list'])->name('admin.admin_manager.list');

    //customer manager
    Route::get('customer-manager', [CustomerController::class, 'index'])->name('admin.customer_manager.index');
    Route::get('customer-manager/create', [CustomerController::class, 'create'])->name('admin.customer_manager.create');
    Route::post('customer-manager/create', [CustomerController::class, 'store'])->name('admin.customer_manager.store');
    Route::get('customer-manager/edit/{id}', [CustomerController::class, 'edit'])->name('admin.customer_manager.edit');
    Route::post('customer-manager/edit/{id}', [CustomerController::class, 'update'])->name('admin.customer_manager.update');
    Route::post('customer-manager/destroy/{id}', [CustomerController::class, 'destroy'])->name('admin.customer_manager.destroy');
    Route::get('customer-manager/list', [CustomerController::class, 'list'])->name('admin.customer_manager.list');

//customer
    //Province manager
    Route::get('province', [ProvinceController::class, 'index'])->name('admin.province.index');
    Route::get('province/create', [ProvinceController::class, 'create'])->name('admin.province.create');
    Route::post('province/create', [ProvinceController::class, 'store'])->name('admin.province.store');
    Route::get('province/edit/{id}', [ProvinceController::class, 'edit'])->name('admin.province.edit');
    Route::post('province/edit/{id}', [ProvinceController::class, 'update'])->name('admin.province.update');
    Route::post('province/destroy/{id}', [ProvinceController::class, 'destroy'])->name('admin.province.destroy');
    Route::get('province/list', [ProvinceController::class, 'list'])->name('admin.province.list');
    //District manager
    Route::get('district', [DistrictController::class, 'index'])->name('admin.district.index');
    Route::get('district/create', [DistrictController::class, 'create'])->name('admin.district.create');
    Route::post('district/create', [DistrictController::class, 'store'])->name('admin.district.store');
    Route::get('district/edit/{id}', [DistrictController::class, 'edit'])->name('admin.district.edit');
    Route::post('district/edit/{id}', [DistrictController::class, 'update'])->name('admin.district.update');
    Route::post('district/destroy/{id}', [DistrictController::class, 'destroy'])->name('admin.district.destroy');
    Route::get('district/list', [DistrictController::class, 'list'])->name('admin.district.list');
    //Cummune manager
    Route::get('commune', [CommuneController::class, 'index'])->name('admin.commune.index');
    Route::get('commune/create', [CommuneController::class, 'create'])->name('admin.commune.create');
    Route::post('commune/create', [CommuneController::class, 'store'])->name('admin.commune.store');
    Route::get('commune/edit/{id}', [CommuneController::class, 'edit'])->name('admin.commune.edit');
    Route::post('commune/edit/{id}', [CommuneController::class, 'update'])->name('admin.commune.update');
    Route::post('commune/destroy/{id}', [CommuneController::class, 'destroy'])->name('admin.commune.destroy');
    Route::get('commune/list', [CommuneController::class, 'list'])->name('admin.commune.list');

    // API service
    Route::post('api-service/multiple-delete', [HelperServiceController::class, 'multiDelete'])->name('admin.helper_service.multi_delete');

    //crawler controller
    Route::get('/craw', [CrawController::class, 'showCrawForm'])->name('admin.craw.showCrawForm');
    Route::post('/craw', [CrawController::class, 'getByLink'])->name('admin.craw.getByLink');
});