<?php
// middleware/auth.php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function checkAuth($cms) {
    
    if (!isset($_COOKIE['access_token'])) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Token mancante']);
        exit;
    }

    $token = $_COOKIE['access_token'];

    try {
        $secretKey = $_ENV['DB_SECRET_KEY_JWT'];
        $decoded = JWT::decode($token, new Key($secretKey, 'HS256'));

        // Verifica IP se vuoi essere più sicuro
        $clientIp = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        if ($decoded->ip !== $clientIp) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Token non valido per questo IP']);
            exit;
        }

        $user = $cms->getUser();
        $response = $user->findByEmail($decoded->email);

        if($response->email != $decoded->email){
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Token non valido per questo Email']);
            exit;
        }

        echo json_encode($response);
        

    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Token JWT non valido', 'error' => $e->getMessage()]);
        exit;
    }
}

