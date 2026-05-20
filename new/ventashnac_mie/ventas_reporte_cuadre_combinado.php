<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
set_time_limit(0);
$codigoTaquilla=$_SESSION['MM_cod_taquilla'];
$codigoUsuario=$_SESSION['MM_id_usuario'];
$inicio=fechanueva(fechaactualbd());
$final=fechanueva(fechaactualbd());
$in=fechaymd($inicio); $fi=fechaymd($final);
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    if (isset($_POST['fecha_inicio']) && isset($_POST['fecha_fin'])) {
        if ($_POST['fecha_inicio']!="" && $_POST['fecha_fin']!="") {
            if (strtotime(fechaymd($_POST['fecha_inicio'])) < strtotime(fechaymd($_POST['fecha_fin']))) {
                $inicio=$_POST['fecha_inicio'];
                $final=$_POST['fecha_fin'];
            } else {
                $final=$_POST['fecha_inicio'];
                $inicio=$_POST['fecha_fin'];
            }
            $in=fechaymd($inicio);
            $fi=fechaymd($final);
            if ($_POST['id_usuario']!="todos") {
                $codigoUsuario=$_POST['id_usuario'];
                include("../ventas/base_ame/bVenta_us_ame.php");//AMERICANA
                mysqli_free_result($Recordset81);
                include("base_hnac/bVenta_us_hnac.php");//NACIONALES
            } else {
                include("../ventas/base_ame/bVenta_ta_ame.php");
                mysqli_free_result($Recordset81);
                include("base_hnac/bVenta_ta_hnac.php");
            }
        }
    }
} else {
    include("../ventas/base_ame/bVenta_us_ame.php");
    mysqli_free_result($Recordset81);
    include("base_hnac/bVenta_us_hnac.php");
}
$total_venta=$Atotal_venta+$Ntotal_venta;
$tot_premios=$Atot_premios+$Ntot_premios;
$ret_pagos=$Aret_pagos+$Nret_pagos;
$inv_pagos=$Ainv_pagos+$Ninv_pagos;
$tot_eliminad=$Atot_eliminad+$Ntot_eliminad;
$ret_porpagar=$Aret_porpagar+$Nret_porpagar;
$inv_porpagar=$Ainv_porpagar+$Ninv_porpagar;
$pre_porpagar=$Apre_porpagar+$Npre_porpagar;
$invCanAnu=$AinvCanAnu+$NinvCanAnu;
$invCanAnu2=$AinvCanAnu2+$NinvCanAnu2;
$enCaja=$AenCaja+$NenCaja;
$pagoSistema=$ApagoSistema+$NpagoSistema;
$totalEliminados=$Neliminados+$Aeliminados;

$query_Recordset2 = sprintf("/* PARSEADORES1 new\ventashnac_mie\ventas_reporte_cuadre_combinado.php - QUERY 1 */ SELECT usuario.nom_usuario, usuario.id_usuario, taquilla.nom_taquilla FROM usuario, taquilla 
	WHERE usuario.cod_taquilla = %s AND tip_usuario='U' AND usuario.cod_taquilla = taquilla.cod_taquilla
	ORDER BY usuario.nom_usuario", GetSQLValueString($codigoTaquilla, "int"));
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
$taquillaV=$row_Recordset2['nom_taquilla'];
if ($vendedor=="") {
    $query_Recordset3 = sprintf("/* PARSEADORES1 new\ventashnac_mie\ventas_reporte_cuadre_combinado.php - QUERY 2 */ SELECT nom_usuario FROM usuario WHERE usuario.id_usuario = %s AND tip_usuario='U' 
	LIMIT 1", GetSQLValueString($codigoUsuario, "int"));
    $Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
    $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
    $vendedor=strtoupper($row_Recordset3['nom_usuario']);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<title>.:Apuestas Hípicas:.</title>
<link rel="stylesheet" type="text/css" href="../css/tcal.css" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<style>
height: 0;
width: 0;
position: absolute;
</style>
<script type="text/javascript" src="../js/tcal.js"></script>
<script src="../js/jquery-1.9.1.min.js"></script>
<script language="JavaScript">
function GetIEVersion(){
	var e=window.navigator.userAgent,t=e.indexOf("MSIE");
	return t>0?parseInt(e.substring(t+5,e.indexOf(".",t))):navigator.userAgent.match(/Trident\/7\./)?11:0;
}
function vernover(){
	var el1 = document.getElementById("noprint1");
	var el2 = document.getElementById("noprint2");
	var el3 = document.getElementById("noprint3");
	var el4 = document.getElementById("noprint4");
	var el5 = document.getElementById("noprint5");
	el1.style.display = (el1.style.display == 'none') ? 'block' : 'none';
	el2.style.display = (el2.style.display == 'none') ? 'block' : 'none';
	el3.style.display = (el3.style.display == 'none') ? 'block' : 'none';
	el4.style.display = (el4.style.display == 'none') ? 'block' : 'none';
	el5.style.display = (el5.style.display == 'none') ? 'block' : 'none';
}
function doprint2(){
	vernover();
	document.getElementById("printtitle");
	window.print("printtitle");
	vernover();
}
if("Microsoft Internet Explorer"==navigator.appName||GetIEVersion()>0)
document.write('<object id="factory" classid="clsid:1663ed61-23eb-11d2-b92f-008048fdd814" codebase="ScriptX.cab#Version=6,5,439,72"></object>');
</script>
<script language="vbscript">
function doPrint1()
	document.all.item("noprint1").style.display="none"
	document.all.item("noprint2").style.display="none"
	document.all.item("noprint3").style.display="none"
	document.all.item("noprint4").style.display="none"
	document.all.item("noprint5").style.display="none"
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
	document.all.item("noprint1").style.display=""
	document.all.item("noprint2").style.display=""
	document.all.item("noprint3").style.display=""
	document.all.item("noprint4").style.display=""
	document.all.item("noprint5").style.display=""
end function
</script>
<script LANGUAGE="JavaScript"> var statusEnvio = false; function chequearEnvio() {if (!statusEnvio) { statusEnvio = true; return true;} else { alert("El formulario ya está siendo enviado, por favor aguarde un instante."); return false;}}</script>
</head>
<script language="JavaScript">document.write("Microsoft Internet Explorer"==navigator.appName||GetIEVersion()>0?'<body onload="javascript:document.all.cmdPrint.focus();">':"<body>");</script>
   <div style="background:#036; width:100%; float:left; padding:50px 2px 2px 2px;
   		color:#FFF; font-size:22px; text-align:center" id="noprint1">
        CUADRE DE CAJA COMBINADO
   </div><!-- end .container -->
   <div style="background: #FFF; width:100%; float:left; padding:15px 0px 0px 10px;
   		color:#000; font-size:20px; text-align: left"  id="noprint2">
       <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off"  
            onsubmit="return chequearEnvio();">
            Desde:
            <input name="fecha_inicio" type="text" id="dateArrival1" tabindex="1" style="width:90px; font-size:16px; height:20px"
                title="fecha inicio. formato: dd-mm-aaaa" class="tcal" 
                value="<?php echo htmlentities($inicio, ENT_COMPAT, 'utf-8'); ?>"/>
            Hasta:    
            <input name="fecha_fin" type="text" id="dateArrival2"  tabindex="2" style="width:90px; font-size:16px; height:20px"
                size="9" title="fecha final. formato: dd-mm-aaaa" class="tcal" 
                value="<?php echo htmlentities($final, ENT_COMPAT, 'utf-8'); ?>" /> 
            <div style="background: #FFF; width:495px; float:left; padding:0px 0px 1px 0px;" id="noprint3">
                Vendedores:
                <select name="id_usuario" style="height:35px; width:280px; margin:0px 0px 0px -4px">
                      <option value="todos" <?php if ($vendedor=="TODOS") {
    echo "SELECTED";
} ?>>
                    TODOS</option>
                      <?php
                do {
                    ?>
               <option value="<?php echo $row_Recordset2['id_usuario']?>" 
                        <?php if ($row_Recordset2['nom_usuario']==$vendedor) {
                        echo "SELECTED";
                    } ?>>
                        <?php echo strtoupper($row_Recordset2['nom_usuario']); ?>
                </option>
                      <?php
                } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
                ?>
                    </select>
                <input type="submit" value="Buscar" class="btn-warning" title="iniciar busqueda" onClick="return enviado()"
                 style="width:80px; height:35px; margin: 3px 0px 0px 0px"/>
                <input type="hidden" name="MM_update" value="form1" />
            </div>
     </form>  
   </div><!-- end .container -->
   <div style="background:#036; width:100%;float:left; padding:5px 0px 5px 0px;" id="noprint4"><?php
        if ($hnac==1) {?>
          <a href="../ventas/ventas_reporte_cuadre_americana.php" style="font-size:11px;margin:0px 10px 0px 0px;line-height:12px;" 
           class="btn btn-info" id="americana">Ver Cuadre de Caja <br/>Pacificnas</a>
          <a href="../ventashnac_mie/ventas_reporte_cuadre_hnac.php" style="font-size:11px; line-height:12px;" 
           class="btn btn-alert" id="nacional">Ver Cuadre de Caja <br/>Nacionales</a>
		   <?php
        }?>
   </div><!-- end .container -->
   <div id="mostrar" style="width:100%; float:left">
	<?php
    if ($totalRows_Recordset81>0) {?>
     	<div style="width:100; float:left; padding:0px 0px 0px 10px">
             <div id="printtitle" style="float:left;">
<br/>TAQUILLA:<?php echo $taquillaV."<br>"; ?>
VENDEDOR:<?php echo $vendedor."<br>"; ?>
DESDE:<?php echo $inicio."<br>"; ?>
HASTA:<?php echo $final."<br>"; ?>
HORA:<?php
$hora1=horaactual();
$nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
$nuevahora1 = date('H:i:s', $nuevahora1);
echo $nuevahora1; ?>
<br/><strong>CUADRE <br/>AMERICANAS<br/>NACIONALES</strong>
<br/>VENTAS:
<br/><?php echo number_format($total_venta, 2, ",", ".");?>
<br/>PREMIOS PAGADOS:
<br/><?php echo number_format($tot_premios, 2, ",", ".");?>
<br/>INVALIDADOS PAGADOS:
<br/><?php echo number_format($ret_pagos, 2, ",", ".");?>
<br/>CANCELADOS PAGADOS:
<br/><?php echo number_format($inv_pagos, 2, ",", ".");?>
<br/>ANULADOS PAGADOS(<?php echo $totalEliminados;?>):
<br/><?php echo number_format($tot_eliminad, 2, ",", ".");?>
<br/>DINERO EN CAJA:
<br/><strong>***<?php echo number_format($enCaja, 2, ",", ".");?>***</strong>

<?php
                  //}?>
<br/>COSTO DEL SISTEMA:
<br/><?php echo number_format($pagoSistema, 2, ",", ".");?>
          <br/><br/>.<br/>.<br/>.<br/>.<br/>.<br/>
            </div>
	 </div>
     <div style="background: #036; width:98%; float:left; color:#FFF; text-align:right; font-size:16px; 
     	padding:5px 10px 5px 5px" id="noprint5">
		<form name="form1">
			<input style="FONT-STYLE: normal; FONT-FAMILY: 'MS Sans Serif'; FONT-SIZE: 15px; FONT-WEIGHT: normal" id="cmdPrint" class="boton"  <?php if ($navegador['browser']=="IE") {
                      echo 'onclick="doprint1()"';
                  } else {
                      echo 'onclick="doprint2()"';
                  } ?> name="cmdPrint" value="Imprimir" type="button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <A onclick=window.close() href="#">
            <FONT color="#F9E209" ><SPAN style="FONT-SIZE: 16pt"><B>Cerrar</B></SPAN></FONT></A>
		</form>
     </div><!-- end .container -->
        <?php } else {?>
        <h4 style="text-align:left; padding:0px 0px 0px 15px">No existen datos</h4>
        <?php }?>  
   </div><!-- end .mostrar -->
</body>
</html>
<?php
mysqli_free_result($Recordset81);
mysqli_free_result($Recordset2);
if (isset($Recordset3)) {
    mysqli_free_result($Recordset3);
}
?>