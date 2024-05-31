<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusinessSegmentController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmpowermentController;
use App\Http\Controllers\EquipmentCategoryController;
use App\Http\Controllers\FilingController;
use App\Http\Controllers\InventoryGroupController;
use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\OperatingInstructionController;
use App\Http\Controllers\StorageLocationController;
use App\Http\Controllers\UserController;


Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->group(function () {
  Route::resource('/params/business-segments', BusinessSegmentController::class);
  Route::resource('/params/departments', DepartmentController::class);
  Route::resource('/params/empowerments', EmpowermentController::class);
  Route::resource('/params/equipment-categories', EquipmentCategoryController::class);
  Route::resource('/params/filings', FilingController::class);
  Route::resource('/params/inventory-groups', InventoryGroupController::class);
  Route::resource('/params/manufacturers', ManufacturerController::class);
  Route::resource('/params/operating-instructions', OperatingInstructionController::class);
  Route::resource('/params/storage-locations', StorageLocationController::class);

  Route::resource('/users', UserController::class);
});
