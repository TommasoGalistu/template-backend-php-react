<?php

function checkUser(string $email, string $password){

    $status = [
        'response' => 200,
        'errors' => []
    ];

    // Validazione formato email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $status['response'] = 400;
        $status['errors'][] = "Email non valida.";
    }

    // Controlli sulla password
    if (strlen($password) <= 8) {
        $status['response'] = 400;
        $status['errors'][] = "La password deve essere più lunga di 8 caratteri.";
    }

    if (!preg_match('/[A-Z]/', $password)) {
        $status['response'] = 400;
        $status['errors'][] = "La password deve contenere almeno una lettera maiuscola.";
    }

    if (!preg_match('/[0-9]/', $password)) {
        $status['response'] = 400;
        $status['errors'][] = "La password deve contenere almeno un numero.";
    }

    if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
        $status['response'] = 400;
        $status['errors'][] = "La password deve contenere almeno un carattere speciale.";
    }

    return [
        'status' => $status
    ];
}