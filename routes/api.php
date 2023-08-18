<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Produk\CartController;
use App\Http\Controllers\UploadGambarController;
use App\Http\Controllers\Produk\ControllerBarang;
use App\Http\Controllers\Auth\CodeCheckController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\Auth\ForgotPaswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

//Route::get('/barang', [ControllerBarang::class, 'index']);
Route::get('/barang', [ControllerBarang::class, 'index']); //->middleware(['auth:sanctum']);
Route::get('/barang/{id}', [ControllerBarang::class, 'show']); //->middleware(['auth:sanctum']);;
Route::post('/barang', [ControllerBarang::class, 'store']);
Route::put('/update/{id}', [ControllerBarang::class, 'update']);

Route::post('/login', [RegisterController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/logout', [RegisterController::class, 'logout'])->middleware(['auth:sanctum']);


Route::post('password/email',  ForgotPaswordController::class);
Route::post('password/code/check', CodeCheckController::class);
Route::post('password/reset', ResetPasswordController::class);

Route::get('/user/{id}', [UserController::class, 'show']);
Route::delete('/user/{id}', [UserController::class, 'delete']);

Route::post('image', [UploadGambarController::class, 'imageStore']);
Route::post('image/{id}', [UploadGambarController::class, 'imageupdate']);
Route::get('/image/tampil/{id}', [UploadGambarController::class, 'show']);

Route::get('carts', [CartController::class, 'index'])->middleware(['auth:sanctum']);

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('carts')->group(function () {
        Route::post('/', [CartController::class, 'store']);
        Route::post('/{product_id}', [CartController::class, 'create']);
    });
});
