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
$mError="";
$cCar=-1;
$cTaq=-1;
$cCab=-1;
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if (isset($_POST["MM_insert"]) && $_POST["MM_insert"]=="form1") {
    $fec=fechaactualbd();
    $graba=30;
    if ($_POST["cod_carrera"]==-1) {
        $graba--;
        $mError="&nbsp;*Seleccione una carrera&nbsp;<br/>";
    }
    if ($_POST["cod_ejemplar"]==-1) {
        $graba--;
        $mError=$mError."&nbsp;*Indique ejempar&nbsp;<br/>";
    }
    if ($_POST["prFij"]<=0) {
        $graba--;
        $mError=$mError."&nbsp;*Indique Precio&nbsp;<br/>fijo&nbsp;<br/>";
    }
    $query_Recordset7 = sprintf(
        "/* PARSEADORES1 new\ventashnac_mie\incluir_modificar_preciofijo_hnac.php - QUERY 1 */ SELECT
			ins.nom_caballo_hnac,
			ins.num_caballo_hnac
			FROM 
				precio_fijo_hnac pr,
				inscritos ins
				WHERE 
					pr.cod_taquilla = %s AND
					ins.cod_inscrito_hnac = pr.cod_inscrito_hnac AND
					pr.cod_inscrito_hnac  = %s",
        GetSQLValueString($_POST["cod_taquilla"], "int"),
        GetSQLValueString($_POST["cod_ejemplar"], "int")
    );
    $Recordset7 = mysqli_query($conexionbanca, $query_Recordset7) or die(mysqli_error($conexionbanca));
    $row_Recordset7 = mysqli_fetch_assoc($Recordset7);
    $totalRows_Recordset7 = mysqli_num_rows($Recordset7);
    $acceso=0;
    if ($totalRows_Recordset7>0) {
        $graba--;
        $mError="&nbsp;*Ya existe un precio fijo&nbsp;<br/>&nbsp; para el ejemplar #:".$row_Recordset7['num_caballo_hnac']."&nbsp;<br/>";
        $acceso=1;
    }
    $query_Recordset11 = sprintf(
        "/* PARSEADORES1 new\ventashnac_mie\incluir_modificar_preciofijo_hnac.php - QUERY 2 */ SELECT 
		max_eje_hnac,
		max_jugtic_hnac,
		min_jugtic_hnac 
		FROM 
			taquilla_opc_hnac
		WHERE
			cod_taquilla = %s
		LIMIT 1",
        GetSQLValueString($_POST["cod_taquilla"], "date")
    );
    $Recordset11 = mysqli_query($conexionbanca, $query_Recordset11) or die(mysqli_error($conexionbanca));
    $row_Recordset11 = mysqli_fetch_assoc($Recordset11);
    $totalRows_Recordset11 = mysqli_num_rows($Recordset11);
    if ($totalRows_Recordset11<=0) {
        $graba--;
        $mError="&nbsp;*Configure&nbsp;<br/>&nbsp;primero&nbsp;<br/>&nbsp;datos de taquilla&nbsp;<br/>";
    } else {
        $_POST["apMax"]=$row_Recordset11['max_eje_hnac'];
        $_POST["juMax"]=$row_Recordset11['max_jugtic_hnac'];
        $_POST["juMin"]=$row_Recordset11['min_jugtic_hnac'];
    }
    if ($graba==30) {
        $mError="&nbsp;Datos guardados correctamente&nbsp;<br/>";
        $cCar=$_POST["cod_carrera"];
        $insertSQL = sprintf(
            "/* PARSEADORES1 new\ventashnac_mie\incluir_modificar_preciofijo_hnac.php - QUERY 3 */ INSERT INTO precio_fijo_hnac (
				fec_carrera_hnac, 
				cod_carrera_hnac, 
				cod_inscrito_hnac, 
				cod_taquilla, 
				max_eje_hnac, 
				max_jug_hnac, 
				min_jug_hnac,
				pre_fijo_hnac) 
				VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($fec, "date"),
            GetSQLValueString($cCar, "int"),
            GetSQLValueString($_POST["cod_ejemplar"], "int"),
            GetSQLValueString($_POST["cod_taquilla"], "int"),
            GetSQLValueString($_POST["apMax"], "int"),
            GetSQLValueString($_POST["juMax"], "int"),
            GetSQLValueString($_POST["juMin"], "int"),
            GetSQLValueString($_POST["prFij"], "double")
        );
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
    }
    if ($acceso==1) {
        $graba=30;
        $cCar=$_POST["cod_carrera"];
    }
}

$query_Recordset10 = sprintf(
    "/* PARSEADORES1 new\ventashnac_mie\incluir_modificar_preciofijo_hnac.php - QUERY 4 */ SELECT 
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
$Recordset10 = mysqli_query($conexionbanca, $query_Recordset10) or die(mysqli_error($conexionbanca));
$row_Recordset10 = mysqli_fetch_assoc($Recordset10);
$totalRows_Recordset10 = mysqli_num_rows($Recordset10);
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
function ver() { 
	var xdata = {"cod_carrera"  : $("#cod_carrera").val(),"cod_taquilla" : $("#cod_taquilla").val()};
    $.ajax({url:"buscaEjemplar.php",type: "GET",data:xdata,
    	success: function(opciones){$("#cod_ejemplar").html(opciones);}
    })
}
function eliminar(cod) {
	var xdata = {"id_pfijo" : cod, "cod_taquilla" : $("#cod_taquilla").val()};
    $.ajax({url:"quitarPrecioFijo.php",type: "GET",data:xdata,
    	success: function(opciones){ver();}
    })
}
</script>
<link href="../estilo/twoColFixLtHdr.css" rel="stylesheet" type="text/css" />
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div style="width:100%">
	<div style="background: #333; width:100%; float:left; padding:1% 0% 1% 0%; color:#FFF; font-size:28px; 
   		text-align:center">
       
  		<div style="float:left; width:75%">PRECIO FIJO
        </div>
        <div style="float:left; width:25%;">
       <input type="submit" value="&nbsp;&nbsp;&nbsp;&nbsp;volver a &#x00A; dividendos" onClick="location.href = 'incluir_modificar_dividendos_hnac.php' "
            title="precio fijo" style="font-size:12px; width:85px; height:40px"/>
        </div>          
  </div><!-- end .container -->
  <div style="background:#E5E5E5; width:100%; float:left; padding:0px 0px 0px 0px"> 
		<?php
        if ($totalRows_Recordset10>=1) {?>
			<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off"  
				onsubmit="return chequearEnvio();">
            <table width="100%" style="border-spacing: 0;" cellpadding="0" cellspacing="0">
				<tr>
					<td height="50" colspan="2" align="left" valign="bottom" 
						style="font-size:22px; text-align:left; background:#0E5157; color:#FFF">
                    </td>
					<td height="50" colspan="3" valign="bottom" 
						style="font-size:12px; text-align: right; background:#0E5157; color:#FFF">
                        <?php if (isset($graba) && $graba!=30) {?>
					  	<span style="background:#FF0004"><?php echo $mError; ?></span>
                        <?php } else {
                            if (isset($graba) && $graba==30) {?>
                	    	    <span style="background: #248311"><?php echo $mError; ?></span>
    							<?php
                            }
                        }?>				    
                    </td>
				</tr>
				<tr>
					<td width="36%" height="50" align="left" valign="bottom" bgcolor="#E5E5E5" 
						style="font-size:14px; text-align:left;">&nbsp;
                        Indique la Hipodromo y Carrera:<br/>
						<select name="cod_carrera" id="cod_carrera" style="width:220px; font-size:14px" 
                        	onchange="ver();">
							<option value="-1" <?php if ($row_Recordset10['cod_carrera_hnac']==$cCar) {
                            echo "SELECTED";
                        } ?>
                            style="background:#FF0004; color:#FFFFFF">Seleccione
                            </option>
						<?php
                        do {?>
							<option value="<?php echo $row_Recordset10['cod_carrera_hnac'];?>"
                            <?php if ($row_Recordset10['cod_carrera_hnac']==$cCar) {
                            echo "SELECTED";
                        } ?>> 
							<?php echo $row_Recordset10['nom_hipodromo_hnac']." Carr...#".$row_Recordset10['num_carrera_hnac'];?>
                            </option>
						<?php
                        } while ($row_Recordset10 = mysqli_fetch_assoc($Recordset10));?>
						</select> 
                                          
					</td>
					<td colspan="2" align="left" valign="bottom" bgcolor="#E5E5E5">&nbsp;
                        Ejemplar:<br/>
						<select id="cod_ejemplar" style="width:180px" name="cod_ejemplar" disabled="disabled"
                        onchange="document.getElementById('prFij').focus();">
                        	<option value="-1">
                        	</option>
                        </select>                     
                    </td>
					<td colspan="2" rowspan="2" align="left" valign="middle" bgcolor="#E5E5E5">&nbsp;
                        <input type="submit" value="Guardar" onClick="return enviado()" 
                        title="guardar resultados y dividendos" id="guarda" disabled="disabled"
                        style="font-size:18px; width:95px; height:70px"/>
                    </td>
				</tr>
				<tr>
				  <td height="50" colspan="3" align="left" valign="bottom"  
						style="font-size:14px; text-align:left;background:#FFFFFF; text-align:center">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" 
                        	style="background:#E5E5E5; font-size:12px">
                            <tr>
                              <td colspan="3"><hr/></td>
                            </tr>
                            <tr >
                              <td width="39%" >&nbsp;
                              </td>
                              <td width="28%">&nbsp;
                              </td>
                              <td width="33%" bgcolor="#FFF2C7">Precio fijo:<br/>
          					  	<input name="prFij"  type="text" onkeypress="javascript:return validarNro(event)"
            					id="prFij" title="indique monto de precio fijo al ejemplar" disabled="disabled"
            					value="" style="width:80px; height:28px; font-size:20px" tabindex="3"/>
                              </td>
                              
                            </tr>
                        </table>
                  </td>
			  </tr>
            </table>
				<input type="hidden" name="cod_taquilla" id="cod_taquilla" value="<?php echo $codTaq; ?>" />
                <input type="hidden" name="MM_insert" value="form1" />
			</form>
            <hr/>
		<?php } else {?>
            <table width="100%" style="border-spacing: 0;" cellpadding="0" cellspacing="0">
				<tr>
				  <td height="50" align="center" valign="bottom" 
						style="font-size:18px;background:#0E5157; color:#FFF">
				  		<?php echo 'AUN NO EXISTEN CARRERAS PROGRAMADAS'; ?>
                  </td>
				</tr>
	</table>                
        <?php }?>
  </div>
	<div id="preciof" style="float:left; width:100%; text-align:left; font-size:18px">
    <?php if (isset($graba) && $graba==30) {?><script languaje="javascript">ver();</script><?php }?>
	</div>
</div><!-- end .container -->
</body>
</html>
<?php
mysqli_free_result($Recordset10);
if (isset($Recordset7)) {
    mysqli_free_result($Recordset7);
}
if (isset($Recordset11)) {
    mysqli_free_result($Recordset11);
}
?>