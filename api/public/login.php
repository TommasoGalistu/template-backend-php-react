<?php

require_once __DIR__ . '/../../app/config/config.php';
require_once __DIR__ . '/../../app/utils/createJWT.php';
require_once __DIR__ . '/../../app/utils/sanitizeData.php';





header('Content-Type: application/json');

$response = [
    "status" => 200,         
    "data" => [],               
    "message" => "Operazione completata",
    "errors" => []
];
// Legge il corpo grezzo della richiesta da react
$rawJson = file_get_contents('php://input');

// Lo decodifica in array associativo
$data = json_decode($rawJson, true);


[$email, $password] = sanitizeDataUser($data['email'], $data['password']);


try{
    // constrollo che la email esista
    $user = $cms->getUser();
    $userValidate = $user->checkUser($email, $password);

    if (!$userValidate || empty($userValidate['email'])) {
        throw new Exception("I dati non corrispondono. Riprovare l'accesso o recupera la password.");
    }
    
    // inizio creazione token
    // prendo l'ip
    $clientIp = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

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

    $jwt = createJWT($payload);

    setcookie('access_token', $jwt, [
        'expires' => $tokenExpiry,
        'path' => '/',
        'secure' => true,
        'httponly' => true,
        'samesite' => 'Strict'
    ]);

    $response = [
        "status" => 200,         
        "data" => [ 
            'id' => $userValidate['id'],
            'email' => $userValidate['email']
        ],               
        "message" => "Accesso consentito.",
        "errors" => []
    ];
    echo json_encode($response);
   
    

}catch(Exception $e){
        $response['status'] = 400;
        $response['errors'] = $e->getMessage();
        echo json_encode($response);
}


