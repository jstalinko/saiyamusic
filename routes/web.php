<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JadiFrontendController;
use Inertia\Inertia;


Route::group(['middleware' => 'seo'], function () {
    Route::get('/', [JadiFrontendController::class, 'home'])->name('home');
    Route::get('/contact', [JadiFrontendController::class, 'contact'])->name('contact');

    Route::get('/page/{slug}', [JadiFrontendController::class, 'detailPage'])->name('page');
    Route::get('/category/{slug}', [JadiFrontendController::class, 'categoryPost'])->name('category.post');
    Route::get('/tag/{slug}', [JadiFrontendController::class, 'tagPost'])->name('tag.post');
    Route::get('/author/{slug}', [JadiFrontendController::class, 'authorPost'])->name('author.post');
    Route::get('/archive/{slug}', [JadiFrontendController::class, 'archivePost'])->name('archive.post');
    Route::get('/search', [JadiFrontendController::class, 'searchPost'])->name('search.post');
    Route::get('/posts', [JadiFrontendController::class, 'posts'])->name('posts');
    Route::get('/products', [JadiFrontendController::class, 'products'])->name('products');
    Route::get('/product/{slug}', [JadiFrontendController::class, 'detailProduct'])->name('product.detail');
    Route::get('/{slug}', [JadiFrontendController::class, 'detailPost'])->name('post.detail');
});
