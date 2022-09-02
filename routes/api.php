<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Api\Admin\AnnouncementController;
use App\Http\Controllers\Api\AuthController;

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

// Public route
// Route::middleware(['client'])->group(function() {
Route::prefix('announcements')->group(function() {
    Route::get('/', [AnnouncementController::class, 'index']);
    Route::get('/{announcement}', [AnnouncementController::class, 'show']);
});


Route::post('/admin/login', [AuthController::class, 'login']);


// Route::middleware(['auth:api'])->prefix('admin')->group(function () {
Route::prefix('admin')->group(function () {

    //CORS NOT WORKING CORRECTLY. JUST A WORKAROUND
    Route::post('/announcements/update/{announcement}', [AdminAnnouncementController::class, 'update']);
    Route::post('/announcements/delete/{announcement}', [AdminAnnouncementController::class, 'destroy']);

    Route::apiResource('/announcements', AdminAnnouncementController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
});
