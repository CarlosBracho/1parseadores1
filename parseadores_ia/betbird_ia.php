<?php
/**
 * betbird_ia.php
 * Integración Final: Extracción de Carreras + Motor de Doble Blindaje (Proactivo/Reactivo)
 * PHP 8.3 | Senior Architect Implementation
 */

// --- CONFIGURACIÓN DE CABECERAS ---
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization2");
header('Content-Type: text/html; charset=utf-8');

// --- RUTAS Y PERSISTENCIA ---
$basePath  = __DIR__ . '/';
$botPath   = $basePath . 'bot/';
$tokenFile = $botPath . 'betbird_token.json';
$nodeScript = $botPath . 'betbird_get_token.js';
$urlData   = "https://www.betbird.com/data/race/nextbetchances/42";

/**
 * Decodifica el Payload de un JWT para verificar expiración (Proactivo)
 */
function isTokenValid(string $token): bool {
    $parts = explode('.', $token);
    if (count($parts) !== 3) return false;

    $payload = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $parts[1])), true);
    $expiration = $payload['exp'] ?? 0;

    // Umbral de seguridad de 5 minutos
    return (time() < ($expiration - 300));
}

/**
 * Ejecuta el bot de Node.js para obtener un nuevo token
 */
function fetchNewToken(string $scriptPath): ?string {
    $command = "node " . escapeshellarg($scriptPath) . " 2>&1";
    $result = trim(shell_exec($command));

    if (str_starts_with($result, 'eyJ')) {
        return $result;
    }
    return null;
}

/**
 * Gestiona la carga y actualización del token en el archivo JSON
 */
function getOrRefreshToken(string $tokenFile, string $nodeScript): string {
    $cache = file_exists($tokenFile) ? json_decode(file_get_contents($tokenFile), true) : [];
    $token = $cache['token'] ?? '';

    if (empty($token) || !isTokenValid($token)) {
        $newToken = fetchNewToken($nodeScript);
        if ($newToken) {
            file_put_contents($tokenFile, json_encode([
                'token' => $newToken, 
                'updated_at' => time()
            ]));
            return $newToken;
        }
    }
    return $token;
}

/**
 * Realiza la petición a la API con lógica reactiva
 */
function makeApiRequest(string $url, string $tokenFile, string $nodeScript, bool $retry = true): array {
    $token = getOrRefreshToken($tokenFile, $nodeScript);

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT        => 20,
        CURLOPT_HTTPHEADER     => [
            "Authorization2: Bearer $token",
            "Accept: application/json, text/plain, */*",
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36"
        ]
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $data = json_decode($response, true);

    // Lógica Reactiva ante fallo de autenticación
    if (($httpCode === 401 || $httpCode === 403 || (isset($data['success']) && !$data['success'])) && $retry) {
        $newToken = fetchNewToken($nodeScript);
        if ($newToken) {
            file_put_contents($tokenFile, json_encode([
                'token' => $newToken, 
                'updated_at' => time()
            ]));
            return makeApiRequest($url, $tokenFile, $nodeScript, false);
        }
    }

    return [
        'code' => $httpCode,
        'data' => $data,
        'raw'  => $response
    ];
}

// --- EJECUCIÓN Y RENDERIZADO ---

$resultado = makeApiRequest($urlData, $tokenFile, $nodeScript);
$json = $resultado['data'];

if (isset($json['success']) && $json['success']) {
    echo "<h2>Carreras Automáticas (Motor Robusto)</h2>";
    echo "<table border='1' style='width:100%; border-collapse:collapse; font-family:sans-serif;'>";
    echo "<tr style='background:#2c3e50; color:white;'>";
    echo "<th style='padding:10px;'>ID</th>";
    echo "<th style='padding:10px;'>Hipódromo</th>";
    echo "<th style='padding:10px;'>#</th>";
    echo "<th style='padding:10px;'>Hora UTC</th>";
    echo "</tr>";

    foreach ($json['data']['races'] as $r) {
        echo "<tr>";
        echo "<td style='padding:8px; text-align:center;'>{$r['id']}</td>";
        echo "<td style='padding:8px;'>{$r['track_name']}</td>";
        echo "<td style='padding:8px;'>{$r['number']}</td>";
        echo "<td style='padding:8px; text-align:center;'>{$r['schedule_time_utc']}</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<div style='color:red; padding:20px; border:2px solid red; font-family:sans-serif;'>";
    echo "<b>Error Crítico:</b> No se pudo sincronizar la data.<br>";
    echo "Código HTTP: " . $resultado['code'] . "<br>";
    echo "Respuesta del Servidor: " . htmlspecialchars($resultado['raw'] ?? 'Sin respuesta');
    echo "</div>";
}
