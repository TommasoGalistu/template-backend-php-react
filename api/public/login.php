<?php

require_once __DIR__ . '/../../app/config/config.php';

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
    $userExist = $user->checkUser($data['email'], $data['password']);

    if($userExist){
        // ritono un token
        echo json_encode($status);
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



