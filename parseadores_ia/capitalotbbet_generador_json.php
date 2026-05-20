<?php
/**
 * capitalotbbet_generador_json.php
 * Motor de integración para CapitalOTBbet con gestión de caché de 20s y limpieza automática.
 * PHP 8.3 | Arquitectura de Doble Blindaje (Secuencial)
 */
set_time_limit(0);

// --- CONFIGURACIÓN DE RUTAS ---
$cap_basePath   = __DIR__ . '/';
$cap_botPath    = $cap_basePath . 'bot/';
$cap_nodeScript = $cap_botPath  . 'capitalotbbet_get_json.js';
$cap_outputDir  = dirname($cap_basePath) . '/includes/';

/**
 * Genera un nombre de archivo único (Slug) basado en la URL de la carrera
 */
if (!function_exists('cap_generateSlug')) {
    function cap_generateSlug(string $url): string {
        // Ejemplo: .../results/2026-05-12/SCD/Harness/5 -> cap_res_2026-05-12_SCD_Harness_5.json
        $parts = explode('/', trim($url, '/'));
        $relevant = array_slice($parts, -4); 
        return 'cap_res_' . implode('_', $relevant) . '.json';
    }
}

/**
 * Limpia archivos temporales de CapitalOTB con más de 10 minutos de antigüedad
 */
if (!function_exists('cap_garbageCollector')) {
    function cap_garbageCollector(string $dir): void {
        $files = glob($dir . 'cap_res_*.json'); // Filtro por prefijo estricto
        $now = time();
        foreach ($files as $file) {
            if (is_file($file) && ($now - filemtime($file)) > 600) { // 10 minutos = 600s
                unlink($file);
            }
        }
    }
}

/**
 * Función principal: Obtiene el JSON (Caché de 20s o Puppeteer Secuencial)
 */
if (!function_exists('getCapitalResultsJson')) {
    function getCapitalResultsJson(string $url, string $nodeScript, string $outputDir): ?string {
        $fileName = cap_generateSlug($url);
        $fullOutputPath = $outputDir . $fileName;

        // 1. BLINDAJE PROACTIVO: Verificar caché de 20 segundos
        if (file_exists($fullOutputPath) && (time() - filemtime($fullOutputPath)) < 20) {
            return file_get_contents($fullOutputPath);
        }

        // 2. EJECUCIÓN SECUENCIAL: Llamada síncrona al bot de Node.js
        // shell_exec bloquea la ejecución de PHP hasta que Node termine, protegiendo el CPU
        // Inyectamos HOME=/home/parsea1 para que Chromium pueda inicializar su perfil en Linux
        $command = "HOME=/home/parsea1 /usr/bin/node " . escapeshellarg($nodeScript) . " " . escapeshellarg($url) . " " . escapeshellarg($fullOutputPath) . " 2>&1";
        $output = shell_exec($command);

        if (file_exists($fullOutputPath)) {
            return file_get_contents($fullOutputPath);
        }

        // Si falló, imprimimos la salida para diagnóstico en el log de errores de PHP
        if ($output) {
            error_log("FALLO_EXTRACCION_CAPITAL: " . $output);
        }

        return null;
    }
}

// --- LÓGICA DE PROCESAMIENTO (Si se invoca directamente o mediante el flujo legacy) ---

// Ejecutar limpieza selectiva en cada ciclo
cap_garbageCollector($cap_outputDir);