<?php

namespace App\Http\Controllers;

use App\Services\EdisApiService;
use Illuminate\Http\Request;
use App\Models\Edis;


class EdisController extends Controller
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
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'password' => 'required'
            ]);

            $edis = Edis::create(
                $request->all()
            );
            $message = 'Edis auth session configured!';
            return response()->json(['message' => $message], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    public function createKVM(Request $request)
    {
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required'
            ]);
            $edis = Edis::findOrFail($id);
            $edis->name = $request->name;
            $edis->email = $request->email;
            $edis->password = $request->password;
            $edis->save();
            $message = '';
            return response()->json($message, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function getAllKVMs(Request $request)
    {
        try {


            $ediService = new EdisApiService();
            $kvms = $ediService->getAllKVMs();
            return response()->json($kvms, 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function destroy(string $id)
    {

    }
}



