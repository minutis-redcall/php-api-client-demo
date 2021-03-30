<?php

namespace App\Service;

use GuzzleHttp\Client;

class RedCallClient
{
    //const API_URL = 'http://127.0.0.1:8000';
    const API_URL = 'https://rcl.re';

    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $secret;

    /**
     * @var Client
     */
    private $client;

    public function __construct(string $token, string $secret)
    {
        $this->token  = $token;
        $this->secret = $secret;

        $this->client = new Client([
            'base_uri' => self::API_URL,
            'timeout'  => 2.0,
        ]);
    }

    public function demo(string $name)
    {
        return $this->call('GET', '/api/demo', [
            'name' => $name,
        ]);
    }

    private function call(string $method, string $uri, array $parameters = [])
    {
        $uri = self::API_URL.$uri;

        if ('GET' === $method) {
            $uri  = $uri.'?'.http_build_query($parameters);
            $body = null;
        } else {
            $body = json_encode($parameters);
        }

        $response = $this->client->get($uri, [
            'body'    => $body,
            'headers' => [
                'Authorization' => sprintf('Bearer %s', $this->token),
                'X-Signature'   => hash_hmac('sha256', sprintf('%s%s%s', $method, $uri, $body), $this->secret),
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}