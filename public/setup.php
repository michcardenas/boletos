<?php
echo "<pre>";

// --- Diagnostico ---
echo "=== DIAGNOSTICO ===\n";
echo "PHP version: " . phpversion() . "\n";
echo "shell_exec disponible: " . (function_exists('shell_exec') ? 'SI' : 'NO') . "\n";

// Buscar composer
$composerPaths = [
    'composer',
    '/usr/local/bin/composer',
    '/usr/bin/composer',
    '/opt/cpanel/composer/bin/composer',
    'php /home/fecoeror/composer.phar',
    'php composer.phar',
];

$composerCmd = null;
foreach ($composerPaths as $path) {
    $result = shell_exec($path . ' --version 2>&1');
    if ($result && strpos($result, 'Composer') !== false) {
        $composerCmd = $path;
        echo "Composer encontrado: {$path}\n";
        echo "Version: " . trim($result) . "\n";
        break;
    }
}

if (!$composerCmd) {
    echo "ERROR: Composer NO encontrado en ninguna ruta conocida.\n";
    echo "Probando 'which composer': " . shell_exec('which composer 2>&1') . "\n";
    echo "Probando 'find / -name composer 2>/dev/null | head -5': " . shell_exec('find / -name "composer" -type f 2>/dev/null | head -5') . "\n";
}

// Verificar estado actual de DomPDF
echo "\n=== VERIFICAR DOMPDF (antes) ===\n";
$dompdfPath = '/home/fecoeror/boletos-app/vendor/barryvdh/laravel-dompdf';
echo "Directorio vendor/barryvdh/laravel-dompdf: " . (file_exists($dompdfPath) ? 'EXISTE' : 'NO EXISTE') . "\n";
echo "Directorio vendor/dompdf/dompdf: " . (file_exists('/home/fecoeror/boletos-app/vendor/dompdf/dompdf') ? 'EXISTE' : 'NO EXISTE') . "\n";

// --- Instalar dependencias ---
if ($composerCmd) {
    echo "\n=== COMPOSER INSTALL ===\n";
    $output = shell_exec("cd /home/fecoeror/boletos-app && {$composerCmd} install --no-dev --no-interaction 2>&1");
    echo $output ?: "(sin salida)\n";

    // Verificar de nuevo
    echo "\n=== VERIFICAR DOMPDF (despues de install) ===\n";
    echo "Directorio vendor/barryvdh/laravel-dompdf: " . (file_exists($dompdfPath) ? 'EXISTE' : 'NO EXISTE') . "\n";

    if (!file_exists($dompdfPath)) {
        echo "\nIntentando composer require...\n";
        echo shell_exec("cd /home/fecoeror/boletos-app && {$composerCmd} require barryvdh/laravel-dompdf:^3.1 --no-interaction 2>&1");
    }

    echo "\n=== DUMP AUTOLOAD ===\n";
    echo shell_exec("cd /home/fecoeror/boletos-app && {$composerCmd} dump-autoload 2>&1");
} else {
    echo "\n=== COMPOSER NO DISPONIBLE ===\n";
    echo "No se puede ejecutar composer install.\n";
    echo "Opciones:\n";
    echo "1. Conectate por SSH y ejecuta: cd /home/fecoeror/boletos-app && composer install --no-dev\n";
    echo "2. Sube la carpeta vendor/ completa desde tu PC via File Manager o FTP.\n";
}

// --- Migraciones ---
echo "\n=== MIGRACIONES ===\n";
echo shell_exec('cd /home/fecoeror/boletos-app && php artisan migrate --force 2>&1');

// --- Limpiar cache ---
echo "\n=== LIMPIAR CACHE ===\n";
echo shell_exec('cd /home/fecoeror/boletos-app && php artisan config:clear 2>&1');
echo shell_exec('cd /home/fecoeror/boletos-app && php artisan cache:clear 2>&1');
echo shell_exec('cd /home/fecoeror/boletos-app && php artisan view:clear 2>&1');
echo shell_exec('cd /home/fecoeror/boletos-app && php artisan route:clear 2>&1');

echo "\n=== LISTO ===\n";
echo "</pre>";
