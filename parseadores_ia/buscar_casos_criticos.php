<?php
/**
 * Script: buscar_casos_criticos.php
 * Objetivo: Localizar registros históricos con empates, llaves, pools vacíos y consolaciones
 * Entorno: PHP 8.3 / MariaDB 10 / Linux
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Carga de la conexión oficial del sistema
require_once('../Connections/conexionbanca.php');

echo "<h1>Buscador Avanzado de Escenarios Críticos para Dividendos</h1>";
echo "<p>Utilice estos datos para extraer los archivos JSON reales de los logs de WatchandWager.</p>";
echo "<hr>";

/**
 * Función auxiliar para renderizar los resultados en una tabla limpia
 */
function imprimirResultados($titulo, $resultado) {
    echo "<h3>$titulo</h3>";
    if (mysqli_num_rows($resultado) == 0) {
        echo "<p style='color: red;'>No se encontraron registros para este caso.</p>";
        return;
    }
    
    echo "<table border='1' cellpadding='5' style='border-collapse: collapse; font-family: monospace; width: 100%;'>";
    echo "<tr style='background-color: #eaeaea;'>
            <th width='20%'>Hipódromo</th>
            <th width='15%'>Fecha Carrera</th>
            <th width='10%'>N° Carrera</th>
            <th width='55%'>Detalle Identificado</th>
          </tr>";
          
    while ($row = mysqli_fetch_assoc($resultado)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['nom_hipodromo']) . "</td>";
        echo "<td>" . htmlspecialchars($row['fec_carrera']) . "</td>";
        echo "<td>" . htmlspecialchars($row['num_carrera']) . "</td>";
        echo "<td>" . htmlspecialchars($row['detalle'] ?? 'N/A') . "</td>";
        echo "</tr>";
    }
    echo "</table><br>";
}

// =========================================================================
// CASE 1: Empate en el Primer Lugar (Dead Heat to Win)
// =========================================================================
$sql_empate_1 = "SELECT nom_hipodromo, fec_carrera, num_carrera, 
                 CONCAT('Ganadores: ', eje_primero, ' y ', eje_doble_primero, ' | Div: ', div_primero_gan, ' / ', div_doble_primero_gan) as detalle
                 FROM carrera 
                 WHERE eje_doble_primero >= 1 AND eje_doble_primero IS NOT NULL 
                 ORDER BY fec_carrera DESC LIMIT 5";
$res_empate_1 = mysqli_query($conexionbanca, $sql_empate_1) or die(mysqli_error($conexionbanca));
imprimirResultados("1. Empates en el PRIMER LUGAR encontrados", $res_empate_1);

// =========================================================================
// CASE 2: Empate en el Segundo Lugar (Dead Heat to Place)
// =========================================================================
$sql_empate_2 = "SELECT nom_hipodromo, fec_carrera, num_carrera, 
                 CONCAT('Segundos: ', eje_segundo, ' y ', eje_doble_segundo) as detalle
                 FROM carrera 
                 WHERE eje_doble_segundo >= 1 AND eje_doble_segundo IS NOT NULL 
                 ORDER BY fec_carrera DESC LIMIT 5";
$res_empate_2 = mysqli_query($conexionbanca, $sql_empate_2) or die(mysqli_error($conexionbanca));
imprimirResultados("2. Empates en el SEGUNDO LUGAR encontrados", $res_empate_2);

// =========================================================================
// CASE 3: Empate en el Tercer Lugar (Dead Heat to Show)
// =========================================================================
$sql_empate_3 = "SELECT nom_hipodromo, fec_carrera, num_carrera, 
                 CONCAT('Terceros: ', eje_tercero, ' y ', eje_doble_tercero) as detalle
                 FROM carrera 
                 WHERE eje_doble_tercero >= 1 AND eje_doble_tercero IS NOT NULL 
                 ORDER BY fec_carrera DESC LIMIT 5";
$res_empate_3 = mysqli_query($conexionbanca, $sql_empate_3) or die(mysqli_error($conexionbanca));
imprimirResultados("3. Empates en el TERCER LUGAR encontrados", $res_empate_3);

// =========================================================================
// CASE 4: Ejemplares Acoplados (Llaves con letras tipo 1A, 1B en el orden oficial)
// =========================================================================
$sql_acoplados = "SELECT nom_hipodromo, fec_carrera, num_carrera, 
                  CONCAT('Orden Exacta: ', ord_exacta, ' | Trifecta: ', ord_trifecta) as detalle
                  FROM carrera 
                  WHERE ord_exacta REGEXP '[A-Za-z]' 
                     OR ord_trifecta REGEXP '[A-Za-z]' 
                     OR ord_superfecta REGEXP '[A-Za-z]'
                  ORDER BY fec_carrera DESC LIMIT 5";
$res_acoplados = mysqli_query($conexionbanca, $sql_acoplados) or die(mysqli_error($conexionbanca));
imprimirResultados("4. Carreras con Ejemplares ACOPLADOS (Letras en secuencias exóticas)", $res_acoplados);

// =========================================================================
// CASE 5: Carreras Canceladas o Anuladas con Resultados en Cero
// =========================================================================
$sql_anuladas = "SELECT nom_hipodromo, fec_carrera, num_carrera, 
                 'Carrera culminada sin ganadores registrados (Posible Anulación)' as detalle
                 FROM carrera 
                 WHERE est_carrera = 0 
                   AND est_confirmacion = 1 
                   AND (eje_primero = 0 OR eje_primero IS NULL)
                 ORDER BY fec_carrera DESC LIMIT 5";
$res_anuladas = mysqli_query($conexionbanca, $sql_anuladas) or die(mysqli_error($conexionbanca));
imprimirResultados("5. Posibles Carreras ANULADAS o CANCELADAS históricas", $res_anuladas);

// =========================================================================
// CASE 6: Triple Empate Categórico (Triple Dead Heat)
// =========================================================================
$sql_triple_empate = "SELECT nom_hipodromo, fec_carrera, num_carrera, 
                      CONCAT('Triple Empate Detectado. Primeros: ', eje_triple_primero, ' | Segundos: ', eje_triple_segundo, ' | Terceros: ', eje_triple_tercero) as detalle
                      FROM carrera 
                      WHERE (eje_triple_primero >= 1 AND eje_triple_primero IS NOT NULL)
                         OR (eje_triple_segundo >= 1 AND eje_triple_segundo IS NOT NULL)
                         OR (eje_triple_tercero >= 1 AND eje_triple_tercero IS NOT NULL)
                      ORDER BY fec_carrera DESC LIMIT 5";
$res_triple_empate = mysqli_query($conexionbanca, $sql_triple_empate) or die(mysqli_error($conexionbanca));
imprimirResultados("6. TRIPLES EMPATES registrados en el sistema", $res_triple_empate);

// =========================================================================
// CASE 7: Pool Vacío o Exótica Sin Ganadores (Carryover)
// =========================================================================
$sql_pool_vacio = "SELECT nom_hipodromo, fec_carrera, num_carrera, 
                   CONCAT('Orden Superfecta: ', ord_superfecta, ' con Dividendo en $0.00 (Nadie acertó)') as detalle
                   FROM carrera 
                   WHERE (ord_superfecta IS NOT NULL AND ord_superfecta != '0/0/0/0' AND ord_superfecta != '') 
                     AND div_superfecta = 0 
                     AND eje_primero >= 1
                   ORDER BY fec_carrera DESC LIMIT 5";
$res_pool_vacio = mysqli_query($conexionbanca, $sql_pool_vacio) or die(mysqli_error($conexionbanca));
imprimirResultados("7. Jugadas Exóticas con POOL VACÍO (Dividendo $0 de consolación/reembolso)", $res_pool_vacio);

// =========================================================================
// CASE 8: Dividendos de Consolación (Consolation Payouts)
// =========================================================================
$sql_consolacion = "SELECT nom_hipodromo, fec_carrera, num_carrera, 
                    CONCAT('Exacta Doble: ', div_exacta_doble, ' | Trifecta Doble: ', div_trifecta_doble) as detalle
                    FROM carrera 
                    WHERE div_exacta_doble > 0 
                       OR div_trifecta_doble > 0 
                    ORDER BY fec_carrera DESC LIMIT 5";
$res_consolacion = mysqli_query($conexionbanca, $sql_consolacion) or die(mysqli_error($conexionbanca));
imprimirResultados("8. Carreras con DIVIDENDOS DE CONSOLACIÓN secundarios activos", $res_consolacion);

// =========================================================================
// CASE 9: Descalificaciones e Inversión de Orden (Flags de Auditoría)
// =========================================================================
$sql_auditoria = "SELECT nom_hipodromo, fec_carrera, num_carrera, 
                  CONCAT('Estado Verificación (confirmandox): ', confirmandox, ' | Hora Confirmación: ', hconfir) as detalle
                  FROM carrera 
                  WHERE confirmandox = 5 
                  ORDER BY fec_carrera DESC LIMIT 5";
$res_auditoria = mysqli_query($conexionbanca, $sql_auditoria) or die(mysqli_error($conexionbanca));
imprimirResultados("9. Carreras auditadas por DESCALIFICACIÓN o Cambios Oficiales", $res_auditoria);

echo "<hr><p>Ejecución finalizada correctamente.</p>";
?>