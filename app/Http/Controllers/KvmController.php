<?php

namespace App\Http\Controllers;

use App\Models\KVM;
use App\Services\EdisApiService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class KvmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // all kvms

            $kvms = KVM::all();
            return response()->json($kvms);
        } catch (\Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 500);

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function getKvms(Request $request)
    {
        try {
            // Retrieve all KVMs from the database
            $vms = KVM::all();

            // Check if all KVMs are still valid
            $allValid = true;
            foreach ($vms as $vm) {
                if ((int) $vm->valid_until < time()) {
                    $allValid = false;
                    break;
                }
            }

            // If all KVMs are still valid, return them from the database
            if ($allValid) {
                return response()->json(['kvms' => $vms], 200);
            }

            // If any KVM is expired, call the EDIS API to get fresh data
            $edisService = new EdisApiService();
            $response = $edisService->getAllKVMs(); // Retrieve all KVMs from the EDIS API

            // Check if the response contains the 'status' and 'data' fields
            if (
                isset($response['status']) && $response['status'] === 'success' &&
                isset($response['data']) && is_array($response['data']) && !empty($response['data'])
            ) {
                $kvms = $response['data']; // Extract the KVM data from the response

                foreach ($kvms as $kvmData) {
                    // Upsert each KVM with the new data
                    KVM::updateOrCreate(
                        ['kvm_id' => $kvmData['kvm_id']], // Condition to find existing KVM
                        [
                            'valid_until' => $kvmData['valid_until'],
                            'signature' => $kvmData['signature'],
                            'kvm_name' => $kvmData['description'], // Assuming `description` is the name
                            'api_host' => $kvmData['api_host'],
                        ]
                    );
                }

                // Return the updated KVMs from the database
                return response()->json(['kvms' => KVM::all()], 200);
            } else {
                return response()->json($response, 400);
            }
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }



    public function store(Request $request)
    {
        try {
            $request->validate([
                "kvm_id" => "required|string",
                "valid_until" => "required",
                "signature" => "required",
                "kvm_name" => "required",
                "api_host" => "required",
            ]);
            $kvm = KVM::create($request->all());
            return response()->json(["kvm" => $kvm, 200]);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            $vm = KVM::findOrFail($id);
            $edisApiService = new EdisApiService();
            $data = $edisApiService->getKVMDetail($vm->kvm_id, $vm->signature, $vm->api_host, $vm->valid_until);
            return response()->json($data);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "KVM not found!"], 404);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function getImages($id)
    {
        try {
            $vm = KVM::findOrFail($id);
            $edisApiService = new EdisApiService();
            $data = $edisApiService->getImages(
                $vm->kvm_id,
                $vm->signature,
                $vm->api_host,
                $vm->valid_until,
            );
            return response()->json($data);
        } catch (\Exception $err) {
            return response()->json([
                "error" => $err->getMessage()
            ], 500);
        }
    }

    public function reinstallKvm(Request $request, $id)
    {
        try {
            $request->validate([
                "password" => "required|string",
                "image" => "required|string",
            ]);
            $vm = KVM::findOrFail($id);
            $edisApiService = new EdisApiService();
            $image = $request->get("image");
            $password = $request->get("password");
            $data = $edisApiService->reinstallKvm($vm->kvm_id, $vm->signatre, $vm->api_host, $vm->valid_until, $password, $image);
            return response()->json($data);
        } catch (\Exception $error) {
            return response()->json([
                "error" => $error->getMessage()
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        //
    }
}
