<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
set_time_limit(0);
$hoy=fechaactualbd();
list($hipodomo, $mTn, $pre, $cantidad, $horainicio, $tipocarrera, $codHipo, $cod_hipodromo)=programar_carreras_tvg();
?>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>.:Apuestas Hípicas:.</title>
<script src="../js/jquery-1.9.1.min.js"></script>
<script>
function crearCarrera(hipodromo, cantidad, mTn, pre, cHip, xDiv, x) {
	bDisable(x);
	var mError="<div style='text-align:center;font-size:11px;color: #FFF; background:#F00;'>ERROR al intentar crear Carreras<br/>Verifique su conexión de internet</div>";
	var esperar = '<div align="center" style="padding:13px 0px 0px 0px;" title=" guardando información &#13; por favor espere..."><img src="../images/barraloading.gif" width="128" height="15" /></div>';
	var parametros2 = { "hip":hipodromo, "can":cantidad, "mTn":mTn, "pre":pre, "cHip":cHip };
	$.ajax({ data:parametros2, url:'../includes/programar_carreras_guardar_tvg.php', type:'GET',
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
        <td width="10%" align="center">CANTIDAD</td>
        <td width="12%" align="center">HORA</td>
        <td width="11%" align="center">TIPO</td>
        <td width="30%" align="center">ACCIÓN</td>
	</tr>
    <?php
    $y=0;
    $z=count($hipodomo);
    if ($z>0 && $hipodomo[0]!="") {
        foreach ($hipodomo as $hip) {
            $tipo="";
            if ($tipocarrera[$y]=="1") {
                $tipo="--";
            }
            if ($tipocarrera[$y]=="2") {
                $tipo="--";
            }
            if ($tipocarrera[$y]=="3") {
                $tipo="--";
            } ?>
			<tr class="brillo" style="font-size:16px">
			  <td><?php echo $hip ?></td>
			  <td align="right"><?php echo $cantidad[$y]." Carreras"; ?></td>
				<td align="center"><?php echo $horainicio[$y] ?></td>
				<td align="center"><?php echo $tipo ?></td>
				<td align="right">
                <?php
                if ($hip!="") {
                    $cta=0;
                    $nom_hipodromo=buscaHip4($cod_hipodromo[$y]);
                    for ($i = 1; $i <= $cantidad[$y]; $i++) {
                        $existe=verificarCarrera($nom_hipodromo, $i, $hoy);
                        if ($existe==1) {
                            $cta++;
                        }
                    }
                    if ($cta!=$cantidad[$y]) {?>
                        <div align="center" style="height:38px; width:100%;" id="divAccion<?php echo $y; ?>">
                          <input type="submit" id="botAccion<?php echo $y; ?>" 
                            class="btn btn-danger"
                            onClick="crearCarrera('<?php echo $nom_hipodromo; ?>', 
                            '<?php echo $cantidad[$y]; ?>',
                            '<?php echo $mTn[$y]; ?>',
                            '<?php echo $pre[$y]; ?>',
                            '<?php echo $codHipo[$y]; ?>',
                            '#divAccion<?php echo $y; ?>',
                            '<?php echo $z; ?>');"
                            style="padding:4px 0px 0px 0px; height:37px;width:130px; font-size:16px; text-decoration:none;"
                            value="Crear carreras" 
                            title=" se crearán <?php echo $cantidad[$y]?> carreras &#13; para el hipódromo <?php echo $hip ?>"/>
                      </div>
					<?php


$cantidad=$cantidad[$y];
$mTn=$mTn[$y];
$pre=$pre[$y];
$codHipo=$codHipo[$y];
echo $z;
echo $y;
$nom_hipodromo = trim(str_replace(" ", "+", $nom_hipodromo));
$url = "http://localhost/includes/programar_carreras_guardar_tvgsolo.php?hip=".$nom_hipodromo."&can=".$cantidad."&mTn=".$mTn."&pre=".$pre."&cHip=".$codHipo;
 $result = file_get_contents($url);
    
    
                    } else {?>
                    	<div align="center" style="height:29px;width:100%;padding:9px 0px 0px 0px;color:#009900">
                        	CARRERAS YA CREADAS
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