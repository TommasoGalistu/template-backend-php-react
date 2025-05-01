<?php

function loadEnv(string $path)
{
    if (!is_file($path)) {
        throw new Exception(".env file not found at: $path");
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        // Ignora commenti
        if (str_starts_with(trim($line), '#')) {
            continue;
        }

        // Parsing riga chiave=valore
        if (strpos($line, '=') !== false) {
            list($name, $value) = explode('=', $line, 2);

            $name = trim($name);
            $value = trim($value, " \t\n\r\0\x0B\"'"); 

            // Imposta nell'ambiente
            $_ENV[$name] = $value;

            // commento di un opzione che può servire
            // putenv("$name=$value");
        }
    }
}
