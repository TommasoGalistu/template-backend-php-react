<?php

// services/UserService.php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../helper/JWTHandler.php';

// gestisco la logica di business
class UserService {
    public function register($email, $password) {
        if (User::findByEmail($email)) return ['error' => 'Email già registrata'];
        User::create($email, $password);
        return ['success' => true];
    }
    public function login($email, $password, $clientIp) {
        $user = User::findByEmail($email);
        if (!$user || !password_verify($password, $user->password)) return ['error' => 'Credenziali errate'];
        $token = JWTHandler::create(['id' => $user->id, 'email' => $user->email, 'ip' => $clientIp]);
        return ['token' => $token];
    }
}