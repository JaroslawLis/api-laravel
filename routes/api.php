<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\OpinionController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post("register", [UserController::class, "register"]);
Route::post("login", [UserController::class, "login"]);

Route::group(["middleware" => ["api"]], function () {

    Route::get("mybookslist", [UserController::class, "mybookslist"]);
    Route::get("logout", [UserController::class, "logout"]);

    //  book api routes

    Route::post("addBook", [BookController::class, "addBook"]);
    Route::get("editBook/{id}", [BookController::class, "editeBook"]);
    Route::get("deleteBook/{id}", [BookController::class, "deleteBook"]);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
