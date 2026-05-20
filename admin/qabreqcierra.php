<?php
require_once('../Connections/conexionbanca.php');
$tiempoapasar=0;
$CONTROLPRIMERTIEMPO=0;
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 admin\qabreqcierra.php - QUERY 1 */ SELECT * FROM
        quiencierrayabre qu
        WHERE
        qu.codcarrera = %s 
        ORDER BY qu.tiempo",
    GetSQLValueString($_POST['cod_carrera'], "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
echo $totalRows_Recordset1;
echo '<center>';
echo ObtenerNombreynumeroJugadaCarrera($_POST['cod_carrera']);
echo '<table border=2>';
echo '<tr>';
echo '<td> &nbsp; &nbsp; &nbsp;MODULO</td>';
echo '<td> &nbsp; &nbsp; &nbsp;HAN PASADO</td>';
echo '<td> &nbsp; &nbsp; &nbsp;ENTRE ACCI</td>';
echo '<td> &nbsp; &nbsp; &nbsp;FECHA Y HORA</td>';
echo '</tr>';
do {
    if($CONTROLPRIMERTIEMPO==0){$CONTROLPRIMERTIEMPO=substr($row_Recordset1['tiempo'], -8);}
    echo '<tr><td>';
    $n=$row_Recordset1['que'];
    if($n==1){echo 'CER WATC '; }
    if($n==2){echo 'CER TWIN '; }
    if($n==3){echo 'CER BETB '; }
    if($n==4){echo 'CER CAPI '; }
    if($n==5){echo 'CER TVG '; }
    if($n==6){echo 'CER BUIL '; }
    if($n==7){echo 'CER RACE '; }
    if($n==10){echo 'ABI WATC '; }
    if($n==11){echo 'ABI TWIN '; }
    if($n==12){echo 'ABI BETB '; }
    if($n==13){echo 'ABI CAPI '; }
    if($n==14){echo 'ABI TVG '; }
    if($n==15){echo 'ABI AMER '; }
    if($n==16){echo 'ABI BUIL '; }
    if($n==17){echo 'ABI AMERD '; }
    if($n==20){echo 'C1 TWIN '; }
    if($n==21){echo 'C1 TRACK '; }
    if($n==22){echo 'C1 BUILD '; }
    if($n==23){echo 'C1 CAPIT '; }
    if($n==25){echo 'C2 TWIN '; }
    if($n==26){echo 'C2 TRACK '; }
    if($n==27){echo 'C2 BUILD '; }
    if($n==28){echo 'C2 CAPIT '; }
    if($n==51){echo 'C1 RACE '; }
    if($n==52){echo 'C2 RACE '; }
    if($n==30){echo 'RET AME '; }
    if($n==31){echo 'RET TWI '; }
    if($n==32){echo 'RET BUI '; }
    if($n==33){echo 'RET CAP '; }
    echo '</td><td>&nbsp; &nbsp;';
    if ($tiempoapasar==0){$tiempoapasar=substr($row_Recordset1['tiempo'], -8);}
    $tiempoaactual=substr($row_Recordset1['tiempo'], -8);
    echo restahoraRB2($CONTROLPRIMERTIEMPO, $tiempoaactual);
    echo '</td><td>&nbsp;';
    echo restahoraRB2($tiempoapasar, $tiempoaactual);
    echo '</td><td>&nbsp;';
 echo '&nbsp;'.$row_Recordset1['tiempo'].'&nbsp;&nbsp;';
 echo "<br>";
 echo '</td></tr>';
 $tiempoapasar=substr($row_Recordset1['tiempo'], -8);
// 1 CER WATCHA  2 CER TWINSP 3 CER BETBIR 4 CER CAPIT  5 CER TVG 6 CER BUIL
// 10 ABI WATCHA 11 ABI TWINSP 12 ABI BETBIR 13 ABI CAPIT 14 ABI TVG 15 ABI AMER 16 ABI BUILDA
// 20 C1 TWIN 21 C1 TRACK 22 C1 BUILD 25 C2 TWIN 26 C2 TRACK 27 C2 BUILD

} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
echo '</table>';