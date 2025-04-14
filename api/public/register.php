<?php

require_once __DIR__ . '/../../app/config/config.php';
require_once __DIR__ . '/../../app/utils/checkUser.php';
require_once __DIR__ . '/../../app/utils/sanitizeData.php';

header('Content-Type: application/json');
// Legge il corpo grezzo della richiesta da react

$rawJson = file_get_contents('php://input');

// Lo decodifica in array associativo
$data = json_decode($rawJson, true);

[$email, $password] = sanitizeDataUser($data['email'], $data['password']);

// constrollo che tutti i dati siano corretti formalmente
$response = checkUser($email, $password); 


// constrollo che la email non esista
$user = $cms->getUser();
$existEmail = $user->emailExists($email);

if($existEmail){
    
    $response['status'] = 400;
    $response['errors'] = "Email già registrata.";
}



// faccio un try catch per salvarli nel db
if($response['status'] == 200){
    try{
        $responseNumber = $user->createUser($email, $password);

        // Aggiorna solo i campi interessati
        $response = [
            "status" => $responseNumber['status'],         
            "data" =>  $responseNumber['data'],               
            "message" =>  $responseNumber['message'],
            "errors" => $responseNumber['errors']
        ];

        echo json_encode($response);
    }catch(Exception $e){
        $response['status'] = 400;
        $response['errors'] = "Riprova, qualcosa è andato male. Se il problema persiste contatta l'assistenza.";
        echo json_encode($result);
    }
}else{
    echo json_encode($response);
}




