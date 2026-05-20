<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$hor=horaactual();
$fec=fechaactualbd();
$codTaq=$_SESSION['MM_cod_taquilla'];
$editFormAction = $_SERVER['PHP_SELF'];
$editFormAction2 = $_SERVER['PHP_SELF'];
$fechaInicial=fechanueva(fechaactualbd());
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction2 .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1") && isset($_POST['fecha_inicio'])) {
    $fec=fechaymd($_POST['fecha_inicio']);
    $fechaInicial=$_POST['fecha_inicio'];
    ;
    $query_Recordset10 = sprintf(
        "/* PARSEADORES1 new\ventashnac_mie\incluir_modificar_dividendos_hnac.php - QUERY 1 */ SELECT 
		ca.cod_carrera_hnac, 
		ca.can_caballos_hnac, 
		ca.num_carrera_hnac,
		ca.hor_carrera_hnac,
		ca.est_carrera_hnac,
		ca.fec_carrera_hnac,
		ca.est_cierre_hnac, 
		hi.nom_hipodromo_hnac,
		hi.cod_hipodromo_hnac
		FROM 
			carrera_hnac ca,
			hipodromo_hnac hi
		WHERE
			hi.cod_hipodromo_hnac = ca.cod_hipodromo_hnac AND
			ca.fec_carrera_hnac = %s 
		ORDER BY 
			hi.nom_hipodromo_hnac, ca.num_carrera_hnac ASC",
        GetSQLValueString($fec, "date")
    );
} else {
    $query_Recordset10 = sprintf(
        "/* PARSEADORES1 new\ventashnac_mie\incluir_modificar_dividendos_hnac.php - QUERY 2 */ SELECT 
		ca.cod_carrera_hnac, 
		ca.can_caballos_hnac, 
		ca.num_carrera_hnac,
		ca.hor_carrera_hnac,
		ca.est_carrera_hnac,
		ca.fec_carrera_hnac,
		ca.est_cierre_hnac, 
		hi.nom_hipodromo_hnac,
		hi.cod_hipodromo_hnac
		FROM 
			carrera_hnac ca,
			hipodromo_hnac hi
		WHERE
			hi.cod_hipodromo_hnac = ca.cod_hipodromo_hnac AND
			ca.fec_carrera_hnac = %s 
		ORDER BY 
			hi.nom_hipodromo_hnac, ca.num_carrera_hnac ASC",
        GetSQLValueString($fec, "date")
    );
}
$Recordset10 = mysqli_query($conexionbanca, $query_Recordset10) or die(mysqli_error($conexionbanca));
$row_Recordset10 = mysqli_fetch_assoc($Recordset10);
$totalRows_Recordset10 = mysqli_num_rows($Recordset10);
if ((isset($_POST["MM_update2"]))) {
    $calc=0;
    $j=$_POST["linea"];
    list($a1, $a2, $add_Edit1, $t1)=buscaDivTaquilla($_POST["cod_carrera_hnac"], $_POST["fec_carrera_hnac"], $_POST["cod_taquilla"], 1, 11);
    list($b1, $b2, $add_Edit3, $t3)=buscaDivTaquilla($_POST["cod_carrera_hnac"], $_POST["fec_carrera_hnac"], $_POST["cod_taquilla"], 1, 21);
    
    if ($add_Edit1==0 && $_POST["eje1_c".$j]!="" && $_POST["div1g_c".$j]!="" && $_POST["eje1_c".$j]>0 && $_POST["div1g_c".$j]>0) {
        if ($_POST["eje1_c".$j]=="") {
            $_POST["eje1_c".$j]=0;
        }
        if ($_POST["div1g_c".$j]=="") {
            $_POST["div1g_c".$j]=0;
        }
        $_POST["eje1_c".$j]=$_POST["eje1_c".$j]*1;
        $insertSQL = sprintf(
            "/* PARSEADORES1 new\ventashnac_mie\incluir_modificar_dividendos_hnac.php - QUERY 3 */ INSERT INTO resultados_hnac (
			fec_resultado_hnac, 
			cod_carrera_hnac, 
			num_caballo_hnac, 
			div_pago_hnac, 
			cod_tventa_hnac, 
			lin_dividendo, 
			cod_taquilla) 
			
			VALUES (%s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($_POST["fec_carrera_hnac"], "date"),
            GetSQLValueString($_POST["cod_carrera_hnac"], "int"),
            GetSQLValueString($_POST["eje1_c".$j], "text"),
            GetSQLValueString($_POST["div1g_c".$j], "double"),
            GetSQLValueString(1, "int"),
            GetSQLValueString(11, "int"),
            GetSQLValueString($_POST["cod_taquilla"], "int")
        );
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        $calc=1;
    }
    if ($add_Edit3==0) {
        if ($_POST["eje2_c".$j]!="" && $_POST["eje2_c".$j]>0 && $_POST["div2g_c".$j]!="" && $_POST["div2g_c".$j]>0) {
            if ($_POST["div2g_c".$j]=="") {
                $_POST["div2g_c".$j]=0;
            }
            $_POST["eje2_c".$j]=$_POST["eje2_c".$j]*1;
            $insertSQL = sprintf(
                "/* PARSEADORES1 new\ventashnac_mie\incluir_modificar_dividendos_hnac.php - QUERY 4 */ INSERT INTO resultados_hnac (
				fec_resultado_hnac, 
				cod_carrera_hnac, 
				num_caballo_hnac, 
				div_pago_hnac, 
				cod_tventa_hnac, 
				lin_dividendo, 
				cod_taquilla) 
				
				VALUES (%s, %s, %s, %s, %s, %s, %s)",
                GetSQLValueString($_POST["fec_carrera_hnac"], "date"),
                GetSQLValueString($_POST["cod_carrera_hnac"], "int"),
                GetSQLValueString($_POST["eje2_c".$j], "text"),
                GetSQLValueString($_POST["div2g_c".$j], "double"),
                GetSQLValueString(1, "int"),
                GetSQLValueString(21, "int"),
                GetSQLValueString($_POST["cod_taquilla"], "int")
            );
            $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
            $calc=1;
        }
    }
    if ($add_Edit1==1 && $_POST["codResul1".$j]!=0 && $_POST["mod_divid_hnac"]==1 && $_POST["eje1_c".$j]!="" && $_POST["div1g_c".$j]!="" && $_POST["eje1_c".$j]>0 && $_POST["div1g_c".$j]>0) {
        if ($_POST["eje1_c".$j]=="") {
            $_POST["eje1_c".$j]=0;
        }
        if ($_POST["div1g_c".$j]=="") {
            $_POST["div1g_c".$j]=0;
        }
        $_POST["eje1_c".$j]=$_POST["eje1_c".$j]*1;
        $insertSQL1 = sprintf(
            "/* PARSEADORES1 new\ventashnac_mie\incluir_modificar_dividendos_hnac.php - QUERY 5 */ UPDATE resultados_hnac 
				SET 
				num_caballo_hnac=%s, 
				div_pago_hnac=%s 
				WHERE cod_resultado_hnac=%s",
            GetSQLValueString($_POST["eje1_c".$j], "text"),
            GetSQLValueString($_POST["div1g_c".$j], "double"),
            GetSQLValueString($_POST["codResul1".$j], "int")
        );
        
        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        $calc=1;
    }
    if ($add_Edit3==1 && $_POST["codResul3".$j]!=0 && $_POST["mod_divid_hnac"]==1) {
        if ($_POST["eje2_c".$j]!="" && $_POST["eje2_c".$j]>0 && $_POST["div2g_c".$j]!="" && $_POST["div2g_c".$j]>0) {
            if ($_POST["div2g_c".$j]=="") {
                $_POST["div2g_c".$j]=0;
            }
            $_POST["eje2_c".$j]=$_POST["eje2_c".$j]*1;
            $insertSQL1 = sprintf(
                "/* PARSEADORES1 new\ventashnac_mie\incluir_modificar_dividendos_hnac.php - QUERY 6 */ UPDATE resultados_hnac 
					SET 
					num_caballo_hnac=%s, 
					div_pago_hnac=%s 
					WHERE cod_resultado_hnac=%s",
                GetSQLValueString($_POST["eje2_c".$j], "text"),
                GetSQLValueString($_POST["div2g_c".$j], "double"),
                GetSQLValueString($_POST["codResul3".$j], "int")
            );
            
            $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
            $calc=1;
        }
    }
    if ($calc==1) {
        $car=$_POST["cod_carrera_hnac"];
        $taq=$_POST["cod_taquilla"];
        $fec=fechaactualbd();
        $query_Recordset1 = sprintf(
            "/* PARSEADORES1 new\ventashnac_mie\incluir_modificar_dividendos_hnac.php - QUERY 7 */ SELECT 
			ve.num_ticket_hnac, ve.mon_venta_hnac, ve.cod_tventa_hnac, ca.est_cierre_hnac, ve.num_caballo_hnac, tp.cab_min_hnac
			FROM 
			venta_hnac ve, 
			carrera_hnac ca, 
			usuario us,
			taquilla_opc_hnac tp
			WHERE 
			ve.cod_carrera_hnac = %s AND
			tp.cod_taquilla = %s AND
			ve.fec_venta_hnac = %s AND
			ve.est_ticket_hnac = 1 AND
			ve.id_usuario = us.id_usuario AND
			us.cod_taquilla  = tp.cod_taquilla AND 
			ca.cod_carrera_hnac = ve.cod_carrera_hnac",
            GetSQLValueString($car, "int"),
            GetSQLValueString($taq, "int"),
            GetSQLValueString($fec, "date")
        );
        $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
        $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
        $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
        if ($totalRows_Recordset1>0) {
            if (is_file('../includes/calculodepago_hnac.php')) {
                include("../includes/calculodepago_hnac.php");
            }
            $montoapagar=0;
            $query_Recordset13 = sprintf("/* PARSEADORES1 new\ventashnac_mie\incluir_modificar_dividendos_hnac.php - QUERY 8 */ SELECT num_caballo_hnac FROM resultados_hnac WHERE 
				cod_carrera_hnac = %s", GetSQLValueString($car, "int"));
            $Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
            $row_Recordset13 = mysqli_fetch_assoc($Recordset13);
            $totalRows_Recordset13 = mysqli_num_rows($Recordset13);
            if ($totalRows_Recordset13>0) {
                $retirados=arrayRetiradosHNAC($car);
                $editFormAction = $_SERVER['PHP_SELF'];
                $montoapagar=0;
                $montoretiro=0;
                $i=0;
                $estado=array(0);
                $x_nTicket=array(0);
                $x_pagoSencillo=array(0);
                $cabMin=$row_Recordset1['cab_min_hnac'];
                $tEjem=enCarrera_HNAC($car);//ejemplares en carrera
                if ($row_Recordset1['est_cierre_hnac']!=0 && $tEjem>=$cabMin) {
                    do {
                        $pago[0]=0;
                        $pago[1]="";
                        $retiro=0;
                        if ($retirados[0]!="0") {
                            if (in_array($row_Recordset1['num_caballo_hnac'], $retirados, true)) {
                                $retiro=1;
                            }
                            if ($row_Recordset1['cod_tventa_hnac']>=4 && $row_Recordset1['cod_tventa_hnac']<=9) {
                                $fcab=explode("-", $row_Recordset1['num_caballo_hnac']);
                                foreach ($fcab as $mtz1) {
                                    if (in_array($mtz1, $retirados, true)) {
                                        $retiro=1;
                                        break;
                                    }
                                }
                            }
                        }
                        if ($retiro==0) {
                            if ($row_Recordset1['cod_tventa_hnac']>=1 && $row_Recordset1['cod_tventa_hnac']<=3) {
                                $numCab=$row_Recordset1['num_caballo_hnac'];
                                $tipVenta=$row_Recordset1['cod_tventa_hnac'];
                                $monVenta=$row_Recordset1['mon_venta_hnac'];
                                $pago=jNormaSimpleHNAC($numCab, $car, $fec, $monVenta, $taq, $tipVenta);
                                if ($pago[0]>0) {
                                    $montoapagar=$pago[0]+$montoapagar;
                                    $x_nTicket[$i]=$row_Recordset1['num_ticket_hnac'];
                                    $estado[$i]=$pago[1];
                                    $x_pagoSencillo[$i]=$pago[0];
                                    $i=$i+1;
                                } else {
                                    $x_nTicket[$i]=$row_Recordset1['num_ticket_hnac'];
                                    $estado[$i]=1;
                                    $x_pagoSencillo[$i]=0;
                                    $i=$i+1;
                                }
                            }
                        } else {
                            $montoretiro=$montoretiro+$row_Recordset1['mon_venta_hnac'];
                            $x_nTicket[$i]=$row_Recordset1['num_ticket_hnac'];
                            $estado[$i]="4";
                            $x_pagoSencillo[$i]=$row_Recordset1['mon_venta_hnac'];
                            $i=$i+1;
                        }
                    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
                } else {
                    if ($tEjem<$cabMin) {
                        do {
                            $montoapagar=$montoapagar+$row_Recordset1['mon_venta_hnac'];
                            $x_nTicket[$i]=$row_Recordset1['num_ticket_hnac'];
                            $estado[$i]="5";
                            $x_pagoSencillo[$i]=$row_Recordset1['mon_venta_hnac'];
                            $i=$i+1;
                        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
                    }
                }
                $x=0;
                do {
                    $updateSQL3 = sprintf(
                        "/* PARSEADORES1 new\ventashnac_mie\incluir_modificar_dividendos_hnac.php - QUERY 9 */ UPDATE venta_hnac 
						SET pag_premio_hnac=%s, est_calculo_hnac=%s 
						WHERE num_ticket_hnac=%s",
                        GetSQLValueString($x_pagoSencillo[$x], "double"),
                        GetSQLValueString($estado[$x], "int"),
                        GetSQLValueString($x_nTicket[$x], "int")
                    );
                    $Result3 = mysqli_query($conexionbanca, $updateSQL3) or die(mysqli_error($conexionbanca));
                    $x++;
                } while ($x < $i);
            }
        }
        if (isset($Recordset1)) {
            mysqli_free_result($Recordset1);
        }
        if (isset($Recordset13)) {
            mysqli_free_result($Recordset13);
        }
    }
}
$query_Recordset16 = sprintf(
    "/* PARSEADORES1 new\ventashnac_mie\incluir_modificar_dividendos_hnac.php - QUERY 10 */ SELECT 
		tp.mod_divid_hnac, tp.est_pla_hnac, tp.def_rin_regdiv_hnac,tp.def_ran_regdiv_hnac,tp.def_val_regdiv_hnac,
		tp.def_san_regdiv_hnac, est_ven_ran_hnac, est_ven_san_hnac, est_ven_val_hnac, est_ven_rin_hnac,
		tp.pre_fijo_hnac 
		FROM 
			taquilla ta, 
			taquilla_opc_hnac tp 
		WHERE 
			ta.cod_taquilla = tp.cod_taquilla AND
			ta.cod_taquilla = %s 
		LIMIT 1",
    GetSQLValueString($codTaq, "int")
);
$Recordset16 = mysqli_query($conexionbanca, $query_Recordset16) or die(mysqli_error($conexionbanca));
$row_Recordset16 = mysqli_fetch_assoc($Recordset16);
$totalRows_Recordset16 = mysqli_num_rows($Recordset16);
$mod_divid_hnac=$row_Recordset16['mod_divid_hnac'];
if ($row_Recordset10['cod_hipodromo_hnac']==1) {
    $defi_regla=$row_Recordset16['def_ran_regdiv_hnac']; // ran
    $estVenta=$row_Recordset16['est_ven_ran_hnac'];
}
if ($row_Recordset10['cod_hipodromo_hnac']==2) {
    $defi_regla=$row_Recordset16['def_san_regdiv_hnac'];// san
    $estVenta=$row_Recordset16['est_ven_san_hnac'];
}
if ($row_Recordset10['cod_hipodromo_hnac']==3) {
    $defi_regla=$row_Recordset16['def_val_regdiv_hnac'];// val
    $estVenta=$row_Recordset16['est_ven_val_hnac'];
}
if ($row_Recordset10['cod_hipodromo_hnac']==4) {
    $defi_regla=$row_Recordset16['def_rin_regdiv_hnac'];// rin
    $estVenta=$row_Recordset16['est_ven_rin_hnac'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<link rel="stylesheet" type="text/css" href="../css/tcal.css" />
<script type="text/javascript" src="../js/tcal.js"></script>
<script src="../js/jquery-1.9.1.min.js"></script>
<script language="javascript"> 
	function cambiacolor_over(celda){ celda.style.backgroundColor="#FFF" }  
	function cambiacolor_out(celda){ celda.style.backgroundColor="#E5E5E5" } 
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
function validarNro(e) {
	cuenta=0;
	var key; if(window.event) { key = e.keyCode; } else if(e.which) { key = e.which; } 
	if (key < 48 || key > 57) { if(key == 8 ) { return true; }
	else { return false; } } return true;
}
function rangoEjempar(field, menor, mayor){
	var fi=document.getElementById(field);
	var va=document.getElementById(field).value;
	var me=menor, ma=mayor;
	var mensajeerror1="excede la cantidad de ejemplares ";
	var mensajeerror2="valores entre "+me+" y "+ma;
	if (va!="") {
		if (va>ma){
			alert(mensajeerror1);
			document.getElementById(field).focus();
			document.getElementById(field).value="";
		}
		if (va<me){
			alert(mensajeerror2);
			document.getElementById(field).focus();
			document.getElementById(field).value="";
		}
	}
}

</script>
<style> 

input[type=submit]{
   width: 80px; 
   height: 52px; 
   float: right; 
   margin: 0 15px 0 0;
   cursor: pointer;
   text-align:center;
   }

</style> 

<link href="../estilo/twoColFixLtHdr.css" rel="stylesheet" type="text/css" />
</head>

<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div style="width:100%">
	<div style="background: #333; width:100%; float:left; padding:1% 0% 1% 0%; color:#FFF; font-size:28px; 
   		text-align:center">
       DIVIDENDOS
	</div><!-- end .container -->
  <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off"  
	onsubmit="return chequearEnvio();">   
     <div style="width:99%; float:left; text-align:right; padding:1% 0% 1% 1%;font-size:16px;">
     	<div style="width:77%; float:left; padding:5px 0px 0px 0px; text-align:right">
          Dividendos anteriores: 
   		  <input name="fecha_inicio" style="font-size:16px; width:90px; heigth:18px;" type="text" id="fecha" 
        	tabindex="1" title="formato: dd-mm-aaaa" class="tcal" 
        	value="<?php echo htmlentities($fechaInicial, ENT_COMPAT, 'utf-8'); ?>"/>
        </div>
     	<div style="width:21%; float:left; padding:0px 0px 0px 5px; text-align:left">
          <input type="submit" value="Buscar" onClick="return enviado()" title="buscar dividendos anteriores"
          style="height:37px;"/>
        </div>
     </div>
     <input type="hidden" name="MM_update" value="form1" />
  </form>
  <div style="background:#0E5157; width:99%; float:left; padding:0px 0px 0px 5px"> 
	<?php
    $c=1;
    if ($totalRows_Recordset10>=1) {?> 
		<table width="100%" style="border-spacing: 0;">
		<?php
        do {
            $codCar=$row_Recordset10['cod_carrera_hnac'];
            $ejeMax=$row_Recordset10['can_caballos_hnac'];
            if ($c==1) {
                ?>          
        <tr>
          <td height="50" colspan="3" align="left" valign="bottom" 
            	style="font-size:22px; text-align:left; background:#0E5157; color:#FFF">
          </td>
          <td colspan="3" align="left" valign="bottom">
          	<?php
              if ($row_Recordset16['pre_fijo_hnac']==1) {?>
          	<input type="submit" value="Precio Fijo" onClick="location.href = 'incluir_modificar_preciofijo_hnac.php' "
            title="precio fijo" style="font-size:16px; width:95px; height:40px"/>
			<?php } ?>
          </td>
        </tr>
        <tr>
          <td colspan="6" align="left" valign="top"style="font-size:1px;background:#000000;">&nbsp;</td>
        </tr>

		<?php
            } ?>          
        <tr>
        <?php
        if ($row_Recordset10['est_carrera_hnac']==0 && $row_Recordset10['est_cierre_hnac']==1) {
            $codCar=$row_Recordset10['cod_carrera_hnac'];
            $fec=$row_Recordset10['fec_carrera_hnac'];
            $ej1si="";
            $di1si="";
            $ej2si="";
            $ej3si="";
            $ej4si="";
            list($ej1si, $di1si)=buscaDivOficiales($codCar, $fec, 1, 11);
            if ($ej1si!=0 || $ej1si!="") {
                list($ej2si, $di2si)=buscaDivOficiales($codCar, $fec, 2, 12);
                list($ej3si, $di3si)=buscaDivOficiales($codCar, $fec, 3, 13);
                list($ej4si, $di4si)=buscaDivOficiales($codCar, $fec, 4, 14);
                list($ej1do, $di1do)=buscaDivOficiales($codCar, $fec, 1, 21);
                list($ej2do, $di2do)=buscaDivOficiales($codCar, $fec, 2, 22);
                list($ej3do, $di3do)=buscaDivOficiales($codCar, $fec, 3, 23);
                list($ej4do, $di4do)=buscaDivOficiales($codCar, $fec, 4, 24);
                if ($ej1do>0) {
                    list($ej1tr, $di1tr)=buscaDivOficiales($codCar, $fec, 1, 31);
                    list($ej2tr, $di2tr)=buscaDivOficiales($codCar, $fec, 2, 32);
                    list($ej3tr, $di3tr)=buscaDivOficiales($codCar, $fec, 3, 33);
                    list($ej4tr, $di4tr)=buscaDivOficiales($codCar, $fec, 4, 34);
                } ?>    
              <td rowspan="2" style="font-size:10px; text-align:left; background:#0E5157; color:#FF0"><span style="font-size:18px; text-align:left; background:#0E5157; color:#FF0"><?php echo $row_Recordset10['nom_hipodromo_hnac']. " Carrera N°:".$row_Recordset10['num_carrera_hnac']."<br/>";
                if ($row_Recordset10['est_carrera_hnac']==0 && $row_Recordset10['est_cierre_hnac']==0) {
                    echo '&nbsp;<font color="#FFFFFF" style="background:#990000">&nbsp;CANCELADA&nbsp;</font>';
                }
                if ($row_Recordset10['est_carrera_hnac']==0 && $row_Recordset10['est_cierre_hnac']>=1 && $row_Recordset10['est_cierre_hnac']<=2) {
                    echo '&nbsp;<font color="#FFFFFF">&nbsp;CERRADA&nbsp;</font>';
                }
                if ($row_Recordset10['est_carrera_hnac']==1 && $row_Recordset10['est_cierre_hnac']==3) {
                    echo '&nbsp;<font color="GREEN" style="background:#FFFFFF">&nbsp;ABIERTA&nbsp;</font>';
                } ?></span></td>
              <td height="1" colspan="2" align="right" valign="top"style="font-size:10px;background:#0E5157; color:#000">
				  <?php
                  echo '<span style="font-size:14px; text-align:left; background:#0E5157; color:#FFF">';
                echo "Carrera #".$row_Recordset10['num_carrera_hnac'];
                echo '</span>'; ?>              
              </td>
          <td align="right" valign="bottom" bgcolor="#333333"style="font-size:12px;color:#FFF">Ejem</td>
              <td align="right" valign="bottom" bgcolor="#333333"style="font-size:12px; color:#FFF">DIV</td>
              <td align="right" valign="bottom" bgcolor="#333333"style="font-size:12px;color:#FFF">-</td>
            <?php
            } else {?>      
              <td rowspan="2" style="font-size:10px; text-align:left; background:#0E5157; color:#FF0">
              <span style="font-size:18px; text-align:left; background:#0E5157; color:#FF0">
			  <?php echo $row_Recordset10['nom_hipodromo_hnac']. " Carrera N°:".$row_Recordset10['num_carrera_hnac']."<br/>";
               if ($row_Recordset10['est_carrera_hnac']==0 && $row_Recordset10['est_cierre_hnac']==0) {
                   echo '&nbsp;<font color="#FFFFFF" style="background:#990000">&nbsp;CANCELADA&nbsp;</font>';
               }
               if ($row_Recordset10['est_carrera_hnac']==0 && $row_Recordset10['est_cierre_hnac']>=1 && $row_Recordset10['est_cierre_hnac']<=2) {
                   echo '&nbsp;<font color="#FFFFFF">&nbsp;CERRADA&nbsp;</font>';
               }
               if ($row_Recordset10['est_carrera_hnac']==1 && $row_Recordset10['est_cierre_hnac']==3) {
                   echo '&nbsp;<font color="GREEN" style="background:#FFFFFF">&nbsp;ABIERTA&nbsp;</font>';
               }
            ?></span></td>
              <td height="1" colspan="2" align="right" valign="top"style="font-size:10px;background:#0E5157; color:#000">&nbsp;
				         
              </td>
          <td align="right" valign="bottom" style="font-size:12px;color:#FFF">&nbsp;</td>
              <td align="right" valign="bottom" style="font-size:12px; color:#FFF">&nbsp;</td>
              <td align="right" valign="bottom" style="font-size:12px;color:#FFF">&nbsp;</td>
        	
			<?php
            }
        } ?>      
        </tr>
        <tr>
        <?php
          if (isset($ej1si) && $ej1si!=0 && $ej1si!="" && $row_Recordset10['est_carrera_hnac']==0 && $row_Recordset10['est_cierre_hnac']>=1 && $row_Recordset10['est_cierre_hnac']<=2) {
              ?>		
          <td colspan="2" align="right" valign="top" bgcolor="#333333"style="font-size:22px;color:#FFF">
          <?php
          if ($row_Recordset10['est_carrera_hnac']==0 && $row_Recordset10['est_cierre_hnac']>=1 && $row_Recordset10['est_cierre_hnac']<=2) {?>
          <span style="font-size:12px; text-align:left; background:#0E5157; color:#FFF">Dividendos oficiales:</span><?php
          } ?>
          </td>
          <td align="right" valign="top" bgcolor="#333333"style="font-size:12px;color:#FFF">
		  <?php
            echo $ej1si;
              if (isset($ej1do) && $ej1do!=0 && $ej1do!="") {
                  echo"/".$ej1do;
                  if (isset($ej1tr) && $ej1tr!=0 && $ej1tr!="") {
                      echo"/".$ej1tr;
                  }
              }
              if (isset($ej2si) && $ej2si!=0 && $ej2si!="") {
                  echo "<br/>".$ej2si;
                  if (isset($ej2do) && $ej2do!=0 && $ej2do!="") {
                      echo"/".$ej2do;
                      if (isset($ej2tr) && $ej2tr!=0 && $ej2tr!="") {
                          echo"/".$ej2tr;
                      }
                  }
                  if (isset($ej3si) && $ej3si!=0 && $ej3si!="") {
                      echo "<br/>".$ej3si;
                      if (isset($ej3do) && $ej3do!=0 && $ej3do!="") {
                          echo"/".$ej3do;
                          if (isset($ej3tr) && $ej3tr!=0 && $ej3tr!="") {
                              echo"/".$ej3tr;
                          }
                      }
                      if (isset($ej4si) && $ej4si!=0 && $ej4si!="") {
                          echo "<br/>".$ej4si;
                          if (isset($ej4do) && $ej4do!=0 && $ej4do!="") {
                              echo"/".$ej4do;
                              if (isset($ej4tr) && $ej4tr!=0 && $ej4tr!="") {
                                  echo"/".$ej4tr;
                              }
                          }
                      }
                  }
              } ?>
          </td>
          <td align="right" valign="top" bgcolor="#333333"style="font-size:12px;color:#FFF">
		  <?php echo $di1si; ?>
          </td>
          <td align="right" valign="top" bgcolor="#333333"style="font-size:12px;color:#FFF">
		  <?php
            echo ""; ?>
          </td>
          <?php
          } ?>      
        </tr>
        <?php
        if ($row_Recordset10['est_carrera_hnac']==0 && ($row_Recordset10['est_cierre_hnac']>=1 && $row_Recordset10['est_cierre_hnac']<=2) && $defi_regla==0 && $estVenta==1) {
            list($eje1_c, $div1g_c, $addEdit1, $codResul1)=buscaDivTaquilla($codCar, $fec, $codTaq, 1, 11);
            list($eje2_c, $div2g_c, $addEdit3, $codResul3)=buscaDivTaquilla($codCar, $fec, $codTaq, 1, 21);
            $editFormAction2 = $_SERVER['PHP_SELF']; ?>
        <tr>
          <td bgcolor="#FFCC00" style="font-size:12px; text-align:left; color:#333333">
		  	Retirados
          </td>
          <td colspan="5" align="center" valign="bottom" bgcolor="#FFFF99" style="font-size:12px; text-align:left;">
          	Resultados y Dividendos 
          </td>
        </tr>
        <tr style="color:#000; font-family:Verdana, Geneva, sans-serif; font-size:10px">
          <td width="39%" bgcolor="#FFFFFF">&nbsp;</td>
          <td width="15%" bgcolor="#CCCCCC">Ejemplar</td>
          <td width="15%" bgcolor="#CCCCCC">Gan</td>
          <td colspan="3" bgcolor="#CCCCCC" style="font-size:10px;">
           <?php if ($mod_divid_hnac==0 && $addEdit1==1) {
                echo "Taquilla no puede modificar dividendos ";
            } ?>
          </td>
        </tr>
	    <form action="<?php echo $editFormAction2; ?>" method="post" name="form2" id="form2" autocomplete="off"  
          onsubmit="return chequearEnvio();">
        <tr>
          <td rowspan="4" align="left" valign="top" bgcolor="#FFFFFF" style="font-size:9px">
          <?php verRetirados_hnac($codCar); ?>
          </td>
          <td height="30" valign="top" bgcolor="#CCCCCC">
          <?php
          if ($defi_regla==0 && $estVenta==1) {?>
          	<input name="<?php echo "eje1_c".$c;?>"  type="text"
            onkeypress="javascript:return validarNro(event)"
            onblur="rangoEjempar('<?php echo "eje1_c".$c;?>',<?php echo "1";?>,<?php echo $ejeMax; ?>)" 
            id="<?php echo "eje1_c".$c;?>" tabindex="3" title="indique ejemplar" 
            value="<?php echo htmlentities($eje1_c, ENT_COMPAT, 'utf-8'); ?>"
           <?php if ($mod_divid_hnac==0 && $addEdit1==1) {
              echo 'disabled style="font-size:18px; width:28px; heigth:17px;background:#CCC;"';
          } else {
               echo 'style="font-size:18px; width:28px; heigth:17px;background:#FFF "';
           }?> />
           <?php
           } ?>
		  </td>
          <td valign="top" bgcolor="#CCCCCC">
		<?php
          if ($defi_regla==0 && $estVenta==1) {?>
          	<input name="<?php echo "div1g_c".$c;?>" type="text" 
            onkeypress="javascript:return validarNro(event)"
            id="<?php echo "div1g_c".$c;?>" tabindex="4" title="indique dividendo" 
            value="<?php echo htmlentities($div1g_c, ENT_COMPAT, 'utf-8'); ?>"
           <?php if ($mod_divid_hnac==0 && $addEdit1==1) {
              echo 'disabled style="font-size:18px; width:60px; heigth:17px;background:#CCC;"';
          } else {
               echo 'style="font-size:18px; width:60px; heigth:17px;background:#FFF;"';
           }?> />
           <?php
           } ?>
          </td>
          <td colspan="3" rowspan="4" align="center" bgcolor="#CCCCCC" style="padding:0px 0px 0px 10px">
            <?php
            if ($defi_regla==0 && $estVenta==1) {
                if ($row_Recordset10['est_carrera_hnac']==0 && $eje1_c=="") {
                    ?>
				<input type="submit" value="Guardar" onClick="return enviado()" 
                title="guardar resultados y dividendos" 
				tabindex="6" style="font-size:18px; width:95px"/>
				<?php
                } else {?>
				<input type="submit" value="Modificar" onClick="return enviado()" 
                title="modificar resultados y dividendos" 
				tabindex="6" style="font-size:18px; width:95px" <?php if ($mod_divid_hnac==0 || $estVenta==0) {
                    echo "disabled";
                } ?> />
				<?php
              }
            } ?>
          </td>
        </tr>
        <tr bgcolor="#FFFFFF" style="font-family:Verdana, Geneva, sans-serif; font-size:10px">
          <td height="20" colspan="2" align="center" valign="bottom" bgcolor="#999999">Empate</td>
          </tr>
        <tr bgcolor="#FFFFFF" style="font-family:Verdana, Geneva, sans-serif; font-size:10px">
          <td bgcolor="#999999">Ejemplar</td>
          <td bgcolor="#999999">Gan</td>
          </tr>
        <tr bgcolor="#FFFFFF">
          <td height="30" valign="top" bgcolor="#999999">
		<?php
          if ($defi_regla==0 && $estVenta==1) {?>
          	<input name="<?php echo "eje2_c".$c;?>" type="text"
            onkeypress="javascript:return validarNro(event)"
            onblur="rangoEjempar('<?php echo "eje2_c".$c;?>',<?php echo "1";?>,<?php echo $ejeMax; ?>)" 
            id="<?php echo "eje2_c".$c;?>" tabindex="3" title="indique ejemplar" 
            value="<?php echo htmlentities($eje2_c, ENT_COMPAT, 'utf-8'); ?>"
           <?php if (($mod_divid_hnac==0 && $addEdit3==1)) {
              echo 'disabled style="font-size:18px; width:28px; heigth:17px;background:#CCC;"';
          } else {
               echo 'style="font-size:18px; width:28px; heigth:17px;background:#FFF "';
           }?> />
           <?php
           } ?>
		  </td>
          <td valign="top" bgcolor="#999999">
		<?php
          if ($defi_regla==0 && $estVenta==1) {?>
          	<input name="<?php echo "div2g_c".$c;?>" type="text"
            onkeypress="javascript:return validarNro(event)" 
            id="<?php echo "div2g_c".$c;?>" tabindex="7" title="indique dividendo" 
            value="<?php echo htmlentities($div2g_c, ENT_COMPAT, 'utf-8'); ?>"
           <?php if (($mod_divid_hnac==0 && $addEdit3==1)) {
              echo 'disabled style="font-size:18px; width:60px; heigth:17px;background:#CCC;"';
          } else {
               echo 'style="font-size:18px; width:60px; heigth:17px;background:#FFF "';
           }?> />
           <?php
           } ?>
          </td>
          </tr>
        <tr>
          <td colspan="6" align="left" valign="top"style="font-size:1px;background:#000000;">&nbsp;</td>
        </tr>
        	<input type="hidden" name="linea" value="<?php echo $c; ?>" />
            <input type="hidden" name="<?php echo "codResul1".$c; ?>" value="<?php echo $codResul1; ?>" />
            <input type="hidden" name="<?php echo "codResul3".$c; ?>" value="<?php echo $codResul3; ?>" />
           
            <input type="hidden" name="taquilla_opc_hnac" value="<?php echo $taquilla_opc_hnac; ?>" />
			<input type="hidden" name="mod_divid_hnac" value="<?php echo $mod_divid_hnac; ?>" />
            <input type="hidden" name="cod_carrera_hnac" value="<?php echo $row_Recordset10['cod_carrera_hnac']; ?>" />
            <input type="hidden" name="cod_taquilla" value="<?php echo $codTaq; ?>" />
            <input type="hidden" name="fec_carrera_hnac" value="<?php echo $row_Recordset10['fec_carrera_hnac']; ?>" />
            <input type="hidden" name="MM_update2" value="<?php echo "form2".$c; ?>" />
		</form>

        <?php
        } else {?>
        <tr bgcolor="#FFFFFF">
          <td colspan="6" align="left" valign="bottom" style="font-size:10px">
		  <?php
            if ($row_Recordset10['est_carrera_hnac']==0 && ($row_Recordset10['est_cierre_hnac']>=1 &&
            $row_Recordset10['est_cierre_hnac']<=2) && $defi_regla==1) {
                echo $row_Recordset10['nom_hipodromo_hnac']." Retirados: CARRERA N°:".$row_Recordset10['num_carrera_hnac']."<br/>";
                verRetirados_hnac($codCar);
            }
          ?>
          </td>
        </tr>
		<?php
        }
            $c++;
        } while ($row_Recordset10 = mysqli_fetch_assoc($Recordset10)); ?>
    </table>
	<?php
    } else { ?>
      <table style="width:100%; font-size:28px" align="left">
          <tr class="brillo">
            <td colspan="4"><?php echo "No existen registros";?></td>
        </tr>
    </table>
	<?php }?>
  </div>  
</div><!-- end .container -->
</body>
</html>
<?php
mysqli_free_result($Recordset10);
?>