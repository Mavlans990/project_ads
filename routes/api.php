<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CutiController;
use App\Http\Controllers\API\KaryawanController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware => auth:sanctum'], function(){
    //Karyawan
    Route::get('/karyawan', [KaryawanController::class, 'show']);
    Route::post('/karyawan', [KaryawanController::class, 'create']);
    Route::put('/karyawan/{nmr_induk}', [KaryawanController::class, 'update']);
    Route::delete('/karyawan/{nmr_induk}', [KaryawanController::class, 'delete']);

    Route::get('/first-joined', [KaryawanController::class, 'firstJoined']);
    Route::get('/taken-leave', [KaryawanController::class, 'takenLeave']);
    Route::get('/leave-balance', [KaryawanController::class, 'leaveBalance']);

    //Cuti
    Route::get('/cuti/{id}', [CutiController::class, 'show']);
    Route::post('/cuti', [CutiController::class, 'create']);
    Route::put('/cuti/{id}', [CutiController::class, 'update']);
    Route::delete('/cuti/{id}', [CutiController::class, 'delete']);

    Route::get('/logout', [AuthController::class, 'logout']);
});

Route::post('/login', [AuthController::class, 'login']);