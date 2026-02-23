<?php
echo "<pre>";

$basePath = '/home/fecoeror/boletos-app';
$zipFile  = __DIR__ . '/dompdf-packages.zip';

// --- Extraer paquetes DomPDF ---
echo "=== INSTALAR DOMPDF ===\n";

if (!file_exists($zipFile)) {
    echo "ERROR: No se encontro dompdf-packages.zip en public/\n";
    echo "Sube el archivo dompdf-packages.zip a la carpeta public/ del servidor.\n";
    echo "</pre>";
    exit;
}

$zip = new ZipArchive();
$res = $zip->open($zipFile);

if ($res !== true) {
    echo "ERROR: No se pudo abrir el zip (codigo: {$res})\n";
    echo "</pre>";
    exit;
}

echo "Archivos en el zip: {$zip->numFiles}\n";
echo "Extrayendo a {$basePath}/...\n";

if ($zip->extractTo($basePath)) {
    echo "OK: Paquetes extraidos correctamente.\n";
} else {
    echo "ERROR: Fallo al extraer.\n";
}

$zip->close();

// --- Verificar DomPDF ---
echo "\n=== VERIFICAR ===\n";
$checks = [
    'vendor/barryvdh/laravel-dompdf/src/ServiceProvider.php',
    'vendor/dompdf/dompdf/src/Dompdf.php',
    'vendor/masterminds/html5/src/HTML5.php',
    'vendor/dompdf/php-font-lib/src/FontLib/Font.php',
    'vendor/composer/autoload_psr4.php',
];

foreach ($checks as $file) {
    $fullPath = "{$basePath}/{$file}";
    echo (file_exists($fullPath) ? 'OK' : 'FALTA') . ": {$file}\n";
}

// --- Verificar que el autoloader conoce DomPDF ---
echo "\n=== VERIFICAR AUTOLOADER ===\n";
$psr4File = "{$basePath}/vendor/composer/autoload_psr4.php";
if (file_exists($psr4File)) {
    $content = file_get_contents($psr4File);
    echo (strpos($content, 'Barryvdh') !== false ? 'OK' : 'FALTA') . ": Barryvdh en autoload_psr4.php\n";
    echo (strpos($content, 'Dompdf') !== false ? 'OK' : 'FALTA') . ": Dompdf en autoload_psr4.php\n";
}

// --- Limpiar cache ---
echo "\n=== LIMPIAR CACHE (via PHP) ===\n";

// Borrar cache de config
$configCache = "{$basePath}/bootstrap/cache/config.php";
if (file_exists($configCache)) {
    unlink($configCache);
    echo "Eliminado: bootstrap/cache/config.php\n";
} else {
    echo "No existia: bootstrap/cache/config.php\n";
}

// Borrar cache de rutas
$routeCache = "{$basePath}/bootstrap/cache/routes-v7.php";
if (file_exists($routeCache)) {
    unlink($routeCache);
    echo "Eliminado: bootstrap/cache/routes-v7.php\n";
} else {
    echo "No existia: bootstrap/cache/routes-v7.php\n";
}

// Borrar vistas compiladas
$viewsPath = "{$basePath}/storage/framework/views";
if (is_dir($viewsPath)) {
    $count = 0;
    foreach (glob("{$viewsPath}/*.php") as $viewFile) {
        unlink($viewFile);
        $count++;
    }
    echo "Eliminadas {$count} vistas compiladas.\n";
}

// Borrar cache de servicios/paquetes
foreach (['services.php', 'packages.php'] as $cacheFile) {
    $path = "{$basePath}/bootstrap/cache/{$cacheFile}";
    if (file_exists($path)) {
        unlink($path);
        echo "Eliminado: bootstrap/cache/{$cacheFile}\n";
    }
}

echo "\n=== LISTO ===\n";
echo "DomPDF instalado. Prueba el boton 'Reenviar' en admin/pagos.\n";
echo "</pre>";
