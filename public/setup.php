<?php
echo "<pre>";

$basePath = '/home/fecoeror/boletos-app';
$vendorPath = $basePath . '/vendor';

// ============================================================
// FIX URGENTE: Sincronizar hash del autoloader
// El zip anterior reemplazo autoload_real.php con un hash
// diferente al que vendor/autoload.php espera.
// ============================================================
echo "=== FIX: SINCRONIZAR AUTOLOADER ===\n";

$autoloadFile = "$vendorPath/autoload.php";
$autoloadReal = "$vendorPath/composer/autoload_real.php";

if (file_exists($autoloadReal) && file_exists($autoloadFile)) {
    // Leer el hash de autoload_real.php
    $realContent = file_get_contents($autoloadReal);
    if (preg_match('/class\s+ComposerAutoloaderInit(\w+)/', $realContent, $matches)) {
        $realHash = $matches[1];
        echo "Hash en autoload_real.php: $realHash\n";

        // Leer el hash de autoload.php
        $autoContent = file_get_contents($autoloadFile);
        if (preg_match('/ComposerAutoloaderInit(\w+)/', $autoContent, $matches2)) {
            $currentHash = $matches2[1];
            echo "Hash en autoload.php: $currentHash\n";

            if ($currentHash !== $realHash) {
                // Reemplazar el hash en autoload.php
                $autoContent = str_replace($currentHash, $realHash, $autoContent);
                file_put_contents($autoloadFile, $autoContent);
                echo "OK: Hash actualizado en autoload.php -> $realHash\n";
            } else {
                echo "OK: Hashes ya coinciden.\n";
            }
        }
    }

    // Tambien sincronizar autoload_static.php
    $staticFile = "$vendorPath/composer/autoload_static.php";
    if (file_exists($staticFile)) {
        $staticContent = file_get_contents($staticFile);
        if (preg_match('/class\s+ComposerStaticInit(\w+)/', $staticContent, $m)) {
            $staticHash = $m[1];
            echo "Hash en autoload_static.php: $staticHash\n";

            // El hash de static debe coincidir con el de real
            if (preg_match('/ComposerStaticInit(\w+)/', $realContent, $m2)) {
                $expectedStaticHash = $m2[1];
                if ($staticHash !== $expectedStaticHash) {
                    echo "WARN: static hash no coincide con real, pero deberian ser iguales.\n";
                } else {
                    echo "OK: static hash coincide.\n";
                }
            }
        }
    }
} else {
    echo "ERROR: Archivos de autoload no encontrados.\n";
    echo "autoload.php: " . (file_exists($autoloadFile) ? 'SI' : 'NO') . "\n";
    echo "autoload_real.php: " . (file_exists($autoloadReal) ? 'SI' : 'NO') . "\n";
}

// ============================================================
// PASO 2: Restaurar packages.php
// ============================================================
echo "\n=== RESTAURAR PACKAGES.PHP ===\n";

$cacheDir = $basePath . '/bootstrap/cache';
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
echo "OK: packages.php escrito.\n";

// Eliminar otros caches
foreach (['services.php', 'config.php'] as $f) {
    $p = $cacheDir . '/' . $f;
    if (file_exists($p)) { unlink($p); echo "Eliminado: $f\n"; }
}
foreach (glob($cacheDir . '/routes-*.php') as $f) {
    unlink($f); echo "Eliminado: " . basename($f) . "\n";
}

// Limpiar vistas
$viewsPath = "$basePath/storage/framework/views";
if (is_dir($viewsPath)) {
    $c = 0;
    foreach (glob("$viewsPath/*.php") as $vf) { unlink($vf); $c++; }
    echo "Eliminadas $c vistas.\n";
}

// ============================================================
// VERIFICACION
// ============================================================
echo "\n=== VERIFICACION ===\n";

// Test autoloader
echo "Probando autoloader... ";
try {
    require_once $autoloadFile;
    echo "OK: autoload.php carga sin error.\n";

    echo "Probando clase DomPDF... ";
    if (class_exists('Barryvdh\\DomPDF\\Facade\\Pdf')) {
        echo "OK: Clase encontrada!\n";
    } else {
        echo "FALTA: Clase no encontrada.\n";

        // Diagnostico adicional
        echo "\nDiagnostico PSR-4:\n";
        $psr4 = file_get_contents("$vendorPath/composer/autoload_psr4.php");
        echo "  Barryvdh en psr4: " . (strpos($psr4, 'Barryvdh') !== false ? 'SI' : 'NO') . "\n";
        echo "  Archivo existe: " . (file_exists("$vendorPath/barryvdh/laravel-dompdf/src/Facade/Pdf.php") ? 'SI' : 'NO') . "\n";
    }
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

echo "\n=== LISTO ===\n";
echo "</pre>";
