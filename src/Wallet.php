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
            'content-type'  =>  'application/json',
            'Accept'        =>  'application/json'
        ]);

        return $this;
    }

    public function initiateKyc($request)
    {
        $response = $this->client->post($this->endpoint . '/kyc/intiate', $request->all());

        return response($response->json())->setStatusCode($response->getStatusCode());
    }

    public function getKycStatus($transaction_id)
    {
        $response = $this->client->get($this->endpoint . '/kyc/inquire/'. $transaction_id);

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

    public function getIdtype($request)
    {
        $response = $this->client->get($this->endpoint . '/id-type', $request->all());

        return $response->json();
    }

    public function getNationality($request)
    {
        $response = $this->client->get($this->endpoint . '/nationality', $request->all());

        return $response->json();
    }

    public function getProductType($request)
    {
        $response = $this->client->get($this->endpoint . '/product-type', $request->all());

        return $response->json();
    }

    public function upgradeAccount($request)
    {
        $response = $this->client->post($this->endpoint . '/upgrade-account/3135710', [
            'product_code'  =>  $request->product_code,
            'currency'      =>  'PHP'
        ]);

        return response($response->json())->setStatusCode($response->getStatusCode());
    }

    public function getBanks($request)
    {
        $response = $this->client->post($this->endpoint . '/banks/instapay', $request->all());

        return response($response->json())->setStatusCode($response->getStatusCode());
    }

    public function transferViaInstapay($request)
    {
        $response = $this->client->post($this->endpoint . '/wallet/fund/transfer/instapay/060002135550', [
            'password'          =>  'password',
            'amount'            =>  $request->amount,
            'accredited_bank'   =>  $request->accredited_bank,
            'credit_account'    =>  $request->credit_account,
            "account_name"      =>  $request->account_name,
            "account_address"   =>  $request->account_address
        ]);

        return response($response->json())->setStatusCode($response->getStatusCode());
    }
}
