<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\ColorController;
use App\Http\Middleware\EnsureAdminIsValid;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/admin/registeration', function () {
    return view('admin-registeration');
});

Route::post('admin/registeration/submit', [AdminController::class, 'submitRegisterationForm'])->name('admin.registeration.submit');

Route::get('/registeration', function () {
    return view('user-registeration');
});

Route::post('/registeration', function () {
    return view('user-registeration');
});

Route::post('/registeration/submit', [UserController::class, 'submitRegisterationForm'])->name('registeration.submit');

Route::get('/user/login', function () {
    return view('user-login');
})->name('user-login');

Route::post('/user/login', [UserController::class, 'submitLoginForm'])->name('user.login.submit');

Route::get('/logout', function () {
    Auth::logout(); // Logout current user for default guard
    return redirect('/user/login');
})->name('logout');

Route::get('admin/logout/', function () {
    Auth::guard('admin')->logout(); // Logout current user for default guard
    return redirect('/user/login');
})->name('admin.logout');




Route::get('/category/{slug}', [ProductController::class, 'filterProducts'])->name('product_filter');
// Route::get('/category-product-filter', [ProductController::class, 'filterProducts'])->name('product_filter');

Route::post('/add-size', [SizeController::class, 'store'])->name('sizes.store');
Route::get('/get-sizes', [SizeController::class, 'fetch_sizes'])->name('sizes.get');

Route::middleware(['ensure.admin.is.valid'])->group(function () {
    Route::get('/admin/product-form', [ProductController::class, 'showForm'])->name('product.form');
    // Add other admin routes here
    Route::get('/admin/category-form', [CategoryController::class, 'viewCategoryForm'])->name('category.form');

    Route::post('/admin/category/submit', [CategoryController::class, 'submitCategoryForm'])->name('category.form.submit');
    
    Route::get('/admin/color-form', function () {
        return view('color-form');
    });
    Route::get('/admin/color-form', function () {
        return view('color-form');
    });
    Route::post('/admin/color/submit', [ColorController::class, 'submitColorForm'])->name('color.form.submit');

    Route::post('/admin/brand/submit', [BrandController::class, 'submitBrandForm'])->name('brand.form.submit');

    Route::get('/admin/product-form', [ProductController::class, 'viewProductForm'])->name('product.create');
    
    Route::post('/admin/product/submit', [ProductController::class, 'storeProduct'])->name('product.submit');
});

Route::get('/single-product/{id}',function(){
    return view('single-product'); 
});

Route::get('/single-product/{id}',[ProductController::class,'showProducts'])
->name('product.show');