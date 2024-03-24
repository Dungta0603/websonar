<?php

use App\Http\Controllers\Admin\roleController;
use App\Http\Controllers\Admin\dashboardController;
use App\Http\Controllers\Admin\postController;
use App\Http\Controllers\Admin\categoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\permissionController;
use App\Http\Controllers\Admin\groupController;
use App\Http\Controllers\Admin\confirmController;

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:admin|author|manager'] ], function () {
    Route::get('/dashboard', function () {
        return view('admin/dashboard');
    });
    Route::group(['prefix' => 'user'] , function () {
        Route::get('index',[dashboardController::class,'index'])->name('admin.user.index');
        Route::get('role/{id}', [dashboardController::class,'role'])->name('admin.user.role');
        Route::post('doRole/{id}', [dashboardController::class,'doRole'])->name('admin.user.doRole');
        Route::post('doPermission/{id}', [dashboardController::class,'doPermission'])->name('admin.user.doPermission');
        Route::get('permission/{id}', [dashboardController::class, 'permission'])->name('admin.user.permission');
    });

//    Router Role

    Route::group(['prefix' => 'role', 'middleware' => ['role:admin']], function () {
        Route::get('index',[roleController::class,'index'])->name('admin.role.index');
        Route::get('create',[roleController::class,'create'])->name('admin.role.create');
        Route::post('store',[roleController::class,'store'])->name('admin.role.store');
        Route::get('edit/{slug}',[roleController::class,'edit'])->name('admin.role.edit');
        Route::patch('update/{id}',[roleController::class,'update'])->name('admin.role.update');
        Route::get('destroy/{id}',[roleController::class,'destroy'])->name('admin.role.destroy');

    });

    Route::group(['prefix' => 'permission', 'middleware' => ['role:admin']], function () {
        Route::get('index',[permissionController::class,'index'])->name('admin.permission.index');
        Route::get('create',[permissionController::class,'create'])->name('admin.permission.create');
        Route::post('store',[permissionController::class,'store'])->name('admin.permission.store');
        Route::get('edit/{slug}',[permissionController::class,'edit'])->name('admin.permission.edit');
        Route::patch('update/{id}',[permissionController::class,'update'])->name('admin.permission.update');
        Route::get('destroy/{id}',[permissionController::class,'destroy'])->name('admin.permission.destroy');

    });

    Route::group(['prefix' => 'post', 'middleware' => ['role:admin|manager|author']], function () {
        Route::get('index', [postController::class , 'index'])->name('admin.post.index');
        Route::get('restore', [postController::class , 'restore'])->name('admin.post.restore');
        Route::get('start-restore/{id}', [postController::class , 'startRestore'])->name('admin.post.startRestore');
        Route::get('create',[postController::class,'create'])->name('admin.post.create');
        Route::post('store',[postController::class,'store'])->name('admin.post.store');
        Route::get('edit/{id}',[postController::class,'edit'])->name('admin.post.edit');
        Route::patch('update/{id}',[postController::class,'update'])->name('admin.post.update');
        Route::get('destroy/{id}',[postController::class,'destroy'])->name('admin.post.destroy');
        Route::get('delete/{id}',[postController::class,'delete'])->name('admin.post.delete');

    });

    Route::group(['prefix' => 'category', 'middleware' => ['role:admin|manager']], function () {
        Route::get('index', [categoryController::class , 'index'])->name('admin.category.index');
        Route::get('create',[categoryController::class,'create'])->name('admin.category.create');
        Route::post('store',[categoryController::class,'store'])->name('admin.category.store');
        Route::get('edit/{id}',[categoryController::class,'edit'])->name('admin.category.edit');
        Route::post('update/{id}',[categoryController::class,'update'])->name('admin.category.update');
        Route::get('destroy/{id}',[categoryController::class,'destroy'])->name('admin.category.destroy');
    });

    Route::group(['prefix' => 'group', 'middleware' => ['role:admin|manager']], function () {
        Route::get('index', [groupController::class , 'index'])->name('admin.group.index');
        Route::get('create',[groupController::class,'create'])->name('admin.group.create');
        Route::post('store',[groupController::class,'store'])->name('admin.group.store');
        Route::get('edit/{id}',[groupController::class,'edit'])->name('admin.group.edit');
        Route::post('update/{id}',[groupController::class,'update'])->name('admin.group.update');
        Route::get('destroy/{id}',[groupController::class,'destroy'])->name('admin.group.destroy');
    });

    Route::group(['prefix' => 'confirm', 'middleware' => ['role:admin|manager']], function(){
        Route::get('index',[confirmController::class, 'index'])->name('admin.confirm.index');
        Route::post('status',[confirmController::class,'status'])->name('admin.group.status');
        Route::get('destroy/{id}',[confirmController::class,'destroy'])->name('admin.confirm.destroy');
        Route::get('show/{slug}', [confirmController::class,'show'])->name('admin.confirm.show');
    });

});
