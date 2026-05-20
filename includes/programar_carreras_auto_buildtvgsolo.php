<?php
require_once('../Connections/conexionbanca.php');

set_time_limit(0);
$hoy=fechaactualbd();
list($hipodomo, $idcarrera, $tipocarrera, $cantidad, $horainicio, $pre_build)=programar_carreras_BuildABet2();

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
        url: "../includes/programar_carreras_auto_racetvgsolo.php",             
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

    $url = "http://localhost/includes/programar_carreras_guardar_buildtvgsolo.php?hip=".$pre_build."&can=".$cantidad."&id=".$idcarrera;
    $result = file_get_contents($url);


?>			

						
							
							

							
							
							
						<?php

/*
"../includes/programar_carreras_guardar_buildtvgsolo.php?hip=".$pre_build."&can=".$cantidad."&id=".$idcarrera;


function crearCarrera($pre_build, $cantidad, $idcarrera, $y, $z) {
    $.ajax({ data:parametros2, url:'../includes/programar_carreras_guardar_buildtvgsolo.php', type:'GET',
        success:function (response) { $(xDiv).html(response); bEnable(x);},
        error: function(){
            $(xDiv).html(mError);
            bEnable(x);
        }

    });
}


crearCarrera($pre_build, $cantidad, $idcarrera, $y, $z);
// evento crearCarrera('<?php $pre_build[$y];
                            // /1/includes/programar_carreras_guardar_buildtvgsolo.php?hip=FLK&can=9&id=427069%2F4603398
                                             <br/> <a href='../admin_hnac/admin_taquillas_edit_hnac.php?recordID=<?php echo $row_Recordset1['cod_taquilla']; ?>'class="btn btn-info"> EDITAR MODULO <br/>HIPISMO NACIONAL</a>
$insertGoTo = "../admin/taquillas_edit.php?recordID=".$codTaquilla;





















                            //comienzo guardar carreras
set_time_limit(0);
include('../includes/mtp_funcion.php');
list($hi, $mT, $pr, $ca, $ho, $ti, $co, $codTVG)=programar_carreras_tvg();
$xhip="";
$xcan=0;
$cod_banca=2;
$mensaje1="";
$mensaje2="";
$t=0;
$prefijo="";
$tarNoch="";
$result1="http://basic.tvg.com/TVGShared/handlers/Results.ashx?TrackAbbr=";
$result2="&Performance=";
$result3="&Tote=PORT&RaceDate=";
$extResu="&RaceNum=";
$retira1="http://basic.tvg.com/TVGShared/handlers/CurrentInfo.ashx?TrackAbbr=";
$extReti="&AddVideoInformation=true";
if (isset($_GET["hip"]) && isset($_GET["can"])) {
    $xhip = $_GET["hip"];
    $xcan = $_GET["can"];
    $id = $_GET["id"];
    $hoy=fechaactualbd();
    if ($xhip!="" && $xcan>0) {
        $id = explode("/",$_GET["id"]);
        $idH=$id[0];
        $idP=$id[1];
        $hoy=fechaactualbd();
        $url2='http://bab2ghc.usofftrack.com/data/ProgramDetail.json?sdt='.$hoy.'&aid=&pid='.$idH.'&rid='.$idP.'&init=true';
        $str_datos2 = get_url_contents($url2);
        $fulldatos2 = json_decode($str_datos2,true);
        $h=0;
        $id="";
        foreach($fulldatos2["Result"]["races"] as $da2) {
            $raceNu[$h]=$fulldatos2["Result"]["races"][$h]["RaceNumber"];
            $Runner[$h]=$fulldatos2["Result"]["races"][$h]["NumberOfRunners"];
            $racePr[$h]=$fulldatos2["Result"]["races"][$h]["ProgramID"];
            $raceId[$h]=$fulldatos2["Result"]["races"][$h]["RaceID"];
            if ($h==0) $id=$racePr[$h]."/".$raceId[$h];
            else  $id=$id."/".$raceId[$h];
            $h++;
        }
        list($cod, $hipodomo, $mtp_control)=buscaHip6($xhip);
        $verif=verificarCarrera2($cod,1,$hoy);
        if ($verif==0) {
                $acceso=0;
                $z=count($codTVG);
                if ($z>0 && $hi[0]!="" && $cod>0) {
                    $ky=0;
                    foreach($codTVG as $chip){
                        if ($chip==$cod) {
                            $result=$result1.$pr[$ky].$result2.$mT[$ky].$result3;
                            $retiro=$retira1.$pr[$ky].$result2.$mT[$ky].$result3;
                            $prefijo=$pr[$ky];
                            $tarNoch=$mT[$ky];
                            $acceso=1;
                            break;
                        }
                        $ky++;
                    }
                }

                if ($acceso==1) {
                    $updateSQL = sprintf("UPDATE hipodromo SET
                                dir_pagresultado_tvg=%s,
                                ext_pagresultado_tvg=%s,
                                dir_retirado=%s,
                                ext_retirado=%s,
                                cod_pagina_rb=%s
                            WHERE
                                cod_hipodromo=%s",
                            GetSQLValueString($result, "text"),
                            GetSQLValueString($extResu, "text"),
                            GetSQLValueString($retiro, "text"),
                            GetSQLValueString($extReti, "text"),
                            GetSQLValueString($id, "text"),
                            GetSQLValueString($cod, "int"));
                    $Result = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));

                }
                else {
                    $updateSQL = sprintf("UPDATE hipodromo SET
                        cod_pagina_rb=%s
                        WHERE
                        cod_hipodromo=%s",
                       GetSQLValueString($id, "text"),
                       GetSQLValueString($cod, "int"));
                    $Result = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                }
            }
        for ($i = 1; $i <= $xcan; $i++) {
            list($cod, $hipodomo, $mtp_control)=buscaHip6($xhip);
            if ($mtp_control==-1) $mtp_control=3;
            $verif=verificarCarrera2($cod,$i,$hoy);
            if ($verif==0 && $cod!=-1) {
                $insertSQL = sprintf("INSERT INTO carrera
                    (cod_banca,
                    cod_hipodromo,
                    nom_hipodromo,
                    nom_hipodromo_hpi,
                    fec_carrera,
                    hor_carrera,
                    hor_mtp,
                    num_carrera,
                    est_carrera,
                    est_cierre,
                    est_confirmacion,
                    mtp_control,
                    mtp_tipo,
                    can_caballos)
                    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($cod_banca, "int"),
                       GetSQLValueString($cod, "int"),
                       GetSQLValueString($hipodomo, "text"),
                       GetSQLValueString($xhip, "text"),
                       GetSQLValueString($hoy, "date"),
                       GetSQLValueString("01:00:00", "date"),
                       GetSQLValueString("01:00:00", "date"),
                       GetSQLValueString($i, "int"),
                       GetSQLValueString(1, "int"),
                       GetSQLValueString(3, "int"),
                       GetSQLValueString(1, "int"),
                       GetSQLValueString(3, "int"),
                       GetSQLValueString(1, "int"),
                       GetSQLValueString(20, "int"));
                $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                $mensaje1="Carrera(s) creada(s)";
            } else {
                $t++;
                if ($cod!=1) $mensaje2="código de hipódromo no existe /".$xhip; else {
                if ($t==1) $mensaje2="una carrera ya ha sido creada anteriormente";
                if ($t>1) $mensaje2="varias carreras ya han sido creadas anteriormente";
                if ($t>=$xcan) $mensaje2="Todas las carreras ya han sido creadas anteriormente"; }
            }
        }
    }
}
if ($mensaje1!="") echo '<font size="1" face="verdana" color="green">'.$mensaje1."(".$prefijo.")>".$tarNoch.'<br/></font>';
echo '<font size="1" face="verdana" color="red">'.$mensaje2.'</font>';
//fin guardar carreras
                        //	*/
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