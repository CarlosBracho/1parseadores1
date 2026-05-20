
<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once('../Connections/conexionbanca.php');
if ($_POST['jtipo']==0 && $_POST['modulo']==0) {
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 new\parley\detalle_ticket.php - QUERY 1 */ SELECT 
			ve.est_ticket, 
			ve.ser_venta, 
			ve.fec_venta, 
			ve.hor_venta,
			ve.num_caballo,
			ve.cod_tventa,
			ve.mon_venta,
			ve.pag_premio,
			ve.can_ticket,
			ve.ip_venta,
			ve.efectivoO,
			tp.tie_reclamo,
			ta.nom_taquilla,
			ve.fec_venta,
			ve.hor_venta,
			ve.ticket,
			us.nom_usuario,
			ca.est_carrera,
			ca.nom_hipodromo,
			ca.num_carrera, 
			ca.est_confirmacion 
	
			FROM
				agencia ag,
				usuario us,
				taquilla ta,
				taquilla_opc_ame tp,
				venta ve,
				carrera ca
			WHERE
				ta.cod_agencia = ag.cod_agencia AND
				tp.cod_taquilla = ta.cod_taquilla AND
				us.cod_taquilla = ta.cod_taquilla AND
				ve.id_usuario = us.id_usuario AND
				ca.cod_carrera = ve.cod_carrera AND
				ve.num_ticket = %s 
			ORDER BY ve.cod_tventa",
        GetSQLValueString($_POST['nticket'], "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    if ($row_Recordset1['efectivoO']<=2) {
        $moneda='Bss';
    }
    if ($row_Recordset1['efectivoO']==3) {
        $moneda='Usd';
    }
    if ($row_Recordset1['efectivoO']==4) {
        $moneda='Cop';
    }
    if ($row_Recordset1['efectivoO']==5) {
        $moneda='Sol';
    } ?>
<div class="card">
    <div class="card-body">
        Ticket Nro.: <?php echo $row_Recordset1['ticket']; ?><br/>
        Fecha: <?php echo $row_Recordset1['fec_venta']; ?> <br/>
        Hora: <?php echo horaampm($row_Recordset1['hor_venta']); ?><br/>
</div>
 <table class="table table-sm">
    <thead class="thead-dark">
        <tr>
          <th scope="col">HIPODROMO</th>
          <th scope="col">#CARR</th>
          <th scope="col">EJEMP</th>
          <th scope="col">JUGADA</th>
          <th scope="col">MONTO</th>
          <th scope="col">PREMIO</th>
        </tr>
    </thead>
    <tbody>
    <tr>
	<td class="detalleTablaLeft"><?php echo $row_Recordset1['nom_hipodromo']; ?></td>
	
	<td class="detalleTablaLeft"><?php echo $row_Recordset1['num_carrera']; ?></td>
	
	<td class="detalleTablaLeft"><?php echo $row_Recordset1['num_caballo']; ?></td>
	
	<td class="detalleTablaLeft"><?php echo ObtenerNombreApuesta($row_Recordset1['cod_tventa']); ?></td>
	
	<td class="detalleTablaLeft"><?php echo $moneda; ?>.. <?php echo $row_Recordset1['mon_venta']; ?></td>
	
	<td class="detalleTablaLeft"><?php echo $moneda; ?>.. <?php echo $row_Recordset1['pag_premio']; ?></td>
	</tr>
	
</table>

<?php
} ?>








<?php if ($_POST['jtipo']==0 && $_POST['modulo']==2) {
        $query_Recordset12 = sprintf(
            "/* PARSEADORES1 new\parley\detalle_ticket.php - QUERY 2 */ SELECT 
    *
        
                FROM
    p4jugadas
                WHERE
    
                    nticketp4 = %s AND lineatp4 = 1  ORDER BY lineatp4 DESC
    ",
            GetSQLValueString($_POST['nticket'], "int")
        );
        $Recordset12 = mysqli_query($conexionbanca, $query_Recordset12) or die(mysqli_error($conexionbanca));
        $row_Recordset12 = mysqli_fetch_assoc($Recordset12);
        $totalRows_Recordset12 = mysqli_num_rows($Recordset12);
        $query_Recordset1 = sprintf(
            "/* PARSEADORES1 new\parley\detalle_ticket.php - QUERY 3 */ SELECT 
*
	
			FROM
p4jugadas
			WHERE

				nticketp4 = %s   ORDER BY lineatp4 DESC
",
            GetSQLValueString($_POST['nticket'], "int")
        );
        $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
        $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
        $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
        if ($row_Recordset1['monedap4']<=2) {
            $moneda='Bss';
        }
        if ($row_Recordset1['monedap4']==3) {
            $moneda='Usd';
        }
        if ($row_Recordset1['monedap4']==4) {
            $moneda='Cop';
        }
        if ($row_Recordset1['monedap4']==5) {
            $moneda='Sol';
        }
        if ($row_Recordset1['monedap4']==12) {
            $moneda='Usd';
        } ?>

<div class="card">
    <div class="card-body">
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

        <?php if ($row_Recordset12['pverificado']==0) {
            echo '<b>Este Ticket no ha sido Verificado</b>';           
            }else {
            echo '<b>Este Ticket ha sido Verificado</b>';
            }
        ?>


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
    } 
    ?>

<?php if ($_POST['jtipo']==0 && $_POST['modulo']==99) {?>
<div class="card">
    <div class="card-body">
        Nro. Taquilla: 1<br/>
        Ticket Nro.: 0001049011<br/>
        Fecha: 08/09/2020<br/>
        Hora: 7:19 am<br/>
        Estatus: PERDIO<br/><br/>
        Apuesta Bs.. 10.000,00<br/>
        Premio Bs.. 295.312,50    </div>
</div>
 <table class="table table-sm">
    <thead class="thead-dark">
        <tr>
          <th scope="col">Tipo</th>
          <th scope="col"></th>
          <th scope="col">Cant.</th>
          <th scope="col">Hora</th>
          <th scope="col">Equipo</th>
          <th scope="col">Logro</th>
          <th scope="col">Deportes</th>
          <th scope="col">Status</th>
        </tr>
    </thead>
    <tbody>
    <tr><td class="detalleTablaLeft">EML</td><td class="detalleTablaLeft"></td><td class="detalleTablaLeft"></td><td class="detalleTablaLeft"><p class="small">11:00:00</td><td class="detalleTablaLeft"><b>4829 - Stjordals Blink</b> Vs <small>4824 - GRORUD</small></td><td class="detalleTablaLeft"> 275</td><td class="detalleTablaLeft"><small>3 - Soccer</small></td><td class="detalleTablaLeft"><span class="badge badge-success">(GANO)</span></td></tr><tr><td class="detalleTablaLeft">BAJA JC</td><td class="detalleTablaLeft">2.5</td><td class="detalleTablaLeft"></td><td class="detalleTablaLeft"><p class="small">11:30:00</td><td class="detalleTablaLeft"><b>4831 - Tromso</b> Vs <small>4827 - KFUM OSLO</small></td><td class="detalleTablaLeft"> 110</td><td class="detalleTablaLeft"><small>3 - Soccer</small></td><td class="detalleTablaLeft"><span class="badge badge-success">(GANO)</span></td></tr><tr><td class="detalleTablaLeft">EML</td><td class="detalleTablaLeft"></td><td class="detalleTablaLeft"></td><td class="detalleTablaLeft"><p class="small">12:00:00</td><td class="detalleTablaLeft"><b>4834 - Jerv</b> Vs <small>4822 - ASANE</small></td><td class="detalleTablaLeft"> 275</td><td class="detalleTablaLeft"><small>3 - Soccer</small></td><td class="detalleTablaLeft"><span class="badge badge-danger">(PERDIO)</span></td></tr>    </tbody>
</table>
<h2>MONTO A PAGAR: BS.295.312,50</h2>
<?php } 


?>
