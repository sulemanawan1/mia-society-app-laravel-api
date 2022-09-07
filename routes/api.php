<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;



Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('allusers',[RoleController::class,'allusers']);



});

Route::post('login',[RoleController::class,'login']);
Route::post('register',[RoleController::class,'register']);
