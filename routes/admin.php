<?php

use App\Http\Controllers\Admin\Category\CategoryEditorController;
use App\Http\Controllers\Admin\Cms\BlogEditorController;
use App\Http\Controllers\Admin\Cms\NewsEditorController;
use App\Http\Controllers\Admin\Cms\PageEditorController;
use App\Http\Livewire\Admin\Catalog\Category\CategoryCreateController;
use App\Http\Livewire\Admin\Catalog\Category\CategoryIndexController;
use App\Http\Livewire\Admin\Catalog\Category\CategoryShowController;
use App\Http\Livewire\Admin\Catalog\Product\ProductCreateController;
use App\Http\Livewire\Admin\Catalog\Product\ProductIndexController;
use App\Http\Livewire\Admin\Catalog\Product\ProductShowController;
use App\Http\Livewire\Admin\Cms\Blog\BlogCreateController;
use App\Http\Livewire\Admin\Cms\Blog\BlogIndexController;
use App\Http\Livewire\Admin\Cms\Blog\BlogShowController;
use App\Http\Livewire\Admin\Cms\Menu\MenuBuilderController;
use App\Http\Livewire\Admin\Cms\Menu\MenuIndexController;
use App\Http\Livewire\Admin\Cms\News\NewsCreateController;
use App\Http\Livewire\Admin\Cms\News\NewsIndexController;
use App\Http\Livewire\Admin\Cms\News\NewsShowController;
use App\Http\Livewire\Admin\Cms\Page\PageCreateController;
use App\Http\Livewire\Admin\Cms\Page\PageIndexController;
use App\Http\Livewire\Admin\Cms\Page\PageShowController;
use App\Http\Livewire\Admin\Cms\Slide\SlideCreateController;
use App\Http\Livewire\Admin\Cms\Slide\SlideIndexController;
use App\Http\Livewire\Admin\Cms\Slide\SlideShowController;
use App\Http\Livewire\Admin\ContactUs\ContactUsIndexController;
use App\Http\Livewire\Admin\ContactUs\ContactUsShowController;
use App\Http\Livewire\Admin\Dashboard\DashboardController;
use App\Http\Livewire\Admin\Profile\StaffProfileController;
use App\Http\Livewire\Admin\System\Settings\SettingsController;
use App\Http\Livewire\Admin\System\Staff\StaffCreateController;
use App\Http\Livewire\Admin\System\Staff\StaffIndexController;
use App\Http\Livewire\Admin\System\Staff\StaffShowController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:admin')->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::middleware('permission:contact-us')->group(function () {
        Route::get('contact-us', ContactUsIndexController::class)->name('contact-us.index');
        Route::get('contact-us/{contactUs}/show', ContactUsShowController::class)->name('contact-us.show');
    });

    Route::prefix('catalog')->middleware('permission:catalog')->as('catalog.')->group(function () {
        Route::middleware('permission:catalog:manage-category')->group(function () {
            Route::get('category', CategoryIndexController::class)->name('category.index');
            Route::get('category/create/', CategoryCreateController::class)->name('category.create');
            Route::get('category/{category}', CategoryShowController::class)->name('category.show');
            Route::get('categories/editor/{category}', [CategoryEditorController::class, 'index'])->name('categories.editor.index');
            Route::post('categories/editor/{category}', [CategoryEditorController::class, 'store'])->name('categories.editor.store');
            Route::get('categories/editor/{category}/templates', [CategoryEditorController::class, 'templates'])->name('categories.editor.templates');
            Route::get('category/{parent}/create/', CategoryCreateController::class)->name('subcategory.create');
        });

        Route::middleware('permission:catalog:manage-products')->group(function () {
            Route::get('product', ProductIndexController::class)->name('product.index');
            Route::get('product/create', ProductCreateController::class)->name('product.create');
            Route::get('product/{product}', ProductShowController::class)->name('product.show');
        });
    });

    Route::prefix('cms')->middleware('permission:cms')->as('cms.')->group(function () {
        Route::middleware('permission:menu:manage-menus')->group(function () {
            Route::get('menus', MenuIndexController::class)->name('menu.index');
            Route::get('menus/{menu}/builder', MenuBuilderController::class)->name('menu.builder');
        });

        Route::middleware('permission:cms:manage-blogs')->group(function () {
            Route::get('blogs', BlogIndexController::class)->name('blogs.index');
            Route::get('blogs/create', BlogCreateController::class)->name('blogs.create');
            Route::get('blogs/{blog}', BlogShowController::class)->name('blogs.show');
            Route::get('blogs/editor/{blog}', [BlogEditorController::class, 'index'])->name('blogs.editor.index');
            Route::post('blogs/editor/{blog}', [BlogEditorController::class, 'store'])->name('blogs.editor.store');
            Route::get('blogs/editor/{blog}/templates', [BlogEditorController::class, 'templates'])->name('blogs.editor.templates');
        });

        Route::middleware('permission:cms:manage-pages')->group(function () {
            Route::get('pages', PageIndexController::class)->name('pages.index');
            Route::get('pages/create', PageCreateController::class)->name('pages.create');
            Route::get('pages/{page}', PageShowController::class)->name('pages.show');
            Route::get('pages/editor/{page}', [PageEditorController::class, 'index'])->name('pages.editor.index');
            Route::post('pages/editor/{page}', [PageEditorController::class, 'store'])->name('pages.editor.store');
            Route::get('pages/editor/{page}/templates', [PageEditorController::class, 'templates'])->name('pages.editor.templates');
        });

        Route::middleware('permission:cms:manage-news')->group(function () {
            Route::get('news', NewsIndexController::class)->name('news.index');
            Route::get('news/create', NewsCreateController::class)->name('news.create');
            Route::get('news/{news}', NewsShowController::class)->name('news.show');
            Route::get('news/editor/{news}', [NewsEditorController::class, 'index'])->name('news.editor.index');
            Route::post('news/editor/{news}', [NewsEditorController::class, 'store'])->name('news.editor.store');
            Route::get('news/editor/{news}/templates', [NewsEditorController::class, 'templates'])->name('news.editor.templates');
        });

        Route::prefix('{type}/{slideableId}')->where(['type' => 'page|category'])->as('slides.')->group(function () {
            Route::get('slides', SlideIndexController::class)->name('show');
            Route::get('create', SlideCreateController::class)->name('create');
            Route::get('edit/{slide}', SlideShowController::class)->name('edit');
        });
    });

    Route::prefix('system')->middleware('permission:system')->as('system.')->group(function () {
        Route::middleware('permission:system:manage-staff')->group(function () {
            Route::get('staff', StaffIndexController::class)->name('staff.index');
            Route::get('staff/create', StaffCreateController::class)->name('staff.create');
            Route::get('staff/{staff}', StaffShowController::class)->name('staff.show');
        });

        Route::middleware('permission:system:settings')->group(function () {
            Route::get('settings', SettingsController::class)->name('settings');
        });
    });

    Route::get('staff/account', StaffProfileController::class)->name('staff.profile');
});
