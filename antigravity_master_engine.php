<?php
/**
 * --------------------------------------------------------------------------------
 * ANTIGRAVITY MASTER ENGINE - v5.9.1 (Senior HTML-Safe & Zero-Repair Edition)
 * --------------------------------------------------------------------------------
 * AUTOR: Arquitecto Senior Full-Stack & UI/UX
 * PROYECTO: 777myto | ENTORNO: Laragon (PHP 5.6 / 7.0.x / 8.x)
 * * * * * * * * * PROPÓSITO TÉCNICO Y ARQUITECTURA:
 * Motor central de trazabilidad SQL. Inyecta dinámicamente un "Tracer" justo
 * antes de las palabras clave SQL para registrar el origen de las consultas
 * en los logs del servidor MariaDB/MySQL.
 *
 * ================================================================================
 * 🛡️ BITÁCORA DE ERRORES SOLUCIONADOS Y PREVENCIÓN (HISTORIAL DE BLINDAJE)
 * [NO BORRAR - DOCUMENTACIÓN CRÍTICA PARA FUTURAS ACTUALIZACIONES]
 * * - BUG v5.0 (Falso Negativo Masivo): PCRE en PHP 7.0 fallaba silenciosamente.
 * * - BUG v5.4 (Amnesia de Estado): Implementación de Ledger Histórico JSON.
 * * - BUG v5.8 (Cuello de Botella del Radar): Arquitectura Ledger-Aware.
 * * - BUG v5.9 (Corrupción HTML): Escudo de Prefijos ampliado para etiquetas <>.
 * * - BUG v5.9.1 (Auto-Inyección y Modificador *): Se implementó auto-exclusión 
 * estricta del motor y migración a delimitadores seguras (~) en Regex.
 * ================================================================================
 */

// --- PASO 1: CONFIGURACIÓN DE RECURSOS ---
set_time_limit(0);
ini_set('memory_limit', '1024M');

echo "🛠️  ENTORNO: PHP " . PHP_VERSION . " (Modo Ámbito Local Activo)\n";
$targetDir = realpath(__DIR__);
echo "📂 RAIZ LOCAL: " . $targetDir . "\n";
echo "--------------------------------------------------\n";

/** --- PARSEO MANUAL CLI --- */
$limit = 1000;
if (isset($argv) && is_array($argv)) {
    foreach ($argv as $arg) {
        if (strpos($arg, '--limit=') === 0) {
            $limit = (int) substr($arg, 8);
        }
    }
}

// Rutas absolutas
$pathLista   = __DIR__ . '/antigravity_master_lista_a_optimizados.json';
$pathSiOptim = __DIR__ . '/antigravity_master_si_optimizados.json';
$pathNoOptim = __DIR__ . '/antigravity_master_no_optimizados.json';

/** --- PASO 2: FASE 0 - FAIL-SAFE --- */
echo "🛡️  [FASE 0] Verificando permisos de sistema de archivos...\n";
if (@file_put_contents($pathLista, "", FILE_APPEND) === false) {
    die("❌ ERROR FATAL: No se puede escribir en la ruta de reportes.\n");
}
echo "✅ Canales de reporte verificados y listos.\n";

/** --- PASO 3: FASE 0.5 - CARGA DEL LEDGER --- */
echo "📚 [FASE 0.5] Cargando Ledger Histórico...\n";
$historicalSuccesses = [];
$optimizedLookup     = [];

if (file_exists($pathSiOptim)) {
    $jsonContent = file_get_contents($pathSiOptim);
    $decodedData = json_decode($jsonContent, true);

    if (is_array($decodedData)) {
        $historicalSuccesses = $decodedData;
        foreach ($historicalSuccesses as $item) {
            if (isset($item['archivo'])) {
                $optimizedLookup[] = $item['archivo'];
            }
        }
    }
}
echo "✅ Historial cargado: " . count($optimizedLookup) . " archivos en memoria.\n";

// --- CONTENEDORES ---
$excludeDirs     = ['node_modules', 'vendor', '.git', '.antigravity', 'build'];
$foundFiles      = [];
$newSuccesses    = [];
$errorInjections = [];

echo "\n🚀 [FASE 1] RADAR: Buscando archivos NUEVOS con lógica SQL...\n";

/** --- PASO 4: FASE 1 - ESCANEO LEDGER-AWARE --- */
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($targetDir));
foreach ($iterator as $file) {
    if ($file->isDir() || $file->getExtension() !== 'php') {
        continue;
    }

    // 🛡️ REGLA CRÍTICA DE AUTO-PRESERVACIÓN: El motor jamás se escaneará a sí mismo
    if ($file->getFilename() === basename(__FILE__)) {
        continue;
    }

    $path         = $file->getRealPath();
    $relativeName = str_replace($targetDir . DIRECTORY_SEPARATOR, '', $path);

    // OMITIR SI YA EXISTE EN EL LEDGER
    if (in_array($relativeName, $optimizedLookup)) {
        continue;
    }

    foreach ($excludeDirs as $ex) {
        if (strpos($path, DIRECTORY_SEPARATOR . $ex . DIRECTORY_SEPARATOR) !== false) {
            continue 2;
        }
    }

    $content = file_get_contents($path);
    
    // 🛡️ REGEX SANEADA: Delimitador ~ usado. Cero basura residual.
    if (preg_match('~\b(SELECT|INSERT|UPDATE|DELETE)\b~i', $content)) {
        $foundFiles[] = $path;
    }

    if (count($foundFiles) >= $limit) {
        break;
    }
}

/** --- PASO 5: REGISTRO DE OBJETIVOS --- */
file_put_contents($pathLista, json_encode($foundFiles, JSON_PRETTY_PRINT));
echo "✅ FASE 1: " . count($foundFiles) . " archivos nuevos registrados en esta tanda.\n";

/** --- PASO 6: FASE 2 - MOTOR DE INYECCIÓN (HTML-SAFE) --- */
echo "\n💉 [FASE 2] INYECCIÓN: Analizando y marcado (Protección HTML activa)...\n";

foreach ($foundFiles as $filePath) {
    $relativeName = str_replace($targetDir . DIRECTORY_SEPARATOR, '', $filePath);
    $content      = file_get_contents($filePath);
    $queryCount   = 0;

    /**
     * REGEX v5.9.1: ESCUDO DE PREFIJOS AMPLIADO Y DELIMITADORES SEGUROS (~)
     * Se usa ~ para prevenir colisión del modificador * con etiquetas HTML.
     */
    $pattern = '~(/\*.*?\*/|//.*?\r?\n|#.*?\r?\n)|(->\s*|::\s*|\$\s*|</?\s*|\.\s*)?\b(SELECT|INSERT|UPDATE|DELETE)\b~is';

    $newContent = preg_replace_callback($pattern, function ($matches) use (&$queryCount, $relativeName) {
        // Ignorar comentarios
        if (isset($matches[1]) && $matches[1] !== '') {
            return $matches[0];
        }

        // Ignorar métodos PHP, variables, Javascript y etiquetas HTML
        if (isset($matches[2]) && $matches[2] !== '') {
            return $matches[0];
        }

        // Es SQL real. Inyectamos.
        $keyword = $matches[3];
        $queryCount++;
        return "/* PARSEADORES1 " . $relativeName . " - QUERY " . $queryCount . " */ " . $keyword;
    }, $content);

    if ($newContent !== $content) {
        if (@file_put_contents($filePath, $newContent)) {
            $newSuccesses[] = ["archivo" => $relativeName, "queries" => $queryCount];
            echo "✔ NUEVO OPTIMIZADO: $relativeName ($queryCount queries)\n";
        } else {
            $errorInjections[$relativeName] = "Error de escritura física.";
            echo "✘ ERROR: $relativeName\n";
        }
    } else {
        $newSuccesses[] = ["archivo" => $relativeName, "queries" => 0, "nota" => "Auditado: Sin queries inyectables (Solo HTML/Variables)"];
        echo "⏭️  AUDITADO (Limpio HTML/PHP): $relativeName\n";
    }
}

/** --- PASO 7: FASE 3 - REPORTE Y FUSIÓN --- */
echo "\n📊 [FASE 3] REPORTE: Fusionando historial...\n";

$finalSuccessList = array_merge($historicalSuccesses, $newSuccesses);

file_put_contents($pathSiOptim, json_encode($finalSuccessList, JSON_PRETTY_PRINT));
file_put_contents($pathNoOptim, json_encode($errorInjections, JSON_PRETTY_PRINT));

echo "--------------------------------------------------\n";
echo "🏁 CICLO FINALIZADO CON ÉXITO\n";
echo "--------------------------------------------------\n";
echo "📂 En Radar (Tanda): " . count($foundFiles) . " archivos nuevos procesados.\n";
echo "✅ Nuevos / Auditados: " . count($newSuccesses) . " procesados en esta ronda.\n";
echo "📈 Total Histórico:  " . count($finalSuccessList) . " en si_optimizados.json.\n";
echo "❌ Fallos Físicos:   " . count($errorInjections) . "\n";
echo "--------------------------------------------------\n";