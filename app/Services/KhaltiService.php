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
        return Http::withHeaders([
            'Authorization' => 'key ' . $this->secretKey,   // lowercase 'key'
            'Content-Type' => 'application/json',
        ])->post($this->baseUrl . 'epayment/initiate/', $payload)->json();
    }

    public function lookupPayment(string $pidx)
    {
        return Http::withHeaders([
            'Authorization' => 'key ' . $this->secretKey,   // lowercase 'key'
            'Content-Type' => 'application/json',
        ])->post($this->baseUrl . 'epayment/lookup/', ['pidx' => $pidx])->json(); // POST with body
    }
}
