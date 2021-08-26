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
Route::get("listofbooks", [BookController::class, "listofbooks"]);
Route::get("addopinion/{id}", [OpinionController::class, "addOpinion"]);
Route::get("bookdetails/{id}", [BookController::class, "bookDetails"]);

Route::group(["middleware" => ["auth:api"]], function () {

    Route::get("mybookslist", [BookController::class, "mybookslist"]);
    Route::get("logout", [UserController::class, "logout"]);

    //  book api routes

    Route::post("addbook", [BookController::class, "addBook"]);
    Route::put("editbook/{id}", [BookController::class, "editBook"]);
    Route::get("deletebook/{id}", [BookController::class, "deleteBook"]);
});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
