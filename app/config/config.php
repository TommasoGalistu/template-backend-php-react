<?php

// config/config.php
require_once __DIR__ . '/../helper/file_get_env_content.php';
require_once __DIR__ . '/Database.php';

loadEnv(__DIR__ . '/../../.env');

DB::connect([
    'db_host' => $_ENV['DB_HOST'],
    'db_name' => $_ENV['DB_NAME'],
    'db_user' => $_ENV['DB_USER'],
    'db_pass' => $_ENV['DB_PASS'],
]);

