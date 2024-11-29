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


// Category, Brand homepage
Route::get('/danh-muc-san-pham/{category_id}', [CategoryProducts::class, 'category_by_id']);
Route::get('/thuong-hieu-san-pham/{brand_id}', [BranchProduct::class, 'brand_by_id']);

// Category Product
Route::get('/all-category-product', [CategoryProducts::class, 'all_category_product']);


// Branch Product
Route::get('/all-branch-product', [BranchProduct::class, 'index'])->name('all-branch');
Route::group(['prefix' => 'branches', 'as' => 'branches.'], function () {     
    Route::get('/add-branch-product', [BranchProduct::class, 'createBranch'])->name('create');
    Route::get('/edit-branch-product/{branch_id}', [BranchProduct::class, 'editBranch'])->name('edit');
    Route::put('/update-branch-product/{branch_id}', [BranchProduct::class, 'updateBranch'])->name('update');
    Route::post('/save-branch-product', [BranchProduct::class, 'saveBranch'])->name('save_branch');
    Route::delete('/delete/{branch_id}', [BranchProduct::class, 'deleteBranch'])->name('delete');
});
Route::get('/search-branch', [BranchProduct::class, 'searchBranch'])->name('search_branch');


// Product Routes
Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
    Route::get('/add-product', [ProductController::class, 'showAddProductForm'])->name('create');
    Route::post('/save-product', [ProductController::class, 'saveProduct'])->name('save');
    Route::get('/edit-product/{id}', [ProductController::class, 'editProduct'])->name('edit');
    Route::put('/update-product/{id}', [ProductController::class, 'updateProduct'])->name('update');
    Route::delete('/delete-product/{product_id}', [ProductController::class, 'deleteProduct'])->name('delete');
    Route::get('/detail/{product_id}', [ProductController::class, 'showProduct'])->name('show');
    Route::get('/all-product', [ProductController::class, 'index'])->name('index');
});
Route::get('/search-product', [ProductController::class, 'searchProduct'])->name('search-product');


// Product Detail
Route::get('/chi-tiet-san-pham/{product_id}', [ProductController::class, 'detail_product']);


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





