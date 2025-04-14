<?php

function createJWT($payload){

    // Chiave segreta condivisa
    $secret = $_ENV['DB_SECRET_KEY_JWT'];

    
    $header = [
        'alg' => 'HS256',
        'typ' => 'JWT'
    ];
    $header_encoded = base64url_encode(json_encode($header));

    $payload_encoded = base64url_encode(json_encode($payload));

    // 3. SIGNATURE
    $signature = hash_hmac('sha256', "$header_encoded.$payload_encoded", $secret, true);
    $signature_encoded = base64url_encode($signature);

    // 4. JWT FINALE
    $jwt = "$header_encoded.$payload_encoded.$signature_encoded";

    return $jwt;

}

function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function decodeJWT(){
    
}