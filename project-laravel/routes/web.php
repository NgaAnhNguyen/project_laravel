<?php

use App\Http\Controllers\CategoryProducts;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;

use App\Http\Controllers\BranchProduct;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DeliveryController;


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

Route::post('/save-cart ', [CartController::class, 'save_cart']);
Route::get('/view-cart', [CartController::class, 'view_cart']);
Route::get('/gio-hang', [CartController::class, 'gio_hang']);




// Login Checkout
Route::get('/checkout', [CheckoutController::class, 'checkout']);
Route::get('/logout-checkout', [CheckoutController::class, 'logout_checkout']);
Route::get('/payment', [CheckoutController::class, 'payment']);
Route::post('/add-customer', [CheckoutController::class, 'add_customer']);
Route::post('/login', [CheckoutController::class, 'login_customer']);
Route::get('/login', [CheckoutController::class, 'login_customer']);
Route::post('/save-checkout-customer', [CheckoutController::class, 'save_checkout_customer']);
Route::get('/login-checkout', [CheckoutController::class, 'login_checkout']);




