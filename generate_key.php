<?php

// Generar clave de aplicación Laravel
$key = 'base64:' . base64_encode(random_bytes(32));
echo "APP_KEY=" . $key . "\n";
echo "Clave generada exitosamente.\n";
echo "Copia esta línea en tu archivo .env:\n";
echo "APP_KEY=" . $key . "\n";
