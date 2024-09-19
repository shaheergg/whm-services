<?php
namespace App\Services;
use Http;



class PleskApiService
{
    protected $username;
    protected $password;
    protected $baseUrl = "https://193.57.33.21:8443/api/v2";
    public function __construct()
    {
        $this->username = config("plesk.PLESK_USERNAME");
        $this->password = config("plesk.PLESK_PASSWORD");
    }

    public function getServerInfo()
    {
        $response = Http::withBasicAuth($this->username, $this->password)
            ->withOptions([
                'verify' => false
            ])->get("{$this->baseUrl}/server");

        if ($response->successful()) {
            return $response->json();
        }
        throw new \Exception('Failed to get server info');
    }
    public function listClients()
    {
        $response = Http::withBasicAuth($this->username, $this->password)
            ->withOptions([
                'verify' => false
            ])->get("{$this->baseUrl}/clients");

        if ($response->successful()) {
            return $response->json();
        }
        throw new \Exception('Failed to get client list');
    }

    public function listDomains()
    {
        $response = Http::withBasicAuth($this->username, $this->password)
            ->withOptions([
                'verify' => false
            ])->get("{$this->baseUrl}/domains");

        if ($response->successful()) {
            return $response->json();
        }
        throw new \Exception('Failed to get domains list');
    }

    public function listDNSRecords($domain)
    {
        $response = Http::withBasicAuth($this->username, $this->password)
            ->withOptions([
                'verify' => false
            ])->get("{$this->baseUrl}/dns/records?domain={$domain}");

        if ($response->successful()) {
            return $response->json();
        }
        throw new \Exception("Failed to get the dns records {$response}");
    }

    public function listExtensions()
    {
        $response = Http::withBasicAuth($this->username, $this->password)
            ->withOptions([
                'verify' => false
            ])->get("{$this->baseUrl}/extensions");

        if ($response->successful()) {
            return $response->json($response);
        }
        throw new \Exception("Failed to get the dns records {$response}");

    }
}