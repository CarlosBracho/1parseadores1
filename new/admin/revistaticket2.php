<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$maxRows_Recordset1 = 19;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
    $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

$xTicket_Recordset1 = "0";
if (isset($_GET["recordID"])) {
    $xTicket_Recordset1 = $_GET["recordID"];
}

$query_Recordset1 = sprintf("/* PARSEADORES1 new\admin\revistaticket2.php - QUERY 1 */ SELECT * FROM venta WHERE venta.ticket = %s ORDER BY venta.cod_tventa", GetSQLValueString($xTicket_Recordset1, "int"));
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysqli_query($conexionbanca, $query_limit_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
    $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
    $all_Recordset1 = mysqli_query($conexionbanca, $query_Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;
$serial=$row_Recordset1['ser_venta'];
$rest = substr($serial, 0, 2);
$rest = $rest.$xTicket_Recordset1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../estilo/twoColFixLtHdr.css" rel="stylesheet" type="text/css" />
<title>.:Apuestas Hípicas:.</title>
<script src="../js/jquery-1.9.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#calcular").click(function(){
		var url = "procesar_ticket_automatico.php"; // El script en dónde se realizará la petición.
		var xerror = '<p id="mpaga"><br/><br/><h3>NO HAY RESPUESTA DEL SERVIDOR<h3/>Por favor intente de nuevo</p>';
		var esper1 = '<img src="../images/buscando.gif" width="20" height="20" /><br/>En Proceso! Por favor espere ...';
		$.ajax({
				url:"procesar_ticket_automatico.php",
				type: "POST", global : false, data: $("#form2").serialize(),
				beforeSend: function(){ 
					$('#resultado').html(esper1);
				},
				success: function(data) {
					$("#resultado").html(data);
				},
				error: function(){ 
					$("#resultado").html(xerror);
				}
			});
		})
	});
</script>
 
</head>
<body style="margin: 0px">
    <div style="float:left; background:#FFFFFF; padding:0px 10px 0px 0px; height:600px">
    <?php
    if ($row_Recordset1['est_ticket']==0) {
        $estado="--ELIMINADO--";
    } else {
        $estado="";
    }
    ?>
<table width="225" border="0" align="left" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4" align="center" class="imprimir"><?php echo ObtenerNombreTaquilla($row_Recordset1['cod_taquilla']); ?></td>
  </tr>
  <tr>
    <td colspan="4" align="center" class="imprimir"><?php echo $estado; ?></td>
  </tr>
  <tr>
    <td colspan="4" align="center" class="imprimir">Fecha: <?php echo fechanueva($row_Recordset1['fec_venta']); ?></td>
  </tr>
  <tr>
    <td colspan="4" align="center" class="imprimir">Hora: <?php echo horaampm($row_Recordset1['hor_venta']); ?></td>
  </tr>
  <tr>
    <td colspan="4" align="center" class="imprimirnroticket">Ticket: <?php echo $row_Recordset1['ticket']; ?></td>
  </tr>
  <tr>
    <td colspan="4" align="center" class="imprimirnroticket">Codigo de ticket: <?php echo $rest; ?></td>
  </tr>
  <tr>
    <td colspan="4" align="center" class="imprimir">Vendedor: <?php echo ObtenerNombreVendedor($row_Recordset1['id_usuario']); ?> #:<?php echo $row_Recordset1['can_ticket']; ?></td>
  </tr>
  <tr>
    <td colspan="4" align="center" class="apuestajugada"><?php echo "  ". ObtenerNombreynumeroJugadaCarrera($row_Recordset1['cod_carrera']); ?></td>
  </tr>
  <tr class="imprimir">
    <td width="163" align="center">EJEMPLAR</td>
    <td colspan="2" align="center">APUESTA</td>
    <td width="171" align="center">MONTO</td>
  </tr>
  <?php
  $montoapagar=0; $montocobrar = 0; $ip=$row_Recordset1['ip_venta'];
  do { ?>
  <tr  class="apuestajugada">
    <td align="center">
        <?php echo $row_Recordset1['num_caballo']; ?>
       
    <td colspan="2" align="center"><?php echo ObtenerNombreApuesta($row_Recordset1['cod_tventa']); ?></td>
    <td align="right"><?php echo number_format($row_Recordset1['mon_venta'], 2, ",", "."); ?></td>
    <?php
        $montoapagar = $montoapagar+$row_Recordset1['mon_venta'];
        $montocobrar = $montocobrar+$row_Recordset1['pag_premio'];
        ?>
  </tr>
  <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
  <tr>
    <td class="imprimirnroticket" height="8" colspan="4" align="right"><p><span class="imprimir">-------------------- <br/>
          <strong><?php echo "Total: Bs:".number_format($montoapagar, 2, ",", "."); ?></strong></span></p>
      <p><span class="imprimir"><?php echo $estado; ?></span></p>
      <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td height="10" colspan="4" align="left">
    </td>  
    </tr>
    </table>
    </div>
    <div id="opciones" style="width:300px; height:300px;float:left; text-align:left; height:585px;
    	padding:5px; border-style: solid;">
        <font size="+2">MODIFICAR DATOS</font><hr>
    	PASO #1: Indique nuevo status del ticket en caso de que este sea ganador:<br/>
      <form name="form2" id="form2" method="post" onsubmit="return chequearEnvio();">
		<select name="est_ticket" id="est_ticket" style="width:240px; height: auto" class="textbox" tabindex="4"> 
			<option value="2">GANADOR (status 2)</option>
			<option value="1">NORMAL (status 1)</option>
    		<option value="4">RETIRADO (status 4)</option>
			<option value="5">DEVOLUCION (status 5)</option>
			<option value="6">STATUS SEGUN PREMIO</option>
		</select>
        <br/><br/>
    	PASO #2: click PROCESAR JUGADA para iniciar:<br/>
		<input name="calcular" type="button" id="calcular"
                  	style="width:200px; height:40px; font-size:16px;"  tabindex="50" value="PROCESAR JUGADA" />
        <input type="hidden" name="recordID" id="recordID" value="<?php echo $xTicket_Recordset1; ?>">
        </form>
        <div id="resultado" style="float:left; text-align:left; padding:20px 0px 0px 0px"> 
        </div>
	</div>
</body>
</html>
<?php
mysqli_free_result($Recordset1);
?>