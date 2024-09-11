<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;



class EdisApiService
{
    protected $email;
    protected $password;
    // protected $baseUrl = "https://session.edisglobal.com/kvm/v2/";
    // pass: gUEhZdnuh8l5$4_-N82{CkmWp*sBT4I0
    // email: vender@navicosoft.com
    public function __construct()
    {
        $this->email = config("edis.EDIS_EMAIL");
        $this->password = config('edis.EDIS_PASSWORD');
    }

    public function getAllKVMs()
    {
        try {
            $email = $this->email;
            $pw = $this->password;
            $response = Http::post("https://session.edisglobal.com/kvm/v2/get/auth", [
                "email" => $email,
                "pw" => $pw
            ]);

            if ($response->successful()) {
                return $response->json();
            }
            throw new \Exception("Error getting auth session");
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getKVMDetail($kvm_id, $signature, $api_host, $valid_until)
    {
        $response = Http::post("https://{$api_host}/kvm/v2/get/all_details", [
            "signature" => $signature,
            "kvm_id" => $kvm_id,
            "valid_until" => $valid_until,
            "api_host" => $api_host
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception($response->body()); // Use the body for a meaningful message
    }
    public function getImages($kvm_id, $signature, $api_host, $valid_until)
    {
        $response = Http::post("https://{$api_host}/kvm/v2/get/images", [
            "signature" => $signature,
            "kvm_id" => $kvm_id,
            "valid_until" => $valid_until
        ]);
        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception("Error getting autoinstall images");
    }
    public function reinstallKvm($kvm_id, $signature, $api_host, $valid_until, $password, $image)
    {
        $response = Http::post("https://{$api_host}/kvm/v2/reinstall", [
            "signature" => $signature,
            "kvm_id" => $kvm_id,
            "valid_until" => $valid_until,
            "password" => $password,
            "image" => $image,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception("There wan an error reinstalling kvm...!");
    }
}