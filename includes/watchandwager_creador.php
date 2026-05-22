<?php
/**
 * Script: watchandwager_creador.php
 * Automatización de programación de carreras basándose en Twinspire
 * Entorno: PHP 8.3 / MariaDB 10 / Linux
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once('../Connections/conexionbanca.php');

// Configuración de contexto para peticiones HTTP
$opts = [
    "http" => [
        "method" => "GET",
        "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36\r\n"
    ]
];
$context = stream_context_create($opts);

$hoy = fechaactualbd();
$hora_actual = horaactual();

// 1. GESTIÓN DE CONTROL Y ALERTA (ID 41)
$query_alerta = "/*  watchandwager_creador.php */ SELECT * FROM alertas WHERE Idalertas = 41";
$res_alerta = mysqli_query($conexionbanca, $query_alerta) or die(mysqli_error($conexionbanca));
$row_alerta = mysqli_fetch_assoc($res_alerta);

if (!function_exists('obtener_ip_servidor')) {
    function obtener_ip_servidor() {
        $ip = '';
        if (isset($_SERVER['SERVER_ADDR']) && !empty($_SERVER['SERVER_ADDR'])) {
            $ip = $_SERVER['SERVER_ADDR'];
        } elseif (isset($_SERVER['LOCAL_ADDR']) && !empty($_SERVER['LOCAL_ADDR'])) {
            $ip = $_SERVER['LOCAL_ADDR'];
        }
        if (empty($ip) || $ip === '127.0.0.1' || $ip === '::1') {
            $host = gethostname();
            if ($host) {
                $ip_host = gethostbyname($host);
                if ($ip_host && $ip_host !== $host) {
                    $ip = $ip_host;
                }
            }
        }
        return $ip ? $ip : '127.0.0.1';
    }
}

if (!function_exists('finalizar_script_alertas')) {
    function finalizar_script_alertas($mensaje) {
        echo $mensaje . "<br>";
        fflush(STDOUT);
        while (ob_get_level() > 0) {
            ob_end_flush();
        }
        echo "\nDONE\n";
        exit(0);
    }
}

if (!$row_alerta) {
    finalizar_script_alertas("Alerta 41 no encontrada.");
}

$ip_servidor = obtener_ip_servidor();
$fecha_hora_actual = date('Y-m-d H:i:s');

// Registrar Llamado (tipo = 0)
$insert_llamado = sprintf(
    "/* Origen: RegistroLlamado / watchandwager_creador.php */ INSERT INTO alertas_registros (id_alerta, tipo, fecha_hora, ip_servidor) VALUES (%s, %s, %s, %s)",
    GetSQLValueString(41, "int"),
    GetSQLValueString(0, "int"),
    GetSQLValueString($fecha_hora_actual, "date"),
    GetSQLValueString($ip_servidor, "text")
);
mysqli_query($conexionbanca, $insert_llamado) or die(mysqli_error($conexionbanca));

// Validar si el código está activo (activo_archivo = 0 significa ACTIVO)
if ($row_alerta['activo_archivo'] != 0) {
    finalizar_script_alertas("Alerta 41 inactiva en la configuración de la base de datos.");
}

$hora_inicio = $row_alerta['horainicio'];
$hora_fin = $row_alerta['horafin'];

// Validar rango horario
if ($hora_actual < $hora_inicio || $hora_actual > $hora_fin) {
    finalizar_script_alertas("Fuera de rango horario para Alerta 41 ($hora_inicio - $hora_fin).");
}

// Validar reposo (mini_para_repetir en segundos en base a ultima_bien)
$mini_para_repetir = '-' . $row_alerta['mini_para_repetir'] . ' second';
$tiemponorepeticion = strtotime($mini_para_repetir, strtotime($hora_actual));
$tiemponorepeticion = date('H:i:s', $tiemponorepeticion);
$tiemponorepeticion = $hoy . ' ' . $tiemponorepeticion;

if ($tiemponorepeticion <= $row_alerta['ultima_bien']) {
    finalizar_script_alertas("No ha transcurrido el tiempo de reposo (" . $row_alerta['mini_para_repetir'] . "s) desde la última ejecución.");
}

// Si pasa todas las validaciones, procede a la ejecución efectiva
echo "Procesando Alerta 41 - Automatización Activa.<br>";

// Descomentar y actualizar la alerta en BD con ultima_bien y contador
$update_alerta = sprintf(
    "/* Origen: ActualizacionAlerta / watchandwager_creador.php */ UPDATE alertas SET contadoralerta = contadoralerta + 1, fec_alerta = %s, hor_alerta = %s, ultima_bien = %s WHERE idalertas = 41",
    GetSQLValueString($hoy, "date"),
    GetSQLValueString($hora_actual, "date"),
    GetSQLValueString($fecha_hora_actual, "date")
);
mysqli_query($conexionbanca, $update_alerta) or die(mysqli_error($conexionbanca));

// Registrar Ejecución Efectiva (tipo = 1)
$insert_ejecucion = sprintf(
    "/* Origen: RegistroEjecucion / watchandwager_creador.php */ INSERT INTO alertas_registros (id_alerta, tipo, fecha_hora, ip_servidor) VALUES (%s, %s, %s, %s)",
    GetSQLValueString(41, "int"),
    GetSQLValueString(1, "int"),
    GetSQLValueString($fecha_hora_actual, "date"),
    GetSQLValueString($ip_servidor, "text")
);
mysqli_query($conexionbanca, $insert_ejecucion) or die(mysqli_error($conexionbanca));

        // 2. FILTRADO DE HIPÓDROMOS HABILITADOS
        $query_hipo = "/* WatchandWager Creador / watchandwager_creador.php */ SELECT cod_hipodromo, nom_hipodromo, nom_hipodromo_hpi FROM hipodromo WHERE mtp_WatchandWager = 1";
        $res_hipo = mysqli_query($conexionbanca, $query_hipo) or die(mysqli_error($conexionbanca));
        
        $hipodromos_habilitados = [];
        while ($row_hipo = mysqli_fetch_assoc($res_hipo)) {
            // Normalización de llave: UPPER + TRIM
            $key = strtoupper(trim($row_hipo['nom_hipodromo_hpi']));
            $hipodromos_habilitados[$key] = $row_hipo;
        }
        echo "Total hipódromos habilitados en BD: " . count($hipodromos_habilitados) . "<br>";

        // 3. CONSUMO DE API PRINCIPAL (CARDS)
        $cardsUrl = 'https://www.watchandwager.com/data/cards';
        $cardsJson = file_get_contents($cardsUrl, false, $context); // Eliminado @ para ver errores
        
        if ($cardsJson) {
            $cardsData = json_decode($cardsJson, true);
            $cardList = $cardsData['card_list'] ?? [];
            
            // Volcado visual de hipódromos en API para depuración
            echo "Hipódromos en API: ";
            foreach ($cardList as $c) { echo "[" . ($c['name'] ?? 'N/A') . "] "; }
            echo "<br><br>";

            foreach ($cardList as $cardId => $card) {
                $apiTrackName = $card['name'] ?? '';
                
                // Normalización para comparación: UPPER + TRIM
                $apiKey = strtoupper(trim($apiTrackName));
                
                if (isset($hipodromos_habilitados[$apiKey])) {
                    $localHipo = $hipodromos_habilitados[$apiKey];
                    echo "Hipódromo detectado: $apiTrackName (ID: $cardId)... ";

                    // Consultar detalle para obtener runners (conteo único) y simulcast
                    $detailUrl = "https://www.watchandwager.com/cards/{$cardId}?results=true";
                    $detailJson = file_get_contents($detailUrl, false, $context); // Eliminado @
                    
                    if ($detailJson) {
                        $detailData = json_decode($detailJson, true);
                        $races = $detailData['racecard']['races'] ?? [];

                        foreach ($races as $raceNum => $raceInfo) {
                            // Algoritmo de Conteo: Valores únicos de program_number (Regex)
                            $runners = $raceInfo['runners'] ?? [];
                            $unique_horses = [];
                            foreach ($runners as $runner) {
                                $prog_num = $runner['program_number'] ?? '';
                                $clean_num = preg_replace('/[^0-9]/', '', $prog_num);
                                if ($clean_num !== '') {
                                    $unique_horses[$clean_num] = true;
                                }
                            }
                            $can_caballos = count($unique_horses);

                            // Detección de Simulcast
                            $raceName = $raceInfo['name'] ?? '';
                            $simulcast = (stripos($raceName, 'Simulcast') !== false) ? 1 : 0;

                            // 4. PERSISTENCIA EN BD (LÓGICA GEMELA)
                            $verif = verificarCarrera($localHipo['nom_hipodromo'], $raceNum, $hoy);
                            if ($verif == 0) {
                                echo "Programando Carrera #$raceNum... ";
                                
                                // CASO A: INSERCIÓN COMENTADA SEGÚN REQUERIMIENTO DE SEGURIDAD VISUAL
                                ///*
                                $insertSQL = sprintf("INSERT INTO carrera 
                                    (cod_banca, cod_hipodromo, nom_hipodromo, nom_hipodromo_hpi, fec_carrera, hor_carrera, hor_mtp, num_carrera, est_carrera, est_cierre, est_confirmacion, mtp_control, can_caballos, simulcast) 
                                    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                                    GetSQLValueString(2, "int"),
                                    GetSQLValueString($localHipo['cod_hipodromo'], "int"),
                                    GetSQLValueString($localHipo['nom_hipodromo'], "text"),
                                    GetSQLValueString($localHipo['nom_hipodromo_hpi'], "text"),
                                    GetSQLValueString($hoy, "date"),
                                    GetSQLValueString("01:00:00", "date"),
                                    GetSQLValueString("01:00:00", "date"),
                                    GetSQLValueString($raceNum, "int"),
                                    GetSQLValueString(1, "int"),
                                    GetSQLValueString(3, "int"),
                                    GetSQLValueString(1, "int"),
                                    GetSQLValueString(3, "int"),
                                    GetSQLValueString($can_caballos, "int"),
                                    GetSQLValueString($simulcast, "int"));
                               mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                                //*/
                            } else {
                                // CASO B: VERIFICACIÓN DE INTEGRIDAD (ACTUALIZACIÓN DE CABALLOS)
                                $query_actual = sprintf("SELECT can_caballos FROM carrera WHERE nom_hipodromo = %s AND num_carrera = %s AND fec_carrera = %s",
                                    GetSQLValueString($localHipo['nom_hipodromo'], "text"),
                                    GetSQLValueString($raceNum, "int"),
                                    GetSQLValueString($hoy, "date"));
                                $res_actual = mysqli_query($conexionbanca, $query_actual) or die(mysqli_error($conexionbanca));
                                $row_actual = mysqli_fetch_assoc($res_actual);

                                if ($row_actual && $row_actual['can_caballos'] != $can_caballos) {
                                    echo "Integridad: Actualizando caballos #$raceNum ({$row_actual['can_caballos']} -> $can_caballos)... ";
                                    // UPDATE COMENTADO SEGÚN REQUERIMIENTO DE SEGURIDAD VISUAL
                                    ///*
                                    $updateSQL = sprintf("UPDATE carrera SET can_caballos = %s WHERE nom_hipodromo = %s AND num_carrera = %s AND fec_carrera = %s",
                                        GetSQLValueString($can_caballos, "int"),
                                        GetSQLValueString($localHipo['nom_hipodromo'], "text"),
                                        GetSQLValueString($raceNum, "int"),
                                        GetSQLValueString($hoy, "date"));
                                   mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                                    //*/
                                }
                            }
                        }
                        echo "OK.<br>";
                    } else {
                        echo "Error al cargar detalle de card $cardId.<br>";
                    }
                }
            }
        } else {
            echo "Error al conectar con la API de WatchandWager.<br>";
        }
?>
