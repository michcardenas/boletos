<?php
echo "<pre>";
echo "=== COMPOSER INSTALL ===\n";
echo shell_exec('cd /home/fecoeror/boletos-app && composer install --no-dev 2>&1');
echo "\n=== MIGRACIONES ===\n";
echo shell_exec('cd /home/fecoeror/boletos-app && php artisan migrate --force 2>&1');
echo "\n=== LIMPIAR CACHE ===\n";
echo shell_exec('cd /home/fecoeror/boletos-app && php artisan config:clear 2>&1');
echo shell_exec('cd /home/fecoeror/boletos-app && php artisan cache:clear 2>&1');
echo shell_exec('cd /home/fecoeror/boletos-app && php artisan view:clear 2>&1');
echo "\n=== LISTO ===\n";
echo "</pre>";
