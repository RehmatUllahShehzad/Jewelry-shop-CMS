<?php

use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\NewsController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', PageController::class)->name('homepage');
Route::get('category/{category:slug}/{subCategory:slug?}', CategoryController::class)->name('category');
Route::get('blog/{blog:slug}', BlogController::class)->name('blog.show');
Route::get('news/{news:slug}', NewsController::class)->name('news.show');
Route::get('category/{category:slug}/{subCategory:slug}/{product:slug}', ProductController::class)->name('product.show');
Route::get('{page:slug}', PageController::class)->name('page');
