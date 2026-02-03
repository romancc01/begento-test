<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\controllers\ProductsController;
use App\Http\Controllers\AuthController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware(['auth:sanctum', 'apiroutes:manage-products'])->group(function () {
Route::get("/products", [ProductsController::class, 'getProducts'])->name('getProducts');
Route::get("/products/{id}", [ProductsController::class, 'getProduct'])->name('getProduct');
Route::get("/products/{id}/prices", [ProductsController::class, 'getProductPrices'])->name('getProductPrices');
Route::post('/products', [ProductsController::class, 'newProduct'])->name('newProduct');
Route::post('/products/{id}/prices', [ProductsController::class, 'newPriceProduct'])->name('newPriceProduct');
Route::put('/products/{id}', [ProductsController::class, 'updateProduct'])->name('updateProduct');
Route::delete('/products/{id}', [ProductsController::class, 'deleteProduct'])->name('deleteProduct');
});
