<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login',[AuthController::class,'login']);
Route::post('/login1',[AuthController::class,'login']);


Route::get('/student',[StudentController::class,'index'])->name('students.create');
Route::get('/student/student',[StudentController::class,'create'])->name('students.create');
Route::post('/student',[StudentController::class,'store'])->name('students.store');
Route::post('/student/{id}',[StudentController::class,'update']);
Route::put('/student/{id}',[StudentController::class,'update']);
Route::get('/student/{id}',[StudentController::class,'show']);
Route::delete('/student/{id}',[StudentController::class,'destroy']);
