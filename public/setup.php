<?php
echo "<pre>";

$basePath = '/home/fecoeror/boletos-app';
$vendorPath = $basePath . '/vendor';
$composerPath = $vendorPath . '/composer';

// ============================================================
// PASO 1: Filtrar autoload_files.php
// Eliminar entradas que apuntan a archivos que no existen
// ============================================================
echo "=== FIX: FILTRAR AUTOLOAD_FILES.PHP ===\n";

$filesPhp = "$composerPath/autoload_files.php";
if (file_exists($filesPhp)) {
    $content = file_get_contents($filesPhp);
    $lines = explode("\n", $content);
    $newLines = [];
    $removed = 0;
    $kept = 0;

    foreach ($lines as $line) {
        // Detectar lineas con rutas a archivos: $vendorDir . '/path/to/file.php'
        if (preg_match("/\\$vendorDir\s*\.\s*'([^']+)'/", $line, $m)) {
            $filePath = $vendorPath . $m[1];
            if (file_exists($filePath)) {
                $newLines[] = $line;
                $kept++;
            } else {
                $removed++;
                echo "  REMOVIDO (no existe): $filePath\n";
            }
        } else {
            // Lineas que no son entradas de archivo (header, return array, etc.)
            $newLines[] = $line;
        }
    }

    $newContent = implode("\n", $newLines);
    file_put_contents($filesPhp, $newContent);
    echo "autoload_files.php: $kept archivos conservados, $removed removidos.\n";
} else {
    echo "ERROR: autoload_files.php no encontrado.\n";
}

// ============================================================
// PASO 2: Filtrar $files en autoload_static.php
// ============================================================
echo "\n=== FIX: FILTRAR AUTOLOAD_STATIC.PHP ===\n";

$staticPhp = "$composerPath/autoload_static.php";
if (file_exists($staticPhp)) {
    $content = file_get_contents($staticPhp);
    $lines = explode("\n", $content);
    $newLines = [];
    $removed = 0;
    $kept = 0;
    $inFilesArray = false;
    $filesArrayDone = false;

    foreach ($lines as $line) {
        // Detectar inicio del array $files
        if (!$filesArrayDone && preg_match('/public\s+static\s+\$files\s*=\s*array\s*\(/', $line)) {
            $inFilesArray = true;
            $newLines[] = $line;
            continue;
        }

        if ($inFilesArray && !$filesArrayDone) {
            // Detectar fin del array $files (linea con solo ");")
            if (preg_match('/^\s*\);\s*$/', $line)) {
                $inFilesArray = false;
                $filesArrayDone = true;
                $newLines[] = $line;
                continue;
            }

            // Detectar entradas con __DIR__ . '/..' . '/path/to/file.php'
            if (preg_match("/__DIR__\s*\.\s*'\/\.\.'?\s*\.\s*'([^']+)'/", $line, $m)) {
                $filePath = $composerPath . '/..' . $m[1];
                $realPath = realpath(dirname($composerPath)) ?: $vendorPath;
                $filePath = $vendorPath . $m[1];
                if (file_exists($filePath)) {
                    $newLines[] = $line;
                    $kept++;
                } else {
                    $removed++;
                    // No imprimir cada uno para no llenar la salida
                }
            } else {
                $newLines[] = $line;
            }
        } else {
            $newLines[] = $line;
        }
    }

    $newContent = implode("\n", $newLines);
    file_put_contents($staticPhp, $newContent);
    echo "autoload_static.php \$files: $kept conservados, $removed removidos.\n";
} else {
    echo "ERROR: autoload_static.php no encontrado.\n";
}

// ============================================================
// PASO 3: Filtrar autoload_classmap.php (dev classes)
// ============================================================
echo "\n=== FIX: FILTRAR AUTOLOAD_CLASSMAP.PHP ===\n";

$classmapPhp = "$composerPath/autoload_classmap.php";
if (file_exists($classmapPhp)) {
    $content = file_get_contents($classmapPhp);
    $lines = explode("\n", $content);
    $newLines = [];
    $removed = 0;
    $kept = 0;

    foreach ($lines as $line) {
        if (preg_match("/\\$vendorDir\s*\.\s*'([^']+)'/", $line, $m)) {
            $filePath = $vendorPath . $m[1];
            if (file_exists($filePath)) {
                $newLines[] = $line;
                $kept++;
            } else {
                $removed++;
            }
        } elseif (preg_match("/\\$baseDir\s*\.\s*'([^']+)'/", $line, $m)) {
            $filePath = $basePath . $m[1];
            if (file_exists($filePath)) {
                $newLines[] = $line;
                $kept++;
            } else {
                $removed++;
            }
        } else {
            $newLines[] = $line;
        }
    }

    $newContent = implode("\n", $newLines);
    file_put_contents($classmapPhp, $newContent);
    echo "autoload_classmap.php: $kept conservados, $removed removidos.\n";
} else {
    echo "SKIP: autoload_classmap.php no encontrado.\n";
}

// ============================================================
// PASO 4: Filtrar PSR-4 en autoload_psr4.php
// ============================================================
echo "\n=== FIX: FILTRAR AUTOLOAD_PSR4.PHP ===\n";

$psr4Php = "$composerPath/autoload_psr4.php";
if (file_exists($psr4Php)) {
    $content = file_get_contents($psr4Php);
    $lines = explode("\n", $content);
    $newLines = [];
    $removed = 0;
    $kept = 0;

    foreach ($lines as $line) {
        if (preg_match("/\\$vendorDir\s*\.\s*'([^']+)'/", $line, $m)) {
            $dirPath = $vendorPath . $m[1];
            if (is_dir($dirPath) || file_exists($dirPath)) {
                $newLines[] = $line;
                $kept++;
            } else {
                $removed++;
                echo "  PSR4 REMOVIDO (dir no existe): $dirPath\n";
            }
        } elseif (preg_match("/\\$baseDir\s*\.\s*'([^']+)'/", $line, $m)) {
            $dirPath = $basePath . $m[1];
            if (is_dir($dirPath) || file_exists($dirPath)) {
                $newLines[] = $line;
                $kept++;
            } else {
                $removed++;
                echo "  PSR4 REMOVIDO (dir no existe): $dirPath\n";
            }
        } else {
            $newLines[] = $line;
        }
    }

    $newContent = implode("\n", $newLines);
    file_put_contents($psr4Php, $newContent);
    echo "autoload_psr4.php: $kept conservados, $removed removidos.\n";
} else {
    echo "SKIP: autoload_psr4.php no encontrado.\n";
}

// ============================================================
// PASO 5: Filtrar $prefixesPsr4 y $classMap en autoload_static.php
// ============================================================
echo "\n=== FIX: FILTRAR PSR4 Y CLASSMAP EN AUTOLOAD_STATIC.PHP ===\n";

if (file_exists($staticPhp)) {
    $content = file_get_contents($staticPhp);
    $lines = explode("\n", $content);
    $newLines = [];
    $removedStatic = 0;

    // Para las secciones de prefixesPsr4 necesitamos un enfoque diferente:
    // Las entradas son array('dir1', 'dir2') y necesitamos verificar los directorios
    foreach ($lines as $line) {
        // Verificar entradas con __DIR__ . '/..' . '/path'
        if (preg_match("/__DIR__\s*\.\s*'\/\.\.\s*'\s*\.\s*'([^']+)'/", $line, $m) ||
            preg_match("/__DIR__\s*\.\s*'\/\.\.'?\s*\.\s*'([^']+)'/", $line, $m)) {
            $path = $vendorPath . $m[1];
            if (file_exists($path) || is_dir($path)) {
                $newLines[] = $line;
            } else {
                $removedStatic++;
            }
        } else {
            $newLines[] = $line;
        }
    }

    // IMPORTANTE: Solo re-escribir si realmente removimos algo adicional
    if ($removedStatic > 0) {
        $newContent = implode("\n", $newLines);
        file_put_contents($staticPhp, $newContent);
        echo "autoload_static.php (psr4/classmap): $removedStatic entradas adicionales removidas.\n";
    } else {
        echo "autoload_static.php (psr4/classmap): Sin entradas adicionales que remover.\n";
    }
}

// ============================================================
// PASO 6: Restaurar packages.php (produccion)
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

// Limpiar vistas compiladas
$viewsPath = "$basePath/storage/framework/views";
if (is_dir($viewsPath)) {
    $c = 0;
    foreach (glob("$viewsPath/*.php") as $vf) { unlink($vf); $c++; }
    echo "Eliminadas $c vistas compiladas.\n";
}

// ============================================================
// VERIFICACION
// ============================================================
echo "\n=== VERIFICACION ===\n";

// Verificar que autoload_files.php ya no tiene archivos faltantes
echo "Verificando autoload_files.php... ";
$content = file_get_contents($filesPhp);
$missing = 0;
if (preg_match_all("/\\$vendorDir\s*\.\s*'([^']+)'/", $content, $allMatches)) {
    foreach ($allMatches[1] as $path) {
        if (!file_exists($vendorPath . $path)) {
            $missing++;
            echo "\n  FALTA: $path";
        }
    }
}
if ($missing === 0) {
    echo "OK - todos los archivos existen.\n";
} else {
    echo "\n  WARN: $missing archivos aun faltan.\n";
}

// Test autoloader
echo "Probando autoloader... ";
try {
    require_once "$vendorPath/autoload.php";
    echo "OK: autoload.php carga sin error.\n";

    echo "Probando clase DomPDF... ";
    if (class_exists('Barryvdh\\DomPDF\\Facade\\Pdf')) {
        echo "OK: Clase encontrada!\n";
    } else {
        echo "FALTA: Clase no encontrada.\n";

        echo "\nDiagnostico PSR-4:\n";
        $psr4Content = file_get_contents($psr4Php);
        echo "  Barryvdh en psr4: " . (strpos($psr4Content, 'Barryvdh') !== false ? 'SI' : 'NO') . "\n";
        echo "  Archivo existe: " . (file_exists("$vendorPath/barryvdh/laravel-dompdf/src/Facade/Pdf.php") ? 'SI' : 'NO') . "\n";
    }
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== LISTO ===\n";
echo "</pre>";
