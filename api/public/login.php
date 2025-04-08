<?php

require_once __DIR__ . '/../../app/config/config.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// require 'vendor/autoload.php';

$status = [
    'response' => 200,
    'errors' => []
];
// Legge il corpo grezzo della richiesta da react
$rawJson = file_get_contents('php://input');

// Lo decodifica in array associativo
$data = json_decode($rawJson, true);

header('Content-Type: application/json');
try{
    // constrollo che la email esista
    $user = $cms->getUser();
    $userValidate = $user->checkUser($data['email'], $data['password']);

    if($userValidate['email']){
        // inizio creazione token
        // prendo l'ip
        $clientIp = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

        // chiave segreta nell'env
        $secretKey = $_ENV['DB_SECRET_KEY_JWT'];

        // creo il termine del token
        $tokenExpiry = time() + (3600 * 24);
        // creo il payload
        $payload = [
            'sub' => $userValidate['id'],
            'email' => $userValidate['email'],
            'ip' => $clientIp,
            'iat' => time(),
            'exp' => $tokenExpiry
        ];

        $jwt = JWT::encode($payload, $secretKey, 'HS256');

        setcookie('access_token', $jwt, [
            'expires' => $tokenExpiry,
            'path' => '/',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict'
        ]);

        echo json_encode([
            'message' => 'Login effettuato',
            'user' => [
                'id' => $userValidate['id'],
                'email' => $userValidate['email']
            ]
        ]);
    }else{
        $status['response'] = 400;
        $status['errors'][] = "I dati non corrispondono:";
        echo json_encode($status);
    }
    

}catch(Exception $e){
        $status['response'] = 400;
        $status['errors'][] = "Riprova, qualcosa è andato male. Se il problema persiste contatta l'assistenza.";
        echo json_encode($status);
}



