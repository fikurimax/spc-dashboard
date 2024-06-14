<?php

use App\Http\Controllers\TelemetryApiController;
use Illuminate\Support\Facades\Route;

Route::post('/telemetry', TelemetryApiController::class)->name('telemetry');
