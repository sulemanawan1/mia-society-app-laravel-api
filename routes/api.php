<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SubAdminSocietyController;
use App\Http\Controllers\SocietyController;
use App\Http\Controllers\ResidentController;


Route::middleware(['auth:sanctum'])->group(function(){

// Society

    Route::post('society/addsociety',[SocietyController::class,'addsociety']);
    Route::put('society/updatesociety',[SocietyController::class,'updatesociety']);
    Route::get('society/viewallsocieties/{userid}',[SocietyController::class,'viewallsocieties']);
    Route::get('society/deletesociety/{id}',[SocietyController::class,'deletesociety']);
    Route::get('society/viewsociety/{societyid}',[SocietyController::class,'viewsociety']);
    Route::get('society/searchsociety/{q?}',[SocietyController::class,'searchsociety']);


    //User
    Route::post('logout',[RoleController::class,'logout']);
    Route::get('allusers',[RoleController::class,'allusers']);

    // SubAdminSocieties
    Route::post('registersubadmin',[SubAdminSocietyController::class,'registersubadmin']);
    Route::get('viewsubadmin/{id}',[SubAdminSocietyController::class,'viewsubadmin']);
    Route::get('deletesubadmin/{id}',[SubAdminSocietyController::class,'deletesubadmin']);
    Route::post('updatesubadmin',[SubAdminSocietyController::class,'updatesubadmin']);

    // Residents

    Route::post('registerresident',[ResidentController::class,'registerresident']);

});




// Authentications

Route::post('login',[RoleController::class,'login']);
Route::post('register',[RoleController::class,'register']);







