<?php

// helpers/sanitize.php
function sanitize_user($email, $password) {
    $email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
    $password = trim($password);
    return [$email, $password];
}

function sanitize_text(string $text): string {
    return htmlspecialchars(trim($text), ENT_QUOTES, 'UTF-8');
}