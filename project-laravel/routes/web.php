<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
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

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\PasswordController;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});
Route::post('/dashboard', [HomeController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});




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


// Category, Brand homepage
Route::get('/danh-muc-san-pham/{category_id}', [CategoryProducts::class, 'category_by_id']);
Route::get('/thuong-hieu-san-pham/{brand_id}', [BranchProduct::class, 'brand_by_id']);

// Product Detail


Route::get('/chi-tiet-san-pham/{product_id}', [ProductController::class, 'detail_product']);

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

    Route::get('/checkout', [CheckoutController::class, 'checkout']);
    Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';



// Category, Brand homepage
Route::get('/danh-muc-san-pham/{category_id}', [CategoryProducts::class, 'category_by_id']);
// Route::get('/thuong-hieu-san-pham/{brand_id}', [BranchProduct::class, 'brand_by_id']);

// Product Detail


Route::get('/chi-tiet-san-pham/{product_id}', [ProductController::class, 'detail_product']);



// Category Product
Route::get('/all-category-product', [CategoryProducts::class, 'all_category_product']);



Route::get('/forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm']);
Route::post('/forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm']);

Route::post('/reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm']);
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm']);
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


Route::get('/verify-email/{token}', [CheckoutController::class, 'verify_email']);

Route::get('/verify-email-notice', function() {
    return view('email.verifyNotice');
})->name('email.verify.notice');

// Product Detail
Route::get('/chi-tiet-san-pham/{product_id}', [ProductController::class, 'detail_product']);

Route::post('/logout',[CheckoutController::class,'logout']);

Route::post('/add-customer',[CheckoutController::class,'add_customer']);
