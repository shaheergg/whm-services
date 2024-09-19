<?php

use App\Http\Controllers\EdisController;
use App\Http\Controllers\KvmController;
use App\Http\Controllers\OneProviderController;
use App\Http\Controllers\PleskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServerController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/up', function () {
    return response()->json(['status' => 'ok']);
});

// Route::get("/check-service", function () {
//     $service = new \App\Services\WhmApiService('https://dnshosting.yourownwebserver.com', 'MF7MM8YW6Q8CLHFH7TFSA8M5IZUY5JLB', "2087", 'root');
//     $response = $service->getAppList('applist');
//     return response()->json($response);
// });

// whm servers
Route::get("/servers", [ServerController::class, 'index']);
Route::post("/servers", [ServerController::class, 'store']);
Route::get("/servers/{id}", [ServerController::class, 'show']);
Route::delete("/servers/{id}", [ServerController::class, 'destroy']);
Route::get("/servers/{id}/domains", [ServerController::class, 'getDomains']);
Route::post("/servers/{id}/change-password", [ServerController::class, 'changePassword']);
Route::get("/servers/{id}/disk-usage", [ServerController::class, 'getDiskUsageInfo']);



// Edis kvm
Route::get("/kvms/all", [KvmController::class, "getKvms"]);
Route::post('/kvms', [KvmController::class, 'store']);
Route::get("/kvms", [KvmController::class, "index"]);
Route::get("/kvms/{id}/details", [KvmController::class, "show"]);
Route::get("/kvms/{id}/images", [KvmController::class, "getImages"]);
Route::post("/kvm/{id}/reinstall", [KvmController::class, "reinstallKvm"]);


// oneprovider 

Route::get("/oneprovider/servers", [OneProviderController::class, "index"]);
Route::get("/oneprovider/servers/{id}", [OneProviderController::class, "show"]);
Route::get("/oneprovider/servers/{id}/manage", [OneProviderController::class, "manageServer"]);
Route::post("/oneprovider/servers/{id}/poweroff", [OneProviderController::class, "powerOffVM"]);


// Plesk
Route::get("/plesk/server", [PleskController::class, "getServerInfo"]);
Route::get("/plesk/clients", [PleskController::class, "listClients"]);
Route::get("/plesk/domains", [PleskController::class, "listDomains"]);
Route::get("/plesk/dns/records", [PleskController::class, "listDNSRecords"]);
Route::get("/plesk/extensions", [PleskController::class, "listExtensions"]);