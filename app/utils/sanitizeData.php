<?php

function sanitizeDataUser($_email, $_password){

    $email = trim($_email ?? '');
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    $password = trim($_password ?? '');

    return [$email,$password];
}