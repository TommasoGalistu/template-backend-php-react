<?php

require_once __DIR__ . '/../services/UserService.php';
require_once __DIR__ . '/../helper/sanitize.php';

// gestisco l'api, pulisco i dati e li passo a service
class UserController {
    private $service;

    public function __construct() {
        $this->service = new UserService();
    }
    public function register($rawJson) {

        $req = json_decode($rawJson, true);
        [$email, $password] = sanitize($req['email'], $req['password']);
        return $this->service->register($email, $password);
    }
    public function login($rawJson, $clientIp) {

        $req = json_decode($rawJson, true);
        [$email, $password] = sanitize($req['email'], $req['password']);
        return $this->service->login($email, $password, $clientIp);
    }
}