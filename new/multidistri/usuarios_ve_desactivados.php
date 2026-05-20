<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "S"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
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
    "/* PARSEADORES1 new\multidistri\usuarios_ve_desactivados.php - QUERY 1 */ SELECT
ta.taq_vende_ame,
ta.taq_por_ame,
ta.taq_vende_parley,
ta.taq_por_parley,
ta.taq_vende_hnac,
ta.taq_cob_hnac,
ta.moneda,  
	ta.nom_taquilla, ta.nom_representante, ta.tel_taquilla, ta.tel_taquilla2, ta.tel_taquilla3, ta.est_taquilla, ta.cod_taquilla,
	ag.nom_agencia 
	FROM  taquilla ta, agencia ag
	WHERE ta.cod_taquilla = %s AND ag.cod_agencia = ta.cod_agencia LIMIT 1",
    GetSQLValueString($xCodigo, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

$query_Recordset94 =  sprintf(
  "/* PARSEADORES1 new\multidistri\usuarios_ve_desactivados.php - QUERY 2 */ SELECT
ba.sinoclavesdistri
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
    
    
        $query_Recordset11 = sprintf(
            "/* PARSEADORES1 new\multidistri\usuarios_ve_desactivados.php - QUERY 3 */ SELECT * FROM usuario 
	WHERE tip_usuario='U' 
	AND usuario.cod_taquilla = %s AND usuario.est_usuario=0
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
            "/* PARSEADORES1 new\multidistri\usuarios_ve_desactivados.php - QUERY 4 */ UPDATE taquilla 
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
    "/* PARSEADORES1 new\multidistri\usuarios_ve_desactivados.php - QUERY 5 */ SELECT ta.cod_taquilla, ta.nom_taquilla
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
			<?php include("../includes/cabeceraamericana_multidistri.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 30px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
                    <!-- InstanceBeginEditable name="Menu" -->
                    <?php include("../includes/cabeceramultidistri.php");?>
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
              
			  
			  
			  <table width="919" align="center" border="0" cellpadding="0" cellspacing="0" style="line-height:13px">
                <tr valign="baseline">
                  <td height="26" colspan="5" align="center" valign="middle" nowrap bgcolor="#5EAEFF"><br/>LISTA DE VENDEDORES DESACTIVADOS<br /><br />  
                </tr>
              </table>
              <table width="920" align="center" border="0"  style="line-height:11px" cellpadding="0" cellspacing="0">







  	<div style="height:100%; font-size:18px;" class="xfirefox">
        <div style="height:100%; font-size:28px; padding:10px 10px 20px 10px; float:right;">
            <a href="taquillas_edit.php?recordID=<?php echo $row_Recordset1['cod_taquilla']; ?>" class="btn alert-success" 
            	style="font-size:18px; width:265px; height:40px; padding:5px 0px 0px 0px; text-align:center; background:#9C0;
                text-decoration:none;" title="crear nuevo usuario vendedor">
                 Edit y Vendedores Activos
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