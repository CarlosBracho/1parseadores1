<?php
if (!isset($_SESSION)) {
    session_start();
}require_once('../Connections/conexionbanca.php');

$horaTxt=horaactual();
$FechaTxt=fechaactualbd();
$datetime=$FechaTxt.' '.$horaTxt;

 if ($_POST['jtipo']==0 && $_POST['modulo']==2) {
$query_Recordset12 = sprintf(
"/* PARSEADORES1 new\parley\tappagarticket2.php - QUERY 1 */ SELECT 
*     
FROM
p4jugadas
WHERE   
nticketp4 = %s AND lineatp4 = 1  AND pverificado = 1   AND premioapagarp4 > 1  
 AND (estadoticketp4 = 1 OR estadoticketp4 = 3)
ORDER BY lineatp4 DESC",
GetSQLValueString($_POST['nticket'], "int"));
$Recordset12 = mysqli_query($conexionbanca, $query_Recordset12) or die(mysqli_error($conexionbanca));
$row_Recordset12 = mysqli_fetch_assoc($Recordset12);
$totalRows_Recordset12 = mysqli_num_rows($Recordset12);


if($totalRows_Recordset12>0){

    if($row_Recordset12['estadoticketp4']==1){$estadopago=5;}
if($row_Recordset12['estadoticketp4']==3){$estadopago=6;}
do{
$insertSQL155 = sprintf(
"/* PARSEADORES1 new\parley\tappagarticket2.php - QUERY 2 */ UPDATE p4jugadas  SET 
jugadadtp4pago=%s,
estadoticketp4=%s 
WHERE nticketp4=%s",
GetSQLValueString($datetime, "date"),
GetSQLValueString($estadopago, "int"),
GetSQLValueString($row_Recordset12['nticketp4'], "int"));
$Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
echo $Result155.' resultado de /* PARSEADORES1 new\parley\tappagarticket2.php - QUERY 3 */ update';

}while ($row_Recordset12 = mysqli_fetch_assoc($Recordset12));








$query_Recordset1 = sprintf(
"/* PARSEADORES1 new\parley\tappagarticket2.php - QUERY 4 */ SELECT 
*
FROM
p4jugadas
WHERE
nticketp4 = %s   ORDER BY lineatp4 DESC",
GetSQLValueString($_POST['nticket'], "int"));
        $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
        $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
        $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
        if ($row_Recordset1['monedap4']<=2) {$moneda='Bss';}
        if ($row_Recordset1['monedap4']==3) {$moneda='Usd';}
        if ($row_Recordset1['monedap4']==4) {$moneda='Cop';}
        if ($row_Recordset1['monedap4']==5) {$moneda='Sol';}
        if ($row_Recordset1['monedap4']==10) {$moneda='Usd';} 
        
        
        ?>

<div class="card">
    <div class="card-body">
    <center><p><H1><FONT SIZE=25>
        Cancelar <?php echo $row_Recordset12['premioapagarp4'].' '.$moneda; ?></FONT></H1></p></center><br/>
        Ticket Nro.: <?php echo $row_Recordset1['nticketp4']; ?><br/>
        Fecha: <?php
echo substr($row_Recordset1['jugadadtp4'], 0, -9); //2020-09-25?>
		
		<br/>
        Hora: <?php $nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($row_Recordset1['jugadadtp4']));
        $nuevahora1 = date('Y-m-j H:i:s', $nuevahora1);
        echo date("g:ia", strtotime($nuevahora1)); ?><br/>

        Apuesta <?php echo $moneda; ?>.. <?php echo $row_Recordset1['mon_ventap4']; ?><br/>

        <?php if ($row_Recordset12['premioapagarp4']>$row_Recordset1['mon_ventap4']) {  ?>
        Premio <?php echo $moneda; ?>.. <?php echo $row_Recordset12['premioapagarp4']; ?><br/>
        <?php  } ?>
        <?php if ($row_Recordset12['premioapagarp4']==$row_Recordset1['mon_ventap4']) {  ?>
        Devolucion <?php echo $moneda; ?>.. <?php echo $row_Recordset12['premioapagarp4']; ?><br/>
        <?php  } ?>
</div>
 <table class="table table-sm">
    <thead class="thead-dark">
        <tr>
          <th scope="col">Tipo</th>
          <th scope="col">Equipo</th>
          <th scope="col">Logro</th>
          <th scope="col">Estado</th>


        </tr>
    </thead>
    <tbody>
	
<?php do { ?>
    <tr>
	<td class="detalleTablaLeft"><?php echo $row_Recordset1['tipojp4'];?><?php echo ' '.$row_Recordset1['ab_o_rlp4'];?></td>


	<td class="detalleTablaLeft"><b><?php echo $row_Recordset1['equipop4'];?></td>
	<td class="detalleTablaLeft"> <?php echo $row_Recordset1['logrop4'];?></td>
    <td class="detalleTablaLeft"> <?php
    if ($row_Recordset1['estadojugadap4']==0) {
        echo 'Pendiente';
    }
    if ($row_Recordset1['estadojugadap4']==1) {
        echo 'Gano';
    }
    if ($row_Recordset1['estadojugadap4']==2) {
        echo 'Perdio';
    }
    if ($row_Recordset1['estadojugadap4']==3) {
        echo 'Devolucion';
    }
    ?></td>


	</tr>

<?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
	</tr>
	</tbody>
</table>
<?php 
}else{?> <div class="card">
    <div class="card-body">

Tciket ya a sido cancelado
    </div>
    </div>
    <?php  }}?>