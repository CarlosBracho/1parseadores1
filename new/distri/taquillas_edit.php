<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "D"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
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
$xCodigo = "-1";
$xCodigo2 = "-1";

include("../includes/taquilla_estandar.php");

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
    "/* PARSEADORES1 new\distri\taquillas_edit.php - QUERY 1 */ SELECT
ta.taq_vende_ame,
ta.taq_por_ame,
ta.taq_vende_parley,
ta.taq_por_parley,
ta.taq_vende_hnac,
ta.taq_cob_hnac,
ta.moneda,  
	ta.nom_taquilla, ta.nom_representante, ta.tel_taquilla, ta.tel_taquilla2, ta.tel_taquilla3, ta.est_taquilla, ta.cod_taquilla,
	ag.nom_agencia, ag.agen_vende_parley
	FROM  taquilla ta, agencia ag 
	WHERE ta.cod_taquilla = %s AND ag.cod_agencia = ta.cod_agencia LIMIT 1",
    GetSQLValueString($xCodigo, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);


$query_Recordset94 =  sprintf(
  "/* PARSEADORES1 new\distri\taquillas_edit.php - QUERY 2 */ SELECT
ba.sinoclavesdistri,
ba.sinomonedadistri
FROM  taquilla ta, 
      banca ba,
      agencia ag
WHERE ta.cod_taquilla = %s AND ag.cod_agencia = ta.cod_agencia AND ag.cod_banca = ba.cod_banca LIMIT 1",
GetSQLValueString($xCodigo, "int")
);
$Recordset94 = mysqli_query($conexionbanca, $query_Recordset94) or die(mysqli_error($conexionbanca));
$row_Recordset94 = mysqli_fetch_assoc($Recordset94);
$totalRows_Recordset94 = mysqli_num_rows($Recordset94);



$moneda=$row_Recordset1['moneda']/1;

$est_taquilla=$row_Recordset1['est_taquilla']/1;
    $taq_vende_ame=$row_Recordset1['taq_vende_ame']/1;
    $taq_por_ame=$row_Recordset1['taq_por_ame']/1;

    $taq_vende_parley=$row_Recordset1['taq_vende_parley']/1;
    $taq_por_parley=$row_Recordset1['taq_por_parley']/1;
    $taq_vende_hnac=$row_Recordset1['taq_vende_hnac']/1;
    $taq_cob_hnac=$row_Recordset1['taq_cob_hnac']/1;
    $agen_vende_parley=$row_Recordset1['agen_vende_parley']/1;
    
        $query_Recordset11 = sprintf(
            "/* PARSEADORES1 new\distri\taquillas_edit.php - QUERY 3 */ SELECT * FROM usuario 
	WHERE tip_usuario='U' 
	AND usuario.cod_taquilla = %s AND usuario.est_usuario=1
	ORDER BY usuario.nom_usuario ASC",
            GetSQLValueString($xCodigo, "int")
        );
$Recordset11 = mysqli_query($conexionbanca, $query_Recordset11) or die(mysqli_error($conexionbanca));
$row_Recordset11 = mysqli_fetch_assoc($Recordset11);
$totalRows_Recordset11 = mysqli_num_rows($Recordset11);



    
$porcentaje=0;
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    $graba=31;
    if ($graba==31) {
        $insertSQL1 = sprintf(
            "/* PARSEADORES1 new\distri\taquillas_edit.php - QUERY 4 */ UPDATE taquilla 
				SET nom_representante=%s, tel_taquilla=%s, tel_taquilla2=%s, tel_taquilla3=%s, est_taquilla=%s,
				taq_vende_ame=%s,
taq_por_ame=%s,
taq_vende_parley=%s,
taq_por_parley=%s,
taq_vende_hnac=%s,
taq_cob_hnac=%s,
moneda=%s				
				WHERE cod_taquilla=%s",
            GetSQLValueString($_POST['nom_representante'], "text"),
            GetSQLValueString($_POST['tel_taquilla'], "text"),
            GetSQLValueString($_POST['tel_taquilla2'], "text"),
            GetSQLValueString($_POST['tel_taquilla3'], "text"),
            GetSQLValueString($_POST['est_taquilla'], "int"),
            GetSQLValueString($_POST['taq_vende_ame'], "int"),
            GetSQLValueString($_POST['taq_por_ame'], "double"),
            GetSQLValueString($_POST['taq_vende_parley'], "int"),
            GetSQLValueString($_POST['taq_por_parley'], "double"),
            GetSQLValueString($_POST['taq_vende_hnac'], "int"),
            GetSQLValueString($_POST['taq_cob_hnac'], "double"),
            GetSQLValueString($_POST['moneda'], "int"),
            GetSQLValueString($_POST['cod_taquilla'], "int")
        );
        
        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        
        
        /*
                    if ($row_Recordset1['moneda']==0)
        {
        $apuestasminimaausar=$apuestasminimaaganadorbss0;
        echo "apuestasminima a usar";
        echo "<br>";
        echo $apuestasminimaausar;
        echo "<br>";
        }
        if ($row_Recordset1['moneda']==1)
        {
        $apuestasminimaausar=$apuestasminimaaganadorusd1;
        echo "apuestasminima a usar";
        echo "<br>";
        echo $apuestasminimaausar;
        echo "<br>";
        }
        if ($row_Recordset1['moneda']==2)
        {
        $apuestasminimaausar=$apuestasminimaaganadorpc2;
        echo "apuestasminima a usar";
        echo "<br>";
        echo $apuestasminimaausar;
        echo "<br>";
        }
        if ($row_Recordset1['moneda']==3)
        {
        $apuestasminimaausar=$apuestasminimaaganadorsp3;
        echo "apuestasminima a usar";
        echo "<br>";
        echo $apuestasminimaausar;
        echo "<br>";
        }
        if ($row_Recordset1['moneda']==10)
        {
        $apuestasminimaausar=$apuestasminimaaganadorusd1;
        echo "apuestasminima a usar";
        echo "<br>";
        echo $apuestasminimaausar;
        echo "<br>";
        }



        $query_Recordset22 =  sprintf("SELECT
        tp.apu_mingan
            FROM  taquilla_opc_ame tp
            WHERE tp.cod_taquilla = %s
            LIMIT 1",
            GetSQLValueString($_POST['cod_taquilla'], "int"));
        $Recordset22 = mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
        $row_Recordset22 = mysqli_fetch_assoc($Recordset22);
        $totalRows_Recordset22 = mysqli_num_rows($Recordset22);




        if ($apuestasminimaausar > $row_Recordset22['apu_mingan'] )
        {
        $insertSQL11 = sprintf("UPDATE taquilla_opc_ame
                            SET
                            apu_mingan=%s
                            WHERE cod_taquilla=%s",

                                       GetSQLValueString($apuestasminimaausar, "int"),
                                       GetSQLValueString($_POST['cod_taquilla'], "int"));

                    $Result11 = mysqli_query($conexionbanca, $insertSQL11) or die(mysqli_error($conexionbanca));
                    echo "se modifico";
        echo "<br>";
        } else {
                    echo "no no se modifico";
        echo "<br>";
        }



            */
            
            
            
        
        
        
        $insertGoTo = "taquillas_lista.php";
        if (isset($_SERVER['QUERY_STRING'])) {
            $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
            $insertGoTo .= $_SERVER['QUERY_STRING'];
        }
        header(sprintf("Location: %s", $insertGoTo));
    }
}
$query_Recordset3 = sprintf(
    "/* PARSEADORES1 new\distri\taquillas_edit.php - QUERY 5 */ SELECT ta.cod_taquilla, ta.nom_taquilla 
FROM taquilla ta, taquilla_opc_ame tp WHERE ta.cod_taquilla = tp.cod_taquilla AND ta.cod_taquilla != %s ORDER BY nom_taquilla",
    GetSQLValueString($xCodigo2, "int")
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
function ValidaSoloNumeros() {
	if (event.keyCode != 46) {
		if ((event.keyCode < 48) || (event.keyCode > 57)) 
			event.returnValue = false;
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
			<?php include("../includes/cabeceraamericana_di.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
                    <!-- InstanceBeginEditable name="Menu" -->
                    <?php include("../includes/cabeceradistri.php");?>
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
        
    </div>
	<div style="padding:70px 10px 20px 10px; text-align:left; font-size:18px; height: auto">
        <form method="post" name="form1" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">
        	<div style="width:920px; text-align:left; font-size:18px; background: #E1E1E1">
              
			  
			  
			  <table width="919" align="center" border="0" cellpadding="0" cellspacing="0" style="line-height:14px">
<tr valign="baseline">
                  <td height="44" colspan="5" align="center" valign="middle" nowrap bgcolor="#333333" 
                  	style="color:#FFF; font-size:24px; font-weight: bold;"> <br />
                  SELECCIONE AQUI PARA ACTIVAR O DESACTIVAR ESTA TAQUILLA:<br /><br />

                    <select name="est_taquilla" style="width:140px; height: auto" class="textbox" tabindex="4"> 
					                        <option value="1" <?php if (!(strcmp(1, htmlentities($est_taquilla, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>ACTIVO</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($est_taquilla, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>INACTIVO</option>
                  </select>
				  </td>
                </tr>
								<?php

if ($row_Recordset94['sinomonedadistri']==0) {
  ?>
  <tr>
                  <td height="44" colspan="5" align="center" valign="middle" nowrap bgcolor="#5EAEFF" 
                  	style="color:#FFF; font-size:24px; font-weight: bold;">
                  	SELECIONE TIPO DE MONEDA DE ESTA TAQUILLA
                  </td>
                </tr>  
				<tr>
                  <td height="44" colspan="5" align="center" valign="middle" nowrap bgcolor="#999999">										                 
                      <select name="moneda" style="width:240px; height: auto" class="textbox" tabindex="4"> 
                      <option value="0" <?php if (!(strcmp(0, htmlentities($moneda, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>BOLIVAR SOBERANO</option>
                      <option value="1" <?php if (!(strcmp(1, htmlentities($moneda, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>DOLAR AMERICANO</option>
                      <option value="2" <?php if (!(strcmp(2, htmlentities($moneda, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>PESO COLOMBIANO</option>
                      <option value="3" <?php if (!(strcmp(3, htmlentities($moneda, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>SOL PERUANO</option>	
                      <option value="10" <?php if (!(strcmp(10, htmlentities($moneda, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>MULTI MONEDA</option>							  
					</select>


				 </td>
                </tr> 



<?php

}
?>


<?php
                if ($row_Recordset94['sinomonedadistri']==1){
                  ?>            
												<tr>
                  <td height="85" colspan="5" align="center" valign="middle" nowrap bgcolor="#5EAEFF" 
                  	style="color:#FFF; font-size:24px; font-weight: bold;">
<?php 

if ($row_Recordset1['moneda']==0){
  echo 'TAQUILLA EN BOLIVAR SOBERANO.';
  }
if ($row_Recordset1['moneda']==1){
  echo 'TAQUILLA EN DOLAR AMERICANO.';
  }
if ($row_Recordset1['moneda']==2){
  echo 'TAQUILLA EN PESOS COLOMBIANOS.';
  }
if ($row_Recordset1['moneda']==3){
  echo 'TAQUILLA EN SOL PERUANO.';
  }
if ($row_Recordset1['moneda']==10){
  echo 'TAQUILLA EN MULTIMONEDA.';
  }

?>
                  </td>
                </tr>  


                <?php
}  

?> 
				<tr>
                  <td height="44" colspan="5" align="center" valign="middle" nowrap bgcolor="#5EAEFF" 
                  	style="color:#FFF; font-size:24px; font-weight: bold;">
                  	COSTO DEL SISTEMA PARA ESTA TAQUILLA
                  </td>
                </tr>  
                 <tr valign="baseline">
                  <td width="300" height="41" align="center" valign="bottom" nowrap bgcolor="#999999">Estado Venta Internacionales:</td>
                  <td width="300" align="center" valign="bottom" nowrap>Estado Venta Nacionales:</td>

                  <?php  if ($dist_vende_parley==1 && $agen_vende_parley==1) {?>
                  <td width="300" height="41" align="center" valign="bottom" nowrap bgcolor="#999999">Estado Venta Parley:</td>
                  <?php          } ?>
                  <td align="center" valign="bottom" nowrap>&nbsp;</td>
                </tr>  
                <tr valign="baseline">
                  <td width="120" height="88" align="center" valign="top" nowrap bgcolor="#999999">										                 
                    <select name="taq_vende_ame" style="width:140px; height: auto" class="textbox" tabindex="4"> 
                      <option value="1" <?php if (!(strcmp(1, htmlentities($taq_vende_ame, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>ACTIVO</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($taq_vende_ame, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>INACTIVO</option>					  
					</select><br />
					Porcentaje Internacionales:<br />
					<input type="text" name="taq_por_ame" class="textbox" style="height:auto; width:50px" 
                    onclick="ocultaDiv('Info7');"
                    value="<?php echo htmlentities($taq_por_ame, ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique pocentaje"
                    onKeyUp="return handleEnter(this, event)" tabindex="8" required max="100"/>
                  	%
										     <br/> <a href='../distri/taquillas_edit_ame.php?recordID=<?php echo $row_Recordset1['cod_taquilla']; ?>'class="btn btn-info"> EDITAR MODULO <br/>HIPISMO INTERNACIONAL</a>



				 </td>





				                 
				                   
                           
                           
                           <td width="120" align="center" valign="top" nowrap>
								                       <select name="taq_vende_hnac" style="width:140px; height: auto" class="textbox" tabindex="4"> 

					  
					                        <option value="1" <?php if (!(strcmp(1, htmlentities($taq_vende_hnac, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>ACTIVO</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($taq_vende_hnac, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>INACTIVO</option>
						  
						  
						  
					</select>
					<br/>Costo x pto Nacionales:<br/>
                  	<input type="text" name="taq_cob_hnac" class="textbox" style="height:auto; width:100px" 
                    onclick="ocultaDiv('Info7');"
                    value="<?php echo htmlentities($taq_cob_hnac, ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique monto"
                    onKeyUp="return handleEnter(this, event)" tabindex="8" required max="100"/>
										     <br/> <a href='../distri_hnac/distri_taquillas_edit_hnac.php?recordID=<?php echo $row_Recordset1['cod_taquilla']; ?>'class="btn btn-info"> EDITAR MODULO <br/>HIPISMO NACIONAL</a>
     
					
                  </td>
						  

                  <?php  
                  echo '*** '.$dist_vende_parley.' *** '.$agen_vende_parley;

                  if ($dist_vende_parley==1 && $agen_vende_parley==1) {
                    echo 'utf-8';
                    ?>

 
                  <td width="120" height="88" align="center" valign="top" nowrap bgcolor="#999999">										                 
                    <select name="taq_vende_parley" style="width:140px; height: auto" class="textbox" tabindex="4"> 
                      <option value="1" <?php if (!(strcmp(1, htmlentities($taq_vende_parley, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>ACTIVO</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($taq_vende_parley, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>INACTIVO</option>					  
					</select><br />
					Porcentaje Parley:<br />
					<input type="text" name="taq_por_parley" class="textbox" style="height:auto; width:50px" 
                    onclick="ocultaDiv('Info7');"
                    value="<?php echo htmlentities($taq_por_parley, ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique pocentaje"
                    onKeyUp="return handleEnter(this, event)" tabindex="8" required max="100"/>
                  	%
										     <br/> <a href='../distri/taquillas_edit_parley.php?recordID=<?php echo $row_Recordset1['cod_taquilla']; ?>'class="btn btn-info"> EDITAR MODULO <br/>PARLEY</a>



				 </td>
         <?php          } ?>


						  </table>
			  
			  
			  

			  
			  
			  <table width="919" align="center" border="0" cellpadding="0" cellspacing="0" style="line-height:13px">
                <tr valign="baseline">
                  <td height="44" colspan="5" align="center" valign="middle" nowrap bgcolor="#333333" 
                  	style="color:#FFF; font-size:24px; font-weight: bold;">
                  	DATOS DE TAQUILLA
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
                  <td align="left" valign="middle" nowrap>&nbsp;</td>
                  <td colspan="2" align="left" valign="middle" nowrap>Nombre de representante:<br />
                  <input type="text" name="nom_representante" class="textbox" tabindex="2" placeholder="nombre completo"
                  value="<?php echo htmlentities($row_Recordset1['nom_representante'], ENT_COMPAT, 'utf-8'); ?>" 
                  size="32" title="indique un nombre de representante. 4-30 caracteres" onclick="ocultaDiv('Info2');"
                  style="width:95%"/>
                  <div id="Info2" style="float: left; padding:0px 0px 0px 0px; font-size:16px; color:#F00;">
				  <?php echo $menNre; ?></div>
                  </td>

                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap>&nbsp;</td>
                  <td width="240" align="left" nowrap>
                  Nro de contacto principal:<br />
                  <input type="text" name="tel_taquilla" class="textbox"  tabindex="3"
                  size="32"  maxlength="20" onkeypress="ValidaSoloNumeros()"
                  value="<?php echo htmlentities($row_Recordset1['tel_taquilla'], ENT_COMPAT, 'utf-8'); ?>"  
                  placeholder="02120000000" title="indique número de teléfono. 9 caracteres mín"
                  onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info3');"/>
                  <div id="Info3" style="float: left; padding:0px 0px 0px 0px; font-size:16px; color:#F00">
				  <?php echo $menTel; ?></div>
                  </td>
                  <td width="242" align="left" nowrap>Nro de contacto 1er auxiliar:<br/>
                  <input type="text" name="tel_taquilla2" class="textbox" tabindex="3"
                  size="32"  maxlength="20" onkeypress="ValidaSoloNumeros()"
                  value="<?php echo htmlentities($row_Recordset1['tel_taquilla2'], ENT_COMPAT, 'utf-8'); ?>"  
                  placeholder="02120000000" title="indique número de teléfono. 9 caracteres mín"
                  onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info3');"/>
                  <div id="Info3" style="float: left; padding:0px 0px 0px 0px; font-size:16px; color:#F00">
				  <?php echo $menTel; ?></div>
                  </td>
                  <td align="left" nowrap>Nro de contacto 2do auxiliar:<br/>
                  <input type="text" name="tel_taquilla3" class="textbox" tabindex="3"
                  size="32"  maxlength="20" onkeypress="ValidaSoloNumeros()"
                  value="<?php echo htmlentities($row_Recordset1['tel_taquilla3'], ENT_COMPAT, 'utf-8'); ?>"  
                  placeholder="02120000000" title="indique número de teléfono. 9 caracteres mín"
                  onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info3');"/>
                  <div id="Info3" style="float: left; padding:0px 0px 0px 0px; font-size:16px; color:#F00">
				  <?php echo $menTel; ?></div>
                  </td>
                  <td align="right" nowrap>&nbsp;</td>
                </tr>
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
                  <td height="26" colspan="5" align="center" valign="middle" nowrap bgcolor="#5EAEFF"><br/>OPCIONES DE TRABAJADORES DE ESTA TAQUILLA<br /><br />  
                </tr>
              </table>
              <table width="920" align="center" border="0"  style="line-height:11px" cellpadding="0" cellspacing="0">


	<div style="height:100%; font-size:18px;" class="xfirefox">
      <div style="height:100%; font-size:28px; padding:10px 10px 20px 10px; float:left;">
            <a href="usuarios_ve_desactivados.php?recordID=<?php echo $row_Recordset1['cod_taquilla']; ?>" class="btn alert-success" 
            	style="font-size:18px; width:265px; height:40px; padding:5px 0px 0px 0px; text-align:center; background:red; color:white;
                text-decoration:none;" title="crear nuevo usuario vendedor">
                 Lista de Vendedores Desactivados
            </a>
			       
    </div>





  	<div style="height:100%; font-size:18px;" class="xfirefox">
        <div style="height:100%; font-size:28px; padding:10px 10px 20px 10px; float:right;">
            <a href="usuarios_ve_add.php?recordID=<?php echo $row_Recordset1['cod_taquilla']; ?>" class="btn alert-success" 
            	style="font-size:18px; width:265px; height:40px; padding:5px 0px 0px 0px; text-align:center; background:#9C0;
                text-decoration:none;" title="crear nuevo usuario vendedor">
                 Añadir Nuevo Vendedor A Esta Taquilla
            </a>
			       
        </div>
    <?php if ($totalRows_Recordset11>0) {?>    

	<table width="100%" border="0" align="center">
  		<tr style="background:#5EAEFF; color:#FFFFFF; height:30px">
          <td width="238">NOMBRE</td>
		  <td width="246">CLAVE</td>
		            <td width="202">TIICKET A ELIMINAR</td>
          <td width="202">STATUS</td>

          <td>ACCIÓN</td>
        </tr>
        <?php do { ?>
          <tr class="brillo">
            <td align="left"><?php echo $row_Recordset11['nom_usuario']; ?></td>
            <td align="left"><?php
            if ($row_Recordset94['sinoclavesdistri']==1){
              echo $row_Recordset11['pas_usuario'];}
              //echo $row_Recordset11['pas_usuario'];}   
      ?></td>						
            <td align="left"><?php echo $row_Recordset11['tic_eliminados']; ?></td>
            <td align="center"><?php echo ObtenerNombreStatus($row_Recordset11['est_usuario']); ?></td>
            <td align="center">
           	  <a href='usuarios_ve_edit.php?recordID=<?php echo $row_Recordset11['id_usuario']; ?>'class="btn btn-info"> EDITAR </a>
            </td>
          </tr>
          <?php } while ($row_Recordset11 = mysqli_fetch_assoc($Recordset11)); ?>
      </table>
       <?php } else {?>
      <table width="100%" border="0" align="center" style="background:#5EAEFF; color:#FFFFFF; height:30px">
  		<tr style="background:#5EAEFF; color:#FFFFFF; height:30px">
          <td width="246">NOMBRE</td>
		  <td width="246">CLAVE</td>
          <td width="196">STATUS</td>
          <td width="80" colspan="2">ACCIÓN</td>
        </tr>
      </table>
          <div style="height:100%; font-size:24px; padding:200px 0px 170px 0px ">
            No existen registros
        </div>
      <?php }?>  
</div>




                <tr valign="baseline">
                  <td height="48" align="right" nowrap>&nbsp;</td>
                  <td nowrap align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
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
                  <a href='taquillas_lista.php'
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