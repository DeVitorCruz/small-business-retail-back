<?php

use App\Http\Controllers\SubCategoriesController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VariationTypesController;
use App\Http\Controllers\SubCategoriesVariationsController;
use App\Http\Controllers\VariationController;
use App\Http\Middleware\CanAccessDashboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

Route::post('register', [RegisteredUserController::class, 'store']);
Route::post('login', [AuthenticatedSessionController::class, 'store']);

Route::middleware(['auth:sanctum', EnsureFrontendRequestsAreStateful::class, CanAccessDashboard::class])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy']);
    Route::get('user', function (Request $request) {
        return $request->user();
    });

    Route::get('/categories', [CategoriesController::class, 'index']);
    Route::get('/categories/products', [CategoriesController::class, 'indexWithProducts']);
    Route::post('/categories', [CategoriesController::class, 'store']);
    Route::get('/categories/{id}', [CategoriesController::class, 'show']);
    Route::put('/categories/{id}', [CategoriesController::class, 'update']);
    Route::delete('/categories/{id}', [CategoriesController::class, 'destroy']);

    Route::get('/sub-categories', [SubCategoriesController::class, 'index']);
    Route::get('/sub-categories/products', [SubCategoriesController::class, 'indexWithProduct']);
    Route::post('/sub-categories', [SubCategoriesController::class, 'store']);
    Route::get('/sub-categories/{id}', [SubCategoriesController::class, 'show']);
    Route::put('/sub-categories/{id}', [SubCategoriesController::class, 'update']);
    Route::delete('/sub-categories/{id}', [SubCategoriescontroller::class, 'destroy']);

    Route::get('/variation-types', [VariationTypesController::class, 'index']);
    Route::get('/variation-types/{id}', [VariationTypesController::class, 'show']);
    Route::post('/variation-types', [VariationTypescontroller::class, 'store']);
    Route::put('/variation-types/{id}', [VariationTypesController::class, 'update']);
    Route::delete('/variation-types/{id}', [VariationTypesController::class, 'destroy']);

    Route::get('/sub-categories-variations', [SubCategoriesVariationsController::class, 'index']);
    Route::post('/sub-categories-variations', [SubCategoriesVariationsController::class, 'store']);
    Route::put('/sub-categories-variations', [SubCategoriesVariationsController::class, 'update']);
    Route::delete('/sub-categories-variations/{id}', [SubCategoriesVariationsController::class, 'destroy']);

    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/variations', [ProductController::class, 'indexWithVariations']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::post('/products/{id}/images', [ProductController::class, 'addImage']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);

    Route::get('/sub-categories/{id}/variations', [VariationController::class, 'getSubCategoryVariations']);
    Route::post('/variations', [VariationController::class, 'store']);
    Route::put('/variations/{id}', [VariationController::class, 'update']);
    Route::delete('/variations/{id}', [VariationController::class, 'destroy']);
});
