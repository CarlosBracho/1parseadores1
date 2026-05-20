<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
if (!isset($_SESSION['MM_id_usuario'])) {
    $id_usuarioO=$_SESSION['MM_id_usuario'];
} else {
    $id_usuarioO=0;
}

        $query_Recordset12 = sprintf(
            "/* PARSEADORES1 parley\parley\ultimotickettap.php - QUERY 1 */ SELECT 
    *
        
                FROM
    p4jugadas
                WHERE
    
                id_usuariop4 = %s AND lineatp4 = 1  ORDER BY nticketp4 DESC LIMIT 1
    ",
            GetSQLValueString($_GET["recordID"], "int")
        );
        $Recordset12 = mysqli_query($conexionbanca, $query_Recordset12) or die(mysqli_error($conexionbanca));
        $row_Recordset12 = mysqli_fetch_assoc($Recordset12);
        $totalRows_Recordset12 = mysqli_num_rows($Recordset12);
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 parley\parley\ultimotickettap.php - QUERY 2 */ SELECT 
*
	
			FROM
p4jugadas
			WHERE

				nticketp4 = %s   ORDER BY lineatp4 DESC
",
    GetSQLValueString($row_Recordset12['nticketp4'], "int")
);
        $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
        $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
        $totalRows_Recordset1 = mysqli_num_rows($Recordset1);

        if ($totalRows_Recordset1>0) {
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
            if ($row_Recordset1['monedap4']==10) {
                $moneda='Usd';
            } ?>

<div class="card">
    <div class="card-body">
    <center>:.Ultimo ticket.:</center><br/>
        Ticket Nro.: <?php echo $row_Recordset1['nticketp4']; ?><br/>
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



        </tr>
    </thead>
    <tbody>
	
<?php do { ?>
    <tr>
	<td class="detalleTablaLeft"><?php echo $row_Recordset1['tipojp4'];?><?php echo ' '.$row_Recordset1['ab_o_rlp4'];?></td>


	<td class="detalleTablaLeft"><b><?php echo $row_Recordset1['equipop4'];?></td>
	<td class="detalleTablaLeft"> <?php echo $row_Recordset1['logrop4'];?></td>
    


	</tr>

<?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
	</tr>
	</tbody>
</table>
<?php
        }
 ?>
