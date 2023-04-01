<?php

namespace Krzysztofzylka\Logger;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Logger {

    /**
     * Url
     * @var string
     */
    public static string $url = '';

    /**
     * Username
     * @var string
     */
    public static string $username = '';

    /**
     * Password
     * @var string
     */
    public static string $password = '';

    /**
     * Site key
     * @var string
     */
    public static string $site_key = '';

    /**
     * Send log
     * @param string $message
     * @param string $type
     * @param array $addional
     * @return void
     * @throws GuzzleException
     */
    public static function log(string $message, string $type = 'INFO', array $addional = []) : array {
        $client = new Client([
            'base_uri' => self::$url,
        ]);

        $response = $client->post('/api/log/add', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'auth' => [self::$username, self::$password],
            'body' => json_encode([
                'site_key' => self::$site_key,
                'type' => $type,
                'message' => $message,
                'additional' => $addional
            ])
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

}