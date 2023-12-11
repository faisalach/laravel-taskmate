<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskLabelController;
use App\Http\Controllers\TasksController;
use Illuminate\Http\Request;
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
Route::post("/login",[AuthController::class,"authenticate"]);
Route::post("/register",[AuthController::class,"register"]);

Route::group(["middleware" => "auth:sanctum"],function(){
    Route::get("/user",function (Request $request) {
        return $request->user();
    });
    Route::get("/logout",[AuthController::class,"logout"]);

    Route::get("/tasklabel/get",[TaskLabelController::class,"get_all"]);
    Route::post("/tasklabel/insert",[TaskLabelController::class,"insert"]);
    Route::post("/tasklabel/update/{id}",[TaskLabelController::class,"update"]);
    Route::post("/tasklabel/delete/{id}",[TaskLabelController::class,"delete"]);

    Route::get("/tasks/get/{tasklabel_id}",[TasksController::class,"get_all"]);
    Route::post("/tasks/insert",[TasksController::class,"insert"]);
    Route::post("/tasks/update/{id}",[TasksController::class,"update"]);
    Route::post("/tasks/delete/{id}",[TasksController::class,"delete"]);
});
