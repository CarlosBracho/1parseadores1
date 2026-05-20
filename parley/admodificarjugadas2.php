
<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once('../Connections/conexionbanca.php');

$horaTxt=horaactual();
$FechaTxt=fechaactualbd();
$datetime=$FechaTxt.' '.$horaTxt;


$fechahora=$FechaTxt.' '.$horaTxt;

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}



if(isset($_POST['Monto'])){
$insertSQL155 = sprintf(
    "/* PARSEADORES1 parley\admodificarjugadas2.php - QUERY 1 */ UPDATE p4jugadas  SET 
    estadoticketp4=%s, mon_ventap4=%s, estadojugadap4=%s, premioapagarp4=%s, jugadadtp4pago=%s
    WHERE nticketp4=%s AND lineatp4 = %s",
    GetSQLValueString($_POST['Est_ticket'], "int"),
    GetSQLValueString($_POST['Monto20'], "double"),
    GetSQLValueString($_POST['Est_jugada'], "int"),
    GetSQLValueString($_POST['Monto'], "double"),
    GetSQLValueString($fechahora, "date"),
    GetSQLValueString($_POST['nticket'], "int"),
    GetSQLValueString($_POST['linea'], "int"));
    $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));


    $insertGoTo2 = "admodificarjugadas.php";

    header(sprintf("Location: %s", $insertGoTo2));


}



if(isset($_POST['Reinicio'])){
    $insertSQL155 = sprintf(
        "/* PARSEADORES1 parley\admodificarjugadas2.php - QUERY 2 */ UPDATE p4jugadas  SET 
        estadoticketp4=%s, estadojugadap4=%s, premioapagarp4=%s, jugadadtp4pago=%s
        WHERE nticketp4=%s",
        GetSQLValueString(0, "int"),
        GetSQLValueString(0, "int"),
        GetSQLValueString(0, "int"),
        GetSQLValueString(0, "date"),
        GetSQLValueString($_POST['nticket'], "int")
        );
        $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
    
    
        $insertGoTo2 = "admodificarjugadas.php";
    
        header(sprintf("Location: %s", $insertGoTo2));
    
    
    }













$query_Recordset12 = sprintf(
"/* PARSEADORES1 parley\admodificarjugadas2.php - QUERY 3 */ SELECT 
*     
FROM
p4jugadas, p2juegos
WHERE   
p2juegos.Id_p2juegosp2 = p4jugadas.juegop4 AND
p4jugadas.nticketp4 = %s AND p4jugadas.lineatp4 = 1
ORDER BY lineatp4 DESC",
GetSQLValueString($_POST['nticket'], "int"));
$Recordset12 = mysqli_query($conexionbanca, $query_Recordset12) or die(mysqli_error($conexionbanca));
$row_Recordset12 = mysqli_fetch_assoc($Recordset12);
$totalRows_Recordset12 = mysqli_num_rows($Recordset12);







if($totalRows_Recordset12>0){



$query_Recordset19 = sprintf(
    "/* PARSEADORES1 parley\admodificarjugadas2.php - QUERY 4 */ SELECT 
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
/*/$insertSQL155 = sprintf(
"UPDATE p4jugadas  SET 
pverificado=%s 
WHERE Id_p4jugadasp4=%s AND lineatp4 = 1",
GetSQLValueString(1, "int"),
GetSQLValueString($row_Recordset12['Id_p4jugadasp4'], "int"));
$Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));/*/








$query_Recordset1 = sprintf(
"/* PARSEADORES1 parley\admodificarjugadas2.php - QUERY 5 */ SELECT 
*
FROM
p4jugadas,
p2juegos
WHERE
p4jugadas.nticketp4 = %s AND p2juegos.Id_p2juegosp2 = p4jugadas.juegop4 ORDER BY lineatp4 DESC",
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
        TICKET A MODIFICAR </FONT></H1></p></center><br/>
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
        <?php  }  ?>
</div>
 <table class="table table-sm">
    <thead class="thead-dark">
        <tr>
          <th scope="col">Tipo</th>
          <th scope="col">Equipo</th>
          <th scope="col">Inicio</th>
          <th scope="col">Logro</th>
          <th scope="col">Estado</th>
          <th scope="col">Linea</th>
          <th scope="col">Est_Jugada</th>
          <th scope="col">Est_ticket</th>


        </tr>
    </thead>
    <tbody>
	
<?php do { ?>
    <tr>
	<td class="detalleTablaLeft"><?php echo $row_Recordset1['tipojp4'];?><?php echo ' '.$row_Recordset1['ab_o_rlp4'];?></td>


	<td class="detalleTablaLeft"><b><?php echo $row_Recordset1['equipop4'];?></td>
    <td class="detalleTablaLeft"><b><?php echo $row_Recordset1['iniciodtp2'];?></td>
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
   <td class="detalleTablaLeft"> <?php echo $row_Recordset1['lineatp4'];?></td><br>
   <td class="detalleTablaLeft"> <?php echo $row_Recordset1['estadojugadap4'];?></td>
   <td class="detalleTablaLeft"> <?php echo $row_Recordset1['estadoticketp4'];?></td><br>
   

	</tr>
    
    <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>

	</tr>
	</tbody>
</table>

<form method="POST" name="Finalizar" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">

    <input type="text" name="Monto20" id="Monto20" value="<?php echo $row_Recordset12['mon_ventap4']; ?>">  Monto de la apuesta(se cambia en la linea 1)
    <br><br>
    <input type="text" name="Monto" id="Monto" value="<?php echo $row_Recordset12['premioapagarp4']; ?>">  Monto a Pagar(se cambia en la linea 1)
    <br><br>
    <input type="text" name="linea" placeholder="Linea a modificar"> Aqui se modificara que Linea del ticket es la que se busca cambiar
    <br><br>
    <input type="text" name="Est_jugada" placeholder="Estado de jugada a modificar"> Donde 1 es: Gano. 2 Es: Perdio. y 3 Devolucion
    <br><br>
    <input type="text" name="Est_ticket" id="Est_ticket" placeholder="Estado de ticket a modificar" value="<?php echo $row_Recordset12['estadoticketp4']; ?>" > Donde 1 es: Ganado por pagar. 2 es: Perdio. 3 es: Devolucion. 5 es: Ganador Pagado. 6 es: Devolucion Pagada y 7 es: Ticket Eliminado (En el estado de Ticket solo se debe Modificar la Linea 1)
    <br><br>
    <input type="hidden" name="nticket" value="<?php echo $_POST['nticket']; ?>">
    
    
    
    <button class="btn btn-primary" type="submit">Cambiar</button><br><br>

    
</form>
<form method="POST" name="Finalizar" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">

   

    

    <input type="hidden" name="nticket" value="<?php echo $_POST['nticket']; ?>">
    <input type="hidden" name="Reinicio">
    <button align="right" class="btn btn-danger" type="submit">Reiniciar Ticket</button>

</form>

<?php  }
} else { ?> 
    <div class="card">
    <div class="card-body">

    <center><p><H1><FONT SIZE=25>TICKET SIN JUEGO RELACIONADO</FONT></H1></p></center>
    </div>
    </div>
    <?php  }?>

    
  