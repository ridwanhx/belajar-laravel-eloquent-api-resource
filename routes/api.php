<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

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