<?php

function checkUser(string $email, string $password){

    
    $response = [
        "status" => 200,         
        "data" => [],               
        "message" => "Operazione completata",
        "errors" => []
    ];

    if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
        
        $response['errors'] = "Email non valida (regex).";
    }

    // Controlli sulla password
    if (strlen($password) <= 8) {
        
        $response['errors'] = "La password deve essere più lunga di 8 caratteri.";
    }

    if (!preg_match('/[A-Z]/', $password)) {
        
        $response['errors'] = "La password deve contenere almeno una lettera maiuscola.";
    }

    if (!preg_match('/[0-9]/', $password)) {
        
        $response['errors'] = "La password deve contenere almeno un numero.";
    }

    if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
        
        $response['errors'] = "La password deve contenere almeno un carattere speciale.";
    }


    if(count($response['errors']) > 0){
        $response['errors'] = 400;
    }
    
    return $response;
}