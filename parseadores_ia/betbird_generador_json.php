<?php
/**
 * betbird_generador_json.php
 * Generador modular y silencioso de datos JSON para Betbird.
 * Diseñado para ser incluido vía include() o require().
 * PHP 8.3 | Arquitectura de Doble Blindaje
 */

// --- CONFIGURACIÓN DE RUTAS ABSOLUTAS ---
// Usamos __DIR__ para que las rutas sean relativas a este archivo, 
// sin importar desde dónde se incluya.
$config_basePath   = __DIR__ . '/';
$config_botPath    = $config_basePath . 'bot/';
$config_tokenFile  = $config_botPath . 'betbird_token.json';
$config_nodeScript = $config_botPath . 'betbird_get_token.js';
$config_outputJson = dirname($config_basePath) . '/includes/betbird.json';
$config_urlData    = "https://www.betbird.com/data/race/nextbetchances/42";

// --- MOTOR DE AUTENTICACIÓN Y EXTRACCIÓN ---

if (!function_exists('bb_isTokenValid')) {
    function bb_isTokenValid(string $token): bool {
        $parts = explode('.', $token);
        if (count($parts) !== 3) return false;
        $payload = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $parts[1])), true);
        $expiration = $payload['exp'] ?? 0;
        return (time() < ($expiration - 300));
    }
}

if (!function_exists('bb_fetchNewToken')) {
    function bb_fetchNewToken(string $scriptPath): ?string {
        $command = "node " . escapeshellarg($scriptPath) . " 2>&1";
        $result = trim(shell_exec($command));
        return (str_starts_with($result, 'eyJ')) ? $result : null;
    }
}

if (!function_exists('bb_getOrRefreshToken')) {
    function bb_getOrRefreshToken(string $tokenFile, string $nodeScript): string {
        $cache = file_exists($tokenFile) ? json_decode(file_get_contents($tokenFile), true) : [];
        $token = $cache['token'] ?? '';

        if (empty($token) || !bb_isTokenValid($token)) {
            $newToken = bb_fetchNewToken($nodeScript);
            if ($newToken) {
                file_put_contents($tokenFile, json_encode(['token' => $newToken, 'updated_at' => time()]));
                return $newToken;
            }
        }
        return $token;
    }
}

if (!function_exists('bb_generateJsonFile')) {
    function bb_generateJsonFile(string $url, string $tokenFile, string $nodeScript, string $outputFile, bool $retry = true): bool {
        $token = bb_getOrRefreshToken($tokenFile, $nodeScript);

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

        // Lógica Reactiva
        if (($httpCode === 401 || $httpCode === 403 || (isset($data['success']) && !$data['success'])) && $retry) {
            $newToken = bb_fetchNewToken($nodeScript);
            if ($newToken) {
                file_put_contents($tokenFile, json_encode(['token' => $newToken, 'updated_at' => time()]));
                return bb_generateJsonFile($url, $tokenFile, $nodeScript, $outputFile, false);
            }
        }

        // Si la data es válida, guardamos el JSON en la ubicación de destino
        if ($httpCode === 200 && isset($data['success']) && $data['success']) {
            return (file_put_contents($outputFile, $response) !== false);
        }

        return false;
    }
}

// --- EJECUCIÓN SILENCIOSA ---
bb_generateJsonFile($config_urlData, $config_tokenFile, $config_nodeScript, $config_outputJson);