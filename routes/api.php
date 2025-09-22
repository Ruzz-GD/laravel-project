<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\VenueController;
use App\Http\Controllers\Api\ParticipantController;
use App\Http\Controllers\Api\TicketController;

Route::get('/test', function () {
    return response()->json(['message' => 'API route working!']);
});

Route::apiResource('events', EventController::class);
Route::apiResource('venues', VenueController::class);
Route::apiResource('participants', ParticipantController::class);
Route::apiResource('tickets', TicketController::class);
