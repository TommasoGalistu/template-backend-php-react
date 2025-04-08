<?php

setcookie('access_token', '', [
    'expires' => time() - 3600,  
    'path' => '/',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict'
]);

echo json_encode([
    'success' => true,
    'message' => 'Logout effettuato con successo'
]);