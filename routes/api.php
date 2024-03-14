<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\authcontroller;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InventoryController;
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

Route::post('/register', [authcontroller::class, 'register']);

Route::post('/login', [authcontroller::class, 'login']);

Route::post('/logout', [authcontroller::class, 'logout'])->middleware('auth:api');

Route::post('/addcustomer', [CustomerController::class, 'Addcustomer'])->middleware('auth:api');

Route::get('/getupdatecustomer/{email}', [CustomerController::class, 'GetupdatecustomerView'])->middleware('auth:api');

Route::post('/updatecustomer/{email}', [CustomerController::class, 'Updatecustomer'])->middleware('auth:api');

Route::delete('/deletecustomer/{email}', [CustomerController::class, 'Deletecustomer'])->middleware('auth:api');

Route::post('/additems', [InventoryController::class, 'Additems'])->middleware('auth:api');

Route::get('/getedititems/{name}', [InventoryController::class, 'GetEdititems'])->middleware('auth:api');

Route::post('/edititems/{name}', [InventoryController::class, 'Edititems'])->middleware('auth:api');

Route::delete('/removeitems/{name}', [InventoryController::class, 'Removeitems'])->middleware('auth:api');
