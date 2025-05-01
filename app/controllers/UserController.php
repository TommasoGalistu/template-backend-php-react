<?php

require_once __DIR__ . '/../services/UserService.php';
require_once __DIR__ . '/../helper/sanitize.php';
require_once __DIR__ . '/../helper/JWTHandler.php';

// gestisco l'api, pulisco i dati e li passo a service
class UserController {
    private UserService $service;
    private array $message;

    public function __construct() {
        $this->service = new UserService();
        $this->message = require __DIR__ . '/../services/en.php';
    }
    public function register($rawJson) {

        $req = json_decode($rawJson, true);
        [$email, $password] = sanitize_user($req['email'], $req['password']);
        try{
            return $this->service->register($email, $password);
        }catch(Exception $e){
            return ['error' => $this->message['email_already_exists'], 'details' => $e->getMessage()];
        }
    }
    public function login($rawJson, $clientIp) {

        $req = json_decode($rawJson, true);
        [$email, $password] = sanitize_user($req['email'], $req['password']);

        try{
            $user = $this->service->login($email, $password, $clientIp);
            $token = JWTHandler::create(['id' => $user->id, 'email' => $user->email, 'ip' => $clientIp]);
            return ['token' => $token];
        }catch(Exception $e){
            return ['error' => $this->message['invalid_credentials'], 'details' => $e->getMessage()];
        }
    }
}