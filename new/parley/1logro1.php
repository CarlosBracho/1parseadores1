<?php
// 
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once('../Connections/conexionbanca.php');
$horaTxt=horaactual();
$FechaTxt=fechaactualbd();
$datetime=$FechaTxt.' '.$horaTxt;



$query_Recordset111 = sprintf(
    "/* PARSEADORES1 new\parley\1logro1.php - QUERY 1 */ SELECT logrop3, Id_p3logrosp3, logroABoRLp3, idjuegop3, equipop3, tipojugadap3
FROM  p3logros
WHERE logrodtp3 >= %s AND idjuegop3 >= 0 ORDER BY idjuegop3 DESC",
    GetSQLValueString($datetime, "date"));
$Recordset111 =mysqli_query($conexionbanca, $query_Recordset111) or die(mysqli_error($conexionbanca));
$row_Recordset111 = mysqli_fetch_assoc($Recordset111);
$totalRows_Recordset111 = mysqli_num_rows($Recordset111);
  //echo  $totalRows_Recordset111;
  $totalvueltas=$totalRows_Recordset111;
 // echo $row_Recordset111['logrop3'];

while ($fila = mysqli_fetch_assoc($Recordset111)) {
    $tlarray[] = $fila;
}

//print_r($tlarray1)."date";
function Obtenerlogro($Id_p2juegos, $equipo, $tipojugada, $tlarray, $tlarray1)
{
//inicio logros individual
$o2=0; 
$palabra_a_buscar  = $Id_p2juegos;
//if (isset($tlarray1)) {
if(is_array($tlarray1)=='true'){
foreach ($tlarray1 as $clave=>$valor) {
$indice = array_search($palabra_a_buscar, $valor);
if ($valor["idjuegop6"]==$Id_p2juegos & $valor["equipop6"]==$equipo & $valor["tipojugadap6"]==$tipojugada) {
    if ($indice) {
        $logro=$valor['logrop6'];
        $Id_p3logros=$valor['idp6logrosind'];
        $logroABoRL=$valor['logroABoRLp6'];
        $o2=1;
    }
    return array($logro, $Id_p3logros, $logroABoRL);
}
}}



//fin logros individual

//inicio logros sistema usare un if si hay individual no usara este
if($o2==0){
    $palabra_a_buscar  = $Id_p2juegos;
    foreach ($tlarray as $clave=>$valor) {
        $indice = array_search($palabra_a_buscar, $valor);
        if ($valor["idjuegop3"]==$Id_p2juegos & $valor["equipop3"]==$equipo & $valor["tipojugadap3"]==$tipojugada) {
            if ($indice) {
                $logro=$valor['logrop3'];
                $Id_p3logros=$valor['Id_p3logrosp3'];
                $logroABoRL=$valor['logroABoRLp3'];
            }
            return array($logro, $Id_p3logros, $logroABoRL);
        }
    }
}
//fin logros sistema



}


$query_Recordset1b = sprintf(
    "/* PARSEADORES1 new\parley\1logro1.php - QUERY 2 */ SELECT * FROM p2juegos WHERE 
iniciodtp2 > %s AND
idequipo1p2 > 0 AND
idequipo1p2 > 0
ORDER BY deportep2,  competicionp2, iniciodtp2
DESC",
    GetSQLValueString($datetime, "date")
);
    $Recordset1b = mysqli_query($conexionbanca, $query_Recordset1b) or die(mysqli_error($conexionbanca));
    $row_Recordset1b = mysqli_fetch_assoc($Recordset1b);
    $totalRows_Recordset1b = mysqli_num_rows($Recordset1b);
    echo 'v2<br>';
echo $totalRows_Recordset1b;
    ?>
    <!doctype html>
    <html lang="en">
      <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
        <!-- Bootstrap CSS -->

        <title>Hello, world!</title>
    
    

      </head>
      <body>
      <div style="text-align:center;">
    <table border='2'  style="margin: 0 auto;">
    
    
    <?php


if($totalRows_Recordset1b>0){ 
    $competicionp2='';
    do { 
        $query_Recordset21 = sprintf(
            "/* PARSEADORES1 new\parley\1logro1.php - QUERY 3 */ SELECT *
    FROM p1equipos
    WHERE  
    Id_p1equiposp1 = %s",
            GetSQLValueString($row_Recordset1b['idequipo1p2'], "int")
        );
    
        $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
        $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
        $totalRows_Recordset21 = mysqli_num_rows($Recordset21);

        $query_Recordset22 = sprintf(
            "/* PARSEADORES1 new\parley\1logro1.php - QUERY 4 */ SELECT *
    FROM p1equipos WHERE Id_p1equiposp1 = %s",
            GetSQLValueString($row_Recordset1b['idequipo2p2'], "int")
        );
        $Recordset22 =mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
        $row_Recordset22 = mysqli_fetch_assoc($Recordset22);
        $totalRows_Recordset22 = mysqli_num_rows($Recordset22);
       
       
       if($row_Recordset1b['competicionp2']<>$competicionp2){
        echo "<tr>";


        ?>
       <th colspan="4" class="text-center"><?php echo strtoupper($row_Recordset1b['deportep2']).' '; echo $row_Recordset1b['competicionp2']; ?></th>   
      
        <?php

echo "</tr>";
}

echo "<tr>";
        echo "<td>";
echo $row_Recordset1b['iniciodtp2'].'<br>';

echo "</td>";
        echo "<td>";
echo $row_Recordset21['nomequipop1'].'<br>';
echo $row_Recordset22['nomequipop1'].'<br>';
echo "</td>";
echo "<td>";





?>

<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1b['Id_p2juegosp2'], 1, 'ML', $tlarray, $tlarray1);
    if ($lg!=0) {?>

<td>
<?php echo $lg; ?>
</td><?php } else {?><td></td><?php } ?>	
<?php










echo $row_Recordset21['nomequipop1'].'<br>';
echo $row_Recordset22['nomequipop1'].'<br>';
echo "</td>";
echo "<td>";
echo $row_Recordset21['nomequipop1'].'<br>';
echo $row_Recordset22['nomequipop1'].'<br>';
echo "</td>";


echo "</tr>";
$competicionp2=$row_Recordset1b['competicionp2'];
    } while ($row_Recordset1b = mysqli_fetch_assoc($Recordset1b));
}
    ?>
    </table>
    </div> 
  </body>
</html>


