<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('Connections/conexionbanca.php');
$query_Recordset1 = "/* PARSEADORES1 mensajesaleatorios.php - QUERY 1 */ SELECT * FROM mensajes ORDER BY RAND() LIMIT 1";
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$mensajealeatorio= $row_Recordset1['mensaje'];
  echo "<br/>";
echo $mensajealeatorio;
  echo "<br/>";
?>
<?php




mysqli_free_result($Recordset1);

?>