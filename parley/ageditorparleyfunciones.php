<?php 
require_once('../Connections/conexionbanca.php');
echo  'inicio6<br>'; 
$horaTxt=horaactual();
$FechaTxt=fechaactualbd();
$datetime=$FechaTxt.' '.$horaTxt;
// funciones 1 operador 1 //crear logro manual de un agentea todas sus taquillas

echo 'funcion '.$_POST['funcion'].'<br>';
echo 'idfuncion '.$_POST['idfuncion'].'<br>';
echo 'operador '.$_POST['operador'].'<br>';

if($_POST['funcion']==1 && $_POST['operador']==1){
echo '<br><br> inicia funcion agente edita logro manual'.'<br>';

$query_Recordset111 = sprintf(
    "/* PARSEADORES1 parley\ageditorparleyfunciones.php - QUERY 1 */ SELECT logrop3, Id_p3logrosp3, logroABoRLp3, idjuegop3, equipop3, tipojugadap3, logrodtp3
FROM  p3logros
WHERE logrodtp3 >= %s AND Id_p3logrosp3 = %s AND idjuegop3 >= 0 ORDER BY idjuegop3 DESC",
    GetSQLValueString($datetime, "date"),
    GetSQLValueString($_POST['idfuncion'], "int"));
$Recordset111 =mysqli_query($conexionbanca, $query_Recordset111) or die(mysqli_error($conexionbanca));
$row_Recordset111 = mysqli_fetch_assoc($Recordset111);
$totalRows_Recordset111 = mysqli_num_rows($Recordset111);
echo 'totalRows_Recordset111 '.$totalRows_Recordset111.'<br>'; 
echo 'idjuegop3 '.$row_Recordset111['idjuegop3'].'<br>';
echo 'equipop3 '.$row_Recordset111['equipop3'].'<br>';
echo 'tipojugadap3 '.$row_Recordset111['tipojugadap3'].'<br>';
echo 'logrop3 '.$row_Recordset111['logrop3'].'.............................<br>';
echo 'Id_p3logrosp3 '.$row_Recordset111['Id_p3logrosp3'].'<br>';
echo 'logroABoRLp3 '.$row_Recordset111['logroABoRLp3'].'<br><br>';
echo 'logrodtp3 '.$row_Recordset111['logrodtp3'].'<br><br>';


//aqui busca si hay logro manual
$query_Recordset1111 = sprintf(
"/* PARSEADORES1 parley\ageditorparleyfunciones.php - QUERY 2 */ SELECT logrop6, idp6logrosind, logroABoRLp6, idjuegop6, equipop6, tipojugadap6, logrodtp6
FROM  p6logrosind
WHERE logrodtp6 >= %s AND idlogrop6 = %s AND idjuegop6 >= 0 ORDER BY idjuegop6 DESC",
GetSQLValueString($datetime, "date"),
GetSQLValueString($_POST['idfuncion'], "int"));
$Recordset1111 =mysqli_query($conexionbanca, $query_Recordset1111) or die(mysqli_error($conexionbanca));
$row_Recordset1111 = mysqli_fetch_assoc($Recordset1111);
$totalRows_Recordset1111 = mysqli_num_rows($Recordset1111);
if($totalRows_Recordset1111>0){ echo 'Si hay logro manual<br>'; $logrom=$row_Recordset1111['logrop6']; $logroABoRLp6=$row_Recordset1111['logroABoRLp6']; $logrodtp6=$row_Recordset1111['logrodtp6'];
?>


<?php
}
else{ echo 'No hay logro manual<br>'; $logrom=''; $logroABoRLp6=''; $logrodtp6=$row_Recordset111['logrodtp3']; }
?>
<input type="hidden" name="Id_p3logrosp3" value="<?php echo $row_Recordset111['Id_p3logrosp3']; ?>"/>					
<input type="hidden" name="idjuegop3" value="<?php echo $row_Recordset111['idjuegop3']; ?>"/>					
<input type="hidden" name="equipop3" value="<?php echo $row_Recordset111['equipop3']; ?>"/>					
<input type="hidden" name="tipojugada" value="<?php echo $row_Recordset111['tipojugadap3']; ?>"/>					
<input type="text" name="logromanual" id="" value="<?php echo $logrom; ?>" placeholder="Logro Manual">
<input type="text" name="logroABoRLp6" id="" value="<?php echo $logroABoRLp6; ?>" placeholder="Valor AB RL SRL HRE y demas">
<input type="hidden" name="logrodtp6" value="<?php echo $logrodtp6; ?>"/>					

<?php 
}
?>