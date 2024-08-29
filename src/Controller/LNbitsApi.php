<?php

namespace Digiwerft\IsotopeLNbits\Controller;

use Exception;
use GuzzleHttp\Client;

class LNbitsApi
{
    private $apiUrl;
    private $apiKey;
    private $client;

    public function __construct($apiUrl, $apiKey)
    {
        $this->apiUrl = rtrim($apiUrl, '/');
        $this->apiKey = $apiKey;
        $this->client = new Client([
            'headers' => [
                'X-Api-Key' => $this->apiKey
            ]
        ]);
    }

    public function createInvoice($amount, $description)
    {
        $endpoint = $this->apiUrl . '/api/v1/payments';
        $data = [
            'out' => false,
            'amount' => $amount,
            'memo' => $description,
            'unit' => 'EUR'
        ];

        try {
            $response = $this->makeRequest($endpoint, 'POST', $data);
        } catch (Exception $e) {
            try {
                $response = $this->makeRequest($endpoint, 'POST', $data);
            } catch (Exception $e) {
                return false;
            }
        }

        if (isset($response['payment_request'])) {
            return $response;
        }

        return false;
    }

    public function checkPayment($paymentHash)
    {
        $endpoint = $this->apiUrl . '/api/v1/payments/' . $paymentHash;
        try {
            $response = $this->makeRequest($endpoint, 'GET');
        } catch (Exception $e) {
            try {
                $response = $this->makeRequest($endpoint, 'GET');
            } catch (Exception $e) {
                return false;
            }
        }

        return $response;
    }

    private function makeRequest($endpoint, $method, $data = [])
    {
        $response = $this->client->request($method, $endpoint, [
            'json' => $data
        ]);
        return json_decode($response->getBody(), true);
    }
}