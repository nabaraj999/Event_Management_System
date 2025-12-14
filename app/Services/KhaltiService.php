<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class KhaltiService
{
    protected $secretKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->secretKey = config('services.khalti.secret_key');

        $this->baseUrl = config('services.khalti.live', false)
            ? 'https://khalti.com/api/v2/'
            : 'https://dev.khalti.com/api/v2/';
    }

    public function initiatePayment(array $payload)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Key ' . $this->secretKey,
            'Content-Type' => 'application/json',
        ])->post($this->baseUrl . 'epayment/initiate/', $payload);

        return $response->json();
    }

    public function lookupPayment(string $pidx)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Key ' . $this->secretKey,
        ])->get($this->baseUrl . 'epayment/lookup/?pidx=' . $pidx);

        return $response->json();
    }
}
