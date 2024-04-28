<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'index'])->name('dashboard');
    Route::get('/profile/type', [ProfileController::class, 'index_profile'])->name('profile.type');
    Route::patch('/profile/type', [ProfileController::class, 'update_type'])->name('profile.update.type');

    //For Storage Admin
    Route::middleware('authStorageAdmin')->group(function () {
        Route::post('/dashboard', [WarehouseController::class, 'store_sensors'])->name('dashboard.update');

        Route::get('/warehouse', [WarehouseController::class, 'index'])->name('warehouse');
        Route::get('/reception', [WarehouseController::class, 'reception'])->name('warehouse.reception');
        Route::get('/bath', [WarehouseController::class, 'bath'])->name('warehouse.bath');

        Route::get('/warehouse/pictures', [WarehouseController::class, 'index_pictures'])->name('warehouse.pictures');
        Route::post('/warehouse/pictures', [WarehouseController::class, 'store_picture'])->name('warehouse.pictures.update');
        Route::get('/warehouse/disclaimer', [WarehouseController::class, 'disclaimer'])->name('warehouse.disclaimer');
        Route::post('/warehouse/disclaimer', [WarehouseController::class, 'store_disclaimer'])->name('warehouse.disclaimer.update');
        Route::post('/warehouse', [WarehouseController::class, 'store'])->name('warehouse.update');
        Route::get('/history/{name}', [WarehouseController::class, 'history'])->name('warehouse.history');
    });

    //Admins
    Route::middleware('authAdmin')->group(function () {
        //Products
        Route::get('/produtos/eliminados', [ProductController::class, 'index_deleted'])->name('products.deleted');
        Route::post('/recover/{produto}', [ProductController::class, 'recover_deleted'])->name('recover');
        Route::get('/produtos/new', [ProductController::class, 'new'])->name('product.new');
        Route::post('/produtos/new', [ProductController::class, 'store_new']);
        Route::patch('/produtos/{produto}', [ProductController::class, 'update']);
        Route::delete('/produtos/{produto}', [ProductController::class, 'destroy']);
    });

    //Admins and Clients
    Route::middleware('authAdmCli')->group(function () {
        Route::get('/produtos', [ProductController::class, 'index'])->name('products');
        Route::get('/produtos/{produto}', [ProductController::class, 'show'])->name('product');
    });

    //Clients
    Route::middleware('authClient')->group(function () {
        Route::get('/cart', [CartController::class, 'index'])->name('cart');
        Route::post('/cart', [CartController::class, 'store']);
        Route::delete('/cart/{venda}', [CartController::class, 'deleteItem'])->name('cart.delete');
        Route::post('/produtos/{produto}', [ProductController::class, 'store']);
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
