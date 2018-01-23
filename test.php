<?php

$http = new GuzzleHttp\Client;

$response = $http->post('http://track-them-all.com/oauth/token', [
    'form_params' => [
        'grant_type' => 'password',
        'client_id' => '3',
        'client_secret' => '',
        'username' => 'taylor@laravel.com',
        'password' => 'my-password',
        'scope' => '',
    ],
]);

return json_decode((string) $response->getBody(), true);