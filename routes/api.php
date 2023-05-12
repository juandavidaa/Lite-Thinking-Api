<?php

use App\Http\Controllers\admin\{UserController, CompanyController, ProductController};
use App\Http\Controllers\AuthController;

use Illuminate\Support\Facades\Route;

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

Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login'])->name('login');

Route::middleware(['auth:api'])->group(function (){

    Route::prefix('auth')->group(function(){
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);

    });

    Route::get('companies', [CompanyController::class, 'index']);

    /**
     * Admin routes
     */

    Route::prefix('admin')->middleware('admin')->group(function (){
        Route::apiResource('users', UserController::class)->only(['index', 'destroy']);
        Route::apiResource('companies', CompanyController::class)->only(['show', 'store', 'destroy']);
        Route::apiResource('products', ProductController::class)->only(['destroy', 'store']);
    });
});

