<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$menTaq="";
$menNre="";
$menTel="";
$menAmig="";	//monto apuesta minima a gan
$menAmag="";
$menRgan="";
$menMgan="";	// monto maximo a ganar a ganador
$menMmt="";		// monto maximo en ticket
$menAmip="";	//monto apuesta minima a pla
$menAmap="";
$menRpla="";
$menMpla="";
$menAmis="";	//monto apuesta minima a sho
$menAmas="";
$menRsho="";
$menMsho="";
$menMmae="";
$menAmie="";	//monto apuesta minima a exa
$menAmae="";
$menRexa="";
$menMexa="";
$menAmit="";	//monto apuesta minima a tri
$menAmat="";
$menRtri="";
$menMtri="";
$menAmisu="";	//monto apuesta minima a sup
$menAmasu="";
$menRsup="";
$menMsup="";
$menNus="";
$menNti="";
$menTeli="";	// maximo ticket a eliminar
$menOpNac="";
include("../includes/taquilla_estandar.php");

$xCodigo = "-1";
$xCodigo2 = "-1";
$editFormAction = $_SERVER['PHP_SELF'];
$editFormAction2 = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction2 .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if (isset($_GET["recordID"])) {
    $xCodigo = $_GET["recordID"];
    $xCodigo2 = $_GET["recordID"];
}
$query_Recordset1 =  sprintf(
    "/* PARSEADORES1 new\admin\taquillas_edit_parley.php - QUERY 1 */ SELECT  
	ta.nom_taquilla, ta.nom_representante, ta.tel_taquilla, ta.tel_taquilla2, ta.tel_taquilla3, ta.est_taquilla, ta.cod_taquilla,
	ag.nom_agencia, ta.moneda  
	FROM  taquilla ta, agencia ag 
	WHERE ta.cod_taquilla = %s AND ag.cod_agencia = ta.cod_agencia LIMIT 1",
    GetSQLValueString($xCodigo, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$query_Recordset4 =  sprintf(
    "/* PARSEADORES1 new\admin\taquillas_edit_parley.php - QUERY 2 */ SELECT  
*
	FROM  taquilla_opc_parley tp, taquilla ta, banca ba, agencia ag 
	WHERE tp.cod_taquilla = %s AND tp.cod_taquilla = ta.cod_taquilla AND
	ba.cod_banca = ag.cod_banca AND ta.cod_agencia = ag.cod_agencia
	LIMIT 1",
    GetSQLValueString($xCodigo, "int")
);
$Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);
$porcentaje=0;
if ($totalRows_Recordset4>0) {
    $existe=1;
    $porcentaje=$row_Recordset4['taq_por_parley'];
}
if ($totalRows_Recordset4==0 && (!isset($_POST["MM_insert2"]))) {
    $cod_taopcame="";
    $est_impresion=0;
    $apu_mingan=10;
    $apu_maxgan=50000;
    $reg_gan=0;
    $max_aganar_gan=20;
    $est_gan=1;
    $est_pla=1;
    $est_sho=1;
    $anu_regalia=0;
    $ver_porpagar=0;
    $tie_reclamo=0;
    $tic_caduca=0;
    $mon_maxejemplar=20000;
    $tip_ticket=0;
    $min_ejecarrera=4;
    $pag_codigo=0;
    $est_impresion=0;
    $mon_maxticket=100000;
    $apu_minpla=10;
    $apu_maxpla=50000;
    $reg_pla=0;
    $max_aganar_pla=16;
    $apu_minsho=10;
    $apu_maxsho=50000;
    $reg_sho=0;
    $max_aganar_sho=10;
    $apu_minexa=10;
    $apu_maxexa=10000;
    $reg_exa=0;
    $max_aganar_exa=200;
    $est_exa=0;
    $apu_mintri=10;
    $apu_maxtri=10000;
    $reg_tri=0;
    $max_aganar_tri=300;
    $est_tri=0;
    $apu_minsup=10;
    $apu_maxsup=10000;
    $reg_sup=0;
    $max_aganar_sup=400;
    $est_sup=0;
    $menOpNac="ATENCIÓN: Los datos Parley de esta taquilla no han sido creadas";
    $existe=0;
    $porcentaje=2;
    $apu_minparley=0.01;
    $apu_maxparley=99999999;
    $comb_minparley=1;
    $comb_maxparley=10;
    $comb_hembra=10;
    $min_eliminar=999;
    $factordehembra=0;
    $factordemacho=0;
    include("../includes/taquilla_estandar.php");
} else {
    $cod_taopcame=$row_Recordset4['cod_taopcparley'];
    if ((isset($_POST["MM_insert2"])) && ($_POST["MM_insert2"] == "form2")) {
        if (isset($_POST["exp_agencia"]) && $_POST["exp_agencia"]>0) {
            $r4=$totalRows_Recordset4;
            $query_Recordset4 =  sprintf(
                "/* PARSEADORES1 new\admin\taquillas_edit_parley.php - QUERY 3 */ SELECT  
* FROM  taquilla ta, taquilla_opc_parley tp 
				WHERE ta.cod_taquilla = %s AND tp.cod_taquilla = ta.cod_taquilla
				LIMIT 1",
                GetSQLValueString($_POST["exp_agencia"], "int")
            );
            $Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
            $row_Recordset4 = mysqli_fetch_assoc($Recordset4);
            $totalRows_Recordset4 = mysqli_num_rows($Recordset4);
            if ($r4==0) {
                $menOpNac="ATENCIÓN: Los datos para Parley de esta taquilla no han sido creadas*";
            }
        }
    }
    $apu_minparley=$row_Recordset4['apu_minparley'];
    $apu_maxparley=$row_Recordset4['apu_maxparley'];
    $comb_minparley=$row_Recordset4['comb_minparley'];
    $comb_maxparley=$row_Recordset4['comb_maxparley'];
    $comb_hembra=$row_Recordset4['comb_hembra'];
    $min_eliminar=$row_Recordset4['min_eliminar'];
    $monto_apuesta=$row_Recordset4['monto_apuesta'];
    $factor_pago=$row_Recordset4['factor_pago'];
    $factordehembra=$row_Recordset4['factor_de_hembra'];
    $factordemacho=$row_Recordset4['factor_de_macho'];
    if($factordehembra==0){
        $factordehembra=100;
    }
    if($factordemacho==0){
        $factordemacho=100;
    }

}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    $graba=31;


    if (!isset($_POST['apu_maxparley']) || $_POST['apu_maxparley']<=0) {
        $_POST['apu_maxparley']="";
        $menAmag= "indique monto";
        $graba--;
    }


    if (!isset($_POST['apu_minparley']) || $_POST['apu_minparley']<=0) {
        $_POST['apu_minparley']="";
        $menAmig= "indique monto";
        $graba--;
    }





    if ($graba==31) {
        if ($_POST['existe']==1) {
            $insertSQL2 = sprintf(
                "/* PARSEADORES1 new\admin\taquillas_edit_parley.php - QUERY 4 */ UPDATE taquilla_opc_parley
					SET
					apu_maxparley=%s, 
					apu_minparley=%s,
                    comb_minparley=%s,
                    comb_maxparley=%s,
                    min_eliminar=%s,
                    comb_hembra=%s,
                    monto_apuesta=%s,
                    factor_pago=%s,
                    factor_de_hembra=%s,
                    factor_de_macho=%s
					WHERE cod_taopcparley=%s",
                GetSQLValueString($_POST['apu_maxparley'], "double"),
                GetSQLValueString($_POST['apu_minparley'], "double"),
                GetSQLValueString($_POST['comb_minparley'], "int"),
                GetSQLValueString($_POST['comb_maxparley'], "int"),
                GetSQLValueString($_POST['min_eliminar'], "int"),
                GetSQLValueString($_POST['comb_hembra'], "int"),   
                GetSQLValueString($_POST['monto_apuesta'], "int"), 
                GetSQLValueString($_POST['factor_pago'], "int"),
                GetSQLValueString($_POST['factor_de_hembra'], "int"),
                GetSQLValueString($_POST['factor_de_macho'], "int"),            
                GetSQLValueString($_POST['cod_taopcame'], "int"));
            $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));

            if ($_POST['monto_apuesta']<>$row_Recordset4['monto_apuesta'] or $_POST['factor_pago']<>$row_Recordset4['factor_pago'] or $_POST['apu_minparley']<>$row_Recordset4['apu_minparley'] or $_POST['apu_maxparley']<>$row_Recordset4['apu_maxparley'] or $_POST['comb_minparley']<>$row_Recordset4['comb_minparley'] or $_POST['comb_maxparley']<>$row_Recordset4['comb_maxparley'] or $_POST['comb_hembra']<>$row_Recordset4['comb_hembra'] or $_POST['min_eliminar']<>$row_Recordset4['min_eliminar'] or $_POST['factor_de_hembra']<>$row_Recordset4['factor_de_hembra'] or $_POST['factor_de_macho']<>$row_Recordset4['factor_de_macho']) {
                $montoapuestal=$_POST['monto_apuesta'];
                $multiplicador=$_POST['factor_pago'];
                $apuestaminima=$_POST['apu_minparley'];
                $apuestamaxima=$_POST['apu_maxparley'];
                $combinacionminima=$_POST['comb_minparley'];
                $combinacionmaxima=$_POST['comb_maxparley'];
                $combinacionhembramax=$_POST['comb_hembra'];
                $combinacioneliticket=$_POST['min_eliminar'];
                $combinacionfachembra=$_POST['factor_de_hembra'];
                $combinacionfacmacho=$_POST['factor_de_macho'];


                $msj="HA HABIDO UNA MODIFICACION EN MODULO PARLEY DE UNA DE SUS TAQUILLAS  \n";
                $msj.= " TAQUILLA: " . $row_Recordset1['nom_taquilla'] . "\n";
                $msj.= " DEL AGENTE: " . $row_Recordset1['nom_agencia'] . "\n";

                if ($_POST['monto_apuesta']<>$row_Recordset4['monto_apuesta']) {
                    $msj.= " MONTO MAXIMO A MODIFICAR POR TICKET ANTES ".$row_Recordset4['monto_apuesta']." Y AHORA ".$montoapuestal."\n";
                }
                if ($_POST['factor_pago']<>$row_Recordset4['factor_pago']) {
                    $msj.= " MULTIPLICADOR DE PAGO ANTES ".$row_Recordset4['factor_pago']." Y AHORA ".$multiplicador."\n";
                }
                if ($_POST['apu_minparley']<>$row_Recordset4['apu_minparley']) {
                    $msj.= " JUGADA MINIMA ANTES ".$row_Recordset4['apu_minparley']." Y AHORA ".$apuestaminima."\n";
                }
                if ($_POST['apu_maxparley']<>$row_Recordset4['apu_maxparley']) {
                    $msj.= " JUGADA MAXIMA ANTES ".$row_Recordset4['apu_maxparley']." Y AHORA ".$apuestamaxima."\n";
                }
                if ($_POST['comb_minparley']<>$row_Recordset4['comb_minparley']) {
                    $msj.= " COMBINACION MINIMA ANTES ".$row_Recordset4['comb_minparley']." Y AHORA ".$combinacionminima."\n";
                }
                if ($_POST['comb_maxparley']<>$row_Recordset4['comb_maxparley']) {
                    $msj.= " COMBINACION MAXIMA ANTES ".$row_Recordset4['comb_maxparley']." Y AHORA ".$combinacionmaxima."\n";
                }
                if ($_POST['comb_hembra']<>$row_Recordset4['comb_hembra']) {
                    $msj.= " COMBINACION MAXIMA HEMBRAS ANTES ".$row_Recordset4['comb_hembra']." Y AHORA ".$combinacionhembramax."\n";
                }
                if ($_POST['min_eliminar']<>$row_Recordset4['min_eliminar']) {
                    $msj.= " LIMITE DE MINUTOS PARA PODER ELIMINAR UNA APUESTA ANTES ".$row_Recordset4['min_eliminar']." Y AHORA ".$combinacioneliticket."\n";
                }
                if ($_POST['factor_de_hembra']<>$row_Recordset4['factor_de_hembra']) {
                    $msj.= " FACTOR MULTIPLICADOR HEMBRA ANTES ".$row_Recordset4['factor_de_hembra']." Y AHORA ".$combinacionfachembra."\n";
                }
                if ($_POST['factor_de_macho']<>$row_Recordset4['factor_de_macho']) {
                    $msj.= " FACTOR MULTIPLICADOR MACHO ANTES ".$row_Recordset4['factor_de_macho']." Y AHORA ".$combinacionfacmacho."\n";
                }                
                
                $msjx=utf8_encode($msj);
                $post=[
                'chat_id'=>-1001639542248,
                'text'=>$msjx,
            ];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot5335385470:AAE0nAUC8c7ZDTPR3UPofIylv6TbkMsXGr8/sendMessage");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                curl_exec($ch);
                curl_close($ch);

        }


        } else {
            $insertSQL2 = sprintf(
                "/* PARSEADORES1 new\admin\taquillas_edit_parley.php - QUERY 5 */ INSERT 
			INTO 
			taquilla_opc_parley 
			(apu_minparley, apu_maxparley, cod_taquilla, comb_minparley, comb_maxparley, min_eliminar, comb_hembra, monto_apuesta, factor_pago ) 
			VALUES 
			(%s,%s,%s,%s,%s,%s,%s,%s,%s)",
                GetSQLValueString($_POST['apu_minparley'], "double"),
                GetSQLValueString($_POST['apu_maxparley'], "double"),
                GetSQLValueString($_POST['cod_taquilla'], "int"),
                GetSQLValueString($_POST['comb_minparley'], "int"),
                GetSQLValueString($_POST['comb_maxparley'], "int"),
                GetSQLValueString($_POST['min_eliminar'], "int"),
                GetSQLValueString($_POST['comb_hembra'], "int"),
                GetSQLValueString($_POST['monto_apuesta'], "int"),
                GetSQLValueString($_POST['factor_pago'], "int"));
            $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
            
            
            
            if ($row_Recordset1['moneda']==0) {
                $apuestasminimaausar=$apuestasminimaaganadorbss0;
            }
            if ($row_Recordset1['moneda']==1) {
                $apuestasminimaausar=$apuestasminimaaganadorusd1;
            }
            if ($row_Recordset1['moneda']==2) {
                $apuestasminimaausar=$apuestasminimaaganadorpc2;
            }
            if ($row_Recordset1['moneda']==3) {
                $apuestasminimaausar=$apuestasminimaaganadorsp3;
            }

            $query_Recordset22 =  sprintf(
                "/* PARSEADORES1 new\admin\taquillas_edit_parley.php - QUERY 6 */ SELECT  
tp.apu_mingan
	FROM  taquilla_opc_parley tp 
	WHERE tp.cod_taquilla = %s
	LIMIT 1",
                GetSQLValueString($row_Recordset1['cod_taquilla'], "int")
            );
            $Recordset22 = mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
            $row_Recordset22 = mysqli_fetch_assoc($Recordset22);
            $totalRows_Recordset22 = mysqli_num_rows($Recordset22);
        }
        $insertGoTo = "../admin/taquillas_edit.php?recordID=".$row_Recordset1['cod_taquilla'];
        if (isset($_SERVER['QUERY_STRING'])) {
            $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
            $insertGoTo .= $_SERVER['QUERY_STRING'];
        }
        header(sprintf("Location: %s", $insertGoTo));
    }
}
$query_Recordset3 = sprintf(
    "/* PARSEADORES1 new\admin\taquillas_edit_parley.php - QUERY 7 */ SELECT ta.cod_taquilla, ta.nom_taquilla 
FROM taquilla ta, taquilla_opc_parley tp, banca ba, agencia ag 
WHERE ta.cod_taquilla = tp.cod_taquilla AND ta.cod_taquilla != %s
AND ag.cod_agencia = ta.cod_agencia AND ba.cod_banca = ag.cod_banca AND ba.cod_banca = %s
ORDER BY nom_taquilla",
    GetSQLValueString($xCodigo2, "int"),
    GetSQLValueString($row_Recordset4['cod_banca'], "int")
);
$Recordset3 =mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>.:Apuestas Hípicas:.</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style>
  .textbox, .textboxsmal {
	  border: 1px solid #DBE1EB;
	  font-size: 18px;
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
	  height:20px;
  }
  .textbox:focus, .textboxsmal:focus {
	  color: #2E3133;
	  border-color: #FBFFAD;
  }
  .textboxsmal {
	  width:50px;
	  height:10px;
  }
 </style>
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
<script>
var statusEnvio = false;
function chequearEnvio() {
    if (!statusEnvio) { statusEnvio = true;
        return true;
    } else { alert("El formulario ya está siendo enviado, por favor aguarde un instante.");
        return false;
    }
}
function ValidaSoloNumerosx() {
	if (event.keyCode != 110) {
		if ((event.keyCode < 48) || (event.keyCode > 57)) 
			event.returnValue = false;
	}
}    

function ValidaSoloNumeros(evt,input){
    // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
    var key = window.Event ? evt.which : evt.keyCode;    
    var chark = String.fromCharCode(key);
    var tempValue = input.value+chark;
    if(key >= 48 && key <= 57){
        if(filter(tempValue)=== false){
            return false;
        }else{       
            return true;
        }
    }else{
          if(key == 8 || key == 13 || key == 0) {     
              return true;              
          }else if(key == 46){
                if(filter(tempValue)=== false){
                    return false;
                }else{       
                    return true;
                }
          }else{
              return false;
          }
    }
}
function filter(__val__){
    var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
    if(preg.test(__val__) === true){
        return true;
    }else{
       return false;
    }
    
}








function ocultaDiv(elemento) {
	document.getElementById(elemento).style.display = "none";
}
$(document).ready(function() {
	$('#exp_agencia').change(function(){
		if($("#exp_agencia").val()>0) {
			
			$("#botExp").removeAttr("disabled");
		}
		else {
			$("#botExp").attr('disabled', 'disabled');
		}
  });
 });
</script>
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
                EDITAR TAQUILLA<br/>
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
    <div style="width:98%; float:right; text-align:right; padding:1.5% 2% 0 0; height:40px; font-size:16px;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;">
        <form method="post" name="form2" action="<?php echo $editFormAction2; ?>" onsubmit="return chequearEnvio();">
        	Exportar opciones de:
            <select name="exp_agencia" id="exp_agencia" style="width:25%; height: auto; background:#9E1C0A; color:#FFFFFF" 
            	class="textbox">
                <option value="" style="background:#9E1C0A; color:#FFFFFF">SELECCIONE<?php
                do {?>
                    <option value="<?php echo $row_Recordset3['cod_taquilla']?>" style="background:#FFF; color:#000">
                        <?php echo $row_Recordset3['nom_taquilla']?></option><?php
                } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));?>
            </select>
			<input name="botExp" id="botExp" type="submit"  value="Exportar" class=" btn-info" 
            	style="width:70px; height:35px; font-size:12px;" disabled="disabled"/>
			<input type="hidden" name="MM_insert2" value="form2"/>
        </form>
    </div>
	<div style="padding:70px 10px 20px 10px; text-align:left; font-size:18px; height: auto">
        <form method="post" name="form1" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">
        	<div style="width:920px; text-align:left; font-size:18px; background: #E1E1E1">
              <table width="919" align="center" border="0" cellpadding="0" cellspacing="0" style="line-height:13px">
                <tr valign="baseline">
                  <td height="44" colspan="5" align="center" valign="middle" nowrap bgcolor="#333333" 
                  	style="color:#FFF; font-size:24px; font-weight: bold;">
                  	CONFIGURAR MODULO PARLEY
                  </td>
                <tr valign="baseline">
                  <td width="1" align="left" valign="middle" nowrap>&nbsp;</td>
                  <td colspan="4" align="left" valign="middle" nowrap><br>
                  	<div style="width:98.5%; text-align:left; padding:6px 0px 6px 8px; font-size:18px; background: #FFF">
                    Nombre de taquilla:
                  	<?php echo $row_Recordset1['nom_taquilla']." | Agente: ".$row_Recordset1['nom_agencia']?>
                    </div>
                    <br>
                  </td>


                <tr valign="baseline">
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <?php if ($menOpNac!="") {?>
                  <td height="33" colspan="5" align="center" valign="middle" nowrap style="background:#CC0000; color:#FFF">
                  <?php echo $menOpNac."<br/>";
                  } else {?>
                  <td colspan="5" align="center" nowrap>
                  <?php }?>
                  </td>
                </tr>
                
                <tr valign="baseline">
                  <td height="26" colspan="5" align="center" valign="middle" nowrap bgcolor="#5EAEFF">OPCIONES DE TAQUILLA</td>
                </tr>
              <table width="920" align="center" border="0"  style="line-height:11px" cellpadding="0" cellspacing="0">

                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td nowrap align="left">JUGADA MINIMA:</td>
                  <td>
                  	<input type="text" name="apu_minparley" class="textboxsmal" style="height:auto; width:100px" onclick="ocultaDiv('Info4');"
                    value="<?php echo htmlentities($apu_minparley, ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta mínima"
                    onKeyUp="return handleEnter(this, event)" />
                    <div id="Info4" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmig; ?></div>
                  </td>
                  <td nowrap align="left">JUGADA MAXIMA:</td>
                  <td>
                      <input type="text" name="apu_maxparley" class="textboxsmal" style="height:auto; width:140px" onclick="ocultaDiv('Info5');"
                      value="<?php echo htmlentities($apu_maxparley, ENT_COMPAT, 'utf-8'); ?>" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta máxima"
                    onKeyUp="return handleEnter(this, event)" tabindex="6"/>
                    <div id="Info5" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmag; ?></div>
                  </td>
                  
                </tr>

                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td nowrap align="left">COMBINACION MINIMA:</td>
                  <td>
                  	<input type="text" name="comb_minparley" class="textboxsmal" style="height:auto; width:100px" onclick="ocultaDiv('Info4');"
                    value="<?php echo htmlentities($comb_minparley, ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique combinacion mínima"
                    onKeyUp="return handleEnter(this, event)" />
                    <div id="Info4" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmig; ?></div>
                  </td>

                  <td nowrap align="left">COMBINACION MAXIMA:</td>
                  <td>
                  	<input type="number" name="comb_maxparley" class="textboxsmal" style="height:auto; width:100px" onclick="ocultaDiv('Info4');"
                    value="<?php echo htmlentities($comb_maxparley, ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" max="20" tabindex="7" min="0" max="20" onkeypress="ValidaSoloNumeros()" title="indique combinacion maxima"
                    onKeyUp="return handleEnter(this, event)" />
                    <div id="Info4" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmig; ?></div>
                    </td>
                </tr>

                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td nowrap align="left">COMBINACION MAXIMA HEMBRAS:</td>
                  <td>
                  	<input type="text" name="comb_hembra" class="textboxsmal" style="height:auto; width:100px" onclick="ocultaDiv('Info4');"
                    value="<?php echo htmlentities($comb_hembra, ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique combinacion maxima de hembras"
                    onKeyUp="return handleEnter(this, event)" />
                    <div id="Info4" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmig; ?></div>
                  </td>

                  <td nowrap align="left">Monto maximo a pagar por ticket:</td>
                  <td>
                  	<input type="text" name="monto_apuesta" class="textboxsmal" style="height:auto; width:100px" onclick="ocultaDiv('Info4');"
                    value="<?php echo htmlentities($monto_apuesta, ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique monto maximo de apuesta"
                    onKeyUp="return handleEnter(this, event)" />
                    <div id="Info4" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmig; ?></div> 
                  </td>
                </tr>

                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td nowrap align="left">LIMITE DE MINUTOS PARA PODER <br>ELIMINAR UNA APUESTA:</td>
                  <td>
                  	<input type="text" name="min_eliminar" class="textboxsmal" style="height:auto; width:100px" onclick="ocultaDiv('Info4');"
                    value="<?php echo htmlentities($min_eliminar, ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique minutos"
                    onKeyUp="return handleEnter(this, event)" />
                    <div id="Info4" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmig; ?></div>
                  </td>


                  <td nowrap align="left">Maximo a multiplicar por apuestas:</td>
                  <td>
                  	<input type="text" name="factor_pago" class="textboxsmal" style="height:auto; width:100px" onclick="ocultaDiv('Info4');"
                    value="<?php echo htmlentities($factor_pago, ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique monto maximo de apuesta"
                    onKeyUp="return handleEnter(this, event)" />
                    <div id="Info4" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmig; ?></div>
                  </td>
                </tr>

                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td nowrap align="left">FACTOR MULTIPLICADOR HEMBRA:</td>
                  <td>
                  	<input type="text" name="factor_de_hembra" class="textboxsmal" style="height:auto; width:100px" onclick="ocultaDiv('Info4');"
                    value="<?php echo htmlentities($factordehembra, ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique minutos"
                    onKeyUp="return handleEnter(this, event)" />
                    <div id="Info4" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmig; ?></div>
                  </td>


                  <td nowrap align="left">FACTOR MULTIPLICADOR MACHO:</td>
                  <td>
                  	<input type="text" name="factor_de_macho" class="textboxsmal" style="height:auto; width:100px" onclick="ocultaDiv('Info4');"
                    value="<?php echo htmlentities($factordemacho, ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique monto maximo de apuesta"
                    onKeyUp="return handleEnter(this, event)" />
                    <div id="Info4" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmig; ?></div>
                  </td>
                </tr>
                

                <tr valign="baseline">
                  <td nowrap align="right">&nbsp;</td>
                  <td nowrap align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td colspan="3">&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td height="20" colspan="11" align="center" valign="bottom" nowrap bgcolor="#5EAEFF">&nbsp;</td>
                </tr>
                </table>
              <table width="924" align="center">
                <tr valign="baseline">
                  <td width="28" align="left" nowrap>&nbsp;</td>
                  <td width="362" align="left" nowrap><br />
                  	<input type="submit" class="btn badge-warning" value="GUARDAR DATOS"  tabindex="50"
                  	style="width:180px; height:50px; font-size:16px;" />
                  </td>
                  <td width="88" align="left" nowrap>&nbsp;</td>
                  <td width="66" align="left" nowrap>&nbsp;</td>
                  <td width="33" align="left" nowrap>&nbsp;</td>
                  <td width="28" align="left" nowrap>&nbsp;</td>
                  <td width="26" align="left" nowrap>&nbsp;</td>
                  <td width="41" align="left" nowrap>&nbsp;</td>
                  <td align="right" valign="bottom" nowrap>
                  <a href='../admin/taquillas_edit.php?recordID=<?php echo $row_Recordset1['cod_taquilla']; ?>'
                  class="btn  btn-danger" style="width:150px; height:40px; font-size:16px;">
                  	<div style="padding:10px 0px 0px 0px">CANCELAR</div>
                  </a>
                  </td>
                  <td width="37" align="left" nowrap>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td colspan="9" align="left" nowrap>&nbsp;</td>
                </tr>
              </table>
               
          </div>
          <input type="hidden" name="MM_update" value="form1">
          <input type="hidden" name="cod_taquilla" value="<?php echo $row_Recordset1['cod_taquilla']; ?>">
          <input type="hidden" name="cod_taopcame" value="<?php echo $cod_taopcame; ?>">
          <input type="hidden" name="existe" value="<?php echo $existe; ?>">
      </form>
    </div>
  <!-- InstanceEndEditable -->
  </div>
  <div class="footer">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
<!-- InstanceEnd --></html>
<?php
mysqli_free_result($Recordset1);
?>