<?php

// comunico con il db
class User {
    public static function findByEmail($email) {
        return DB::row("SELECT * FROM users WHERE email = :email", ['email' => $email]);
    }
    public static function create($email, $password) {
        DB::query("INSERT INTO users (email, password) VALUES (:email, :password)", [
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT)
        ]);
    }
}