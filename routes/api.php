<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SubAdminSocietyController;
use App\Http\Controllers\SocietyController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\GateKeeperController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\NoticeBoardController;
use App\Http\Controllers\PreApproveEntryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PhaseController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\StreetController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\FloorController;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\BuildingResidentController;



Route::middleware(['auth:sanctum'])->group(function(){

// Society

// Society

Route::post('society/addsociety', [SocietyController::class, 'addsociety']);
Route::put('society/updatesociety', [SocietyController::class, 'updatesociety']);
Route::get('society/viewallsocieties/{userid}', [SocietyController::class, 'viewallsocieties']);
Route::get('society/deletesociety/{id}', [SocietyController::class, 'deletesociety']);
Route::get('society/viewsociety/{societyid}', [SocietyController::class, 'viewsociety']);
Route::get('society/searchsociety/{q?}', [SocietyController::class, 'searchsociety']);
Route::get('society/filtersocietybuilding/{id}/{q?}', [SocietyController::class, 'filtersocietybuilding']);
Route::get('society/viewsocietiesforresidents/{type?}', [SocietyController::class, 'viewsocietiesforresidents']);
// Route::get('society/viewbuildingsforresidents', [SocietyController::class, 'viewbuildingsforresidents']);
    //User
    Route::post('logout',[RoleController::class,'logout']);
    Route::post('fcmtokenrefresh',[RoleController::class,'fcmtokenrefresh']);
    Route::post('resetpassword',[RoleController::class,'resetpassword']);
    // SubAdminSocieties
    Route::post('registersubadmin',[SubAdminSocietyController::class,'registersubadmin']);
    Route::get('viewsubadmin/{id}',[SubAdminSocietyController::class,'viewsubadmin']);
    Route::get('deletesubadmin/{id}',[SubAdminSocietyController::class,'deletesubadmin']);
    Route::post('updatesubadmin',[SubAdminSocietyController::class,'updatesubadmin']);
    // Residents
    Route::post('registerresident',[ResidentController::class,'registerresident']);
    Route::get('viewresidents/{id}',[ResidentController::class,'viewresidents']);
    Route::get('deleteresident/{id}',[ResidentController::class,'deleteresident']);
    Route::get('searchresident/{subadminid}/{q?}',[ResidentController::class,'searchresident']);
    Route::post('updateresident',[ResidentController::class,'updateresident']);
    Route::get('loginresidentdetails/{residentid}',[ResidentController::class,'loginresidentdetails']);
    Route::get('unverifiedresident/{subadminid}/{status}',[ResidentController::class,'unverifiedresident']);
    Route::post('loginresidentupdateaddress',[ResidentController::class,'loginresidentupdateaddress']);


    // GateKeeper
  Route::post('registergatekeeper', [GateKeeperController::class, 'registergatekeeper']);
  Route::get('viewgatekeepers/{id}', [GateKeeperController::class, 'viewgatekeepers']);
  Route::get('deletegatekeeper/{id}', [GateKeeperController::class, 'deletegatekeeper']);
  Route::post('updategatekeeper', [GateKeeperController::class, 'updategatekeeper']);


  //Events

    Route::post('event/addevent',[EventController::class,'addevent']);
    Route::post('event/addeventimages',[EventController::class,'addeventimages']);
    Route::post('event/updateevent',[EventController::class,'updateevent']);
    Route::get('event/events/{userid}',[EventController::class,'events']);
    Route::get('event/deleteevent/{id}',[EventController::class,'deleteevent']);
    Route::get('event/searchevent/{userid}/{q?}',[EventController::class,'searchevent']);



//Notice Board
Route::post('addnoticeboarddetail', [NoticeBoardController::class, 'addnoticeboarddetail']);
Route::get('viewallnotices/{id}', [NoticeBoardController::class, 'viewallnotices']);
Route::get('deletenotice/{id}', [NoticeBoardController::class, 'deletenotice']);
Route::post('updatenotice', [NoticeBoardController::class, 'updatenotice']);


// Reports
Route::post('reporttoadmin', [ReportController::class, 'reporttoadmin']);
Route::get('adminreports/{residentid}', [ReportController::class, 'adminreports']);
Route::post('updatereportstatus', [ReportController::class, 'updatereportstatus']);
Route::get('deletereport/{id}', [ReportController::class, 'deletereport']);
Route::get('reportedresidents/{subadminid}', [ReportController::class, 'reportedresidents']);
Route::get('reports/{subadminid}/{userid}', [ReportController::class, 'reports']);
Route::get('pendingreports/{subadminid}', [ReportController::class, 'pendingreports']);
Route::get('historyreportedresidents/{subadminid}', [ReportController::class, 'historyreportedresidents']);
Route::get('historyreports/{subadminid}/{userid}', [ReportController::class, 'historyreports']);


// Preapproveentry
Route::get('getgatekeepers/{subadminid}', [PreApproveEntryController::class, 'getgatekeepers']);
Route::get('getvisitorstypes', [PreApproveEntryController::class, 'getvisitorstypes']);
Route::post('addvisitorstypes', [PreApproveEntryController::class, 'addvisitorstypes']);
Route::post('addpreapproventry', [PreApproveEntryController::class, 'addpreapproventry']);
Route::post('updatepreapproveentrystatus', [PreApproveEntryController::class, 'updatepreapproveentrystatus']);
Route::get('viewpreapproveentryreports/{userid}', [PreApproveEntryController::class, 'viewpreapproveentryreports']);
Route::get('preapproveentryresidents/{userid}', [PreApproveEntryController::class, 'preapproveentryresidents']);
Route::get('preapproventrynotifications/{userid}', [PreApproveEntryController::class, 'preapproventrynotifications']);
Route::get('preapproveentries/{userid}', [PreApproveEntryController::class, 'preapproveentries']);
Route::get('preapproveentryhistories/{userid}', [PreApproveEntryController::class, 'preapproveentryhistories']);




// Phases
Route::post('addphases', [PhaseController::class, 'addphases']);
Route::get('phases/{subadminid}', [PhaseController::class, 'phases']);
Route::get('distinctphases/{subadminid}', [PhaseController::class, 'distinctphases']);
Route::get('viewphasesforresidents/{societyid}', [PhaseController::class, 'viewphasesforresidents']);

// Blocks
Route::post('addblocks', [BlockController::class, 'addblocks']);
Route::get('blocks/{pid}', [BlockController::class, 'blocks']);
Route::get('distinctblocks/{bid}', [BlockController::class, 'distinctblocks']);
Route::get('viewblocksforresidents/{phaseid}', [BlockController::class, 'viewblocksforresidents']);


Route::get('viewblocksforresidents/{phaseid}', [BlockController::class, 'viewblocksforresidents']);
// Streets
Route::post('addstreets', [StreetController::class, 'addstreets']);
Route::get('streets/{bid}', [StreetController::class, 'streets']);
Route::get('viewstreetsforresidents/{blockid}', [StreetController::class, 'viewstreetsforresidents']);

// Houses
Route::post('addhouses', [HouseController::class, 'addhouses']);
Route::get('houses/{sid}', [HouseController::class, 'houses']);
Route::get('viewhousesforresidents/{streetid}', [HouseController::class, 'viewhousesforresidents']);


    //Bahir ki  Building ka Floors
    Route::post('addfloors', [FloorController::class, 'addfloors']);




    // Route::get('phases/{subadminid}', [PhaseController::class, 'phases']);

    // Route::get('distinctphases/{subadminid}', [PhaseController::class, 'distinctphases']);
     Route::get('viewfloorsforresidents/{buildingid}', [FloorController::class, 'viewfloorsforresidents']);

    //Bahir ki  Building ka Apartment
    Route::post('addapartments', [ApartmentController::class, 'addapartments']);
    Route::get('viewapartmentsforresidents/{floorid}', [ApartmentController::class, 'viewapartmentsforresidents']);

      // Building Residents

  Route::post('registerbuildingresident', [BuildingResidentController::class, 'registerbuildingresident']);



});




// Authentications

Route::post('login',[RoleController::class,'login']);
Route::post('residentlogin',[ResidentController::class,'residentlogin']);
Route::post('register',[RoleController::class,'register']);
Route::get('allusers',[RoleController::class,'allusers']);





