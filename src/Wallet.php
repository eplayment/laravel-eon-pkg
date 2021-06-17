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
        $response = $this->client->get($this->endpoint . '/kyc/inquire/' . $transaction_id);

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
        $response = $this->client->post($this->endpoint . '/wallet/fund/transfer/instapay/' . $request->account_number, [
            'password'          =>  'password',
            'amount'            =>  $request->amount,
            'accredited_bank'   =>  $request->accredited_bank,
            'credit_account'    =>  $request->credit_account,
            "account_name"      =>  $request->account_name,
            "account_address"   =>  $request->account_address
        ]);

        return response($response->json())->setStatusCode($response->getStatusCode());
    }
    public function transferViaPesonet($request)
    {
        $response = $this->client->post($this->endpoint . '/wallet/fund/transfer/pesonet/' . $request->account_number, [
            'password'          =>  'password',
            'amount'            =>  $request->amount,
            'accredited_bank'   =>  $request->accredited_bank,
            'credit_account'    =>  $request->credit_account,
            "account_name"      =>  $request->account_name,
            "account_address"   =>  $request->account_address
        ]);

        return response($response->json())->setStatusCode($response->getStatusCode());
    }

    public function createVirtualAccount($request)
    {
        $response = $this->client->post($this->endpoint . '/create/virtual-account', [
            'customer_id'   =>  $request->customer_id,
            'product_type'  =>  $request->product_type,
            'nickname'      =>  $request->nickname,
            'password'      =>  'password'
        ]);

        return response($this->sendResponse($response->getStatusCode(), $response->json()))
            ->setStatusCode($response->getStatusCode());
    }

    private function sendResponse($status_code, $response_data)
    {
        if ($status_code === 201 || $status_code === 200) {
            if (!empty($response_data['success']))
                return $response_data;
            return [
                'success'   =>  true,
                'message'   =>  !empty($response_data['description']) ? $response_data['description'] : null,
                'data'      =>  $response_data
            ];
        }

        return array_merge([
            'success'   =>  false,

        ], $response_data);
    }

    public function getCards($customer_id)
    {
        $response = $this->client->get($this->endpoint . '/card/get/' . $customer_id);

        return response($this->sendResponse($response->getStatusCode(), $response->json()))
            ->setStatusCode($response->getStatusCode());
    }

    public function lockCard($account_number)
    {
        $response = $this->client->post($this->endpoint . '/card/lock/' . $account_number, [
            'password'      =>  'password'
        ]);

        return response($this->sendResponse($response->getStatusCode(), $response->json()))
            ->setStatusCode($response->getStatusCode());
    }

    public function unlockCard($account_number)
    {
        $response = $this->client->post($this->endpoint . '/card/unlock/' . $account_number, [
            'password'      =>  'password'
        ]);

        return response($this->sendResponse($response->getStatusCode(), $response->json()))
            ->setStatusCode($response->getStatusCode());
    }

    public function showCard($account_number)
    {
        $response = $this->client->get($this->endpoint . '/card/show/' . $account_number);

        return response($this->sendResponse($response->getStatusCode(), $response->json()))
            ->setStatusCode($response->getStatusCode());
    }

    public function showCvv($account_number)
    {
        $response = $this->client->get($this->endpoint . '/card/show/cvv/' . $account_number);

        return response($this->sendResponse($response->getStatusCode(), $response->json()))
            ->setStatusCode($response->getStatusCode());
    }

    public function generateCvv($account_number)
    {
        $response1 = $this->client->post($this->endpoint . '/card/generate/cvv/' . $account_number);

        $response = $response1->json();
        if ($response1->json()['success']) {
            $message = ['message' => 'Cvv Successfully Generated.'];
            $response = array_replace($response1->json(), $message);
        };

        return response($this->sendResponse($response1->getStatusCode(), $response))
            ->setStatusCode($response1->getStatusCode());
    }

    public function getCard($account_number)
    {
        $response = $this->client->get($this->endpoint . '/wallet/balance/' . $account_number);

        return response($this->sendResponse($response->getStatusCode(), $response->json()))
            ->setStatusCode($response->getStatusCode());
    }

    public function validatePin($request)
    {
        $response = $this->client->post($this->endpoint . '/card/security/validate/pin/' . $request->account_number, [
            'pin_number'    =>  $request->pin_number
        ]);

        return response($this->sendResponse($response->getStatusCode(), $response->json()))
            ->setStatusCode($response->getStatusCode());
    }

    public function updateWithdrawalLimit($request)
    {
        $response = $this->client->put($this->endpoint . '/card/update/withdrawal/limit/' . $request->account_number, [
            'amount' => $request->amount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'password'  =>  'password'
        ]);

        return response($this->sendResponse($response->getStatusCode(), $response->json()))
            ->setStatusCode($response->getStatusCode());
    }
}
