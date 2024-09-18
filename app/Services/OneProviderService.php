<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OneProviderService
{
    protected $baseUrl;
    protected $apiKey;
    protected $clientSecret;

    public function __construct()
    {
        $this->baseUrl = config("oneprovider.ONE_BASE_URL");
        $this->apiKey = config("oneprovider.ONE_API_KEY");
        $this->clientSecret = config("oneprovider.ONE_CLIENT_SECRET");
    }

    public function getServersList()
    {
        $response = Http::withHeaders([
            "Api-Key" => $this->apiKey,
            "Client-Key" => $this->clientSecret,
            "X-Pretty-JSON" => "1"
        ])->get("{$this->baseUrl}/server/list");

        if ($response->successful()) {
            return $response->json();
        }
        throw new \Exception($response);
    }

    public function getServerInfo(int $server_id)
    {
        // Log the server_id for debugging
        $response = Http::withHeaders(
            [
                "Api-Key" => $this->apiKey,
                "Client-Key" => $this->clientSecret,
                "X-Pretty-JSON" => "1"
            ]
        )->get("{$this->baseUrl}/vm/info/{$server_id}");

        if ($response->successful()) {
            return $response->json();
        }

        // Log the response for debugging
        \Log::error("Error response: " . $response->body());

        throw new \Exception("Error getting server info: " . $response->body());
    }

    public function manageServer(int $server_id)
    {
        $response = Http::withHeaders([
            [
                "Api-Key" => $this->apiKey,
                "Client-Key" => $this->clientSecret,
                "X-Pretty-JSON" => "1"
            ],
        ])->get("{$this->baseUrl}/server/manage/{$server_id}");

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception($response);
    }

    public function powerOff(int $server_id)
    {
        $response = Http::withHeaders([
            [
                "Api-Key" => $this->apiKey,
                "Client-Key" => $this->clientSecret,
                "X-Pretty-JSON" => "1",
                "vm_id" => $server_id
            ],
        ])->post("{$this->baseUrl}/vm/poweroff");

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception($response);
    }
}