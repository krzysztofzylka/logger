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
     * ApiKey auth
     * @var string
     */
    public static ?string $api_key = null;

    /**
     * Send log
     * @param string $message
     * @param string $type
     * @param array $additional
     * @return void
     * @throws GuzzleException
     */
    public static function log(string $message, string $type = 'INFO', array $additional = []) : array {
        $client = new Client([
            'base_uri' => self::$url,
        ]);

        $params =  [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode([
                'site_key' => self::$site_key,
                'type' => $type,
                'message' => $message,
                'additional' => $additional
            ])
        ];

        if (!is_null(self::$api_key)) {
            $params['headers']['apiKey'] = self::$api_key;
        } else {
            $params['auth'] = [self::$username, self::$password];
        }

        $response = $client->post('/api/log/add', $params);

        return json_decode($response->getBody()->getContents(), true);
    }

}