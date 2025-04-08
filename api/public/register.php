<?php

require_once __DIR__ . '/../../app/config/config.php';
require_once __DIR__ . '/../../app/utils/checkUser.php';

// Legge il corpo grezzo della richiesta da react
$rawJson = file_get_contents('php://input');

// Lo decodifica in array associativo
$data = json_decode($rawJson, true);

// constrollo che tutti i dati siano corretti formalmente
$result = checkUser($data['email'], $data['password']); 

// constrollo che la email non esista
$user = $cms->getUser();
$existEmail = $user->emailExists($data['email']);

if($existEmail){
    
    $result['status']['response'] = 400;
    $result['status']['errors'][] = "Email già registrata.";
}

header('Content-Type: application/json');

// faccio un try catch per salvarli nel db
if($result['status']['response'] == 200){
    try{
        $responseNumber = $user->createUser($data['email'], $data['password']);

        $result['status']['response'] = $responseNumber;
        echo json_encode($result);
    }catch(Exception $e){
        $result['status']['response'] = 400;
        $result['status']['errors'][] = "Riprova, qualcosa è andato male. Se il problema persiste contatta l'assistenza.";
        echo json_encode($result);
    }
}else{
    echo json_encode($result);
}




