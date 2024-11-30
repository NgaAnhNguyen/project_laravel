<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryProducts;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BranchProduct;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdminController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [PageController::class, 'welcome']);
Route::get('/welcome', [PageController::class, 'welcome']);
Route::get('/tim-kiem', [PageController::class, 'search']);

Route::get('/dashboard', [HomeController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::post('/save-cart', [CartController::class, 'save_cart']); //->name('cart.save');
    Route::get('/view-cart', [CartController::class, 'view_cart']);
    Route::get('/gio-hang', [CartController::class, 'gio_hang']);
    Route::get('/del-cart/{session_id}', [CartController::class, 'del_cart']);
    Route::get('/logout', [HomeController::class, 'logout']);

    Route::get('/delete-to-cart/{rowId}', [CartController::class, 'delete_row_cart']);
    Route::get('/delete-cart', [CartController::class, 'delete_cart']);

    Route::post('/add-cart-ajax', [CartController::class, 'add_cart_ajax']);
    Route::post('/update-cart', [CartController::class, 'update_cart']);
    Route::post('/update-view-cart', [CartController::class, 'update_cart_quanlity']);


    Route::get('/checkout', [CheckoutController::class, 'checkout']);
    Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// Product Detail
Route::get('/chi-tiet-san-pham/{product_id}', [ProductController::class, 'detail_product']);

// Category, Brand homepage
Route::get('/danh-muc-san-pham/{category_id}', [CategoryProducts::class, 'category_by_id']);
Route::get('/thuong-hieu-san-pham/{brand_id}', [BranchProduct::class, 'brand_by_id']);
// Product Detail


Route::get('/chi-tiet-san-pham/{product_id}', [ProductController::class, 'detail_product']);


// Category Product
Route::get('/all-category-product', [CategoryProducts::class, 'all_category_product']);


// Branch Product
Route::get('/all-branch-product', [BranchProduct::class, 'all_branch_product']);

// Product

Route::get('/all-product', [ProductController::class, 'all_product']);


