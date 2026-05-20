<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
set_time_limit(0);
include("../includes/calculodepago.php");
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
            if ($_POST['id_distribuidor']!="todos") {
                $query_Recordset10 = sprintf(
                    "/* PARSEADORES1 new\admin\calcula.php - QUERY 1 */ SELECT cod_banca, nom_banca, tel_banca, cor_banca, por_banca 
				FROM banca WHERE cod_banca = %s",
                    GetSQLValueString($_POST['id_distribuidor'], "int")
                );
                $v=1;
            }
        }
    }
}
if (((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1") && $_POST['id_distribuidor']=="todos") ||
    !isset($_POST["MM_update"])) {
    $query_Recordset10 = sprintf("/* PARSEADORES1 new\admin\calcula.php - QUERY 2 */ SELECT cod_banca, nom_banca, tel_banca, cor_banca, por_banca FROM banca");
    $v=0;
}
$Recordset10 = mysqli_query($conexionbanca, $query_Recordset10) or die(mysqli_error($conexionbanca));
$row_Recordset10 = mysqli_fetch_assoc($Recordset10);
$totalRows_Recordset10 = mysqli_num_rows($Recordset10);
if (isset($v) && $v==1) {
    $nomb=$row_Recordset10['nom_banca'];
} else {
    $nomb="TODOS";
}
$query_Recordset2 = sprintf("/* PARSEADORES1 new\admin\calcula.php - QUERY 3 */ SELECT cod_banca, nom_banca FROM banca ORDER BY banca.nom_banca");
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<link rel="shortcut icon" href="../images/favicon.ico">
<title>.:Apuestas Hípicas:.</title>
<script language="javascript"> 
	function cambiacolor_over(celda){ celda.style.backgroundColor="#9FBFD7" }  
	function cambiacolor_out(celda){ celda.style.backgroundColor="#FFFFFF" } 
</script>
<script LANGUAGE="JavaScript">
var statusEnvio = false;
function chequearEnvio() {
    if (!statusEnvio) { statusEnvio = true;
        return true;
    } else { alert("El formulario ya está siendo enviado, por favor aguarde un instante.");
        return false;
    }
}
</script><style>.boton-top{display:none;position:fixed;bottom:0;right:0;width:40px;height:40px;text-align:center;line-height:40px;color:#fff;background:#F93;cursor:pointer;font-size:18px;}</style>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
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
<script src="../js/jquery-1.9.1.min.js"></script>
<script>
 $(document).ready(function() { 
 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
 var refreshId1 = setInterval(function() {
 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
 }, 60000);
});
</script>
<!-- InstanceBeginEditable name="aHead" -->
<!-- InstanceEndEditable -->
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
  <div class="header" style="height:100px; background:#333">
			<?php include("../includes/cabeceraamericana.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
                    <!-- InstanceBeginEditable name="Menu" -->
                    <?php include("../includes/cabeceraadmin.php");?>
                    <!-- InstanceEndEditable -->        	
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#333; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background: #333;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            			margin:20px 0px 0px 0px; width:240px; font-size:16px ">
                <!-- InstanceBeginEditable name="pagina" -->
                PREMIAR TICKETS
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
  <div style="height:100%; font-size:26px; padding:50px 0px 100px 0px ">
       <div style="background: #FFF; width:100%; float:left; padding:5px 0px 0px 10px;
            color:#000; font-size:20px; text-align: left">
           <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off"  
                onsubmit="return chequearEnvio();">
                Desde:
                <input name="fecha_inicio" type="text" id="dateArrival1" tabindex="1" 
                	style="width:100px; font-size:16px; height:30px"
                    title="fecha inicio. formato: dd-mm-aaaa" class="tcal" 
                    value="<?php echo htmlentities($inicio, ENT_COMPAT, 'utf-8'); ?>"/>
                Hasta:    
                <input name="fecha_fin" type="text" id="dateArrival2"  tabindex="2" 
                	style="width:100px; font-size:16px; height:30px"
                    size="9" title="fecha final. formato: dd-mm-aaaa" class="tcal" 
                    value="<?php echo htmlentities($final, ENT_COMPAT, 'utf-8'); ?>" /> 
                 Distribuidores:
             <select name="id_distribuidor" id="soflow" style="height:40px; width:320px; margin:-9px 0px 0px 0px ">
                      <option value="todos" >TODOS</option>
                      <?php
                do {
                    ?>
               <option value="<?php echo $row_Recordset2['cod_banca']?>"
               <?php if ($row_Recordset2['nom_banca']==$nomb) {
                        echo "SELECTED";
                    } ?>>
			   <?php echo strtoupper($row_Recordset2['nom_banca']); ?>
               </option>
                      <?php
                } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
                ?>
             </select>
                <input type="submit" value="Buscar" class="btn-warning" title="iniciar busqueda" onClick="return enviado()"
                 style="width:80px; height:40px"/>
                <input type="hidden" name="MM_update" value="form1" />
         </form>  
       </div><!-- end .container -->
   <div style="background:#CCC; width:915px; float:left; padding:12px 13px 0px 12px;
      color:#000; font-size:20px;">
   <div><span style="float:right;">FECHA: del <?php echo $inicio." al ".$final; ?></span><?php echo ""; ?></div>
   </div><!-- end .container -->

	<div>
	</div>
   <div id="mostrar" style="width:99.7%; float:left; padding:0px 0px 50px 3px; background: #CCC">
   	   	<table width="934" border="0" style="color:#000; font-size:14px;">
			<?php
           if ($totalRows_Recordset10>0) {
               $f=0;
               do {
                   $codBanca=$row_Recordset10['cod_banca'];
                   $porBanca=$row_Recordset10['por_banca'];
                   $query_Recordset3 = sprintf(
                       "/* PARSEADORES1 new\admin\calcula.php - QUERY 4 */ SELECT cod_agencia, nom_agencia, por_agencia
							FROM agencia WHERE cod_banca = %s",
                       GetSQLValueString($codBanca, "int")
                   );
                   $Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
                   $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
                   $totalRows_Recordset3 = mysqli_num_rows($Recordset3);
                   $total=$totalRows_Recordset3;
                   $reg=0;
                   if ($totalRows_Recordset3>0) {
                       do {
                           $codAgencia=$row_Recordset3['cod_agencia'];
                           $nomAgente=$row_Recordset3['nom_agencia'];
                           $query_Recordset1 = sprintf(
                               "/* PARSEADORES1 new\admin\calcula.php - QUERY 5 */ SELECT venta.num_ticket,
							venta.fec_venta, venta.mon_venta, venta.pag_premio, taquilla_opc_ame.anu_regalia,
							venta.est_ticket, carrera.est_confirmacion, venta.cod_tventa, venta.fec_pago,
							venta.num_caballo, taquilla_opc_ame.max_aganar_gan,	taquilla_opc_ame.reg_gan, 
							carrera.est_confirmacion, carrera.eje_primero, carrera.eje_doble_primero,
							carrera.eje_triple_primero, carrera.div_primero_gan, carrera.div_primero_pla,
							carrera.div_primero_sho, carrera.div_doble_primero_gan, carrera.div_doble_primero_pla,
							carrera.div_doble_primero_sho, carrera.div_triple_primero_gan, carrera.div_triple_primero_pla,
							carrera.div_triple_primero_sho,	carrera.eje_segundo, carrera.eje_doble_segundo,
							carrera.eje_triple_segundo,	carrera.div_segundo_pla, carrera.div_segundo_sho,
							carrera.div_doble_segundo_pla, carrera.div_doble_segundo_sho, carrera.div_triple_segundo_pla,
							carrera.div_triple_segundo_sho,	carrera.eje_tercero, carrera.eje_doble_tercero,
							carrera.eje_triple_tercero, carrera.div_tercero_sho, carrera.div_doble_tercero_sho,
							carrera.div_triple_tercero_sho, taquilla_opc_ame.max_aganar_pla, taquilla_opc_ame.reg_pla,
							taquilla_opc_ame.max_aganar_sho, taquilla_opc_ame.reg_sho, carrera.fac_superfecta, 
							taquilla_opc_ame.max_aganar_sup, taquilla_opc_ame.reg_sup, carrera.div_exacta, 
							carrera.ord_exacta, carrera.div_trifecta, carrera.ord_trifecta, carrera.div_superfecta,
							carrera.ord_superfecta, carrera.div_exacta_doble, carrera.ord_exacta_doble, 
							carrera.div_trifecta_doble, carrera.ord_trifecta_doble, carrera.div_superfecta_doble,
							carrera.ord_superfecta_doble, carrera.div_exacta_triple, carrera.ord_exacta_triple, 
							div_trifecta_triple, carrera.ord_trifecta_triple, carrera.div_superfecta_triple, 
							carrera.ord_superfecta_triple, carrera.fac_trifecta, taquilla_opc_ame.max_aganar_tri,
							taquilla_opc_ame.reg_tri, carrera.fac_exacta, taquilla_opc_ame.max_aganar_exa,
							taquilla_opc_ame.reg_exa 
							FROM carrera, taquilla, taquilla_opc_ame, venta 
							WHERE venta.cod_carrera = carrera.cod_carrera AND
							(venta.fec_venta >= %s AND venta.fec_venta <= %s OR venta.fec_pago >= %s 
							AND venta.fec_pago <= %s) AND taquilla.cod_agencia = %s AND 
							taquilla.cod_taquilla = venta.cod_taquilla AND 
							taquilla_opc_ame.cod_taquilla = taquilla.cod_taquilla
							ORDER BY taquilla.cod_taquilla ASC",
                               GetSQLValueString($in, "date"),
                               GetSQLValueString($fi, "date"),
                               GetSQLValueString($in, "date"),
                               GetSQLValueString($fi, "date"),
                               GetSQLValueString($codAgencia, "int")
                           );
                           $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
                           $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
                           $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
                           if ($totalRows_Recordset1>0) {
                               do {
                                   $pago=0;
                                   $pa[0]=0;
                                   $pa[1]="";
                                   $anuReg=$row_Recordset1['anu_regalia'];
                                   if ($row_Recordset1['est_ticket']==1 && $row_Recordset1['est_confirmacion']==0) {
                                       if ($row_Recordset1['cod_tventa']>=1 && $row_Recordset1['cod_tventa']<=3) {
                                           if ($row_Recordset1['cod_tventa']==1) {
                                               $topJugada=$row_Recordset1['max_aganar_gan'];
                                               $regalo=$row_Recordset1['reg_gan'];
                                           }
                                           if ($row_Recordset1['cod_tventa']==2) {
                                               $topJugada=$row_Recordset1['max_aganar_pla'];
                                               $regalo=$row_Recordset1['reg_pla'];
                                           }
                                           if ($row_Recordset1['cod_tventa']==3) {
                                               $topJugada=$row_Recordset1['max_aganar_sho'];
                                               $regalo=$row_Recordset1['reg_sho'];
                                           }
                                           $pa=jNormal(
                                               $row_Recordset1['num_caballo'],
                                               $row_Recordset1['cod_tventa'],
                                               $row_Recordset1['mon_venta'],
                                               $row_Recordset1['eje_primero'],
                                               $row_Recordset1['eje_doble_primero'],
                                               $row_Recordset1['eje_triple_primero'],
                                               $row_Recordset1['div_primero_gan'],
                                               $row_Recordset1['div_primero_pla'],
                                               $row_Recordset1['div_primero_sho'],
                                               $row_Recordset1['div_doble_primero_gan'],
                                               $row_Recordset1['div_doble_primero_pla'],
                                               $row_Recordset1['div_doble_primero_sho'],
                                               $row_Recordset1['div_triple_primero_gan'],
                                               $row_Recordset1['div_triple_primero_pla'],
                                               $row_Recordset1['div_triple_primero_sho'],
                                               $row_Recordset1['eje_segundo'],
                                               $row_Recordset1['eje_doble_segundo'],
                                               $row_Recordset1['eje_triple_segundo'],
                                               $row_Recordset1['div_segundo_pla'],
                                               $row_Recordset1['div_segundo_sho'],
                                               $row_Recordset1['div_doble_segundo_pla'],
                                               $row_Recordset1['div_doble_segundo_sho'],
                                               $row_Recordset1['div_triple_segundo_pla'],
                                               $row_Recordset1['div_triple_segundo_sho'],
                                               $row_Recordset1['eje_tercero'],
                                               $row_Recordset1['eje_doble_tercero'],
                                               $row_Recordset1['eje_triple_tercero'],
                                               $row_Recordset1['div_tercero_sho'],
                                               $row_Recordset1['div_doble_tercero_sho'],
                                               $row_Recordset1['div_triple_tercero_sho'],
                                               $topJugada,
                                               $regalo,
                                               $anuReg
                                           );
                                           $pago=$pa[0];
                                       }
                                       if ($row_Recordset1['cod_tventa']>=4 && $row_Recordset1['cod_tventa']<=9) {
                                           if ($row_Recordset1['cod_tventa']==4 || $row_Recordset1['cod_tventa']==7) {
                                               $fact=$row_Recordset1['fac_exacta'];
                                               $topJugada=$row_Recordset1['max_aganar_exa'];
                                               $regalo=$row_Recordset1['reg_exa'];
                                           }
                                           if ($row_Recordset1['cod_tventa']==5 || $row_Recordset1['cod_tventa']==8) {
                                               $fact=$row_Recordset1['fac_trifecta'];
                                               $topJugada=$row_Recordset1['max_aganar_tri'];
                                               $regalo=$row_Recordset1['reg_tri'];
                                           }
                                           if ($row_Recordset1['cod_tventa']==6 || $row_Recordset1['cod_tventa']==9) {
                                               $fact=$row_Recordset1['fac_superfecta'];
                                               $topJugada=$row_Recordset1['max_aganar_sup'];
                                               $regalo=$row_Recordset1['reg_sup'];
                                           }
                                           $base=2;
                                           $pa=jExotica2(
                                               $row_Recordset1['num_caballo'],
                                               $row_Recordset1['cod_tventa'],
                                               $row_Recordset1['mon_venta'],
                                               $row_Recordset1['div_exacta'],
                                               $row_Recordset1['ord_exacta'],
                                               $row_Recordset1['div_trifecta'],
                                               $row_Recordset1['ord_trifecta'],
                                               $row_Recordset1['div_superfecta'],
                                               $row_Recordset1['ord_superfecta'],
                                               $row_Recordset1['div_exacta_doble'],
                                               $row_Recordset1['ord_exacta_doble'],
                                               $row_Recordset1['div_trifecta_doble'],
                                               $row_Recordset1['ord_trifecta_doble'],
                                               $row_Recordset1['div_superfecta_doble'],
                                               $row_Recordset1['ord_superfecta_doble'],
                                               $row_Recordset1['div_exacta_triple'],
                                               $row_Recordset1['ord_exacta_triple'],
                                               $row_Recordset1['div_trifecta_triple'],
                                               $row_Recordset1['ord_trifecta_triple'],
                                               $row_Recordset1['div_superfecta_triple'],
                                               $row_Recordset1['ord_superfecta_triple'],
                                               $topJugada,
                                               $regalo,
                                               $fact,
                                               $base
                                           );
                                           $pago=$pa[0];
                                       }
                                       if ($pago>0) {
                                           $updateSQL = sprintf(
                                               "/* PARSEADORES1 new\admin\calcula.php - QUERY 6 */ UPDATE venta 
															   SET pag_premio=%s 
															   WHERE num_ticket=%s",
                                               GetSQLValueString($pago, "double"),
                                               GetSQLValueString($row_Recordset1['num_ticket'], "int")
                                           );
                                           $Result1 = mysqli_query($conexionbanca, $updateSQL) or
                                                            die(mysqli_error($conexionbanca));
                                           $reg++;
                                       }
                                   }
                                   if ($row_Recordset1['est_ticket']==2 && $row_Recordset1['fec_pago']>=$in
                                        && $row_Recordset1['fec_pago']<=$fi) {
                                       if ($row_Recordset1['cod_tventa']>=1 && $row_Recordset1['cod_tventa']<=3) {
                                           if ($row_Recordset1['cod_tventa']==1) {
                                               $topJugada=$row_Recordset1['max_aganar_gan'];
                                               $regalo=$row_Recordset1['reg_gan'];
                                           }
                                           if ($row_Recordset1['cod_tventa']==2) {
                                               $topJugada=$row_Recordset1['max_aganar_pla'];
                                               $regalo=$row_Recordset1['reg_pla'];
                                           }
                                           if ($row_Recordset1['cod_tventa']==3) {
                                               $topJugada=$row_Recordset1['max_aganar_sho'];
                                               $regalo=$row_Recordset1['reg_sho'];
                                           }
                                           $pa=jNormal(
                                               $row_Recordset1['num_caballo'],
                                               $row_Recordset1['cod_tventa'],
                                               $row_Recordset1['mon_venta'],
                                               $row_Recordset1['eje_primero'],
                                               $row_Recordset1['eje_doble_primero'],
                                               $row_Recordset1['eje_triple_primero'],
                                               $row_Recordset1['div_primero_gan'],
                                               $row_Recordset1['div_primero_pla'],
                                               $row_Recordset1['div_primero_sho'],
                                               $row_Recordset1['div_doble_primero_gan'],
                                               $row_Recordset1['div_doble_primero_pla'],
                                               $row_Recordset1['div_doble_primero_sho'],
                                               $row_Recordset1['div_triple_primero_gan'],
                                               $row_Recordset1['div_triple_primero_pla'],
                                               $row_Recordset1['div_triple_primero_sho'],
                                               $row_Recordset1['eje_segundo'],
                                               $row_Recordset1['eje_doble_segundo'],
                                               $row_Recordset1['eje_triple_segundo'],
                                               $row_Recordset1['div_segundo_pla'],
                                               $row_Recordset1['div_segundo_sho'],
                                               $row_Recordset1['div_doble_segundo_pla'],
                                               $row_Recordset1['div_doble_segundo_sho'],
                                               $row_Recordset1['div_triple_segundo_pla'],
                                               $row_Recordset1['div_triple_segundo_sho'],
                                               $row_Recordset1['eje_tercero'],
                                               $row_Recordset1['eje_doble_tercero'],
                                               $row_Recordset1['eje_triple_tercero'],
                                               $row_Recordset1['div_tercero_sho'],
                                               $row_Recordset1['div_doble_tercero_sho'],
                                               $row_Recordset1['div_triple_tercero_sho'],
                                               $topJugada,
                                               $regalo,
                                               $anuReg
                                           );
                                           $pago=$pa[0];
                                       }
                                       if ($row_Recordset1['cod_tventa']>=4 && $row_Recordset1['cod_tventa']<=9) {
                                           if ($row_Recordset1['cod_tventa']==4 || $row_Recordset1['cod_tventa']==7) {
                                               $fact=$row_Recordset1['fac_exacta'];
                                               $topJugada=$row_Recordset1['max_aganar_exa'];
                                               $regalo=$row_Recordset1['reg_exa'];
                                           }
                                           if ($row_Recordset1['cod_tventa']==5 || $row_Recordset1['cod_tventa']==8) {
                                               $fact=$row_Recordset1['fac_trifecta'];
                                               $topJugada=$row_Recordset1['max_aganar_tri'];
                                               $regalo=$row_Recordset1['reg_tri'];
                                           }
                                           if ($row_Recordset1['cod_tventa']==6 || $row_Recordset1['cod_tventa']==9) {
                                               $fact=$row_Recordset1['fac_superfecta'];
                                               $topJugada=$row_Recordset1['max_aganar_sup'];
                                               $regalo=$row_Recordset1['reg_sup'];
                                           }
                                           $base=2;
                                           $pa=jExotica2(
                                               $row_Recordset1['num_caballo'],
                                               $row_Recordset1['cod_tventa'],
                                               $row_Recordset1['mon_venta'],
                                               $row_Recordset1['div_exacta'],
                                               $row_Recordset1['ord_exacta'],
                                               $row_Recordset1['div_trifecta'],
                                               $row_Recordset1['ord_trifecta'],
                                               $row_Recordset1['div_superfecta'],
                                               $row_Recordset1['ord_superfecta'],
                                               $row_Recordset1['div_exacta_doble'],
                                               $row_Recordset1['ord_exacta_doble'],
                                               $row_Recordset1['div_trifecta_doble'],
                                               $row_Recordset1['ord_trifecta_doble'],
                                               $row_Recordset1['div_superfecta_doble'],
                                               $row_Recordset1['ord_superfecta_doble'],
                                               $row_Recordset1['div_exacta_triple'],
                                               $row_Recordset1['ord_exacta_triple'],
                                               $row_Recordset1['div_trifecta_triple'],
                                               $row_Recordset1['ord_trifecta_triple'],
                                               $row_Recordset1['div_superfecta_triple'],
                                               $row_Recordset1['ord_superfecta_triple'],
                                               $topJugada,
                                               $regalo,
                                               $fact,
                                               $base
                                           );
                                           $pago=$pa[0];
                                       }
                                       if ($pago>0) {
                                           $updateSQL2 = sprintf(
                                               "/* PARSEADORES1 new\admin\calcula.php - QUERY 7 */ UPDATE venta 
															   SET pag_premio=%s 
															   WHERE num_ticket=%s",
                                               GetSQLValueString($pago, "double"),
                                               GetSQLValueString($row_Recordset1['num_ticket'], "int")
                                           );
                                           $Result2 = mysqli_query($conexionbanca, $updateSQL2) or
                                                            die(mysqli_error($conexionbanca));
                                           $reg++;
                                       }
                                   }
                                   if (($row_Recordset1['est_ticket']==4 || $row_Recordset1['est_ticket']==5)
                                        && $row_Recordset1['fec_pago']>=$in && $row_Recordset1['fec_pago']<=$fi) {
                                       $updateSQL3 = sprintf(
                                           "/* PARSEADORES1 new\admin\calcula.php - QUERY 8 */ UPDATE venta 
											   SET pag_premio=%s WHERE num_ticket=%s",
                                           GetSQLValueString($row_Recordset1['mon_venta'], "double"),
                                           GetSQLValueString($row_Recordset1['num_ticket'], "int")
                                       );
                                       $Result3 = mysqli_query($conexionbanca, $updateSQL3) or
                                                                die(mysqli_error($conexionbanca));
                                       $reg++;
                                   }
                               } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
                           }
                       } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));
                   }
                   if ($f%2==0) {?>
					<tr style="background:#FFFFFF; color:#000; border-color:#333" valign="middle" align="center">
                    <?php } else {?>
                    <tr style="background:#CCC; color:#000; border-color:#333" valign="middle" align="center">
                    <?php } ?>
						<td width="207" align="left" style="font-size:14px">
							<strong>
							<?php
                            echo $row_Recordset10['nom_banca']; ?>
					    </strong></td>
						<td width="717" align="left" style="font-size:12px">
                        <?php
                            echo "Premios incluidos: ".$reg; ?>
                        </td>
					</tr>
					<?php
                    $f++;
               } while ($row_Recordset10 = mysqli_fetch_assoc($Recordset10));
           } else {?>
		  <tr align="left">
					<td height="40" colspan="2" style="background: #333; color:#FFF; font-size:24px">NO EXISTEN DATOS</td>
		  </tr><?php
            }
            ?>
	</table>	
</div><!-- end .mostrar -->
<span class="boton-top" title="ir arriba">▲</span>
</div>
<script>$(window).scroll(function(){if($(this).scrollTop()>0){$('.boton-top').fadeIn();} else{$('.boton-top').fadeOut();}});$('.boton-top').click(function(){$(document.body).animate({scrollTop : 0}, 500);return false;});document.getElementById('ganSis').innerHTML = "<?php echo number_format($totalSistema, 2, ",", "."); ?>";document.getElementById('ganDis').innerHTML = "<?php echo number_format($totalGenDi, 2, ",", "."); ?>";</script>
<?php
mysqli_free_result($Recordset2);
if (isset($Recordset1)) {
    mysqli_free_result($Recordset1);
}
?>  	
  <!-- InstanceEndEditable -->
  </div>
  <div class="footer">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
<!-- InstanceEnd --></html>