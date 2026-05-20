
<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once('../Connections/conexionbanca.php');


$usuario=$_SESSION['MM_nom_usuario'];

$horaTxt=horaactual();
$FechaTxt=fechaactualbd();
$datetime=$FechaTxt.' '.$horaTxt;


$fechahora=$FechaTxt.' '.$horaTxt;

$fechaactual=fechaactualbd();



 if ($_POST['jtipo']==0 && $_POST['modulo']==2) {











$query_Recordset12 = sprintf(
"/* PARSEADORES1 parley\adpaprobar2.php - QUERY 1 */ SELECT 
*     
FROM
p4jugadas, p2juegos
WHERE   
p2juegos.Id_p2juegosp2 = p4jugadas.juegop4 AND
p4jugadas.nticketp4 = %s AND p4jugadas.lineatp4 = 1  AND 
p4jugadas.pverificado = 0
ORDER BY lineatp4 DESC",
GetSQLValueString($_POST['nticket'], "int"));
$Recordset12 = mysqli_query($conexionbanca, $query_Recordset12) or die(mysqli_error($conexionbanca));
$row_Recordset12 = mysqli_fetch_assoc($Recordset12);
$totalRows_Recordset12 = mysqli_num_rows($Recordset12);







if($totalRows_Recordset12>0){



$query_Recordset19 = sprintf(
    "/* PARSEADORES1 parley\adpaprobar2.php - QUERY 2 */ SELECT 
    *
    FROM
    p4jugadas, p2juegos
    WHERE p4jugadas.nticketp4 = %s AND
    p4jugadas.juegop4 = p2juegos.Id_p2juegosp2    ORDER BY p4jugadas.lineatp4 DESC",
    GetSQLValueString($_POST['nticket'], "int"));
            $Recordset19 = mysqli_query($conexionbanca, $query_Recordset19) or die(mysqli_error($conexionbanca));
            $row_Recordset19 = mysqli_fetch_assoc($Recordset19);
            $totalRows_Recordset19 = mysqli_num_rows($Recordset19);
         //   echo 'ee '.$totalRows_Recordset19.' ee';
if($totalRows_Recordset19>0){ 

    if($row_Recordset12['estadoticketp4']==1){$estadopago=5;}
if($row_Recordset12['estadoticketp4']==3){$estadopago=6;}
$insertSQL155 = sprintf(
"/* PARSEADORES1 parley\adpaprobar2.php - QUERY 3 */ UPDATE p4jugadas  SET 
pverificado=%s,
quien_apruebap4=%s 
WHERE Id_p4jugadasp4=%s AND lineatp4 = 1",
GetSQLValueString(1, "int"),
GetSQLValueString($usuario, "text"),
GetSQLValueString($row_Recordset12['Id_p4jugadasp4'], "int"));
$Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));








$query_Recordset1 = sprintf(
"/* PARSEADORES1 parley\adpaprobar2.php - QUERY 4 */ SELECT 
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
        Ticket Aprobado <?php echo $row_Recordset12['premioapagarp4'].' '.$moneda; ?></FONT></H1></p></center><br/>
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

<div style="display: none">
        <?php


    
$msj= 'El Administrador '. $_SESSION['MM_nom_usuario']. ' Aprobo el Ticket Nro '.$row_Recordset1['nticketp4'];
    $msjx=utf8_encode($msj);
    $post=[
      'chat_id'=>-1001639542248,
      'text'=>$msjx,
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"https://api.telegram.org/bot5335385470:AAE0nAUC8c7ZDTPR3UPofIylv6TbkMsXGr8/sendMessage");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_exec ($ch);
    curl_close ($ch);



$insertSQL2 = sprintf(
        "/* PARSEADORES1 parley\adpaprobar2.php - QUERY 5 */ INSERT 
        INTO bitacora 
        (des_bitacora, hor_bitacora, codtaquilla, fec_bitacora) 
        VALUES (%s, %s, %s, %s)",
        GetSQLValueString($msj, "text"),
        GetSQLValueString($horaTxt, "date"),
        GetSQLValueString(0, "int"),
        GetSQLValueString($fechaactual, "date")
    );
    $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));


    ?>
</div>

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
<?php }
} else { ?> 
    <div class="card">
    <div class="card-body">

    <center><p><H1><FONT SIZE=25>TICKET YA A SIDO APROBADA</FONT></H1></p></center>
    </div>
    </div>
    <?php  }}?>

    <?php

    if ($_POST['jtipo']==0 && $_POST['modulo']==18) {











$query_Recordset12 = sprintf(
"/* PARSEADORES1 parley\adpaprobar2.php - QUERY 6 */ SELECT 
*     
FROM
p4jugadas, p2juegos
WHERE   
p2juegos.Id_p2juegosp2 = p4jugadas.juegop4 AND
p4jugadas.nticketp4 = %s AND p4jugadas.lineatp4 = 1  AND 
p4jugadas.pverificado = 0
ORDER BY lineatp4 DESC",
GetSQLValueString($_POST['nticket'], "int"));
$Recordset12 = mysqli_query($conexionbanca, $query_Recordset12) or die(mysqli_error($conexionbanca));
$row_Recordset12 = mysqli_fetch_assoc($Recordset12);
$totalRows_Recordset12 = mysqli_num_rows($Recordset12);







if($totalRows_Recordset12>0){



$query_Recordset19 = sprintf(
    "/* PARSEADORES1 parley\adpaprobar2.php - QUERY 7 */ SELECT 
    *
    FROM
    p4jugadas, p2juegos
    WHERE p4jugadas.nticketp4 = %s AND
    p4jugadas.juegop4 = p2juegos.Id_p2juegosp2    ORDER BY p4jugadas.lineatp4 DESC",
    GetSQLValueString($_POST['nticket'], "int"));
            $Recordset19 = mysqli_query($conexionbanca, $query_Recordset19) or die(mysqli_error($conexionbanca));
            $row_Recordset19 = mysqli_fetch_assoc($Recordset19);
            $totalRows_Recordset19 = mysqli_num_rows($Recordset19);
         //   echo 'ee '.$totalRows_Recordset19.' ee';
if($totalRows_Recordset19>0){ 

$insertSQL155 = sprintf(
"/* PARSEADORES1 parley\adpaprobar2.php - QUERY 8 */ UPDATE p4jugadas  SET 
estadoticketp4=6, premioapagarp4=%s, jugadadtp4pago=%s, pverificado=%s
WHERE Id_p4jugadasp4=%s AND lineatp4 = 1",
GetSQLValueString($row_Recordset19['mon_ventap4'], "int"),
GetSQLValueString($fechahora, "date"),
GetSQLValueString(1, "int"),
GetSQLValueString($row_Recordset12['Id_p4jugadasp4'], "int"));
$Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));








$query_Recordset1 = sprintf(
"/* PARSEADORES1 parley\adpaprobar2.php - QUERY 9 */ SELECT 
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
        Ticket Devuelto <?php echo $row_Recordset12['mon_ventap4'].' '.$moneda; ?></FONT></H1></p></center><br/>
        Ticket Nro.: <?php echo $row_Recordset1['nticketp4']; ?><br/>
        Fecha: <?php
echo substr($row_Recordset1['jugadadtp4'], 0, -9); //2020-09-25?>
		
		<br/>
        Hora: <?php $nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($row_Recordset1['jugadadtp4']));
        $nuevahora1 = date('Y-m-j H:i:s', $nuevahora1);
        echo date("g:ia", strtotime($nuevahora1)); ?><br/>

        Apuesta <?php echo $moneda; ?>.. <?php echo $row_Recordset1['mon_ventap4']; ?><br/>

        <?php if ($row_Recordset12['premioapagarp4']>$row_Recordset1['mon_ventap4']) {  ?>
        Premio <?php echo $moneda; ?>.. <?php echo $row_Recordset12['mon_ventap4']; ?><br/>
        <?php  } ?>
        <?php if ($row_Recordset12['premioapagarp4']==$row_Recordset1['mon_ventap4']) {  ?>
        Devolucion <?php echo $moneda; ?>.. <?php echo $row_Recordset12['mon_ventap4']; ?><br/>
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

<?php }
} else { ?> 
    <div class="card">
    <div class="card-body">

    <center><p><H1><FONT SIZE=25>TICKET YA A SIDO DEVUELTO</FONT></H1></p></center>
    </div>
    </div>
    <?php  }}?>