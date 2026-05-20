<?php
 
error_reporting(E_ALL);
ini_set('display_errors', '1');
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');



//segunda parte ------------------------------------------------------------------------------
if(isset($_GET["recordID2"])) {


$hor=horaactual();
$fec=fechaactualbd();
$query_Recordset1z = sprintf("/* PARSEADORES1 new\ventas\pick2.php - QUERY 1 */ SELECT * FROM carrera WHERE carrera.fec_carrera = %s AND carrera.hor_carrera >= %s AND carrera.est_carrera = 1 AND  cod_carrera=%s ORDER BY carrera.hor_carrera  LIMIT 1", 
GetSQLValueString($fec, "date"), 
GetSQLValueString($hor, "date"), 
GetSQLValueString($_GET["recordID2"], "int"));
$Recordset1z = mysqli_query($conexionbanca, $query_Recordset1z) or die(mysqli_error($conexionbanca));
$row_Recordset1z = mysqli_fetch_assoc($Recordset1z);
$totalRows_Recordset1z = mysqli_num_rows($Recordset1z);
?>







<select id="Tipojugadaahacer" required="required" onchange="Tipojugadaahacer()">
<option value="-1">Selecione</option>
    <?php if(strpos($row_Recordset1z['TipoApuestas'], '2') === false){}else{  ?> 
<option value="2">Daily Double</option>
<?php } ?>
    <?php if(strpos($row_Recordset1z['TipoApuestas'], '3') === false){}else{   ?> 
<option value="3">Pick 3</option>
<?php } ?>
    <?php if(strpos($row_Recordset1z['TipoApuestas'], '4') === false){}else{   ?> 
<option value="4">Pick 4</option>
<?php } ?>
    <?php if(strpos($row_Recordset1z['TipoApuestas'], '5') === false){}else{   ?> 
<option value="5">Pick 5</option>
<?php } ?>

</select>
</div>

<?php
}

//tercera parte parte ------------------------------------------------------------------------------
if(isset($_GET["recordID3"])) {

echo $_GET["recordID3"];







}