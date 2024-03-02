<?php

use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [UserController::class, 'displayHome'])->name('display.home');




Route::get('/home',[HomeController::class, 'index'])->middleware('auth') ->name('home');
Route::get('/products',[HomeController::class, 'display_Products']) ->name('display.product');

// Route::get('/products',[AdminController::class, 'index'])->middleware(['auth','admin']) ->name('products');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ==========================User Route=====================================================
Route::group(['prefix' =>'user', 'as' => 'user.','middleware' => ['auth','user']], function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
});



// =============================AdminRoute===================================================
Route::group(['prefix' => 'admin', 'as' => 'admin.','middleware' => ['auth', 'admin']], function () {
    Route::get('/post', [AdminController::class, 'post'])->name('post');
    Route::get('/category',[CategoryController::class, 'displayCategory'])->name('category');
    Route::get('/dashboard',[AdminController::class, 'displayDashboard'])->name('dashboard');


    // CATEGORY
    Route::get('create-category',[AdminController::class,'addCategory'])->name('add.category');
    Route::post('store-category',[AdminController::class,'storeCategory'])->name('store.category');
    Route::get('category/{id}',[CategoryController::class,'editCategory'])->name('edit.category');
    Route::post('update-category/{id}',[CategoryController::class,'updateCategory'])->name('update.category');
    Route::get('delete-category/{id}',[CategoryController::class,'deleteCategory'])->name('delete.category');

    // USER
    Route::get('users',[UserController::class, 'index'])->name('users');
    Route::get('user/{id}',[UserController::class, 'view'])->name('view.user');
    Route::get('delete-user/{id}',[UserController::class,'deleteUser'])->name('delete.user');

    // PRODUCT
    Route::get('products',[ProductController::class, 'index'])->name('products');
    Route::get('create-product',[ProductController::class, 'create'])->name('create.product');
    Route::post('store-product', [ProductController::class, 'store'])->name('store.product');
    Route::get('edit-product/{id}',[ProductController::class, 'edit'])->name('edit.product');
    Route::post('update-product/{id}',[ProductController::class, 'update'])->name('update.product');
    Route::get('delete-product/{id}',[ProductController::class, 'delete'])->name('delete.product');





});



require __DIR__.'/auth.php';
