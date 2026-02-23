<?php
echo "<pre>";

// --- Configurar Gmail SMTP en .env ---
echo "=== CONFIGURAR GMAIL SMTP ===\n";
$envPath = '/home/fecoeror/boletos-app/.env';
$env = file_get_contents($envPath);

$mailVars = [
    'MAIL_MAILER'       => 'smtp',
    'MAIL_HOST'         => 'smtp.gmail.com',
    'MAIL_PORT'         => '587',
    'MAIL_USERNAME'     => 'michcardenas001@gmail.com',
    'MAIL_PASSWORD'     => '"lisl uiow lydp wpfo"',
    'MAIL_ENCRYPTION'   => 'tls',
    'MAIL_FROM_ADDRESS' => '"michcardenas001@gmail.com"',
    'MAIL_FROM_NAME'    => '"FECOER Gala"',
];

foreach ($mailVars as $key => $value) {
    // Replace existing line or append
    if (preg_match("/^{$key}=.*/m", $env)) {
        $env = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $env);
        echo "  Actualizado: {$key}={$value}\n";
    } else {
        $env .= "\n{$key}={$value}";
        echo "  Agregado: {$key}={$value}\n";
    }
}

file_put_contents($envPath, $env);
echo "Archivo .env actualizado.\n";

// --- Limpiar cache ---
echo "\n=== LIMPIAR CACHE ===\n";
echo shell_exec('cd /home/fecoeror/boletos-app && php artisan config:clear 2>&1');
echo shell_exec('cd /home/fecoeror/boletos-app && php artisan cache:clear 2>&1');
echo shell_exec('cd /home/fecoeror/boletos-app && php artisan view:clear 2>&1');

echo "\n=== LISTO ===\n";
echo "Gmail SMTP configurado. Prueba enviar un correo desde el admin.\n";
echo "</pre>";
