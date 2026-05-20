<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xTicket_Recordset1=0;
$usuario_venta=0;
if (isset($_GET["recordID"]) && isset($_GET["uVenta"])) {
    $xTicket_Recordset1 = $_GET["recordID"];
    $usuario_venta = $_GET["uVenta"];
} else {
    $xTicket_Recordset1 = $_POST["iD"];
    $usuario_venta = $_SESSION["MM_id_usuario"];
}
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 new\ventashnac_mie\t_imprimeticket.php - QUERY 1 */ SELECT 
venta_hnac.fec_venta_hnac, 
venta_hnac.hor_venta_hnac,
venta_hnac.ser_venta_hnac,
venta_hnac.can_ticket_hnac,
venta_hnac.num_caballo_hnac,
venta_hnac.ip_venta_hnac,
venta_hnac.ticket_hnac,
venta_hnac.cod_tventa_hnac,
venta_hnac.mon_venta_hnac,
venta_hnac.efectivoOn,
usuario.nom_completo,
usuario.nom_usuario,
usuario.cod_barra,
taquilla.nom_taquilla,
carrera_hnac.num_carrera_hnac,
carrera_hnac.hor_carrera_hnac,
hipodromo_hnac.nom_hipodromo_hnac,
taquilla_opc_hnac.anc_ticket_hnac,
taquilla_opc_hnac.lar_ticket_hnac,
taquilla_opc_hnac.tip_ticket_hnac,
taquilla_opc_hnac.tic_caduca_hnac
FROM 
venta_hnac,
carrera_hnac,
usuario,
taquilla,
hipodromo_hnac,
taquilla_opc_hnac 
WHERE
carrera_hnac.cod_hipodromo_hnac = hipodromo_hnac.cod_hipodromo_hnac AND
venta_hnac.ticket_hnac = %s AND
venta_hnac.id_usuario = %s AND
carrera_hnac.cod_carrera_hnac = venta_hnac.cod_carrera_hnac AND
usuario.id_usuario = venta_hnac.id_usuario AND
usuario.cod_taquilla = taquilla.cod_taquilla AND
taquilla_opc_hnac.cod_taquilla = taquilla.cod_taquilla
ORDER BY venta_hnac.cod_tventa_hnac, venta_hnac.num_caballo_hnac ASC",
    GetSQLValueString($xTicket_Recordset1, "int"),
    GetSQLValueString($usuario_venta, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$horacarrerabd=$row_Recordset1['hor_carrera_hnac'];
$tamletras=12;
if ($horacarrerabd<"23:55:00") {
    $aumento=$horacarrerabd."+5 min";
    $horacarrerabd=(date('H:i', strtotime($aumento)));
}
$cod=0;

$moneda=$row_Recordset1['efectivoOn'];


$GetIEVersion=0;
$info=detect2();

if (isset($info["version"])) {
} else {
    $info["version"]=11;
}
if ($info["version"]<=9 & $info["browser"]=='IE') {
    ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../estilo/twoColFixLtHdr.css" rel="stylesheet" type="text/css" />
<title>.:Apuestas Hípicas:.</title>
<script language="JavaScript">function GetIEVersion(){var e=window.navigator.userAgent,t=e.indexOf("MSIE");return t>0?parseInt(e.substring(t+5,e.indexOf(".",t))):navigator.userAgent.match(/Trident\/7\./)?11:0}function doprint2(e){document.getElementById(e);window.print(e)}("Microsoft Internet Explorer"==navigator.appName||GetIEVersion()>0)&&document.write('<object id="factory" classid="clsid:1663ed61-23eb-11d2-b92f-008048fdd814" codebase="ScriptX.cab#Version=6,5,439,72"></object>');</script>
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
<script language="JavaScript">document.write("Microsoft Internet Explorer"==navigator.appName||GetIEVersion()>0?'<body onload="javascript:document.all.cmdPrint.focus();">':"<body>");</script>
<?php
if ($horacarrerabd >= horaactual() && $row_Recordset1['fec_venta_hnac']==fechaactualbd() && $totalRows_Recordset1>0) {
        $serial=$row_Recordset1['ser_venta_hnac'];
        $estadoCodBarra=$row_Recordset1['cod_barra'];
        $rest = substr($serial, 0, 2);
        $rest = $rest.$xTicket_Recordset1;
        $largo=$row_Recordset1['lar_ticket_hnac']+1;
        $tipo=$row_Recordset1['tip_ticket_hnac'];
        $tic_caduca=$row_Recordset1['tic_caduca_hnac'];
        echo '<div id="printtitle" align="left" style="margin: 0px">';
        switch ($tipo) {
            case 0: include("ticket_hnac0.php"); break;
            case 1: include("ticket_hnac1.php"); break;
            case 2: include("ticket_hnac2.php"); break;
            case 3: include("ticket_hnac3.php"); break;
        }
        $cod=1;
        echo "</div>";
        $_SESSION['MM_mensaje2'] ="APUESTA REALIZADA CORRECTAMENTE!"; ?>
	<div id="noprint" align="center">
		<div align="left">
			<script language="JavaScript">"Microsoft Internet Explorer"==navigator.appName||GetIEVersion()>0?doprint1():doprint2("printtitle"),setTimeout("window.location='index.php'",10);</script>
	    </div>
    </div>
<?php
    } else {
        $cod=2;
        $_SESSION['MM_mensaje2'] ="No se produjo ningún resultado";
        echo "<p><h1>".$_SESSION['MM_mensaje2']."</h1></p>";
        echo '<p><a href="index.php">Volver a taquilla</a></p>';
    } ?>
</body>
</html>
<?php
mysqli_free_result($Recordset1);
} else {
    if ($horacarrerabd >= horaactual() && $row_Recordset1['fec_venta_hnac']==fechaactualbd() && $totalRows_Recordset1>0) {
        $serial=$row_Recordset1['ser_venta_hnac'];
        $estadoCodBarra=$row_Recordset1['cod_barra'];
        $rest = substr($serial, 0, 3);
        $tic_caduca=$row_Recordset1['tic_caduca_hnac']; ?>
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
<?php  echo "<div id='resultado2' style='line-height: 0.5em;'>"; ?>
<?php if ($row_Recordset1['tip_ticket_hnac']==0) { ?>
<font size="<?php echo $tamletras; ?>" face="Arial" >
        <table width="225" border="0" align="left">
          <tr>
            <th colspan="4" class="imprimir" scope="col"><?php echo $row_Recordset1['nom_taquilla']; ?></th>
          </tr>
          <tr>
            <th colspan="4" class="imprimir" scope="col">-ORIGINAL0-</th>
          </tr>
          <tr>
            <td colspan="4" align="center" class="imprimir">Fecha: <?php echo fechanueva($row_Recordset1['fec_venta_hnac']); ?></td>
          </tr>
          <tr>
            <td colspan="4" align="center" class="imprimir">Hora: <?php
$hora1=$row_Recordset1['hor_venta_hnac'];
$nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
$nuevahora1 = date('H:i:s', $nuevahora1);
echo horaampm($nuevahora1); ?></td>
          </tr>
          <tr>
            <td colspan="4" align="center" class="imprimirnroticket">Ticket: <?php echo $row_Recordset1['ticket_hnac']; ?></td>
          </tr>
          <tr>
            <td colspan="4" align="center" class="imprimirnroticket">Cod: <?php echo $rest; ?></td>
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
            <td width="163" align="center">EJEMPLAR</td>
            <td colspan="2" align="center">APUESTA</td>
            <td width="171" align="center">MONTO</td>
          </tr>
          
          <?php
          $montoapagar=0; $ip=$row_Recordset1['ip_venta_hnac'];
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
            <td class="imprimirnroticket" height="8" colspan="4" align="right">&nbsp;</td>
          </tr>
          <tr>
            <td class="imprimirnroticket" height="8" colspan="4" align="right"><p><strong><?php
if ($moneda<=2) {
                    echo "Total Bss:.".number_format($montoapagar, 2, ",", ".");
                }
if ($moneda==3) {
    echo "Total Usd:.".number_format($montoapagar, 2, ",", ".");
}
if ($moneda==4) {
    echo "Total Cop:.".number_format($montoapagar, 2, ",", ".");
}
if ($moneda==5) {
    echo "Total Sol:.".number_format($montoapagar, 2, ",", ".");
}
             ?></strong></p>


</td>
          </tr>

          <?php if ($tic_caduca>0) { ?>
          <tr>
            <td colspan="4" align="center"><?php echo "Ticket caduca a los ".$tic_caduca." dias";?></td>
          </tr>
          <?php }?>
          <tr><td colspan="4" align="center">-ORIGINAL0-</td></tr>
          <tr>
            <td colspan="4" align="center">
				<?php
                if ($estadoCodBarra==1) {
                    $rest = substr($serial, 0, 2);
                    $rest = $rest.$xTicket_Recordset1;
                    echo "<img src='../includes/barcode2.php?s=code-128&wq=4&p=3&ph=0&w=110&d=".$xTicket_Recordset1."'>";
                }?>          
	        </td>
          </tr>
          <tr>
            <td height="10" colspan="4" align="left">IP: <?php echo $ip; ?>  
            <tr>
            <td height="10" colspan="4" align="center">&nbsp;
	        </td>
          </tr>
          <?php $explorador = $_SERVER['HTTP_USER_AGENT'];
          if (preg_match('/MSIE/i', $explorador) && !preg_match('/Opera/i', $explorador)) {?>
              <tr>
                <td colspan="4" align="center">&nbsp;          
              <tr>
              <tr>
                <td colspan="4" align="center">&nbsp;          
              <tr>
              <tr>
                <td colspan="4" align="center">&nbsp;          
              <tr>
              <tr>
                <td colspan="4" align="center">&nbsp;          
              <tr>
              <tr>
                <td colspan="4" align="center">&nbsp;          
              <tr>
              <tr>
                <td colspan="4" align="center">.          
              <tr>
		  <?php }?>	          
     </table></font>
	 
	 <?php } //---- fin0?> 
	 
	 <?php if ($row_Recordset1['tip_ticket_hnac']==1) { ?>
	 <font size="<?php echo $tamletras; ?>" face="Arial" >
        <table width="225" border="0" align="left">
          <tr>
            <td colspan="4" class="imprimir" scope="col" align="left"><?php echo $rest2 = substr($row_Recordset1['nom_taquilla'], 0, 5); ?>-ORIG#:<?php echo $row_Recordset1['can_ticket_hnac']; ?></td>

          </tr>
          <tr>
            <td colspan="4"  align="left" class="imprimir"><?php echo $rest3 = substr(fechanueva($row_Recordset1['fec_venta_hnac']), 0, 6);
            $hora1=$row_Recordset1['hor_venta_hnac'];
$nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
$nuevahora1 = date('H:i:s', $nuevahora1);
echo horaampm($nuevahora1);
?></td>
          </tr>

          <tr>
            <td colspan="4" align="left" class="imprimirnroticket">T: <?php echo $row_Recordset1['ticket_hnac']; ?></td>
          </tr>
          <tr>
            <td colspan="4" align="left" class="imprimirnroticket">Cod: <?php echo $rest; ?></td>
          </tr>
          <tr>
            <td colspan="4" align="left" class="imprimir">
            	Ven: <?php echo $row_Recordset1['nom_usuario']; ?> 
                
            </td>
          </tr>
          <tr>
            <td colspan="4" align="left"class="apuestajugada">
				<?php echo "  ".$row_Recordset1['nom_hipodromo_hnac']." #".$row_Recordset1['num_carrera_hnac']; ?>
            </td>
          </tr>
          
          <?php
          $montoapagar=0; $ip=$row_Recordset1['ip_venta_hnac'];
          do { ?>
          <tr  class="apuestajugada">
            <td align="left">
                <?php echo $row_Recordset1['num_caballo_hnac']; ?>
               
            <td colspan="2" align="left"><?php echo ObtenerNombreApuesta($row_Recordset1['cod_tventa_hnac']); ?>
            
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
                    echo number_format($montoVenta, 2, ",", ".");
                ?>
            </td>
            <?php $montoapagar = $montoapagar+$row_Recordset1['mon_venta_hnac']; ?>
			<?php

 ?>

          </tr>
          <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>

          <tr>
            <td class="imprimirnroticket" height="8" colspan="4" align="left"><p><strong><?php
if ($moneda<=2) {
     echo "Total Bss:.".number_format($montoapagar, 2, ",", ".");
 }
if ($moneda==3) {
    echo "Total Usd:.".number_format($montoapagar, 2, ",", ".");
}
if ($moneda==4) {
    echo "Total Cop:.".number_format($montoapagar, 2, ",", ".");
}
if ($moneda==5) {
    echo "Total Sol:.".number_format($montoapagar, 2, ",", ".");
}
             ?></strong></p>


</td>
          </tr>

          <?php if ($tic_caduca>0) { ?>
          <tr>
            <td colspan="4" align="left"><?php echo "Caduca a ".$tic_caduca." dias";?></td>
          </tr>
          <?php }?>
          <tr>
            <td colspan="4" align="left">
				<?php
                if ($estadoCodBarra==1) {
                    $rest = substr($serial, 0, 2);
                    $rest = $rest.$xTicket_Recordset1;
                    echo "<img src='../includes/barcode2.php?s=code-128&wq=4&p=3&ph=0&w=110&d=".$rest."'>";
                }?>          
	        </td>
          </tr>
          <?php $explorador = $_SERVER['HTTP_USER_AGENT'];
          if (preg_match('/MSIE/i', $explorador) && !preg_match('/Opera/i', $explorador)) {?>
		  
                      
           
		  <?php }?>	 
		  
		  <?php for ($i = 0; $i < $largo; ++$i) {?><tr><td colspan="4" align="left">&nbsp;</td></tr><?php } ?>
   <tr><td colspan="4" align="left">.</td></tr>		  
     </table></font>
	 <?php } //---- fin1?> 
	 
	 
	 <?php if ($row_Recordset1['tip_ticket_hnac']==2) { ?>
	 
	 <font size="<?php echo $tamletras; ?>" face="Arial" >
        <table width="225" border="0" align="left">
          <tr>
            <th colspan="4" class="imprimir" scope="col"><?php echo $row_Recordset1['nom_taquilla']; ?></th>
          </tr>
          <tr>
            <th colspan="4" class="imprimir" scope="col">-ORIGINAL2-</th>
          </tr>
          <tr>
            <td colspan="4" align="center" class="imprimir">Fecha: <?php echo fechanueva($row_Recordset1['fec_venta_hnac']); ?></td>
          </tr>
          <tr>
            <td colspan="4" align="center" class="imprimir">Hora: <?php
$hora1=$row_Recordset1['hor_venta_hnac'];
$nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
$nuevahora1 = date('H:i:s', $nuevahora1);
echo horaampm($nuevahora1); ?></td>
          </tr>
          <tr>
            <td colspan="4" align="center" class="imprimirnroticket">Ticket: <?php echo $row_Recordset1['ticket_hnac']; ?></td>
          </tr>
          <tr>
            <td colspan="4" align="center" class="imprimirnroticket">Cod: <?php echo $rest; ?></td>
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
            <td width="163" align="center">EJEMPLAR</td>
            <td colspan="2" align="center">APUESTA</td>
            <td width="171" align="center">MONTO</td>
          </tr>
          
          <?php
          $montoapagar=0; $ip=$row_Recordset1['ip_venta_hnac'];
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
            <td class="imprimirnroticket" height="8" colspan="4" align="right">&nbsp;</td>
          </tr>
          <tr>
            <td class="imprimirnroticket" height="8" colspan="4" align="right"><p><strong><?php
if ($moneda<=2) {
                    echo "Total Bss:.".number_format($montoapagar, 2, ",", ".");
                }
if ($moneda==3) {
    echo "Total Usd:.".number_format($montoapagar, 2, ",", ".");
}
if ($moneda==4) {
    echo "Total Cop:.".number_format($montoapagar, 2, ",", ".");
}
if ($moneda==5) {
    echo "Total Sol:.".number_format($montoapagar, 2, ",", ".");
}
             ?></strong></p>


</td>
          </tr>

          <?php if ($tic_caduca>0) { ?>
          <tr>
            <td colspan="4" align="center"><?php echo "Ticket caduca a los ".$tic_caduca." dias";?></td>
          </tr>
          <?php }?>
          <tr><td colspan="4" align="center">-ORIGINAL2-</td></tr>
          <tr>
            <td colspan="4" align="center">
				<?php
                if ($estadoCodBarra==1) {
                    $rest = substr($serial, 0, 2);
                    $rest = $rest.$xTicket_Recordset1;
                    echo "<img src='../includes/barcode2.php?s=code-128&wq=4&p=3&ph=0&w=110&d=".$rest."'>";
                }?>          
	        </td>
          </tr>
          <tr>
            <td height="10" colspan="4" align="left">IP: <?php echo $ip; ?>  
            <tr>
            <td height="10" colspan="4" align="center">&nbsp;
	        </td>
          </tr>
          <?php $explorador = $_SERVER['HTTP_USER_AGENT'];
          if (preg_match('/MSIE/i', $explorador) && !preg_match('/Opera/i', $explorador)) {?>
              <tr>
                <td colspan="4" align="center">&nbsp;          
              <tr>
              <tr>
                <td colspan="4" align="center">&nbsp;          
              <tr>
              <tr>
                <td colspan="4" align="center">&nbsp;          
              <tr>
              <tr>
                <td colspan="4" align="center">&nbsp;          
              <tr>
              <tr>
                <td colspan="4" align="center">&nbsp;          
              <tr>
              <tr>
                <td colspan="4" align="center">.          
              <tr>
		  <?php }?>	          
     </table></font>
	 <?php } //---- fin2?> 
	 
	 
<?php if ($row_Recordset1['tip_ticket_hnac']==1) { ?>
<font size="<?php echo $tamletras; ?>" face="Arial" >
        <table width="225" border="0" align="left">
          <tr>
            <td colspan="4" class="imprimir" scope="col" align="left"><?php echo $rest2 = substr($row_Recordset1['nom_taquilla'], 0, 5); ?>-ORIG#:<?php echo $row_Recordset1['can_ticket_hnac']; ?></td>

          </tr>
          <tr>
            <td colspan="4"  align="left" class="imprimir"><?php echo $rest3 = substr(fechanueva($row_Recordset1['fec_venta_hnac_hnac']), 0, 6);
            $hora1=$row_Recordset1['hor_venta_hnac'];
$nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
$nuevahora1 = date('H:i:s', $nuevahora1);
echo horaampm($nuevahora1);
?></td>
          </tr>

          <tr>
            <td colspan="4" align="left" class="imprimirnroticket">T: <?php echo $row_Recordset1['ticket_hnac']; ?></td>
          </tr>
          <tr>
            <td colspan="4" align="left" class="imprimirnroticket">Cod: <?php echo $rest; ?></td>
          </tr>
          <tr>
            <td colspan="4" align="left" class="imprimir">
            	Ven: <?php echo $row_Recordset1['nom_usuario']; ?> 
                
            </td>
          </tr>
          <tr>
            <td colspan="4" align="left"class="apuestajugada">
				<?php echo "  ".$row_Recordset1['nom_hipodromo_hnac']." #".$row_Recordset1['num_carrera_hnac']; ?>
            </td>
          </tr>
          
          <?php
          $montoapagar=0; $ip=$row_Recordset1['ip_venta_hnac'];
          do { ?>
          <tr  class="apuestajugada">
            <td align="left">
                <?php echo $row_Recordset1['num_caballo_hnac']; ?>
               
            <td colspan="2" align="left"><?php echo ObtenerNombreApuesta($row_Recordset1['cod_tventa_hnac']); ?>
            
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
                    echo number_format($montoVenta, 2, ",", ".");
                ?>
            </td>
            <?php $montoapagar = $montoapagar+$row_Recordset1['mon_venta_hnac']; ?>
			<?php
$moneda=$row_Recordset1['efectivoOn'];
 ?>

          </tr>
          <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>

          <tr>
            <td class="imprimirnroticket" height="8" colspan="4" align="left"><p><strong><?php
if ($moneda<=2) {
     echo "Total Bss:.".number_format($montoapagar, 2, ",", ".");
 }
if ($moneda==3) {
    echo "Total Usd:.".number_format($montoapagar, 2, ",", ".");
}
if ($moneda==4) {
    echo "Total Cop:.".number_format($montoapagar, 2, ",", ".");
}
if ($moneda==5) {
    echo "Total Sol:.".number_format($montoapagar, 2, ",", ".");
}
             ?></strong></p>


</td>
          </tr>

          <?php if ($tic_caduca>0) { ?>
          <tr>
            <td colspan="4" align="left"><?php echo "Caduca a ".$tic_caduca." dias";?></td>
          </tr>
          <?php }?>
          <tr>
            <td colspan="4" align="left">
				<?php
                if ($estadoCodBarra==1) {
                    $rest = substr($serial, 0, 2);
                    $rest = $rest.$xTicket_Recordset1;
                    echo "<img src='../includes/barcode2.php?s=code-128&wq=4&p=3&ph=0&w=110&d=".$rest."'>";
                }?>          
	        </td>
          </tr>
          <?php $explorador = $_SERVER['HTTP_USER_AGENT'];
          if (preg_match('/MSIE/i', $explorador) && !preg_match('/Opera/i', $explorador)) {?>
		  
                      
           
		  <?php }?>	 
		  
		  <?php for ($i = 0; $i < $largo; ++$i) {?><tr><td colspan="4" align="left">&nbsp;</td></tr><?php } ?>
   <tr><td colspan="4" align="left">.</td></tr>		  
     </table></font>
	 <?php } //---- fin3?> 
	 
	 
    <?php
    echo "</div>";
    } else {
        echo "No se produjo ningún resultado";
    } ?>
</body>
</html>
<?php
mysqli_free_result($Recordset1); ?>


<?php
} ?>
   