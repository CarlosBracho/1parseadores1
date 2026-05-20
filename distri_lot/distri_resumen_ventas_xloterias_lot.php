<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "D"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$menE="";
$fechahoyi=fechaactualbd();
$fechahoyf=fechaactualbd();
$osorteo=array();
$agencia=array();
$xCodigo = $_SESSION['MM_cod_banca'];
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if (isset($_POST["MM_inserto"])&&$_POST["MM_inserto"]=="formo"&&isset($_POST["buscar"])) {
    if (isset($_POST["od_sorteo"])&&isset($_POST["od_agencia"])&&isset($_POST["fechai"])&&isset($_POST["fechaf"])) {
        if ($_POST["fechai"]<$_POST["fechaf"]) {
            $fechahoyi=fechaymd($_POST["fechaf"]);
            $fechahoyf=fechaymd($_POST["fechai"]);
        } else {
            $fechahoyi=fechaymd($_POST["fechai"]);
            $fechahoyf=fechaymd($_POST["fechaf"]);
        }
        $osorteo=$_POST["od_sorteo"];
        $agencia=$_POST["od_agencia"];
        $xsorteo = implode("','", $_POST["od_sorteo"]);
        $xgencia = implode("','", $_POST["od_agencia"]);
        $query_Recordset1 = sprintf(
            "/* PARSEADORES1 distri_lot\distri_resumen_ventas_xloterias_lot.php - QUERY 1 */ SELECT 
			lo.nom_loteria, lo.id_triple, nom_sorteo, lo.id_sorteo, 
			SUM(mon_apuesta_lot) AS ven_triple,
			CASE lo.tip_loteria
				WHEN 1 THEN (/* PARSEADORES1 distri_lot\distri_resumen_ventas_xloterias_lot.php - QUERY 2 */ SELECT SUM(mon_apuesta_lot) FROM venta_lot ven WHERE ven.id_loteria=lo.id_terminal AND
					us.id_usuario=ve.id_usuario)
				WHEN 3 THEN (/* PARSEADORES1 distri_lot\distri_resumen_ventas_xloterias_lot.php - QUERY 3 */ SELECT SUM(mon_apuesta_lot) FROM venta_lot ven WHERE ven.id_loteria=lo.id_terminal AND
					us.id_usuario=ve.id_usuario)
				WHEN 4 THEN '0'
				WHEN 5 THEN '0'
				WHEN 6 THEN '0'
			END AS ven_terminal
			FROM
				bancaloterias bl,
				agencialoterias al,
				sorteos so,
				agencia ag,
				usuario us
			LEFT JOIN loterias lo ON lo.id_sorteo IN ('$xsorteo') AND lo.tip_loteria!=2 
			LEFT JOIN taquilla ta ON ta.cod_agencia IN ('$xgencia') AND us.cod_taquilla = ta.cod_taquilla
			LEFT JOIN venta_lot ve ON us.id_usuario = ve.id_usuario AND ve.est_ticket_lot > 0 AND
				ve.id_loteria = lo.id_loteria AND ve.fec_venta_lot >= %s AND ve.fec_venta_lot <= %s 
			WHERE
			so.id_sorteo = lo.id_sorteo AND
			bl.id_banca = ag.cod_banca AND
			al.id_agencia = ag.cod_agencia AND
			lo.est_loteria=1 AND
			bl.est_banlot = 1 AND bl.id_loteria = lo.id_loteria AND
			al.est_agelot=1 AND al.id_loteria = lo.id_loteria AND 
			ag.cod_agencia = ta.cod_agencia AND ag.cod_banca = %s
			GROUP BY lo.id_loteria",
            GetSQLValueString($fechahoyi, "date"),
            GetSQLValueString($fechahoyf, "date"),
            GetSQLValueString($xCodigo, "int")
        );
        $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
        $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
        $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    } else {
        if (!isset($_POST["od_sorteo"])) {
            $osorteo=array();
            $menE.="&nbsp;&nbsp;SELECCIONE SORTEO &nbsp;&nbsp;<br/>";
            $c++;
        }
        if (!isset($_POST["od_agencia"])) {
            $agencia=array();
            $menE.="&nbsp;&nbsp;SELECCIONE AGENTE &nbsp;&nbsp;<br/>";
            $c++;
        }
        if (!isset($_POST["fechai"])) {
            $fechahoyi=fechaactualbd();
            $menE.="&nbsp;&nbsp;INDIQUE FECHA&nbsp;&nbsp;<br/>";
        }
        if (!isset($_POST["fechaf"])) {
            $fechahoyf=fechaactualbd();
            $menE.="&nbsp;&nbsp;INDIQUE FECHA&nbsp;&nbsp;<br/>";
        }
        $menE.="&nbsp;&nbsp;BUSQUEDA NO REALIZADA&nbsp;&nbsp;<br/>";
    }
}
$query_Recordset3 =  sprintf("/* PARSEADORES1 distri_lot\distri_resumen_ventas_xloterias_lot.php - QUERY 4 */ SELECT so.id_sorteo, so.nom_sorteo
	FROM loterias lo, sorteos so, bancaloterias bl
	WHERE ((lo.tip_loteria = 1 OR lo.tip_loteria>=3) AND lo.est_loteria=1) AND 
	so.id_sorteo = lo.id_sorteo  AND so.est_sorteo=1 AND bl.id_loteria = lo.id_loteria AND bl.est_banlot = 1
	GROUP BY so.id_sorteo
	ORDER BY lo.nom_loteria ASC");
$Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);
$query_Recordset4 =  sprintf(
    "/* PARSEADORES1 distri_lot\distri_resumen_ventas_xloterias_lot.php - QUERY 5 */ SELECT ag.cod_agencia, ag.nom_agencia 
	FROM agencia ag, agencialoterias al, taquilla ta, taquilla_opc_lot tp 
	WHERE ag.cod_agencia = al.id_agencia AND ta.cod_agencia = ag.cod_agencia AND ta.cod_taquilla = tp.cod_taquilla AND
	ag.cod_banca = %s
	GROUP BY ag.cod_agencia
	ORDER BY ag.nom_agencia ASC",
    GetSQLValueString($xCodigo, "int")
);
$Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<style>
  .textbox, .textboxsmal {
  border: 1px solid #DBE1EB;
  font-size: 16px;
  font-family: Arial, Verdana;
  padding-left: 7px;
  padding-right: 7px;
  padding-top: 10px;
  padding-bottom: 10px;
  border-radius: 4px;
  -moz-border-radius: 4px;
  -webkit-border-radius: 4px;
  -o-border-radius: 4px;
  background: #FFFFFF;
  background: linear-gradient(left, #FFFFFF, #F7F9FA);
  background: -moz-linear-gradient(left, #FFFFFF, #F7F9FA);
  background: -webkit-linear-gradient(left, #FFFFFF, #F7F9FA);
  background: -o-linear-gradient(left, #FFFFFF, #F7F9FA);
  color: #2E3133;
  height:24px;
  }
  .textbox:focus, .textboxsmal:focus {color:#2E3133;border-color:#FBFFAD;}
  .textboxsmal {width:80px;height:8px;}
 </style>
<!--[if lte IE 7]>
<link type="text/css" rel="stylesheet" media="all" href="../css/screen_ie.css" />
<![endif]-->
<style>
body {
	background-color: #eeeeee;
	padding:0;
	margin:0 auto;
	font-family:"Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
	font-size:11px;
}
</style>
<link href="../estilo/admin.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="../css/tcal.css" />
<script type="text/javascript" src="../js/tcal.js"></script>
<script type="text/javascript" src="../admin_lot/jslot/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="../admin_lot/jslot/bootstrap.min.js"></script>
<script type="text/javascript" src="../admin_lot/jslot/multiselect.js"></script>
<script>
 $(document).ready(function() {$("#reloj").load('../includes/reloj.php?&js='+Math.random());var refreshId1 = setInterval(function() {$("#reloj").load('../includes/reloj.php?&js='+Math.random());}, 60000);$('#divE').fadeOut(12000);
 	$('#od_sorteo, #od_agencia').multiselect({
		includeSelectAllOption: true, // add select all option as usual
		enableCaseInsensitiveFiltering: true, numberDisplayed: 1, buttonWidth: 250, maxHeight: 400,
		optionClass: function(element) {
			var value = $(element).val();
			if (value%2 == 0) { return 'odd'; }
			else { return 'even'; }
		}
	});
	$( "#od_sorteo, #od_agencia" ).change(function() {
		if ($("#od_sorteo option:selected").text()=="" || $("#od_agencia option:selected").text()=="") 
			$("#buscar").attr('disabled','disabled'); else $("#buscar").removeAttr('disabled');
	});
	if ($("#od_sorteo option:selected").text()=="" || $("#od_agencia option:selected").text()=="") 
	$("#buscar").attr('disabled','disabled'); else $("#buscar").removeAttr('disabled');
	
 });
var statusEnvio = false;
function chequearEnvio() {
    if (!statusEnvio) { statusEnvio = true;
        return true;
    } else { alert("El formulario ya está siendo enviado, por favor aguarde un instante.");
        return false;
    }
}
function ocultaDiv(elemento) {
	document.getElementById(elemento).style.display = "none";
}
</script>
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
	<div class="header" style="height:100px; background:#0084B4">
		<?php include("../includes/cabeceraamericana_di.php");?>
		<div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
			<div class="triangulo_sup" style=" margin:0px 0px 0px 205px"></div>
			<div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
				position:absolute;border-radius: 0px 0px 5px 5px;">
				<?php include("../includes/cabeceradistri_lot.php");?>
			</div>
		</div> <!-- end .menu -->
	</div> <!-- end .header -->
	<div style="background:#0084B4; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" 
		id="datosUsuario">
		<div style="background:#0084B4;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
			margin:20px 0px 0px 0px; width:240px; font-size:16px"> 
			RESUMEN DE VENTAS POR SORTEOS<br/>
		</div>
		Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
		<span id="reloj"></span>
	</div>
	<div class="contentAdmin">
		<div style="padding:5px 0px; float:right; color:#FFFFFF;background:#FF9A9C;font-size:22px;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;border-radius: 5px 5px 5px 5px;-moz-border-radius: 5px 5px 5px 5px;-webkit-border-radius: 5px 5px 5px 5px;border: 0px solid #000000; margin:5px" id="divE">
			<?php echo $menE; ?>   
		</div>
		<div style="padding:70px 10px 20px 10px; text-align:left; font-size:18px; height: auto;">
			<div style="width:920px; text-align:left; font-size:17px; background: #E1E1E1">
				<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
					<tr valign="baseline">
						<td height="42" colspan="3" align="center" valign="middle" nowrap 
							style="background:#333333;font-size:24px;color:#FFF">
							<strong>RESUMEN DE VENTAS POR SORTEOS</strong>
						</td>
					</tr>
					<tr valign="baseline" style="border-bottom:1px solid  #D5D5D5; background:#D5D5D5; text-align:center">
						<form action="<?php echo $editFormAction; ?>" method="POST" name="formo" id="formo" 
                                autocomplete="off" onsubmit="return chequearEnvio();">
							<td width="35%" height="30" align="left" valign="bottom" nowrap 
								style="font-size:16px;color:#000; padding:0 0 0 10px;">
                                    <div style="float:left; padding:0;">
                                    SELECCIONE SORTEOS:
                                    </div>
                                    <div style="float:left; margin:0;">
                                    <select multiple="multiple" name="od_sorteo[]" id="od_sorteo"
                                        style="height:50px; font-size:16px;margin:2px 0 2px 10px;float:left;"><?php
                                        do {?>
                                            <option value="<?php echo $row_Recordset3['id_sorteo']?>" 
											<?php if (in_array($row_Recordset3['id_sorteo'], $osorteo)) {
                                            echo"selected=\"selected\"";
                                        }?>>
                                            <?php echo $row_Recordset3['nom_sorteo']; ?></option><?php
                                        } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));?>
                                    </select>
									</div>
							</td>
							<td width="35%" align="left" valign="bottom" nowrap>
                                    <div style="float:left; padding:0;">
                                        SELECCIONE AGENTE:
                                    </div>
                                    <div style="float:left;">
                                    <select multiple="multiple" name="od_agencia[]" id="od_agencia"
                                        style="height:50px; font-size:16px;margin:2px 0 2px 10px;float:left;"><?php
                                        $ag="AGENTES: ";
                                        do {?>
                                            <option value="<?php echo $row_Recordset4['cod_agencia']?>" 
											<?php if (in_array($row_Recordset4['cod_agencia'], $agencia)) {
                                            echo"selected=\"selected\"";
                                        }?>>
                                            <?php echo $row_Recordset4['nom_agencia'];?></option><?php
                                            if (isset($totalRows_Recordset1) && $totalRows_Recordset1>0) {
                                                $ag.="-". $row_Recordset4['nom_agencia'];
                                            }
                                        } while ($row_Recordset4 = mysqli_fetch_assoc($Recordset4));?>
                                    </select>
                                    </div>
							</td>
							<td width="30%" align="left" valign="bottom" nowrap 
									style="color:#000000;">
                                    <div style="float:left; margin:4px 0 0 68px; font-size:11px; height:14px">DESDE:</div>
                                    <div style="float:left;margin:4px 0 0 78px;font-size:11px;height:14px">HASTA:</div>
                                    <br/>
									FECHA:
									<input name="fechai" type="text" id="dateArrival1" tabindex="0" 
										style="width:90px; font-size:16px; height:19px; margin:2px 0 2px 0"
										title="fecha inicio. formato: dd-mm-aaaa" class="tcal" 
										value="<?php echo htmlentities(fechanueva($fechahoyi), ENT_COMPAT, 'utf-8'); ?>"/>
									<input name="fechaf" type="text" id="dateArrival1" tabindex="0" 
										style="width:90px; font-size:16px; height:19px; margin:2px 0 2px 0"
										title="fecha fin. formato: dd-mm-aaaa" class="tcal" 
										value="<?php echo htmlentities(fechanueva($fechahoyf), ENT_COMPAT, 'utf-8'); ?>"/>
									<input type="submit" value="Buscar" class="btn btn-primary" 
                                    	id="buscar" name="buscar" title="iniciar busqueda" 
										style="width:80px; height:30px" disabled="disabled"/>
                                    <input type="hidden" name="MM_inserto" value="formo"/>
							</td>
							<input type="hidden" name="MM_update2" value="form2" />
							<input type="hidden" name="MM_inserto" value="formo"/>
							<input type="hidden" name="fec_filtro" value="<?php echo $fechahoy?>"/>
						</form>
					</tr>
				</table>
                
			</div>
            <div id="mostrar" style="width:100%; float:left; border-top: 1px solid #C1BDBE;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;"><?php
                if (isset($totalRows_Recordset1) && $totalRows_Recordset1>0) {?>
                	<div style="width:100%; float:left; padding:0; overflow:auto;overflow-x:hidden;">
							<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:16px;">
                                <tr align="center" style="line-height: 1;">
                                    <td height="48" colspan="4" valign="bottom"><?php
                                        echo '<font size="2">'.$ag.'-</font><br/>';
                                        echo '<font size="3">RESUMEN DE VENTAS POR SORTEOS DESDE:'.fechanueva($fechahoyi).' ';
                                        echo 'HASTA:'.fechanueva($fechahoyf).'</font>';
                                        ?>
                                    </td>
                                </tr>

                              <tr align="center" valign="bottom" style="background: #DBDBDB;line-height: 1">
                                    <td height="26">LOTERIA</td>
									<td>TOTAL TRIPLE</td>
                                    <td>TOTAL TERMINAL</td>
                                    <td>TOTAL VENTAS</td>
                                </tr><?php
                                $totalTr=0;
                                $totalTe=0;
                                do {?>
                                    <tr style="font-size:12px;">
                                        <td bgcolor="#FFFFFF" width="25%" style="font-size:11px;padding:0 0 0 5px">
                                            <?php echo $row_Recordset1['nom_loteria'];?>
                                        </td>
                                        <td bgcolor="#EAEAEA" width="25%" style="text-align:right"><?php
                                            if ($row_Recordset1['ven_triple']>0) {
                                                echo "<strong>";
                                            }
                                            echo number_format($row_Recordset1['ven_triple'], 2, ",", ".");
                                            if ($row_Recordset1['ven_triple']>0) {
                                                echo "</strong>";
                                            }?>
                                        </td>
                                      <td bgcolor="#F3F3F3" width="25%" style="text-align:right"><?php
                                        if ($row_Recordset1['ven_terminal']>0) {
                                            echo "<strong>";
                                        }
                                        echo number_format($row_Recordset1['ven_terminal'], 2, ",", ".");
                                        if ($row_Recordset1['ven_terminal']>0) {
                                            echo "</strong>";
                                        }?>
									  </td>
                                      <td bgcolor="#CCCCCC" width="25%" style="text-align:right;padding:0 5px 0 0"><?php
                                      if ($row_Recordset1['ven_triple']+$row_Recordset1['ven_terminal']>0) {
                                          echo "<strong>";
                                      }
                                      echo number_format($row_Recordset1['ven_triple']+$row_Recordset1['ven_terminal'], 2, ",", ".");
                                      if ($row_Recordset1['ven_triple']+$row_Recordset1['ven_terminal']>0) {
                                          echo "</strong>";
                                      }
                                      ?>
                                        </td>
                                    <tr><?php
                                    $totalTr=$totalTr+$row_Recordset1['ven_triple'];
                                    $totalTe=$totalTe+$row_Recordset1['ven_terminal'];
                                    
                                } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));?>
                                <tr align="right" style="background: #DBDBDB;line-height: 1;font-weight: bold;">
                                    <td height="18">TOTALES:</td>
                                    <td><?php echo number_format($totalTr, 2, ",", ".");?></td>
                                    <td><?php echo number_format($totalTe, 2, ",", ".");?></td>
                                    <td><?php echo number_format($totalTr+$totalTe, 2, ",", ".");?></td>
                                </tr>
							</table>
                    </div>
                <?php
                } else {
                    echo '<div style="text-align:center;padding:120px 0 150px 0;font-size:20px;background:#FEFCE7;color:#A6A6A6">';
                    if (isset($totalRows_Recordset1)) {
                        echo 'NO SE PRODUJO NINGUN RESULTADO';
                    } else {
                        echo 'SELECCIONE SORTEOS, ELIJA AGENTES, INDIQUE RANGO DE FECHA<br/>Y PRESIONE EL BOTON BUSCAR';
                    }
                    echo '</div>';
                }?>
            </div>
		</div>
	</div>
	<div class="footer" style="background:#0084B4">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
</div>
</body>
</html>
<?php
if (isset($Recordset1)) {
                    mysqli_free_result($Recordset1);
                }
if (isset($Recordset2)) {
    mysqli_free_result($Recordset2);
}
?>