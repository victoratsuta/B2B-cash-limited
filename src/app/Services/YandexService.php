<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class YandexService
{
    /**
     * @return bool
     */
    public function send(): bool
    {
        try {
            $client = new Client();
            $response = $client->request('GET', 'https://ya.ru');
        } catch (GuzzleException $e) {
            return false;
        }
        return $response->getStatusCode() === 200;
    }
}