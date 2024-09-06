<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Server;
use App\Services\WhmApiService;


class ServerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $servers = Server::all();
            return response()->json($servers);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                'name' => 'required',
                'ip' => 'required',
                'port' => 'required',
                'user' => 'required',
                'api_key' => 'required',
                'hostname' => 'required'
            ]);

            $server = Server::create($request->all());
            return response()->json($server, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        try {
            $server = Server::find($id);
            if ($server) {
                return response()->json($server);
            } else {
                return response()->json(['error' => 'Server not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $server = Server::find($id);
            if ($server) {
                $server->delete();
                return response()->json(['message' => 'Server deleted successfully']);
            } else {
                return response()->json(['error' => 'Server not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getDomains($id)
    {
        try {
            $server = Server::find($id);
            if (!$server) {
                return response()->json(['error' => 'Server not found'], 404);
            }
            $api_token = $server->api_key;
            $whmApiService = new WhmApiService($server->hostname, $api_token, $server->port, $server->user);
            $response = $whmApiService->getDomainList();
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function changePassword(Request $request, $id)
    {
        try {
            $request->validate([
                'username' => 'required',
                'password' => 'required'
            ]);
            $server = Server::find($id);
            if (!$server) {
                return response()->json(['error' => 'Server not found'], 404);
            }
            $api_token = $server->api_key;
            $whmApiService = new WhmApiService($server->hostname, $api_token, $server->port, $server->user);
            $response = $whmApiService->changePassword($request->username, $request->password);
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function suspendAccount(Request $request, $id)
    {
        try {
            $request->validate([
                'username' => 'required'
            ]);

            $username = $request->username;
            $server = Server::find($id);
            if (!$server) {
                return response()->json(['error' => 'Server not found'], 404);
            }
            $api_token = $server->api_key;
            $whmApiService = new WhmApiService($server->hostname, $api_token, $server->port, $server->user);
            $response = $whmApiService->suspendAccount($username);
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function getDiskUsageInfo(Request $request, $id)
    {
        try {
            $server = Server::find($id);
            if (!$server) {
                return response()->json(['error' => 'Server not found'], 404);
            }
            $api_token = $server->api_key;
            $whmApiService = new WhmApiService($server->hostname, $api_token, $server->port, $server->user);
            $response = $whmApiService->getDiskUsage();
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
