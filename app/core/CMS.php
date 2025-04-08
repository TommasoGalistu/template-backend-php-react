<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/User.php';

class CMS{
    protected $db = null;
    protected $user = null;

    public function __construct($dsn, $username, $password)
    {
       
        $this->db = new Database($dsn, $username, $password);
    }

    public function getUser(){
        if($this->user === null){
            $this->user = new User($this->db);
        }

        return $this->user;
    }
}