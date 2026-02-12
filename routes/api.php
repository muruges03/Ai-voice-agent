<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Models\Agent;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::post('/register', [RegisterController::class, 'register']);


//Tenant Routes
Route::middleware(['auth:sanctum'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Tenant Routes (After Auth)
    |--------------------------------------------------------------------------
    */

    Route::middleware([
        InitializeTenancyByDomain::class,
        PreventAccessFromCentralDomains::class,
    ])->group(function () {

        Route::get('/agents', function () {
            return \App\Models\Agent::all();
        });

    });

});