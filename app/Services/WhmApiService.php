<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhmApiService
{
    protected $whm_host;
    protected $whm_api_token;
    protected $whm_port;
    protected $whm_api_version;
    protected $whm_username;

    public function __construct($hostname, $api_token, $port, $username,)
    {
        $this->whm_host = $hostname;
        $this->whm_api_token = $api_token;
        $this->whm_port = $port;
        $this->whm_api_version = 2;
        $this->whm_username = $username;
    }

    public function getAppList($function)
    {
        $response = Http::withHeaders([
            'Authorization' => 'whm ' . $this->whm_username . ':' . $this->whm_api_token
        ])->get("{$this->whm_host}:{$this->whm_port}/json-api/{$function}?api.version={$this->whm_api_version}");

        if ($response->successful()) {
            return $response->json();
        }
        throw new \Exception('Failed to get services status');
    }

    public function changePassword($username, $password)
    {
        $response = Http::withHeaders([
            'Authorization' => 'whm ' . $this->whm_username . ':' . $this->whm_api_token
        ])->get("{$this->whm_host}:{$this->whm_port}/json-api/passwd?api.version={$this->whm_api_version}&user={$username}&password={$password}");

        if ($response->successful()) {
            return $response->json();
        }
        throw new \Exception('Failed to change password');
    }

    public function getDomainList()
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'whm ' . $this->whm_username . ':' . $this->whm_api_token
            ])->get("{$this->whm_host}:{$this->whm_port}/json-api/get_domain_info?api.version={$this->whm_api_version}");

            if ($response->successful()) {
                return $response->json();
            }
            throw new \Exception('Failed to get domain list');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function suspendAccount($username)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'whm ' . $this->whm_username . ':' . $this->whm_api_token
            ])->get("{$this->whm_host}:{$this->whm_port}/json-api/suspendacct?api.version={$this->whm_api_version}&user={$username}");

            if ($response->successful()) {
                return $response->json();
            }
            throw new \Exception('Failed to suspend account');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function unsuspendAccount($username)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'whm ' . $this->whm_username . ':' . $this->whm_api_token
            ])->get("{$this->whm_host}:{$this->whm_port}/json-api/unsuspendacct?api.version={$this->whm_api_version}&user={$username}");

            if ($response->successful()) {
                return $response->json();
            }
            throw new \Exception('Failed to suspend account');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    // getting servers disk usage
    public function getDiskUsage()
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'whm ' . $this->whm_username . ':' . $this->whm_api_token
            ])->get("{$this->whm_host}:{$this->whm_port}/json-api/getdiskusage?api.version={$this->whm_api_version}");
            if ($response->successful()) {
                return $response->json();
            }
            throw new \Exception('Failed to get disk usage');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

