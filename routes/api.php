<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SocietyController;


Route::middleware(['auth:sanctum'])->group(function(){

// Society

    Route::post('society/addsociety',[SocietyController::class,'addsociety']);
    Route::put('society/updatesociety',[SocietyController::class,'updatesociety']);
    Route::get('society/viewallsocieties/{userid}',[SocietyController::class,'viewallsocieties']);
    Route::get('society/deletesociety/{id}',[SocietyController::class,'deletesociety']);
    Route::get('society/viewsociety/{societyid}',[SocietyController::class,'viewsociety']);


    //User
    Route::post('logout',[RoleController::class,'logout']);
    Route::get('allusers',[RoleController::class,'allusers']);

});




// Authentications

Route::post('login',[RoleController::class,'login']);
Route::post('register',[RoleController::class,'register']);







