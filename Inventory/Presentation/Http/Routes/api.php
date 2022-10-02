<?php

use App\Inventory\Presentation\Http\Api\InventoryItemController;
use Illuminate\Support\Facades\Route;

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

Route::post("/webhooks/{webhookName?}", [InventoryItemController::class, "handleWebhook"])
    ->withoutMiddleware('auth:api')
    ->name('handle-inventory-webhook');
