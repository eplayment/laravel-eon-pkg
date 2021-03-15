<?php

namespace Eplayment\Wallet;

use Illuminate\Support\Facades\Http;

class Wallet
{
    protected $endpoint;
    protected $client;

    public function __construct()
    {
        $this->endpoint = config('wallet.url');
        $this->client = Http::withHeaders([
            'content-type'  =>  'application/json'
        ]);

        return $this;
    }

    public function initiateKyc($request)
    {
        $response = $this->client->post($this->endpoint . '/kyc/intiate', $request->all());

        return $response->json();
    }
}
