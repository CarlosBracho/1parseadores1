<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "G"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xTicket = "0";
$navegador=detect();
if (isset($_GET["recordID"])) {
    $xTicket = $_GET["recordID"];
}
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 new\agente_hnac\revistaticket_hnac.php - QUERY 1 */ SELECT * 
			FROM
				agencia,
				usuario,
				taquilla,
				taquilla_opc_hnac,
				venta_hnac,
				carrera_hnac,
				hipodromo_hnac
			WHERE
				taquilla.cod_agencia = agencia.cod_agencia AND
				taquilla_opc_hnac.cod_taquilla = taquilla.cod_taquilla AND
				usuario.id_usuario = venta_hnac.id_usuario AND
				usuario.cod_taquilla = taquilla.cod_taquilla AND
				venta_hnac.cod_carrera_hnac = carrera_hnac.cod_carrera_hnac AND
				carrera_hnac.cod_hipodromo_hnac = hipodromo_hnac.cod_hipodromo_hnac AND
				venta_hnac.ticket_hnac = %s AND
				agencia.cod_agencia = %s
			ORDER BY venta_hnac.cod_tventa_hnac",
    GetSQLValueString($xTicket, "int"),
    GetSQLValueString($_SESSION['MM_cod_agente'], "int")
);
$Recordset1 =mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../estilo/twoColFixLtHdr.css" rel="stylesheet" type="text/css" />
<title>.:Apuestas Hípicas:.</title>
<script language="JavaScript">
function GetIEVersion(){
	var e=window.navigator.userAgent,t=e.indexOf("MSIE");
	return t>0?parseInt(e.substring(t+5,e.indexOf(".",t))):navigator.userAgent.match(/Trident\/7\./)?11:0;
}
function doprint2(){
	var el = document.getElementById("noprint");
	el.style.display = (el.style.display == 'none') ? 'block' : 'none';
	document.getElementById("printtitle");
	window.print("printtitle");
	el.style.display = (el.style.display == 'none') ? 'block' : 'none';
}
if("Microsoft Internet Explorer"==navigator.appName||GetIEVersion()>0)
document.write('<object id="factory" classid="clsid:1663ed61-23eb-11d2-b92f-008048fdd814" codebase="ScriptX.cab#Version=6,5,439,72"></object>');
</script>
<script language="vbscript">
function doPrint1()
	document.all.item("noprint").style.display="none"
	document.all.item()
	with factory.printing
	.header = ""
	.footer = ""
	.topMargin = 0.4
	.bottomMargin = 0.4
	.leftMargin = 0.4
	.rightMargin = 0.4
	.Print(false)
	end with
	document.all.item("noprint").style.display=""
end function
</script>
</head>
<html>
<script language="JavaScript">document.write("Microsoft Internet Explorer"==navigator.appName||GetIEVersion()>0?'<body onload="javascript:document.all.cmdPrint.focus();">':"<body>");</script>
<?php
if ($totalRows_Recordset1>0) {
    $serial=$row_Recordset1['ser_venta_hnac'];
    $estadoCodBarra=$row_Recordset1['cod_barra'];
    $rest = substr($serial, 0, 2);
    $rest = $rest.$xTicket;
    $mar=$row_Recordset1['anc_ticket_hnac']*40;
    $largo=$row_Recordset1['lar_ticket_hnac']+1;
    
    echo '<div id="printtitle" align="left" style="margin: 0px">'; ?>
        <table width="<?php echo 225-$mar; ?>" border="0" align="left">
          <tr align="center">
            <th colspan="4" class="imprimir" scope="col"><?php echo $row_Recordset1['nom_taquilla']; ?></th>
          </tr>
          <tr align="center">
            <th colspan="4" class="imprimir" scope="col">-COPIA-</th>
          </tr>
          <tr>
            <td colspan="4" align="center" class="imprimir">Fecha: <?php echo fechanueva($row_Recordset1['fec_venta_hnac']); ?></td>
          </tr>
          <tr>
            <td colspan="4" align="center" class="imprimir">Hora: <?php echo horaampm($row_Recordset1['hor_venta_hnac']); ?></td>
          </tr>
          <tr>
            <td colspan="4" align="center" class="imprimirnroticket">Ticket: <?php echo $row_Recordset1['ticket_hnac']; ?></td>
          </tr>
          <tr>
            <td colspan="4" align="center" class="imprimirnroticket">Cod. pago: <?php echo $rest; ?></td>
          </tr>
          <tr>
            <td colspan="4" align="center" class="imprimir">
            	Vendedor: <?php echo $row_Recordset1['nom_usuario']; ?> 
                #:<?php echo $row_Recordset1['can_ticket_hnac']; ?>
            </td>
          </tr>
          <tr>
            <td colspan="4" align="center" class="apuestajugada">
				<?php echo "  ".$row_Recordset1['nom_hipodromo_hnac']." Carr...".$row_Recordset1['num_carrera_hnac']; ?>
            </td>
          </tr>
          <tr class="imprimir">
            <td width="0" align="center">EJEM</td>
            <td colspan="2" align="center">APUESTA</td>
            <td width="0" align="center">MONTO</td>
          </tr>
          
          <?php
          $montoapagar=0;
    $ip=$row_Recordset1['ip_venta_hnac'];
    do { ?>
          <tr  class="apuestajugada">
            <td align="center">
                <?php echo $row_Recordset1['num_caballo_hnac']; ?>
               
            <td colspan="2" align="center"><?php echo ObtenerNombreApuesta($row_Recordset1['cod_tventa_hnac']); ?></td>
            <td align="right">
				<?php
                    $ley="";
                    if ($row_Recordset1['cod_tventa_hnac']>=7 && $row_Recordset1['cod_tventa_hnac']<=9) {
                        if ($row_Recordset1['cod_tventa_hnac']==7) {
                            $fact=2;
                        }
                        if ($row_Recordset1['cod_tventa_hnac']==8) {
                            $fact=6;
                        }
                        if ($row_Recordset1['cod_tventa_hnac']==9) {
                            $fact=24;
                        }
                        $montoVenta=$row_Recordset1['mon_venta_hnac']/$fact;
                        $ley="c/u";
                    } else {
                        $montoVenta=$row_Recordset1['mon_venta_hnac'];
                    }
                    echo $ley.number_format($montoVenta, 2, ",", ".");
                ?>
            </td>
            <?php $montoapagar = $montoapagar+$row_Recordset1['mon_venta_hnac']; ?>
          </tr>
          <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
          <tr>
            <td class="imprimirnroticket" height="8" colspan="4" align="right">
            <p><strong><?php echo "Total: Bs:".number_format($montoapagar, 2, ",", "."); ?></strong></p></td>
          </tr>
          <tr>
            <td colspan="4" align="center">-COPIA-</td>
          </tr>
          <tr>
            <td colspan="4" align="center" class="imprimir">CARRERAS NACIONALES</td> 
          </tr>          
          <tr>
            <td colspan="4" align="center">
				<?php
                if ($estadoCodBarra==1) {
                    $rest = substr($serial, 0, 2);
                    $rest = $rest.$xTicket_Recordset1;
                    echo "<img src='../includes/barcode2.php?s=code128&wq=4&d=".$rest."'>";
                } ?>
            </td>            
          <tr>
            <td height="10" colspan="4" align="left">IP: <?php echo $ip; ?></td>
          </tr>
          <tr>
            <td height="10" colspan="4" align="left">
            <DIV id="noprint" align="center" style="float:left; width: auto;">
                <DIV align="center">
                    <form name="form1">
                    <input style="FONT-STYLE: normal; FONT-FAMILY: 'MS Sans Serif'; FONT-SIZE: 15px; FONT-WEIGHT: normal" id="cmdPrint" class="boton"  <?php if ($navegador['browser']=="IE") {
                    echo 'onclick="doprint1()"';
                } else {
                    echo 'onclick="doprint2()"';
                } ?> name="cmdPrint" value="Imprimir" type="button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <A onclick=window.close() href="#"><FONT color=#1b007f><SPAN style="FONT-SIZE: 16pt"><B>Cerrar</B></FONT></A>
	                 </form>
                </DIV>
            </DIV>
            
            </td>
          </tr>
          <?php for ($i = 1; $i < $largo; ++$i) {?>
          <tr>
            <td height="10" colspan="4" align="left">&nbsp;</td>
          </tr>
          <?php } ?>
          <tr>
            <td height="10" colspan="4" align="left">_&nbsp;</td>
          </tr>
     </table>
    <?php
    echo "</div>";
} else {
        echo "No se produjo ningún resultado";
    } ?>
</body>
</html>
<?php
mysqli_free_result($Recordset1);
?>