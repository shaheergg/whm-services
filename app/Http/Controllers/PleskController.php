<?php

namespace App\Http\Controllers;

use App\Services\PleskApiService;
use Illuminate\Http\Request;

class PleskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }
    public function getServerInfo(Request $request)
    {
        try {
            $pleskService = new PleskApiService();
            $data = $pleskService->getServerInfo();
            return response()->json($data);
        } catch (\Exception $error) {
            return response()->json([
                "error" => $error->getMessage(),
                "code" => $error->getCode()
            ]);
        }
    }
    public function listClients(Request $request)
    {
        try {
            $pleskService = new PleskApiService();
            $data = $pleskService->listClients();
            return response()->json($data);
        } catch (\Exception $error) {
            return response()->json([
                "error" => $error->getMessage(),
                "code" => $error->getCode()
            ]);
        }
    }
    public function listDomains(Request $request)
    {
        try {
            $pleskService = new PleskApiService();
            $data = $pleskService->listDomains();
            return response()->json($data);
        } catch (\Exception $error) {
            return response()->json([
                "error" => $error->getMessage(),
                "code" => $error->getCode()
            ]);
        }
    }

    public function listDNSRecords(Request $request)
    {
        try {
            $domain = $request->query("domain");
            $pleskService = new PleskApiService();
            $data = $pleskService->listDNSRecords($domain);
            return response()->json($data);
        } catch (\Exception $error) {
            return response()->json(
                [
                    "error" => $error->getMessage(),
                    "code" => $error->getCode()
                ]
            );
        }
    }
    /**
     * Display the specified resource.
     */
    public function listExtensions(Request $request)
    {
        try {
            $pleskApiService = new PleskApiService();
            $data = $pleskApiService->listExtensions();
            return response()->json($data);
        } catch (\Exception $error) {
            return response()->json([
                "error" => $error->getMessage(),
                "code" => $error->getCode()
            ]);
        }
    }

    public function createDNSRecord(Request $request)
    {
        try {
            $pleskApiService = new PleskApiService();
            $data = $request->all();
            $res = $pleskApiService->createDNSRecord($data);

            return response()->json($res);
        } catch (\Exception $error) {
            return response()->json([
                "error" => $error->getMessage(),
                "code" => $error->getCode()
            ]);
        }
    }
    public function show(string $id)
    {
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
        //
    }
}
