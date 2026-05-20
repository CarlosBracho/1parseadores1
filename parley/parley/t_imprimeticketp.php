<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');



$_POST['iD']=substr(filter_var($_POST['iD'], FILTER_SANITIZE_NUMBER_INT), 0, -2);
       











?>
<style type="text/css" media="print">
#Imprime {
	height: auto;
	width: 0px;
	margin: 0px;
	padding: 0px;
	float: left;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 7px;
	font-style: normal;
	line-height: normal;
	font-weight: normal;
	font-variant: normal;
	text-transform: none;
	color: #000;
}
@page{
   margin: 0;
}
</style>


	 
     <?php
     $query_Recordset1 = sprintf(
    "/* PARSEADORES1 parley\parley\t_imprimeticketp.php - QUERY 1 */ SELECT 
*
	
			FROM
p4jugadas
			WHERE

				nticketp4 = %s  ORDER BY lineatp4 DESC
",
    GetSQLValueString($_POST['iD'], "int")
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
        if ($row_Recordset1['monedap4']==10) {
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
Estatus: Pendiente<br/>
        Apuesta <?php echo $moneda; ?>.. <?php echo $row_Recordset1['mon_ventap4']; ?><br/>
</div>
 <table class="table table-sm">
    <thead class="thead-dark">
        <tr>
          <th scope="col">Tipo</th>
          <th scope="col"></th>
          <th scope="col">Equipo</th>
          <th scope="col">Logro</th>


        </tr>
    </thead>
    <tbody>
	
<?php
 $premio=0;
do { ?>
    <tr>
	<td class="detalleTablaLeft"><?php echo $row_Recordset1['tipojp4'].' '.$row_Recordset1['ab_o_rlp4']; ?></td>
	<td class="detalleTablaLeft"></td>

	<td class="detalleTablaLeft"><b><?php echo  substr($row_Recordset1['equipop4'], 0, 7);?></td>
	<td class="detalleTablaLeft"> <?php echo $row_Recordset1['logrop4'];?></td>


	</tr>






<?php
   

if ($premio==0) {
    $premio=$row_Recordset1['mon_ventap4'];
} else {
    $premio=$premio;
}
if ($row_Recordset1['logrop4']>0) {
    $premio=($premio*($row_Recordset1['logrop4']/100))+$premio;
}
if ($row_Recordset1['logrop4']<0) {
    $premio=($premio/(($row_Recordset1['logrop4']* -1)/100))+$premio;
}




} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
function truncar($numero, $digitos)
{
    $truncar = 10**$digitos;
    return intval($numero * $truncar) / $truncar;
}
?>
Premio <?php echo $moneda; ?>.. <?php echo number_format($premio, 2, '.', '');
?>
	</tr>
	</tbody>
</table>


<?php if ($_POST['iD']==0 && $_POST['iD']==99) {?>
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
<?php
    } ?>

<script>
limpiarPantalla()
</script>
</body>
</html>
