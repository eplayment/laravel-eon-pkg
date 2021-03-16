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

    public function getEmploymentStatus($request)
    {
        $response = $this->client->get($this->endpoint . '/employment-status', $request->all());

        return $response->json();
    }

    public function getEmploymentNatureOfWork($request)
    {
        $response = $this->client->get($this->endpoint . '/employment-nature-of-work', $request->all());

        return $response->json();
    }

    public function getGender($request)
    {
        $response = $this->client->get($this->endpoint . '/gender', $request->all());

        return $response->json();
    }

    public function getSourceOfFund($request)
    {
        $response = $this->client->get($this->endpoint . '/source-of-fund', $request->all());

        return $response->json();
    }

    public function getCivilStatus($request)
    {
        $response = $this->client->get($this->endpoint . '/civil-status', $request->all());

        return $response->json();
    }
}
