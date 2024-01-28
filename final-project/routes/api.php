<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\TournamentRegistrationController;
use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\LadderController;

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

Route::post('register',[AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware(['auth:api', 'verified'])->post('logout', [AuthController::class, 'logout']);
Route::middleware(['auth:api', 'verified'])->post('change-password', [AuthController::class,'changePassword']);

Route::middleware('guest:api')->post('reset', [AuthController::class, 'resetPassword']);
Route::middleware('guest:api')->post('reset-password',[AuthController::class, 'resetPassword_store']);

Route::get('email/verify/{id}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::middleware('auth:api')->get('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

Route::prefix('tournaments')->controller(TournamentController::class)->group(function() {
    Route::get('/all', 'all');
    Route::get('/get/{id}', 'getById');
    Route::post('/create', 'create');
    Route::put('/edit/{id}', 'edit');
    Route::get('/organizing', 'organizing');
});

Route::prefix('tournaments')->controller(TournamentRegistrationController::class)->group(function() {
    Route::post('/register/{id}', 'register');
    Route::get('/participating', 'participating');
});

Route::middleware(['auth:api', 'verified'])->get('/disciplines/all', [DisciplineController::class, 'all']);

Route::get('/ladder/{id}', [LadderController::class, 'ladderForTournament']);
Route::post('/ladder/{id}', [LadderController::class, 'rateLadder']);
