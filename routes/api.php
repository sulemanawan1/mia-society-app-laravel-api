<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SocietyController;



Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('allusers',[RoleController::class,'allusers']);
// Society  
    Route::get('addsociety',[SocietyController::class,'addsociety']);




});

// Authentications

Route::post('login',[RoleController::class,'login']);
Route::post('register',[RoleController::class,'register']);






