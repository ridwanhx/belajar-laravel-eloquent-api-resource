<?php

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Implementasi materi Resource
// Cara Kerja Resource
Route::get('/categories/{id}', [CategoryController::class, 'category_resource']);


// Implementasi materi Resource Collection
Route::get('/categories', [CategoryController::class, 'resourceCollection']);


// Implementasi materi Custom Resource Collection
Route::get('/categories-custom', [CategoryController::class, 'customResourceCollection']);


// Implementasi materi Data Wrap
// Route::get('/products/{id}', [ProductController::class, 'data_wrap']);


// Implementasi materi Conditional Attributes
Route::get('/products/{id}', function ($id) {
    $products = Product::find($id);
    $products->load('category');    // load data category
    return new ProductResource($products);
});


// Implementasi materi Data Wrap Collection
// Route::get('/products', [ProductController::class, 'data_wrap_collection']);


// Implementasi materi Conditional Attributes
Route::get('/products', function () {
    $products = Product::with('category')->get();
    return new ProductCollection($products);
});


// # Implementasi materi Pagination
Route::get('/products-paging', [ProductController::class, 'products_paging']);


// Implementasi materi Additional Metadata
Route::get('/products-debug/{id}', [ProductController::class, 'products_debug']);