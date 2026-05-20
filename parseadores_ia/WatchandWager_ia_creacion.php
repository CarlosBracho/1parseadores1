<?php
/**
 * Script de visualización de carreras y resultados (Consumo Remoto)
 * Entorno: PHP 8.3 / Linux
 */

// Configuración de contexto para peticiones HTTP
$opts = [
    "http" => [
        "method" => "GET",
        "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36\r\n"
    ]
];
$context = stream_context_create($opts);

// 0. DETECCIÓN DE PETICIÓN ASÍNCRONA (AJAX)
if (isset($_GET['ajax']) && isset($_GET['card_id']) && isset($_GET['race_num'])) {
    $cId = $_GET['card_id'];
    $rNum = $_GET['race_num'];
    $detailUrl = "https://www.watchandwager.com/cards/{$cId}?results=true";
    $detailJson = @file_get_contents($detailUrl, false, $context);
    
    if (!$detailJson) {
        echo "<div style='padding:20px; color:#c0392b;'>Error de conexión con el servidor externo.</div>";
        exit;
    }

    $detailData = json_decode($detailJson, true);
    
    // Búsqueda dinámica de la carrera por atributo de negocio 'number'
    $raceInfo = null;
    $rawRaces = $detailData['racecard']['races'] ?? [];
    foreach ($rawRaces as $key => $race) {
        if ($key == $rNum || ($race['number'] ?? '') == $rNum) {
            $raceInfo = $race;
            break;
        }
    }

    $trackNameAPI = $detailData['racecard']['name'] ?? 'HIPÓDROMO';

    if ($raceInfo) {
        $runners = $raceInfo['runners'] ?? [];
        $status = strtoupper(trim($raceInfo['status'] ?? '')); // Sanitización Atómica
        
        // --- REINGENIERÍA DE EXTRACCIÓN DE POOLS (NODO GLOBAL) ---
        $pools = [];
        $globalPools = $detailData['racecard']['pools'] ?? [];
        foreach ($globalPools as $gp) {
            // Filtro por rango estricto de carrera
            if (($gp['first_race_number'] ?? 0) == $rNum && ($gp['last_race_number'] ?? 0) == $rNum) {
                $gp['type'] = strtoupper($gp['code'] ?? ''); // Homologación code -> type
                $pools[] = $gp;
            }
        }

        // --- 1. LÓGICA DE STATUS ---
        if ($status == 'X' || $status == 'A') {
            echo "<div style='padding:20px; color:white; background:#e74c3c; border-radius:8px; font-weight:bold; text-align:center;'>[CARRERA ANULADA / CANCELADA]</div>";
            exit;
        }

        if ($status == 'O') {
            echo "<div style='padding:20px; color:#2980b9; background:#ebf5fb; border-radius:8px; font-weight:bold; text-align:center;'>[Carrera en progreso - Dividendos no disponibles]</div>";
            exit; // Evita concatenación de mensajes residuales
        }

        // --- 2. PARSEO ITERATIVO DE POOLS Y PAYOUTS (ANIDACIÓN PROFUNDA) ---
        $divs = ['WIN' => [], 'PLC' => [], 'SHW' => []];
        $exotics = [];
        foreach ($pools as $pool) {
            $type = strtoupper($pool['type'] ?? ''); // Normalización a Mayúsculas
            $payoutList = $pool['payouts'] ?? [];   // Iteración obligatoria sobre payouts
            
            foreach ($payoutList as $p) {
                // Limpieza Regex de ejemplares (Solo números)
                $selRaw = $p['selection'] ?? '';
                $sel = preg_replace('/[^0-9]/', '', $selRaw);
                
                if (in_array($type, ['WIN', 'PLC', 'SHW'])) {
                    $divs[$type][$sel] = number_format($p['amount'] ?? 0, 2);
                } elseif (in_array($type, ['EXA', 'TRI', 'SFC'])) {
                    $label = str_replace(['EXA', 'TRI', 'SFC'], ['Ex', 'Tr', 'Su'], $type);
                    // Formateo de exótica: - por / para visualización estándar
                    $selection = str_replace('-', '/', $selRaw);
                    $exotics[] = "$label -> $selection " . number_format($p['amount'] ?? 0, 2);
                }
            }
        }

        // --- 3. PERSISTENCIA (COMENTADA POR PROTOCOLO) ---
        /*
        // Simulación de Caso A/B
        $verif = verificarCarrera($trackNameAPI, $rNum, $hoy);
        if ($verif == 0) {
            // INSERT INTO carrera ...
        } else {
            // UPDATE carrera SET can_caballos = ...
        }
        */

        // Fallback: Detección de resultados por posición oficial en competidores
        $hasResults = false;
        foreach ($runners as $r) {
            if (($r['finish_position'] ?? 0) >= 1) {
                $hasResults = true;
                break;
            }
        }

        // --- 4. RENDERIZADO VISUAL OFICIAL (TRIGGER: STATUS == "C" o POSICIONES DETECTADAS) ---
        if ($status == 'C' || !empty($pools) || $hasResults) {
            // Agrupación de llegada (1ro a 4to)
            $llegada = array_fill(1, 4, ['horse' => '0', 'win' => '', 'place' => '', 'show' => '']);
            foreach ($runners as $r) {
                $fPos = $r['finish_position'] ?? 0;
                if ($fPos >= 1 && $fPos <= 4) {
                    $pNum = preg_replace('/[^0-9]/', '', $r['program_number'] ?? '');
                    $llegada[$fPos]['horse'] = $pNum;
                    $llegada[$fPos]['win'] = $divs['WIN'][$pNum] ?? '';
                    $llegada[$fPos]['place'] = $divs['PLC'][$pNum] ?? '';
                    $llegada[$fPos]['show'] = $divs['SHW'][$pNum] ?? '';
                }
            }

            // Datos de Pie (Retirados y Conteo)
            $scratched = [];
            $activeCount = 0;
            foreach ($runners as $r) {
                if ($r['scratched'] ?? false) {
                    $scratched[] = $r['program_number'];
                } else {
                    $activeCount++;
                }
            }
            $retiradosStr = empty($scratched) ? "NINGUNO" : implode(", ", $scratched);
            $conteoStr = "$activeCount/" . count($runners);

            // MAQUETACIÓN VISUAL (ESTILO image_dccfd6.png)
            echo "<div style='width:100%; font-family: Arial, sans-serif; border: 1px solid #ccc;'>";
            
            // Cabecera Azul
            echo "<div style='display: flex; background: #5dade2; color: white; padding: 5px 10px; font-weight: bold; font-size: 14px; text-transform: uppercase;'>
                    <div style='flex: 2; text-align: center;'>HIPÓDROMO</div>
                    <div style='flex: 1; text-align: center;'># CARRERA</div>
                    <div style='flex: 0.8; text-align: center;'>LLEGADA</div>
                    <div style='flex: 1; text-align: center;'>GANADOR</div>
                    <div style='flex: 1; text-align: center;'>PLACE</div>
                    <div style='flex: 1; text-align: center;'>SHOW</div>
                  </div>";

            // Cuerpo Gris
            echo "<div style='display: flex; background: #d5d8dc; align-items: stretch;'>
                    <div style='flex: 2; display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: bold; border-right: 1px solid #aaa; padding: 10px; text-transform: uppercase; color: #1a1a1a;'>
                        $trackNameAPI
                    </div>
                    <div style='flex: 1; display: flex; align-items: center; justify-content: center; font-size: 40px; font-weight: bold; border-right: 1px solid #aaa; color: #1a1a1a;'>
                        $rNum
                    </div>
                    <div style='flex: 3.8; background: white;'>
                        <table style='width: 100%; border-collapse: collapse; font-size: 13px;'>";
                        $posLabels = [1 => '1ro', 2 => '2do', 3 => '3ro', 4 => '4to'];
                        for ($i = 1; $i <= 4; $i++) {
                            $boldStyle = ($i == 1) ? "font-weight:bold;" : "";
                            echo "<tr style='border-bottom: 1px solid #eee;'>
                                    <td style='width: 21%; padding: 4px 10px; font-weight: bold; text-align: left; background: white;'>{$posLabels[$i]}</td>
                                    <td style='width: 21%; padding: 4px; text-align: center; background: white;'>{$llegada[$i]['horse']}</td>
                                    <td style='width: 20%; padding: 4px; text-align: center; background: white; $boldStyle'>{$llegada[$i]['win']}</td>
                                    <td style='width: 20%; padding: 4px; text-align: center; background: white;'>{$llegada[$i]['place']}</td>
                                    <td style='width: 18%; padding: 4px; text-align: center; background: white;'>{$llegada[$i]['show']}</td>
                                  </tr>";
                        }
            echo "      </table>
                    </div>
                  </div>";

            // Pie de Exóticas y Auditoría
            echo "<div style='display: flex; background: #cacfd2; padding: 4px 10px; font-size: 12px; font-weight: bold;'>
                    <div style='flex: 1.5; text-transform: uppercase;'>
                        EXÓTICAS: " . (empty($exotics) ? "N/A" : implode(" | ", $exotics)) . " |
                    </div>
                    <div style='flex: 1; text-align: right; text-transform: uppercase;'>
                        RETIRADOS: $retiradosStr &nbsp;&nbsp; CORRIERON : $conteoStr
                    </div>
                  </div>";

            echo "</div>"; // Fin contenedor
        } else {
            // Instrumentación de diagnóstico en caliente
            echo "<div style='padding:20px; color:#7f8c8d; text-align:center;'>
                    Esperando confirmación oficial de resultados... <br>
                    <small style='color:#e74c3c;'>[Detección Real -> Status: '".$status."' | Pools: ".count($pools)." | Runners: ".count($runners)."]</small>
                  </div>";
        }
    } else {
        echo "<div style='padding:20px; color:#7f8c8d;'>No se encontraron datos disponibles para esta carrera.</div>";
    }
    exit;
}

// Estilos Premium para la Lista Principal
echo "<style>
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; color: #333; padding: 20px; }
    .race-item { cursor: pointer; color: #2980b9; transition: color 0.3s; padding: 5px 0; display: inline-block; }
    .race-item:hover { color: #1a5276; text-decoration: underline; }
    
    /* Estilos del Modal */
    .modal-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.7); display: none; justify-content: center; align-items: center;
        z-index: 1000; backdrop-filter: blur(5px);
    }
    .modal-container {
        background: white; width: 95%; max-width: 850px; padding: 20px;
        border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        position: relative; animation: slideDown 0.3s ease-out;
        max-height: 90vh; overflow-y: auto;
    }
    @keyframes slideDown {
        from { transform: translateY(-30px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .close-btn {
        position: absolute; top: 10px; right: 15px; font-size: 24px;
        cursor: pointer; color: #7f8c8d; transition: color 0.2s; z-index: 10;
    }
    .close-btn:hover { color: #333; }
    .loading-spinner { text-align: center; padding: 40px; font-style: italic; color: #7f8c8d; }
</style>";

// 1. CARGA DESDE EL LINK PRINCIPAL
$cardsUrl = 'https://www.watchandwager.com/data/cards';
$cardsJson = file_get_contents($cardsUrl, false, $context);
$cardsData = json_decode($cardsJson, true);
$cardList = $cardsData['card_list'] ?? [];

echo "<h1>Listado de Hipódromos y Carreras (En Vivo)</h1>";

foreach ($cardList as $cardId => $card) {
    $trackName = $card['name'] ?? 'Unknown';
    $races = $card['races'] ?? [];
    
    echo "<h3>Hipódromo: $trackName (ID: $cardId)</h3>";
    echo "<ul>";
    foreach ($races as $raceId => $race) {
        $raceNum = $race['number'];
        echo "<li>
                <span class='race-item' data-card-id='$cardId' data-race-num='$raceNum'>
                    Carrera #$raceNum (ID: $raceId)
                </span>
              </li>";
    }
    echo "</ul>";
}

// --- ESTRUCTURA DEL MODAL ---
echo '
<div id="resultsModal" class="modal-overlay">
    <div class="modal-container">
        <span class="close-btn" id="closeModal">&times;</span>
        <div id="modalBody">
            <!-- Contenido dinámico -->
        </div>
    </div>
</div>';

// --- LÓGICA JAVASCRIPT ---
echo "
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('resultsModal');
    const modalBody = document.getElementById('modalBody');
    const closeBtn = document.getElementById('closeModal');
    const raceItems = document.querySelectorAll('.race-item');

    raceItems.forEach(item => {
        item.addEventListener('click', function() {
            const cardId = this.getAttribute('data-card-id');
            const raceNum = this.getAttribute('data-race-num');
            
            modal.style.display = 'flex';
            modalBody.innerHTML = '<div class=\"loading-spinner\">Cargando resultados oficiales...</div>';

            fetch('?ajax=1&card_id=' + cardId + '&race_num=' + raceNum)
                .then(response => response.text())
                .then(data => {
                    modalBody.innerHTML = data;
                })
                .catch(error => {
                    modalBody.innerHTML = '<div style=\"color:red; padding:20px;\">Error al recuperar resultados.</div>';
                    console.error('Error:', error);
                });
        });
    });

    closeBtn.onclick = () => modal.style.display = 'none';
    window.onclick = (event) => {
        if (event.target == modal) modal.style.display = 'none';
    };
});
</script>";
?>