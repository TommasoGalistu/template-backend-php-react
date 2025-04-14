<?php

use APP\Core\Database;

class Register {

    protected $response = [
        "status" => 200,         
        "data" => [],               
        "message" => "Operazione completata",
        "errors" => []
    ];

    public function handle($rawJson){

        // Lo decodifica in array associativo
        $data = json_decode($rawJson, true);

        [$email, $password] = $this->sanitizeDataUser($data['email'], $data['password']);

        // fine sanitizzazione
        // inizio validazione

        $response = $this->response;
    
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
        
        // fine validazione response
        // constrollo che la email non esista

        $pdo = Database::getConnection();
        $user = $cms->getUser();
        $existEmail = $user->emailExists($email);

        if($existEmail){
            
            $response['status'] = 400;
            $response['errors'] = "Email già registrata.";
        }
    }

    // function sanitizeDataUser($_email, $_password){

    //     $email = trim($_email ?? '');
    //     $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    
    //     $password = trim($_password ?? '');
    
    //     return [$email,$password];
    // }

    // function checkUser(string $email, string $password){

    
        
    // }

}