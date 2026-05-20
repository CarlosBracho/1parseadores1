<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xCodigo=0;
$menSorteo="";
$menPrin="";
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    $graba=31;
    if ($_POST['nom_sorteo']=="" || strlen($_POST['nom_sorteo'])<=3) {
        $menSorteo="nombre no válido";
        $graba--;
    }
    if ($_POST['am']=="PM") {
        if ($_POST['hor']!=12) {
            $_POST['hor']=$_POST['hor']+12;
        }
    }
    $hora=$_POST['hor'].":".$_POST['min'].":00";
    if (!isset($_POST['lun'])) {
        $_POST['lun']=0;
    } else {
        $_POST['lun']=1;
    }
    if (!isset($_POST['mar'])) {
        $_POST['mar']=0;
    } else {
        $_POST['mar']=1;
    }
    if (!isset($_POST['mie'])) {
        $_POST['mie']=0;
    } else {
        $_POST['mie']=1;
    }
    if (!isset($_POST['jue'])) {
        $_POST['jue']=0;
    } else {
        $_POST['jue']=1;
    }
    if (!isset($_POST['vie'])) {
        $_POST['vie']=0;
    } else {
        $_POST['vie']=1;
    }
    if (!isset($_POST['sab'])) {
        $_POST['sab']=0;
    } else {
        $_POST['sab']=1;
    }
    if (!isset($_POST['dom'])) {
        $_POST['dom']=0;
    } else {
        $_POST['dom']=1;
    }
    if ($graba==31) {
        $insertSQL1 = sprintf(
            "/* PARSEADORES1 new\admin_lot\admin_sorteos_edit_lot.php - QUERY 1 */ UPDATE sorteos 
				SET
				nom_sorteo=%s, 
				hor_sorteo=%s,
				tur_sorteo=%s, 
				est_sorteo=%s,
				lun=%s,
				mar=%s,
				mie=%s,
				jue=%s,
				vie=%s,
				sab=%s,
				dom=%s 
				WHERE id_sorteo=%s",
            GetSQLValueString(strtoupper($_POST['nom_sorteo']), "text"),
            GetSQLValueString($hora, "date"),
            GetSQLValueString($_POST['tur_sorteo'], "text"),
            GetSQLValueString($_POST['est_sorteo'], "int"),
            GetSQLValueString($_POST['lun'], "int"),
            GetSQLValueString($_POST['mar'], "int"),
            GetSQLValueString($_POST['mie'], "int"),
            GetSQLValueString($_POST['jue'], "int"),
            GetSQLValueString($_POST['vie'], "int"),
            GetSQLValueString($_POST['sab'], "int"),
            GetSQLValueString($_POST['dom'], "int"),
            GetSQLValueString($_POST['id_sorteo'], "int")
        );
        
        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        $menPrin="&nbsp;&nbsp; DATOS DE SORTEO GUARDADOS CORRECTAMENTE &nbsp;&nbsp;";
    }
}
if ((isset($_POST["MM_insert2"])) && ($_POST["MM_insert2"] == "form2")) {
    if (isset($_POST['nom_loteria'])&&isset($_POST['let_loteria'])&&isset($_POST['tip_loteria'])&&isset($_POST['est_loteria'])&&
        isset($_POST['id_sorteo2'])) {
        $let_loteria=$_POST['let_loteria'];
        $tip_loteria=$_POST['tip_loteria'];
        $est_loteria=$_POST['est_loteria'];
        $cta=0;
        $acceso=0;
        foreach ($_POST['nom_loteria'] as $nom_loteria) {
            $query_Recordset2 =  sprintf(
                "/* PARSEADORES1 new\admin_lot\admin_sorteos_edit_lot.php - QUERY 2 */ SELECT 
					lo.nom_loteria, lo.let_loteria
				FROM loterias lo 
				WHERE (lo.nom_loteria = %s OR (let_loteria = %s AND lo.id_sorteo = %s)) AND tip_loteria!=2 LIMIT 1",
                GetSQLValueString(trim($nom_loteria), "text"),
                GetSQLValueString(trim($let_loteria[$cta]), "text"),
                GetSQLValueString($_POST['id_sorteo2'], "int")
            );
            $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
            $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
            $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
            if ($totalRows_Recordset2>0) {
                if ($row_Recordset2['nom_loteria']==trim($nom_loteria)) {
                    $menPrin="&nbsp;&nbsp;NOMBRE DE LOTERIA YA EXISTE&nbsp;&nbsp;";
                } elseif ($row_Recordset2['let_loteria']==trim($let_loteria[$cta])) {
                    $menPrin="&nbsp;&nbsp;CODIGO YA EXISTE&nbsp;&nbsp;";
                }
                $acceso=0;
            } else {
                $acceso=1;
                if ($nom_loteria=="" || strlen($nom_loteria)<=3) {
                    $menPrin="&nbsp;&nbsp;Nombre de loteria debe contener 4 caracteres o mas";
                    $acceso=0;
                }
                if (preg_match("/^[0-9]+$/", $let_loteria[$cta])) {
                    $menPrin="&nbsp;&nbsp;Solo se admiten letras para codigo";
                    $acceso=0;
                }
                if ($let_loteria[$cta]=="") {
                    $menPrin="&nbsp;&nbsp;Indique una letra para codigo";
                    $acceso=0;
                }
            }
            if ($acceso==1) {
                $insertSQL1 = sprintf(
                    "/* PARSEADORES1 new\admin_lot\admin_sorteos_edit_lot.php - QUERY 3 */ INSERT 
				INTO loterias 
				(nom_loteria, let_loteria, tip_loteria, est_loteria, id_sorteo) 
				VALUES (%s, %s, %s, %s, %s)",
                    GetSQLValueString(strtoupper($nom_loteria), "text"),
                    GetSQLValueString(strtoupper($let_loteria[$cta]), "text"),
                    GetSQLValueString($tip_loteria[$cta], "int"),
                    GetSQLValueString($est_loteria[$cta], "int"),
                    GetSQLValueString($_POST['id_sorteo2'], "int")
                );
                $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
                $idTriple=mysqli_insert_id($conexionbanca);
                $menPrin="&nbsp;&nbsp; DATOS DE LOTERIA GUARDADOS CORRECTAMENTE &nbsp;&nbsp;";
                if ($tip_loteria[$cta]==1 or $tip_loteria[$cta]==3) {
                    $nTerminal=strtoupper($nom_loteria)."t";
                    $insertSQL2 = sprintf(
                        "/* PARSEADORES1 new\admin_lot\admin_sorteos_edit_lot.php - QUERY 4 */ INSERT 
					INTO loterias 
					(nom_loteria, let_loteria, tip_loteria, est_loteria, id_triple, id_sorteo) 
					VALUES (%s, %s, %s, %s, %s, %s)",
                        GetSQLValueString($nTerminal, "text"),
                        GetSQLValueString(strtoupper($let_loteria[$cta]), "text"),
                        GetSQLValueString(2, "int"),
                        GetSQLValueString($est_loteria[$cta], "int"),
                        GetSQLValueString($idTriple, "int"),
                        GetSQLValueString($_POST['id_sorteo2'], "int")
                    );
                    $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
                    $idTerminal=mysqli_insert_id($conexionbanca);
                    $insertSQL1 = sprintf(
                        "/* PARSEADORES1 new\admin_lot\admin_sorteos_edit_lot.php - QUERY 5 */ UPDATE loterias 
							SET
							id_terminal=%s 
							WHERE id_loteria=%s",
                        GetSQLValueString($idTerminal, "int"),
                        GetSQLValueString($idTriple, "int")
                    );
                    $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
                }
                $query_Recordset3 = sprintf(
                    "/* PARSEADORES1 new\admin_lot\admin_sorteos_edit_lot.php - QUERY 6 */ SELECT hor_sorteo, lun, mar, mie, jue, vie, sab, dom 
					FROM sorteos 
					WHERE id_sorteo = %s LIMIT 1",
                    GetSQLValueString($_POST['id_sorteo2'], "int")
                );
                $Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
                $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
                $totalRows_Recordset3 = mysqli_num_rows($Recordset3);
                $query_Recordset4 = sprintf("/* PARSEADORES1 new\admin_lot\admin_sorteos_edit_lot.php - QUERY 7 */ SELECT id_banca FROM bancaloterias GROUP BY id_banca");
                $Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
                $row_Recordset4 = mysqli_fetch_assoc($Recordset4);
                $totalRows_Recordset4 = mysqli_num_rows($Recordset4);
                if ($totalRows_Recordset4>0) {
                    if ($tip_loteria[$cta]==1) {
                        $top_venta=100;
                        $pre_triple=600;
                        $pre_terminal=60;
                    } elseif ($tip_loteria[$cta]==3) {
                        $top_venta=50;
                        $pre_triple=6000;
                        $pre_terminal=600;
                    } elseif ($tip_loteria[$cta]==4) {
                        $top_venta=50;
                        $pre_triple=300;
                        $pre_terminal=600;
                    } elseif ($tip_loteria[$cta]==5) {
                        $top_venta=50;
                        $pre_triple=300;
                        $pre_terminal=600;
                    } elseif ($tip_loteria[$cta]==6) {
                        $top_venta=50;
                        $pre_triple=320;
                        $pre_terminal=600;
                    }
                    do {
                        $insertSQL1 = sprintf(
                            "/* PARSEADORES1 new\admin_lot\admin_sorteos_edit_lot.php - QUERY 8 */ INSERT 
						INTO bancaloterias 
						(id_banca, id_loteria, est_banlot, hor_cierre, top_venta, pre_loteria, lun_loteriabanca, mar_loteriabanca, 
						mie_loteriabanca, jue_loteriabanca, vie_loteriabanca, sab_loteriabanca, dom_loteriabanca) 
						VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                            GetSQLValueString($row_Recordset4['id_banca'], "int"),
                            GetSQLValueString($idTriple, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString($row_Recordset3['hor_sorteo'], "date"),
                            GetSQLValueString($top_venta, "int"),
                            GetSQLValueString($pre_triple, "double"),
                            GetSQLValueString($row_Recordset3['lun'], "int"),
                            GetSQLValueString($row_Recordset3['mar'], "int"),
                            GetSQLValueString($row_Recordset3['mie'], "int"),
                            GetSQLValueString($row_Recordset3['jue'], "int"),
                            GetSQLValueString($row_Recordset3['vie'], "int"),
                            GetSQLValueString($row_Recordset3['sab'], "int"),
                            GetSQLValueString($row_Recordset3['dom'], "int")
                        );
                        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
                        if ($tip_loteria[$cta]==1 or $tip_loteria[$cta]==3) {
                            $insertSQL2 = sprintf(
                                "/* PARSEADORES1 new\admin_lot\admin_sorteos_edit_lot.php - QUERY 9 */ INSERT 
							INTO bancaloterias 
							(id_banca, id_loteria, est_banlot, hor_cierre, top_venta, pre_loteria, lun_loteriabanca, 
							mar_loteriabanca, 
							mie_loteriabanca, jue_loteriabanca, vie_loteriabanca, sab_loteriabanca, dom_loteriabanca) 
							VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                                GetSQLValueString($row_Recordset4['id_banca'], "int"),
                                GetSQLValueString($idTerminal, "int"),
                                GetSQLValueString(0, "int"),
                                GetSQLValueString($row_Recordset3['hor_sorteo'], "date"),
                                GetSQLValueString(150, "int"),
                                GetSQLValueString($pre_terminal, "double"),
                                GetSQLValueString($row_Recordset3['lun'], "int"),
                                GetSQLValueString($row_Recordset3['mar'], "int"),
                                GetSQLValueString($row_Recordset3['mie'], "int"),
                                GetSQLValueString($row_Recordset3['jue'], "int"),
                                GetSQLValueString($row_Recordset3['vie'], "int"),
                                GetSQLValueString($row_Recordset3['sab'], "int"),
                                GetSQLValueString($row_Recordset3['dom'], "int")
                            );
                            $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
                        }
                    } while ($row_Recordset4 = mysqli_fetch_assoc($Recordset4));
                    $query_Recordset5 = sprintf("/* PARSEADORES1 new\admin_lot\admin_sorteos_edit_lot.php - QUERY 10 */ SELECT id_agencia FROM agencialoterias GROUP BY id_agencia");
                    $Recordset5 = mysqli_query($conexionbanca, $query_Recordset5) or die(mysqli_error($conexionbanca));
                    $row_Recordset5 = mysqli_fetch_assoc($Recordset5);
                    $totalRows_Recordset5 = mysqli_num_rows($Recordset5);
                    if ($totalRows_Recordset5>0) {
                        do {
                            if ($tip_loteria[$cta]==1 or $tip_loteria[$cta]==3) {
                                $insertSQL3 = sprintf(
                                    "/* PARSEADORES1 new\admin_lot\admin_sorteos_edit_lot.php - QUERY 11 */ INSERT 
								INTO agencialoterias 
								(id_agencia, id_loteria, est_agelot, top_ventaage, lun_loteria, mar_loteria, 
								mie_loteria, jue_loteria, vie_loteria, sab_loteria, dom_loteria) 
								VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                                    GetSQLValueString($row_Recordset5['id_agencia'], "int"),
                                    GetSQLValueString($idTerminal, "int"),
                                    GetSQLValueString(0, "int"),
                                    GetSQLValueString($top_venta, "int"),
                                    GetSQLValueString($row_Recordset3['lun'], "int"),
                                    GetSQLValueString($row_Recordset3['mar'], "int"),
                                    GetSQLValueString($row_Recordset3['mie'], "int"),
                                    GetSQLValueString($row_Recordset3['jue'], "int"),
                                    GetSQLValueString($row_Recordset3['vie'], "int"),
                                    GetSQLValueString($row_Recordset3['sab'], "int"),
                                    GetSQLValueString($row_Recordset3['dom'], "int")
                                );
                                $Result3 = mysqli_query($conexionbanca, $insertSQL3) or die(mysqli_error($conexionbanca));
                            }
                            $insertSQL3 = sprintf(
                                "/* PARSEADORES1 new\admin_lot\admin_sorteos_edit_lot.php - QUERY 12 */ INSERT 
							INTO agencialoterias 
							(id_agencia, id_loteria, est_agelot, top_ventaage, lun_loteria, mar_loteria, 
							mie_loteria, jue_loteria, vie_loteria, sab_loteria, dom_loteria) 
							VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                                GetSQLValueString($row_Recordset5['id_agencia'], "int"),
                                GetSQLValueString($idTriple, "int"),
                                GetSQLValueString(0, "int"),
                                GetSQLValueString(150, "int"),
                                GetSQLValueString($row_Recordset3['lun'], "int"),
                                GetSQLValueString($row_Recordset3['mar'], "int"),
                                GetSQLValueString($row_Recordset3['mie'], "int"),
                                GetSQLValueString($row_Recordset3['jue'], "int"),
                                GetSQLValueString($row_Recordset3['vie'], "int"),
                                GetSQLValueString($row_Recordset3['sab'], "int"),
                                GetSQLValueString($row_Recordset3['dom'], "int")
                            );
                            $Result3 = mysqli_query($conexionbanca, $insertSQL3) or die(mysqli_error($conexionbanca));
                        } while ($row_Recordset5 = mysqli_fetch_assoc($Recordset5));
                    }
                }
            }
            $cta++;
        }
    }
    if (isset($_POST['id_loteria']) && isset($_POST['cambio'])) {
        $cta=0;
        $id_loteria=$_POST['id_loteria'];
        $es_loteria=$_POST['est_loteria'];
        foreach ($_POST['cambio'] as $valor) {
            if ($valor==1) {
                $menPrin="&nbsp;&nbsp; DATOS DE SORTEO GUARDADOS CORRECTAMENTE &nbsp;&nbsp;";
                $insertSQL1 = sprintf(
                    "/* PARSEADORES1 new\admin_lot\admin_sorteos_edit_lot.php - QUERY 13 */ UPDATE loterias 
						SET
						est_loteria=%s 
						WHERE id_loteria=%s",
                    GetSQLValueString($es_loteria[$cta], "int"),
                    GetSQLValueString($id_loteria[$cta], "int")
                );
                $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
            }
            $cta++;
        }
    }
    if (isset($Recordset1)) {
        mysqli_free_result($Recordset1);
    }
    if (isset($Recordset2)) {
        mysqli_free_result($Recordset2);
    }
    if (isset($Recordset3)) {
        mysqli_free_result($Recordset3);
    }
    if (isset($Recordset4)) {
        mysqli_free_result($Recordset4);
    }
}
$xCodigo = "-1";
if (isset($_GET["recordID"])) {
    $xCodigo = $_GET["recordID"];
}
$query_Recordset1 =  sprintf(
    "/* PARSEADORES1 new\admin_lot\admin_sorteos_edit_lot.php - QUERY 14 */ SELECT 
		so.id_sorteo, so.nom_sorteo, so.est_sorteo, so.hor_sorteo, so.tur_sorteo, so.ord_sorteo,
		so.lun, so.mar, so.mie, so.jue, so.vie, so.sab, so.dom, gl.nom_grupo_lot
	FROM sorteos so, grupo_loterias gl 
	WHERE so.id_sorteo = %s AND so.id_grupo_lot = gl.id_grupo_lot 
	LIMIT 1",
    GetSQLValueString($xCodigo, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$query_Recordset2 =  sprintf(
    "/* PARSEADORES1 new\admin_lot\admin_sorteos_edit_lot.php - QUERY 15 */ SELECT 
		id_loteria, nom_loteria, let_loteria, tip_loteria, est_loteria, 
		CASE lo.tip_loteria  
			WHEN 1 THEN 'TRIPLE'
			WHEN 3 THEN 'ZODIACAL'
			WHEN 4 THEN 'ANIMALITOS'
			WHEN 5 THEN 'FRUTAS'
			WHEN 6 THEN 'CARTAS'
			ELSE 'NO DEFINIDO'
		END AS tipo
	FROM loterias lo 
	WHERE lo.id_sorteo = %s AND tip_loteria!=2",
    GetSQLValueString($xCodigo, "int")
);
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
list($hor, $min, $am)=explode(":", cambioHoramysql($row_Recordset1['hor_sorteo']));
$lineas=$totalRows_Recordset2+2;
$grupo=1;
if ($row_Recordset1['nom_grupo_lot']=="ANIMALITOS") {
    $grupo=2;
} elseif ($row_Recordset1['nom_grupo_lot']=="FRUTAS") {
    $grupo=3;
} elseif ($row_Recordset1['nom_grupo_lot']=="CARTAS") {
    $grupo=4;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
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
  .textbox:focus, .textboxsmal:focus {
  color: #2E3133;
  border-color: #FBFFAD;
  }
  .textboxsmal {
	  width:80px;
	  height:8px;
  }
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
<script type="text/javascript" src="jslot/jquery-1.9.1.min.js"></script>
<script>
 $(document).ready(function() { 
 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
 var refreshId1 = setInterval(function() {
 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
 }, 60000);
$('#divPrin').fadeOut(12000);
});
</script><script>
var statusEnvio = false;
function chequearEnvio() {
    if (!statusEnvio) { statusEnvio = true;
        return true;
    } else { alert("El formulario ya está siendo enviado, por favor aguarde un instante.");
        return false;
    }
}
$(document).ready(function() {    
    $('#username').blur(function(){
		var usern = $('input[name=username]').val();
		if(usern != '') {
			var username = $(this).val();        
			var dataString = 'username='+username;
			$.ajax({
				type: "POST",
				url: "../includes/comprobarUsuario.php",
				data: dataString,
				success: function(data) {
					$('#Info32').fadeIn(200).html(data);
				}
			});
		};	
    });              
});    
function ocultaDiv(elemento) {
	document.getElementById(elemento).style.display = "none";
}
function myCreateFunction(linea, grupo) {
	document.getElementById('aNvaLot').disabled=true;
	var table = document.getElementById("nvaLot"); {
  		var row = table.insertRow(linea);
		var cell1 = row.insertCell(0);var cell2 = row.insertCell(1);var cell3 = row.insertCell(2);var cell4 = row.insertCell(3);
		var cell5 = row.insertCell(4);
		cell2.style.textAlign = 'center';cell3.style.textAlign = 'center';cell4.style.textAlign = 'center';
		cell5.style.textAlign = 'center';
		var nombre = '&nbsp;<input type="text" name="nom_loteria[]" id="nom_loteria[]" class="textbox" placeholder="nombre de loteria" maxlength="30" pattern="[A-Z a-z0-9]{4,30}" title="indique un nombre para mostrar en ticket. 4-30 caracteres" onKeyUp="return handleEnter(this, event)" required value="" size="42" />';
		var letra = '&nbsp;<input type="text" name="let_loteria[]" id="let_loteria[]" class="textbox" maxlength="1" pattern="[A-Z a-z]{1}" title="indique un codigo. 1 caracter" style="width:30px; margin-bottom:0px; text-align:center" onKeyUp="return handleEnter(this, event)" required value="" size="1 " />';
		if (grupo==1) var tipo = '<select name="tip_loteria[]" id="tip_loteria[]" style="width:130px; height:32px; margin-bottom:0px" class="textbox"><option value="1">TRIPLE</option><option value="3">ZODIACAL</option>';
		else if (grupo==2) var tipo = '<input type="hidden" name="tip_loteria[]" id="tip_loteria[]" value="4"/>ANIMALITOS';
		else if (grupo==3) var tipo = '<input type="hidden" name="tip_loteria[]" id="tip_loteria[]" value="5"/>FRUTAS';
		else if (grupo==4) var tipo = '<input type="hidden" name="tip_loteria[]" id="tip_loteria[]" value="6"/>CARTAS';
		var status = '<select name="est_loteria[]" id="est_loteria[]" style="width:120px; height:32px; margin-bottom:0px" class="textbox"><option value="1">ACTIVO</option><option value="0">INACTIVO</option></select>';
		var accion = '<input type="submit" value="Guardar" class="btn btn-primary" style="font-size:11px;" title="guardar cambios de loterias"/>&nbsp;<button class="btn-important" style="font-size:18px" title="eliminar" onclick="removeRow(); return false">-</button>';
		cell1.innerHTML = nombre;cell2.innerHTML = letra;cell3.innerHTML = tipo;cell4.innerHTML = status;
		cell5.innerHTML = accion;
		document.getElementById("nom_loteria[]").focus();
	}
	return false;
}
function removeRow() {
	document.getElementById('aNvaLot').disabled=false;
	var table = document.getElementById("nvaLot");
	var rowCount = table.rows.length;
	r=rowCount-3;
	document.getElementById("nvaLot").deleteRow(r);
} 
function dtcambio(cambio, guarda) {
	if (document.getElementById(cambio).value==1) {	document.getElementById(cambio).value=0;
		document.getElementById(guarda).disabled=true; document.getElementById(guarda).style.display = 'none';}
	else { document.getElementById(cambio).value=1;document.getElementById(guarda).disabled=false; 
		document.getElementById(guarda).style.display = '';}
	
} 
</script>
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
  <div class="header" style="height:100px; background:#0084B4">
			<?php include("../includes/cabeceraamericana.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup" style=" margin:0px 0px 0px 205px"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
						<?php include("../includes/cabecera_lot.php");?>
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#0084B4; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" 
        	id="datosUsuario">
        	<div style="background:#0084B4;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            	margin:20px 0px 0px 0px; width:240px; font-size:16px"> 
              EDITAR SORTEO<br/>
		    </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin">
  	<div style="padding:15px 0; float:right; color:#FFFFFF; background:#FF9A9C; font-size:22px;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;border-radius: 5px 5px 5px 5px;-moz-border-radius: 5px 5px 5px 5px;-webkit-border-radius: 5px 5px 5px 5px;border: 0px solid #000000; margin:5px" id="divPrin">
		<?php echo $menPrin; ?>
    </div>
<div style="padding:70px 10px 20px 10px; text-align:left; font-size:18px; height: auto">
   	<div style="width:920px; text-align:left; font-size:18px; background: #E1E1E1">
            <form method="post" name="form1" action="<?php echo $editFormAction; ?>"  onsubmit="return chequearEnvio();">
              <table width="920" align="center" border="0" cellpadding="0" cellspacing="0">
                <tr valign="baseline">
                  <?php if ($totalRows_Recordset1==0) {?>
                  <td height="82" colspan="10" align="center" valign="middle" nowrap 
                  style="background:#333333; font-size:24px; color: #FFF">
                  <?php } else {?>
                  <td height="52" colspan="10" align="center" valign="middle" nowrap 
                  style="background:#333333; font-size:24px; color: #FFF">
                  <?php }?>
                  
               	  <strong>DATOS DE SORTEO</strong>
                  </td>
                </tr>
              </table>
              <table width="921" align="center" border="0" cellpadding="0" cellspacing="0">
                <tr valign="baseline">
                  <td align="left" nowrap>&nbsp;</td>
                  <td align="left" nowrap>&nbsp;</td>
                  <td align="left" nowrap>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td width="45" align="left" nowrap>&nbsp;</td>
                  <td width="309" align="left" nowrap>
                  	Nombre de sorteo:<br />
                  	<input type="text" name="nom_sorteo" class="textbox" placeholder="nombre de sorteo" maxlength="40"
                     title="indique un nombre para sorteo. 4-40 caracteres"
                    onKeyUp="return handleEnter(this, event)" tabindex="1"
                    value="<?php echo htmlentities($row_Recordset1['nom_sorteo'], ENT_COMPAT, 'utf-8'); ?>" 
                    size="42" />
                  </td>
                  <td width="161" align="left" nowrap>
                  		Turno:<br/>
                        <select name="tur_sorteo" style="width:140px; height: auto" class="textbox" tabindex="2"> 
                          <option value="M" <?php if (!(strcmp("M", htmlentities($row_Recordset1['tur_sorteo'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>MAÑANA</option>
                          <option value="T" <?php if (!(strcmp("T", htmlentities($row_Recordset1['tur_sorteo'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>TARDE</option>
                          <option value="N" <?php if (!(strcmp("N", htmlentities($row_Recordset1['tur_sorteo'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>NOCHE</option>
                        </select>
                  </td>
                  <td width="200">
                  		Hora cierre de venta:<br/>
                    	<select name="hor" style="width: auto; height: auto" class="textbox" tabindex="3">
                        	<?php for ($i = 1; $i <= 12; $i++) {
    if ($i<10) {
        $v="0".$i;
    } else {
        $v=$i;
    } ?>
                          <option value="<?php echo $i; ?>" <?php
                                if (!(strcmp($v, htmlentities($hor, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>><?php echo $v; ?>
                          </option>
                           <?php
}?>
                        </select>
                      	<select name="min" style="width: auto; height: auto" class="textbox" tabindex="4">
                        	<?php for ($i = 0; $i <= 55; $i=$i+5) {
                                    if ($i<10) {
                                        $v="0".$i;
                                    } else {
                                        $v=$i;
                                    } ?>
                          <option value="<?php echo $i; ?>" <?php
                                if (!(strcmp($v, htmlentities($min, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>><?php echo $v; ?>
                          </option>
                            <?php
                                }?>
                      </select>
                      <select name="am" style="width: auto; height: auto" class="textbox" tabindex="5">
	                        <option value="AM" <?php
                            if (!(strcmp("AM", htmlentities($am, ENT_COMPAT, 'utf-8')))) {
                                echo "SELECTED";
                            } ?>>AM
                            </option>
                        	<option value="PM" <?php
                            if (!(strcmp("PM", htmlentities($am, ENT_COMPAT, 'utf-8')))) {
                                echo "SELECTED";
                            } ?>>PM
                            </option>
                      </select>
                  </td>
                  <td width="172">
                        Status de sorteo:<br />
                        <select name="est_sorteo" style="width:140px; height: auto" class="textbox" tabindex="6"> 
                          <option value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset1['est_sorteo'], ENT_COMPAT, 'utf-8')))) {
                                echo "SELECTED";
                            } ?>>ACTIVO</option>
                          <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset1['est_sorteo'], ENT_COMPAT, 'utf-8')))) {
                                echo "SELECTED";
                            } ?>>INACTIVO</option>
                        </select>
                  </td>
                </tr>
              </table>
                <table width="920" align="center" border="0" cellpadding="0" cellspacing="0">
                <tr valign="baseline" style="font-size:12px">
                  <td width="14" align="left" nowrap>&nbsp;</td>
                  <td width="202" align="left" nowrap>&nbsp;</td>
                  <td width="70" align="center" valign="bottom">LUNES</td>
                  <td align="center" valign="bottom">MARTES</td>
                  <td align="center" valign="bottom">MIÉRCOLES</td>
                  <td width="70" align="center" valign="bottom">JUEVES</td>
                  <td width="70" align="center" valign="bottom">VIERNES</td>
                  <td width="70" align="center" valign="bottom">SÁBADO</td>
                  <td width="70" align="center" valign="bottom">DOMINGO</td>
                  <td width="10" rowspan="2" align="right" valign="top">&nbsp;</td>
                  <td width="148" colspan="2" align="left" valign="top">&nbsp;</td>
                  </tr>
                <tr valign="baseline">
                  <td align="left" nowrap>&nbsp;</td>
                  <td nowrap align="right">Días de sorteo:</td>
                  <td align="center"><input type="checkbox" name="lun" class="textboxsmal" tabindex="7"
                  value=""  <?php if (!(strcmp(htmlentities($row_Recordset1['lun'], ENT_COMPAT, 'utf-8'), 1))) {
                                echo "checked=\"checked\"";
                            } ?> /></td>
                  <td width="86" align="center"><input type="checkbox" name="mar" class="textboxsmal" tabindex="8"
                  value=""  <?php if (!(strcmp(htmlentities($row_Recordset1['mar'], ENT_COMPAT, 'utf-8'), 1))) {
                                echo "checked=\"checked\"";
                            } ?> /></td>
                  <td width="86" align="center"><input type="checkbox" name="mie" class="textboxsmal" tabindex="9"
                  value=""  <?php if (!(strcmp(htmlentities($row_Recordset1['mie'], ENT_COMPAT, 'utf-8'), 1))) {
                                echo "checked=\"checked\"";
                            } ?> /></td> 
                  <td align="center"><input type="checkbox" name="jue" class="textboxsmal" tabindex="10"
                  value=""  <?php if (!(strcmp(htmlentities($row_Recordset1['jue'], ENT_COMPAT, 'utf-8'), 1))) {
                                echo "checked=\"checked\"";
                            } ?> /></td>
                  <td align="center"><input type="checkbox" name="vie" class="textboxsmal" tabindex="11"
                  value=""  <?php if (!(strcmp(htmlentities($row_Recordset1['vie'], ENT_COMPAT, 'utf-8'), 1))) {
                                echo "checked=\"checked\"";
                            } ?> /></td>
                  <td align="center"><input type="checkbox" name="sab" class="textboxsmal" tabindex="12"
                  value=""  <?php if (!(strcmp(htmlentities($row_Recordset1['sab'], ENT_COMPAT, 'utf-8'), 1))) {
                                echo "checked=\"checked\"";
                            } ?> /></td>
                  <td align="center"><input type="checkbox" name="dom" class="textboxsmal" tabindex="13"
                  value=""  <?php if (!(strcmp(htmlentities($row_Recordset1['dom'], ENT_COMPAT, 'utf-8'), 1))) {
                                echo "checked=\"checked\"";
                            } ?> /></td>
                  <td colspan="2" align="center" valign="top">
                  	<input type="submit" class=" btn btn-success" value="APLICAR CAMBIOS"  tabindex="14"
                  	style="width:140px; height:40px; font-size:14px;" />
                  </td>
                  </tr>
				</table>
			<input type="hidden" name="MM_insert" value="form1"/>
			<input type="hidden" name="id_sorteo" value="<?php echo $row_Recordset1['id_sorteo'] ?>"/>
		</form>
        <form method="post" name="form2" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">
                <table width="100%" border="0" cellpadding="0" cellspacing="0" id="nvaLot">
                  <tbody>
                    <tr>
                      <td colspan="5" height="5" style="background:#0084B4">
                          <button id="aNvaLot" class="btn btn-inverse" 
                          	style="font-size:11px" title="crear nueva loteria para sorteo"
                          	onclick="myCreateFunction('<?php echo $lineas; ?>','<?php echo $grupo; ?>'); return false">
                          +NUEVA LOTERIA
                          </button>
                      </td>
                    </tr>
                    <tr style="font-size:15px; text-align:center; vertical-align:text-bottom;border-bottom:1px solid  #D5D5D5;">
                      <td width="47%">LOTERIA</td>
                      <td width="11%">CODIGO</td>
                      <td width="15%">TIPO</td>
                      <td width="15%">STATUS</td>
                      <td width="12%">&nbsp;</td>
                    </tr><?php
                    if ($totalRows_Recordset2>0) {
                        do {
                            $cambiar="bc".$row_Recordset2['id_loteria'];
                            $guardar="bg".$row_Recordset2['id_loteria']; ?>
							<input type="hidden" name="cambio[]" id="<?php echo $cambiar; ?>" value="0"/>
							<tr class="brillo" style="border-bottom:1px solid  #D5D5D5; text-align:center">
							  <td height="24" align="left">&nbsp;
								<?php echo $row_Recordset2['nom_loteria']; ?>
							  </td>
							  <td><?php echo $row_Recordset2['let_loteria']; ?></td>
							  <td><?php echo $row_Recordset2['tipo']; ?></td>
							  <td>
								<select name="est_loteria[]" style="width:120px; height:32px; margin-bottom:0px;" class="textbox"
									onchange="dtcambio('<?php echo $cambiar; ?>','<?php echo $guardar; ?>')"> 
								  <option value="1" 
								  <?php if (!(strcmp(1, htmlentities($row_Recordset2['est_loteria'], ENT_COMPAT, 'utf-8')))) {
                                echo "SELECTED";
                            } ?>>ACTIVO</option>
								  <option value="0" 
								  <?php if (!(strcmp(0, htmlentities($row_Recordset2['est_loteria'], ENT_COMPAT, 'utf-8')))) {
                                echo "SELECTED";
                            } ?>>INACTIVO</option>
								</select>
							  </td>
							  <td>
							  <input type="submit" value="Guardar" name="<?php echo $guardar; ?>" id="<?php echo $guardar; ?>" 
							  class="btn btn-primary" disabled="disabled" style="font-size:11px; display:none" 
							  title="guardar cambios de loterias"/>
							</td>
							</tr>
							<input type="hidden" name="id_loteria[]" value="<?php echo $row_Recordset2['id_loteria']; ?>"/>
							<?php
                        } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
                    } ?>
                    <tr>
						<td height="5" colspan="5"></td>
                  </tr>
                    <tr>
                      <td colspan="5" height="5" style="background:#0084B4">&nbsp;</td>
                    </tr>
                  </tbody>
              </table>
			<input type="hidden" name="MM_insert2" value="form2"/>
			<input type="hidden" name="id_sorteo2" value="<?php echo $xCodigo; ?>"/>
		</form>
		<table width="920" align="center" border="0" cellpadding="0" cellspacing="0">
          <tbody>
            <tr>
              <td align="center">
                  <a href='admin_sorteos_lista_lot.php'
                  class="btn  btn-danger" style="width:150px; height:40px; font-size:16px; text-decoration:none; color:#FFFFFF">
                  	<div style="padding:10px 0px 0px 0px">SALIR</div>
                  </a>
              </td>
            </tr>
          </tbody>
		</table>
          </div>
    </div>
  </div>
  <div class="footer" style="background:#0084B4">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
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