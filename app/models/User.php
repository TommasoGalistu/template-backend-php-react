<?php

class User{
    protected Database $db;
    
    public function __construct(Database $_db)
    {
        $this->db = $_db;
    }

    public function emailExists(string $email): bool {
        $sql = "SELECT COUNT(*) as count FROM users WHERE email = :email";
        
        $stmt = $this->db->runSQL($sql, ['email' =>$email]);
        $result = $stmt->fetch();

        return $result['count'] > 0;
    }

    public function checkUser(string $email, string $password) {
        $user = $this->findByEmail($email);

        if($password === $user['password']){
            return true;
        }else{
            return false;
        }
        
    }

    public function createUser(string $email, string $password){
        $this->db->runSQL('INSERT INTO users(email, password) VALUES (:email, :password)',['email' => $email, 'password' => $password]);
        
        return 200;
    }

    public function getById(int $id){
        $stmt = $this->db->runSQL('SELECT id, name, email FROM users WHERE id = ?', [$id]);
    }

    public function findByEmail(string $email){
        $stmt = $this->db->runSQL('SELECT * FROM users WHERE email = ?', [$email]);
        $response = $stmt->fetch();

        return $response;
    }
}