<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    Auth\LoginController,
    AdminDashboardController,
    UsersController,
    ProductsController
};

// Route Admin Login
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])
    ->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login']);

Route::group([
    'prefix' => 'admin',
    'middleware' => 'web'
    ], function () {
    /** Route Logout */
    Route::post('/admin/logout', [LoginController::class, 'logout'])
    ->name('admin.logout');
    /** Dashboard System */
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
    ->name('admin.dashboard');
    /**
     * Route Users
     */
    Route::group(['prefix' => '/users'], function () {
        Route::get('/form', [UsersController::class, 'create'])
            ->name('admin.users.create');
        Route::patch('/', [UsersController::class, 'store'])
            ->name('admin.users.store');
        Route::get('/{user}/form', [UsersController::class, 'edit'])
            ->name('admin.users.edit');
        Route::patch('/{user}', [UsersController::class, 'update'])
            ->name('admin.users.update');
        Route::get('/trash', [UsersController::class, 'index'])
            ->name('admin.users.trashed');
        Route::patch('/trash/{user}', [UsersController::class, 'trash'])
            ->name('admin.users.trash');
        Route::get('/{id}/restore', [UsersController::class, 'restore'])
            ->name('admin.users.restore')
            ->where('id', '[0-9]+');
        Route::delete('{id}/delete', [UsersController::class, 'destroy'])
            ->name('admin.users.destroy')
            ->where('id', '[0-9]+');
        Route::get('/', [UsersController::class, 'index'])
            ->name('admin.users')
            ->middleware('cache_response');
    });
    /**
     * Route Products
     */
    Route::group(['prefix' => '/products'], function () {
        Route::get('/form', [ProductsController::class, 'create'])
            ->name('admin.products.create');
        Route::patch('/', [ProductsController::class, 'store'])
            ->name('admin.products.store');
        Route::get('/{product}/form', [ProductsController::class, 'edit'])
            ->name('admin.products.edit');
        Route::patch('/{product}', [ProductsController::class, 'update'])
            ->name('admin.products.update');
        Route::get('/trash', [ProductsController::class, 'index'])
            ->name('admin.products.trashed');
        Route::patch('/trash/{product}', [ProductsController::class, 'trash'])
            ->name('admin.products.trash');
        Route::get('/{id}/restore', [ProductsController::class, 'restore'])
            ->name('admin.products.restore')
            ->where('id', '[0-9]+');
        Route::delete('{id}/delete', [ProductsController::class, 'destroy'])
            ->name('admin.products.destroy')
            ->where('id', '[0-9]+');
        Route::get('/', [ProductsController::class, 'index'])
            ->name('admin.products')
            ->middleware('cache_response');
    });
});
