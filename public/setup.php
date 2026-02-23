<?php
echo "<pre>";

// --- Instalar dependencias ---
echo "=== COMPOSER INSTALL ===\n";
echo shell_exec('cd /home/fecoeror/boletos-app && composer install --no-dev --no-interaction 2>&1');

// --- Verificar que DomPDF esta instalado ---
echo "\n=== VERIFICAR DOMPDF ===\n";
if (file_exists('/home/fecoeror/boletos-app/vendor/barryvdh/laravel-dompdf')) {
    echo "OK: barryvdh/laravel-dompdf esta instalado.\n";
} else {
    echo "FALTA: barryvdh/laravel-dompdf NO esta instalado. Ejecutando composer require...\n";
    echo shell_exec('cd /home/fecoeror/boletos-app && composer require barryvdh/laravel-dompdf --no-interaction 2>&1');
}

// --- Regenerar autoloader ---
echo "\n=== DUMP AUTOLOAD ===\n";
echo shell_exec('cd /home/fecoeror/boletos-app && composer dump-autoload --no-dev 2>&1');

// --- Migraciones ---
echo "\n=== MIGRACIONES ===\n";
echo shell_exec('cd /home/fecoeror/boletos-app && php artisan migrate --force 2>&1');

// --- Limpiar toda la cache ---
echo "\n=== LIMPIAR CACHE ===\n";
echo shell_exec('cd /home/fecoeror/boletos-app && php artisan config:clear 2>&1');
echo shell_exec('cd /home/fecoeror/boletos-app && php artisan cache:clear 2>&1');
echo shell_exec('cd /home/fecoeror/boletos-app && php artisan view:clear 2>&1');
echo shell_exec('cd /home/fecoeror/boletos-app && php artisan route:clear 2>&1');

echo "\n=== LISTO ===\n";
echo "</pre>";
