<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OneProviderService;
class OneProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $oneProviderService = new OneProviderService();
            $data = $oneProviderService->getServersList();
            return response()->json($data);
        } catch (\Exception $error) {
            return response()->json([
                "message" => $error->getMessage(),
                "code" => 500
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            // Convert the ID to an integer before calling the service method
            $server_id = intval($id);

            // Instantiate the OneProviderService
            $oneProviderService = new OneProviderService();

            // Get server info
            $data = $oneProviderService->getServerInfo($server_id);

            // Return a JSON response with the data
            return response()->json($data);
        } catch (\InvalidArgumentException $e) {
            // Handle invalid argument exceptions (like conversion issues)
            return response()->json([
                "message" => "Invalid server ID provided.",
                "code" => 400 // Bad Request
            ], 400);
        } catch (\Exception $e) {
            // Handle generic exceptions
            return response()->json([
                "message" => $e->getMessage(),
                "code" => 500 // Internal Server Error
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
    public function manageServer($id)
    {
        try {
            $oneProviderService = new OneProviderService();
            $data = $oneProviderService->manageServer($id);
            return response()->json($data);
        } catch (\Exception $error) {
            return response()->json([
                "message" => $error->getMessage(),
                "code" => 500
            ]);
        }
    }

    public function powerOffVM($id)
    {
        try {
            $oneProvider = new OneProviderService();
            $data = $oneProvider->powerOff($id);
            return response()->json($data);
        } catch (\Exception $error) {
            return response()->json([
                "message" => $error->getMessage(),
                "code" => 500
            ]);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
