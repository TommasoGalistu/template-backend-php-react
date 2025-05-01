<?php

// services/UserService.php
require_once __DIR__ . '/../models/User.php';


// gestisco la logica di business
class UserService {
    public function register($email, $password) {

        if (User::findByEmail($email)) throw new Exception("Email già registrata");
        User::create($email, $password);
        return ['success' => true];
    }
    public function login($email, $password, $clientIp) {
        $user = User::findByEmail($email);
        if (!$user || !password_verify($password, $user->password)) throw new Exception('Email o password errati');
        return $user;
    }
}