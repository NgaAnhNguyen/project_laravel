<?php

use App\Http\Controllers\CategoryProducts;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BranchProduct;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminController;


// Frontend Routes
Route::get('/', [HomeController::class, 'index']);
Route::get('/trang-chu', [HomeController::class, 'index']);
Route::get('/tim-kiem', [HomeController::class, 'search']);

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


// Cart

Route::post('/save-cart', [CartController::class, 'save_cart']);
Route::get('/view-cart', [CartController::class, 'view_cart']);
Route::get('/gio-hang', [CartController::class, 'gio_hang']);
Route::get('/del-cart/{session_id}', [CartController::class, 'del_cart']);

Route::get('/delete-to-cart/{rowId}', [CartController::class, 'delete_row_cart']);
Route::get('/delete-cart', [CartController::class, 'delete_cart']);

Route::post('/add-cart-ajax', [CartController::class, 'add_cart_ajax']);
Route::post('/update-cart', [CartController::class, 'update_cart']);
Route::post('/update-view-cart', [CartController::class, 'update_cart_quanlity']);



// Login Checkout
Route::get('/checkout', [CheckoutController::class, 'checkout']);
Route::get('/logout-checkout', [CheckoutController::class, 'logout_checkout']);
Route::post('/add-customer', [CheckoutController::class, 'add_customer']);
Route::post('/login', [CheckoutController::class, 'login_customer']);
Route::get('/login', [CheckoutController::class, 'login_customer']);
Route::post('/save-checkout-customer', [CheckoutController::class, 'save_checkout_customer']);
Route::get('/login-checkout', [CheckoutController::class, 'login_checkout']);


Route::get('/admin', [AdminController::class, 'index']);
Route::get('/dashboard', [AdminController::class, 'admin_layout']);
Route::get('/logout', [AdminController::class, 'logout']);
Route::post('/admin_dashboard', [AdminController::class, 'dashboard']);





