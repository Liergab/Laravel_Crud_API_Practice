<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('students/{id}',[StudentController::class,'getStudentById']);
Route::get('students',[StudentController::class,'getStudent']);
Route::post('students',[StudentController::class,'createStudent']);
Route::put('students/{id}',[StudentController::class,'updateStudent']);
Route::delete('students/{id}',[StudentController::class,'deleteStudent']);
