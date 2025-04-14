<!-- pagina pubblica -->
<?php

$path_env = __DIR__ . '/../../.env';

$righe = file($path_env);
foreach ($righe as $riga) {
    echo trim($riga) . PHP_EOL ;
}