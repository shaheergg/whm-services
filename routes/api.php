<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServerController;
use App\Models\Server;
use App\Services\WhmApiService;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/up', function () {
    return response()->json(['status' => 'ok']);
});

Route::get("/check-service", function () {
    $service = new \App\Services\WhmApiService('https://dnshosting.yourownwebserver.com', 'MF7MM8YW6Q8CLHFH7TFSA8M5IZUY5JLB', "2087", 'root');
    $response = $service->getAppList('applist');
    return response()->json($response);
});
Route::get("/servers",  [ServerController::class, 'index']);
Route::post("/servers",  [ServerController::class, 'store']);
Route::get("/servers/{id}",  [ServerController::class, 'show']);
Route::delete("/servers/{id}", [ServerController::class, 'destroy']);
Route::get("/servers/{id}/domains",  [ServerController::class, 'getDomains']);
Route::post("/servers/{id}/change-password", [ServerController::class, 'changePassword']);
Route::get("/servers/{id}/disk-usage", [ServerController::class, 'getDiskUsageInfo']);
