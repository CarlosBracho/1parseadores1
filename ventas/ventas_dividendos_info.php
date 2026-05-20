<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xcarrera_Recordset1 = "-1";
if (isset($_GET["recordID"])) {
    $xcarrera_Recordset1 = $_GET["recordID"];
}

$query_Recordset1 = sprintf(
    "/* PARSEADORES1 ventas\ventas_dividendos_info.php - QUERY 1 */ SELECT *
FROM 
carrera 
WHERE 
carrera.cod_carrera = %s",
    GetSQLValueString($xcarrera_Recordset1, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

$query_Recordset2 = sprintf(
    "/* PARSEADORES1 ventas\ventas_dividendos_info.php - QUERY 2 */ SELECT * FROM retirados WHERE retirados.cod_carrera = %s",
    GetSQLValueString($xcarrera_Recordset1, "int")
);
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
$retirados="";
if ($totalRows_Recordset2>0) {
    do {
        $retirados=$retirados."-".$row_Recordset2['num_rcaballo'];
    } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseVentas2.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>.:Apuestas Hípicas:.</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<link href="../estilo/twoColFixLtHdr.css" rel="stylesheet" type="text/css" />
</head>

<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="content5">
	<!-- InstanceBeginEditable name="Contenido" -->
   <div style="background: #333; width:100%; float:left; padding:50px 2px 2px 2px;
   		border-radius: 10px 10px 0px 0px; color:#FFF; font-size:28px; text-align:center">
        INFORMACIÓN DE DIVIDENDOS
   </div><!-- end .container -->
   <div style="width:100%; float:left; padding:15px 0px 0px 10px;color:#000; font-size:24px; text-align: left;">
        <?php  echo " HIPÓDROMO: ".$row_Recordset1['nom_hipodromo']." Carr: ...".$row_Recordset1['num_carrera']; ?>
   </div><!-- end .container -->
   <div style="background: #333; width:98.1%; float:left;color:#FFF; font-size:18px; text-align: left;
   		padding:10px 0px 10px 10px;margin:0px 0px 0px 5px;">
		<?php  echo "FECHA Y HORA DE CIERRE ".fechanueva($row_Recordset1['fec_carrera'])." - "; ?> 
		<?php echo horaampm($row_Recordset1['hor_carrera']); ?>
   </div><!-- end .container -->
   <div style="background: #333; width:5.3%; float:left;color:#FFF; font-size:11px; text-align:center; margin:0px 0px 0px 5px;
   padding:44px 0px 2px 0px;">
		Orden
   </div><!-- end .container -->
   <div style="background: #333; width:28.2%; float:left;color:#FFF; font-size:18px; text-align:center;
   padding:10px 0px 0px 0px;">
		Carrera Simple
   </div><!-- end .container -->
   <div style="background: #333; width:31.5%; float:left;color:#FFF; font-size:18px; text-align:center;
   padding:10px 0px 0px 0px;">
   		Carrera Doble Empate
   </div><!-- end .container -->
   <div style="background:#333; width:34.36%; float:left;color:#FFF; font-size:18px; text-align:center;
   padding:10px 0px 0px 0px;">
   		Carrera Triple Empate
   </div><!-- end .container -->
   <div style="background: #5EAEFF; width:28.2%; float:left;color:#FFF; font-size:15px; text-align:center;
   padding:10px 0px 0px 0px; margin:0px 0px 0px 0px; word-spacing:17px;">
		LLEGADA GAN PLA SHW
   </div><!-- end .container -->
   <div style="background: #5EAEFF; width:31.5%; float:left;color:#FFF; font-size:15px; text-align:center;
   padding:10px 0px 0px 0px; word-spacing:16px;">
   		LLEGADA GAN PLA SHW
   </div><!-- end .container -->
   <div style="background:#5EAEFF; width:34.36%; float:left;color:#FFF; font-size:15px; text-align:center;
   padding:10px 0px 0px 0px;word-spacing:26px;">
   		LLEGADA GAN PLA SHW
   </div><!-- end .container -->
<div style="padding:0px 0px 0px 1px; margin:0px 0px 0px 3px; width:100%; float:left">   
     <table border="0" align="center" width="99.99%">
      <tr align="center" style="color:#000">
        <td width="5%" bgcolor="#333333" style="color:#FFF; font-size:11px" ><strong>1er Lugar:</strong></td>
        <td width="10%" bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['eje_primero']; ?></strong></td>
        <td width="7%" bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_primero_gan']; ?></strong></td>
        <td width="6%" bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_primero_pla']; ?></strong></td>
        <td width="6%" bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_primero_sho']; ?></strong></td>
        <td width="1%">&nbsp;</td>
        <td width="10%" bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['eje_doble_primero']; ?></strong></td>
        <td width="7%" bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_doble_primero_gan']; ?></strong></td>
        <td width="6%" bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_doble_primero_pla']; ?></strong></td>
        <td width="7%" bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_doble_primero_sho']; ?></strong></td>
        <td width="1%">&nbsp;</td>
        <td width="11%" bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['eje_triple_primero']; ?></strong></td>
        <td width="8%" bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_triple_primero_gan']; ?></strong></td>
        <td width="8%" bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_triple_primero_pla']; ?></strong></td>
        <td width="7%" bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_triple_primero_sho']; ?></strong></td>
      </tr>
      <tr align="center" style="color:#000">
        <td bgcolor="#333333" style="color:#FFF; font-size:11px"><strong>2do Lugar:</strong></td>
        <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['eje_segundo']; ?></strong></td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_segundo_pla']; ?></strong></td>
        <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_segundo_sho']; ?></strong></td>
        <td>&nbsp;</td>
        <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['eje_doble_segundo']; ?></strong></td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_doble_segundo_pla']; ?></strong></td>
        <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_doble_segundo_sho']; ?></strong></td>
        <td>&nbsp;</td>
        <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['eje_triple_segundo']; ?></strong></td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_triple_segundo_pla']; ?></strong></td>
        <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_triple_segundo_sho']; ?></strong></td>
      </tr>
      <tr align="center" style="color:#000">
        <td bgcolor="#333333" style="color:#FFF; font-size:11px"><strong>3er Lugar:</strong></td>
        <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['eje_tercero']; ?></strong></td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_tercero_sho']; ?></strong></td>
        <td>&nbsp;</td>
        <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['eje_doble_tercero']; ?></strong></td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_doble_tercero_sho']; ?></strong></td>
        <td>&nbsp;</td>
        <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['eje_triple_tercero']; ?></strong></td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_triple_tercero_sho']; ?></strong></td>
      </tr>
      <tr align="center" style="color:#000">
        <td bgcolor="#333333" style="color:#FFF; font-size:11px"><strong>4to Lugar:</strong></td>
        <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['eje_cuarto']; ?></strong></td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td>&nbsp;</td>
        <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['eje_doble_cuarto']; ?></strong></td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td>&nbsp;</td>
        <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['eje_triple_cuarto']; ?></strong></td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
      </tr>
    </table>    
    <p style="margin:10px; text-align:left; font-size:16px">
        <?php if ($totalRows_Recordset2>0) {
    echo "Ejemplares retirados: ".$retirados;
} else {
                echo "Ejemplares retirados: NINGUNO";
            }
        ?>
    </p>
    <p><a href="ventas_historial_lista.php">Volver</a></p>
</div> 
  <!-- InstanceEndEditable -->
</div><!-- end .container -->
</body>
<!-- InstanceEnd --></html>
<?php
mysqli_free_result($Recordset1);
?>