<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\TouristDestinationController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Api for login
Route::post('/login', [AuthController::class, 'login']);
//Api for register
Route::post('/register', [AuthController::class, 'register']);

//protected routes
// protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    //destinasi API
    Route::get('/destinasi', [TouristDestinationController::class, 'getAllDestinasi']);
    Route::get('/destinasi/{id}', [TouristDestinationController::class, 'getDestinasiById']);

    //ticket API
    Route::get('/info-ticket', [TicketController::class, 'getAllTicketInfo']);
    Route::post('/order-ticket', [TicketController::class, 'orderTicket']);
    Route::post('/cancel-ticket/{ticket_id}',[TicketController::class, 'cancelTicket']);
    //update ticket
    Route::put('/update-ticket/{ticket_id}', [TicketController::class, 'updateTicket']);
    Route::put('/generate-booking-code/{ticket_id}', [TicketController::class, 'generateBookingCode']);
    Route::put('/used-ticket/{booking_code}', [TicketController::class, 'markTicketAsUsed']);




});
