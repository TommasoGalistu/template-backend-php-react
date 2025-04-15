<?php

// helpers/sanitize.php
function sanitize($email, $password) {
    $email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
    $password = trim($password);
    return [$email, $password];
}