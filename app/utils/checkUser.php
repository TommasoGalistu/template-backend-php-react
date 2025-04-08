<?php

function checkUser(string $email, string $password){

    
    $response = [
        "status" => 200,         
        "data" => [],               
        "message" => "Operazione completata",
        "errors" => []
    ];

    // Validazione formato email
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['status'] = 400;
        $response['errors'] = "Email non valida.";
    }

    // Controlli sulla password
    if (strlen($password) <= 8) {
        $response['status'] = 400;
        $response['errors'] = "La password deve essere più lunga di 8 caratteri.";
    }

    if (!preg_match('/[A-Z]/', $password)) {
        $response['status'] = 400;
        $response['errors'] = "La password deve contenere almeno una lettera maiuscola.";
    }

    if (!preg_match('/[0-9]/', $password)) {
        $response['status'] = 400;
        $response['errors'] = "La password deve contenere almeno un numero.";
    }

    if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
        $response['status'] = 400;
        $response['errors'] = "La password deve contenere almeno un carattere speciale.";
    }

    return $response;
}