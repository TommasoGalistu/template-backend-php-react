<?php

require_once __DIR__ . '/../../vendor/autoload.php';

require_once __DIR__ . '/../core/CMS.php';
require_once __DIR__ . '/../utils/file_get_env_content.php';


loadEnv(__DIR__ . '/../../.env');

$dsn = sprintf(
            "%s:host=%s;port=%s;dbname=%s;charset=%s",
            $_ENV['DB_DRIVER'],
            $_ENV['DB_HOST'],
            $_ENV['DB_PORT'],
            $_ENV['DB_NAME'],
            $_ENV['DB_CHARSET']
        );
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];

$cms = new CMS($dsn, $username, $password);

