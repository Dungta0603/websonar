<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\homeController;
use App\Http\Controllers\User\commentController;


Route::prefix('/')->group(function(){
    Route::get('', [homeController::class, 'index'])->name('home');
    Route::get('detail/{slug}', [homeController::class, 'detail'])->name('detail');
    Route::get('category/{slug}', [homeController::class, 'category'])->name('category');
    Route::get('tag/{tag}', [homeController::class, 'tag'])->name('tag');
    Route::get('search', [homeController::class, 'searchPage'])->name('search');
    Route::get('searchAPI', [homeController::class, 'searchAPI'])->name('searchAPI');

    Route::prefix('comment')->group(function(){
        Route::post('store', [commentController::class, 'store'])->name('comment.store');
        Route::get('delete/{id}', [commentController::class, 'delete'])->name('comment.delete');
        Route::post('reply', [commentController::class, 'reply'])->name('comment.reply');
    });

});
