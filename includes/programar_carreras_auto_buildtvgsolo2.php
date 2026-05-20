<?php
require_once('../Connections/conexionbanca.php');

set_time_limit(0);
$hoy=fechaactualbd();
list($hipodomo, $idcarrera, $tipocarrera, $cantidad, $horainicio, $pre_build)=programar_carreras_BuildABet22();

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>.:Apuestas Hípicas:.</title>
<script src="../js/jquery-1.9.1.min.js"></script>
<script>
$(document).ready(function() {
    programa();
});
var programa = function() {
    $.ajax({    
        type: "GET",
        url: "../includes/programar_carreras_auto_racetvg.php",             
        dataType: "html",                   
        success: function(response) {                    
            $(".divprograma").html(response);
        },
		error: function(){ 
			$("#divprograma").html("<div align='center' style='padding:120px 0px 40px 0px;'><h3 style='text-align:center;'>NO HAY RESPUESTA DEL SERVIDOR</h3><h2 style='text-align:center'>Verifique su conexión de internet</h2><br/><br/><a class='btn btn-warning' style='text-decoration:none; font-size:18px; width:150px' href='javascript:location.reload()'>RECARGAR PÁGINA</a></div>");
		}    
	});
};
function crearCarrera(hipodromo, cantidad, idCarr, xDiv, x) {
	bDisable(x);
	var mError="<div style='text-align:center;font-size:11px;color: #FFF; background:#F00;'>ERROR al intentar crear Carreras<br/>Verifique su conexión de internet</div>";
	var esperar = '<div align="center" style="padding:13px 0px 0px 0px;" title=" guardando información &#13; por favor espere..."><img src="../images/barraloading.gif" width="128" height="15" /></div>';
	var parametros2 = { "hip":hipodromo, "can":cantidad, "id":idCarr };
	$.ajax({ data:parametros2, url:'../includes/programar_carreras_guardar_racetvg.php', type:'GET',
		beforeSend: function(){ $(xDiv).html(esperar); },
		success:function (response) { $(xDiv).html(response); bEnable(x);},
		error: function(){ 
			$(xDiv).html(mError);
			bEnable(x);
		}    
 
	}); 
}
function bEnable(y) {
for (i = 0; i < y; i++) {if ( document.getElementById('botAccion'+i)) {document.getElementById('botAccion'+i).disabled=false;}}
}
function bDisable(y) {
for (i = 0; i < y; i++) {if ( document.getElementById('botAccion'+i)) {document.getElementById('botAccion'+i).disabled=true;}}
}
</script>

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
<link href='//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css' rel='stylesheet'/>
<!-- InstanceEndEditable -->
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">



<table width="100%" border="0">
	<tr>
	  <td height="32" colspan="5">&nbsp;</td>
	</tr>
	<tr style="background:#5EAEFF; color:#FFFFFF; height:30px; text-align:center">
        <td width="37%">HIPODROMO</td>
        <td width="4%" style="font-size:9px">Prefijo BuildaBet2</td>
        <td width="10%" align="center">CANTIDAD</td>
        <td width="12%" align="center">HORA INICIO</td>
        <td width="11%" align="center">TIPO</td>
        <td width="30%" align="center">ACCIÓN</td>
	</tr>
    <?php
    $y=0;
    $z=count($hipodomo);
    if ($z>0 && $hipodomo[0]!="") {
        foreach ($hipodomo as $hip) {
            $tipo="";
            if ($tipocarrera[$y]=="G") {
                $tipo="CABALLOS";
            }
            if ($tipocarrera[$y]=="T") {
                $tipo="CARRETAS";
            }
            if ($tipocarrera[$y]=="D") {
                $tipo="GALGOS";
            } ?>
			<tr class="brillo" style="font-size:16px">
			  <td><?php echo $hip; ?></td>
			  <td><?php echo $pre_build[$y]; ?></td>

			  <td align="right"><?php echo $cantidad[$y]." Carreras "; ?></td>
				<td align="center"></td>
				<td align="center"><?php echo $tipo ?></td>
				<td align="right">
                <?php
                if ($hip!="") {
                    $cta=0;
                    list($nom_hipodromo, $tRow, $codH)=buscaHipBuild($pre_build[$y], "");
                    if ($tRow>0) {
                        for ($i = 1; $i <= $cantidad[$y]; $i++) {
                            $existe=verificarCarrera($nom_hipodromo, $i, $hoy);
                            if ($existe==1) {
                                $cta++;
                            }
                        }
                        if ($cta!=$cantidad[$y]) {?>
							<div align="center" style="height:38px; width:100%;" id="divAccion<?php echo $y; ?>">
							  <input type="submit" id="botAccion<?php echo $y; ?>" 
								class="btn btn-success"
								onClick="crearCarrera('<?php echo $pre_build[$y]; ?>', 
								'<?php echo $cantidad[$y]; ?>',
								'<?php echo $idcarrera[$y]; ?>',
								'#divAccion<?php echo $y; ?>',
								'<?php echo $z; ?>');"
		  style="padding:4px 0px 0px 0px; height:37px;width:156px; font-size:16px; text-decoration:none;background: #C6F;"
								value="Crear carreras" 
		  title=" se crearán <?php echo $cantidad[$y]?> carreras &#13; para el hipódromo <?php echo $hip ?>"/>
		   <input type="hidden" type="submit"  value="crearCarrera('<?php echo $pre_build[$y]; ?>', 
								'<?php echo $cantidad[$y]; ?>',
								'<?php echo $idcarrera[$y]; ?>',
								'#divAccion<?php echo $y; ?>',
								'<?php echo $z; ?>');"
							</div>
				<?php
//evento
$pre_build=$pre_build[$y];
echo $pre_build;
$cantidad=$cantidad[$y];
$idcarrera=$idcarrera[$y];
$pre_build = trim(str_replace(" ", "+", $pre_build));
    $url = "http://localhost/includes/programar_carreras_guardar_buildtvgsolo.php?hip=".$pre_build."&can=".$cantidad."&id=".$idcarrera;
    $result = file_get_contents($url);


?>			

						
							
							

							
							
							
						<?php


?>	
							
	
							
						<?php
                        
                        } else {?>
							<div align="center" style="height:29px;width:100%;padding:9px 0px 0px 0px;color:#009900">
								CARRERAS YA CREADAS
							</div>
						<?php
                        }
                    } else {?>
						<div align="center" style="height:38px; width:100%;">
						<a class="btn btn-danger" href="hipodromos_listas.php"  
                        style="text-align:center; color:#FFFFFF; width:135px;text-decoration:none; font-size:12px"
                        title="Prefijo BuildABet2 no configurado ó hipodromo no existe">
                        
  							<i class="fa fa-cog fa-2x pull-center"></i> IR A HIPÓDROMOS
                        </a>
						</div>
					<?php
                    }
                } ?>  
				</td>
			</tr>
		<?php
            $y++;
        }
    } else {?>
        <tr style="text-align:center; font-size:28px; height:100px">
            <td colspan="5">NO EXISTEN DATOS</td>
        </tr>
    	<?php
    }?>        
</table>
  <div class="footer">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
<!-- InstanceEnd -->
</html>