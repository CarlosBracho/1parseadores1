<?php
// Orquestador PHP para capturar y parsear webSockets de apuestas INH en tiempo real.
// Diseñado para ejecución en entorno CLI AlmaLinux.

set_time_limit(0);
ob_implicit_flush(true);
while (ob_get_level() > 0) {
    ob_end_flush();
}

$bot_path = __DIR__ . '/bot/inh_bot.js';

// Comando para invocar el motor Chromium a través de Node.js
$cmd = 'node ' . escapeshellarg($bot_path) . ' 2>&1';

echo "=== INICIANDO CAPTURA WEBSOCKET INH (PID: " . getmypid() . ") ===\n";

/**
 * Despacha una alerta de cambio de estado a Telegram vía cURL.
 * Sin el uso de la función obsoleta utf8_encode().
 */
function despacharAlertaTelegram($text) {
    $post = [
        'chat_id' => -1003755064511,
        'text' => $text,
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot309341364:AAETe6H8z5HXbqdv5XhpTEY-nsfBKtYQ0mE/sendMessage");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // ❌ APAGAR LA VERIFICACIÓN SSL (PARA VPS Y LARAGON)
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    
    $res = curl_exec($ch);
    if ($res === false) {
        echo "[TELEGRAM ERROR]: " . curl_error($ch) . "\n";
    } else {
        echo "[TELEGRAM ALERT]: $text\n";
    }
    curl_close($ch);
}

$estadoCarreras = [];
$inicializacionNotificada = false;

// Lazo Supervisor Infinito
while (true) {
    echo "[SUPERVISOR]: Iniciando proceso hijo de Node.js...\n";
    $handle = popen($cmd, 'r');
    if ($handle === false) {
        echo "[SUPERVISOR ERROR]: No se pudo ejecutar el bot de Node.js. Reintentando en 5 segundos...\n";
        sleep(5);
        continue;
    }

    // Configurar canal de comunicación como no bloqueante
    stream_set_blocking($handle, false);

    $lastDataTimestamp = time();

    while (!feof($handle)) {
        // Control por Umbral de Inactividad (Timeout de Red de 120 segundos)
        if ((time() - $lastDataTimestamp) > 120) {
            echo "[SUPERVISOR WARNING]: Umbral de inactividad de 120 segundos superado. Forzando reinicio del bot...\n";
            break;
        }

        $buffer = fgets($handle);
        if ($buffer !== false) {
            $line = trim($buffer);
            if (empty($line)) {
                usleep(50000);
                continue;
            }

            // Desacoplamiento de String de Entrada
            if (strpos($line, '|') !== false) {
                $parts = explode('|', $line, 2);
                $trackName = trim($parts[0]);
                $racesBlock = trim($parts[1]);

                // Control de Inicialización Única de Red
                if (!$inicializacionNotificada) {
                    $inicializacionNotificada = true;
                    despacharAlertaTelegram("nacionales automaticas activadas");
                }

                $racesList = explode('...', $racesBlock);
                foreach ($racesList as $raceItem) {
                    $raceItem = trim($raceItem);
                    if (empty($raceItem)) continue;

                    $fields = explode(',', $raceItem);
                    if (count($fields) === 7 && $fields[0] === 'r') {
                        $raceNumber = intval($fields[1]);
                        $statusId = intval($fields[2]);
                        $maxProgramNumber = intval($fields[3]);
                        $retiradosString = isset($fields[4]) ? trim($fields[4]) : '0';
                        $ganadorString = isset($fields[5]) ? trim($fields[5]) : '0';
                        $dividendoString = isset($fields[6]) ? trim($fields[6]) : '0';

                        // Lógica de Intercepción Diferencial Multidimensional
                        if (isset($estadoCarreras[$trackName][$raceNumber])) {
                            $viejo = $estadoCarreras[$trackName][$raceNumber];

                            // A. Evento Cambio de Estatus
                            if ($statusId !== $viejo['status']) {
                                $statusTexto = ($statusId === 1) ? 'abierta' : (($statusId === 2) ? 'cerrada' : 'estatus ' . $statusId);
                                despacharAlertaTelegram("$trackName carrera $raceNumber ya está $statusTexto");
                            }

                            // B. Evento Caballo Retirado
                            if ($retiradosString !== $viejo['retirados'] && $retiradosString !== '0') {
                                despacharAlertaTelegram("$trackName carrera $raceNumber retirado: $retiradosString");
                            }

                            // C. Evento Ganador
                            if ($viejo['ganador'] === '0' && $ganadorString !== '0') {
                                despacharAlertaTelegram("$trackName carrera $raceNumber ganador: $ganadorString");
                            }

                            // D. Evento Dividendo
                            if ($viejo['dividendo'] === '0' && $dividendoString !== '0') {
                                despacharAlertaTelegram("$trackName carrera $raceNumber dividendo: $dividendoString");
                            }
                        }

                        // Sincroniza la matriz local multidimensional
                        $estadoCarreras[$trackName][$raceNumber] = [
                            'status' => $statusId,
                            'retirados' => $retiradosString,
                            'ganador' => $ganadorString,
                            'dividendo' => $dividendoString
                        ];
                    }
                }

                // Sincronización del tiempo tras recepción exitosa de datos
                $lastDataTimestamp = time();

                echo "[" . date('g:i s') . "s] $trackName -> $racesBlock\n";
            } else {
                echo "[NODE LOG]: " . $line . "\n";
            }
        } else {
            // Estabilizador de CPU ante buffer vacío en modo no bloqueante
            usleep(50000);
        }
    }

    echo "[SUPERVISOR]: Cerrando canal de comunicación del proceso hijo...\n";
    pclose($handle);

    echo "[SUPERVISOR]: Esperando 5 segundos para liberar descriptores de archivos de perfil (SingletonLock)...\n";
    sleep(5);
}
