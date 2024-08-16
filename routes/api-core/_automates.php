<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AutomateController;

Route::prefix('automates')->group(function () {
   
    Route::get('/{id}', [AutomateController::class, 'show'])
        ->name('api-core.automates.show');

});

Route::prefix('automates')->middleware('auth:sanctum')->group(function () {

    Route::post('/search', [AutomateController::class, 'search'])
        ->name('api-core.automates.search');

    Route::post('/', [AutomateController::class, 'store'])
        ->name('api-core.automates.store');

    Route::put('/{id}', [AutomateController::class, 'update'])
        ->name('api-core.automates.update');
    
    Route::delete('/{id}', [AutomateController::class, 'destroy'])
        ->name('api-core.automates.destroy');
        
    Route::patch('/{id}/type', [AutomateController::class, 'updateType'])
        ->name('api-core.automates.update-type');

    Route::patch('/{id}/description-short', [AutomateController::class, 'updateDescriptionShort'])
        ->name('api-core.automates.update-description-short');
    
    Route::patch('/{id}/description', [AutomateController::class, 'updateDescription'])
        ->name('api-core.automates.update-description');

    Route::patch('/{id}/command', [AutomateController::class, 'updateCommand'])
        ->name('api-core.automates.update-command');
    
    Route::patch('/{id}/status', [AutomateController::class, 'updateStatus'])
        ->name('api-core.automates.update-status');
});