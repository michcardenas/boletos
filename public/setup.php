<?php
echo "<pre>";

$basePath = '/home/fecoeror/boletos-app';
$vendorPath = $basePath . '/vendor';
$cacheDir = $basePath . '/bootstrap/cache';

// ============================================================
// PASO 1: Restaurar packages.php (SOLO paquetes de produccion)
// El zip anterior metio paquetes dev (breeze, sail, etc) que
// no existen en el servidor y causan el error 500.
// ============================================================
echo "=== PASO 1: RESTAURAR PACKAGES.PHP ===\n";

$packagesPhp = <<<'PHP'
<?php return array (
  'barryvdh/laravel-dompdf' =>
  array (
    'aliases' =>
    array (
      'PDF' => 'Barryvdh\\DomPDF\\Facade\\Pdf',
      'Pdf' => 'Barryvdh\\DomPDF\\Facade\\Pdf',
    ),
    'providers' =>
    array (
      0 => 'Barryvdh\\DomPDF\\ServiceProvider',
    ),
  ),
  'laravel/tinker' =>
  array (
    'providers' =>
    array (
      0 => 'Laravel\\Tinker\\TinkerServiceProvider',
    ),
  ),
  'nesbot/carbon' =>
  array (
    'providers' =>
    array (
      0 => 'Carbon\\Laravel\\ServiceProvider',
    ),
  ),
  'spatie/laravel-permission' =>
  array (
    'providers' =>
    array (
      0 => 'Spatie\\Permission\\PermissionServiceProvider',
    ),
  ),
);
PHP;

if (!is_dir($cacheDir)) {
    mkdir($cacheDir, 0755, true);
}

file_put_contents($cacheDir . '/packages.php', $packagesPhp);
echo "OK: packages.php creado (solo produccion, sin dev).\n";

// Eliminar caches corruptos
foreach (['services.php', 'config.php'] as $f) {
    $path = $cacheDir . '/' . $f;
    if (file_exists($path)) {
        unlink($path);
        echo "Eliminado: $f\n";
    }
}
foreach (glob($cacheDir . '/routes-*.php') as $f) {
    unlink($f);
    echo "Eliminado: " . basename($f) . "\n";
}

// ============================================================
// PASO 2: Extraer paquetes DomPDF desde zip
// ============================================================
echo "\n=== PASO 2: EXTRAER DOMPDF ===\n";

$zipFile = __DIR__ . '/dompdf-packages.zip';
if (!file_exists($zipFile)) {
    echo "AVISO: dompdf-packages.zip no encontrado. Saltando extraccion.\n";
} else {
    $zip = new ZipArchive();
    if ($zip->open($zipFile) === true) {
        $zip->extractTo($basePath);
        echo "OK: {$zip->numFiles} archivos extraidos.\n";
        $zip->close();
    } else {
        echo "ERROR: No se pudo abrir el zip.\n";
    }
}

// Verificar
$checks = [
    'vendor/barryvdh/laravel-dompdf/src/Facade/Pdf.php',
    'vendor/barryvdh/laravel-dompdf/src/ServiceProvider.php',
    'vendor/dompdf/dompdf/src/Dompdf.php',
    'vendor/masterminds/html5/src/HTML5.php',
];
foreach ($checks as $file) {
    echo (file_exists("$basePath/$file") ? 'OK' : 'FALTA') . ": $file\n";
}

// ============================================================
// PASO 3: Patchear autoloader PSR-4
// ============================================================
echo "\n=== PASO 3: PATCHEAR AUTOLOADER ===\n";

// --- autoload_psr4.php ---
$psr4File = "$vendorPath/composer/autoload_psr4.php";
if (file_exists($psr4File)) {
    $psr4 = file_get_contents($psr4File);
    $psr4Entries = [
        "'Barryvdh\\\\DomPDF\\\\' => array(\$vendorDir . '/barryvdh/laravel-dompdf/src')",
        "'Dompdf\\\\' => array(\$vendorDir . '/dompdf/dompdf/src')",
        "'Masterminds\\\\' => array(\$vendorDir . '/masterminds/html5/src')",
        "'FontLib\\\\' => array(\$vendorDir . '/dompdf/php-font-lib/src/FontLib')",
        "'Svg\\\\' => array(\$vendorDir . '/dompdf/php-svg-lib/src/Svg')",
    ];

    $added = 0;
    foreach ($psr4Entries as $entry) {
        $ns = explode("'", $entry)[1];
        if (strpos($psr4, $ns) === false) {
            $psr4 = str_replace(');', "    $entry,\n);", $psr4);
            $added++;
        }
    }
    file_put_contents($psr4File, $psr4);
    echo "autoload_psr4.php: $added entradas agregadas.\n";
} else {
    echo "FALTA: autoload_psr4.php\n";
}

// --- autoload_static.php ---
$staticFile = "$vendorPath/composer/autoload_static.php";
if (file_exists($staticFile)) {
    $static = file_get_contents($staticFile);
    $staticPsr4 = [
        "'Barryvdh\\\\DomPDF\\\\'" => "array(0 => __DIR__ . '/..' . '/barryvdh/laravel-dompdf/src')",
        "'Dompdf\\\\'" => "array(0 => __DIR__ . '/..' . '/dompdf/dompdf/src')",
        "'Masterminds\\\\'" => "array(0 => __DIR__ . '/..' . '/masterminds/html5/src')",
        "'FontLib\\\\'" => "array(0 => __DIR__ . '/..' . '/dompdf/php-font-lib/src/FontLib')",
        "'Svg\\\\'" => "array(0 => __DIR__ . '/..' . '/dompdf/php-svg-lib/src/Svg')",
    ];

    $marker = 'public static $prefixDirsPsr4 = array (';
    $added = 0;
    foreach ($staticPsr4 as $ns => $path) {
        if (strpos($static, $ns) === false && strpos($static, $marker) !== false) {
            $static = str_replace(
                $marker,
                $marker . "\n        $ns => \n            $path,",
                $static
            );
            $added++;
        }
    }
    file_put_contents($staticFile, $static);
    echo "autoload_static.php: $added entradas agregadas.\n";
} else {
    echo "FALTA: autoload_static.php\n";
}

// ============================================================
// PASO 4: Limpiar vistas compiladas
// ============================================================
echo "\n=== PASO 4: LIMPIAR VISTAS ===\n";
$viewsPath = "$basePath/storage/framework/views";
if (is_dir($viewsPath)) {
    $count = 0;
    foreach (glob("$viewsPath/*.php") as $viewFile) {
        unlink($viewFile);
        $count++;
    }
    echo "Eliminadas $count vistas compiladas.\n";
}

// ============================================================
// VERIFICACION FINAL
// ============================================================
echo "\n=== VERIFICACION ===\n";
$psr4Check = file_get_contents($psr4File);
echo (strpos($psr4Check, 'Barryvdh') !== false ? 'OK' : 'FALTA') . ": Barryvdh en autoloader\n";
echo (strpos($psr4Check, 'Dompdf') !== false ? 'OK' : 'FALTA') . ": Dompdf en autoloader\n";

$pkgCheck = file_get_contents("$cacheDir/packages.php");
echo (strpos($pkgCheck, 'DomPDF') !== false ? 'OK' : 'FALTA') . ": DomPDF en packages.php\n";
echo (strpos($pkgCheck, 'breeze') === false ? 'OK' : 'MAL') . ": Sin paquetes dev\n";

echo "\n=== LISTO ===\n";
echo "Visita https://eventos.fecoer.org/ para verificar.\n";
echo "</pre>";
