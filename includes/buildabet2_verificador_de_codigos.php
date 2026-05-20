<?php
// 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../Connections/conexionbanca.php');
set_time_limit(300);
$fechahoy=fechaactualbd();
echo '-.- ';
echo horaactual().'<br><br>';
list($hipodomo, $idcarrera, $tipocarrera, $cantidad, $horainicio, $pre_hipodromo)=programar_carreras_BuildABet2();





?>
<table width="100%" border="0">
	<tr>
	  <td height="32" colspan="4">&nbsp;</td>
	</tr>
	<tr style="background:#5EAEFF; color:#FFFFFF; height:30px; text-align:center">
        <td width="49%">HIPODROMO</td>
        <td width="4%" style="font-size:9px">Prefijo BuildaBet2</td>
        <td width="17%" align="center">CANTIDAD</td>
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
			<tr class="brillo" style="font-size:18px">
			  <td><?php echo $hip; ?></td>
			  <td><?php echo $pre_hipodromo[$y]; ?></td>
			  <td align="center"><?php echo $cantidad[$y]." Carreras"; ?></td>
				<td align="right">
                <?php
                if ($hip!="") {
                    $cta=0;
                    list($nom_hipodromo, $recibo, $cod_hip)=buscaHipBuild($pre_hipodromo[$y], $hip);
                    if ($recibo!=0) {
                        for ($i = 1; $i <= $cantidad[$y]; $i++) {
                            $existe=verificarCarrera($nom_hipodromo, $i, $fechahoy);
                            if ($existe==1) {
                                $cta++;
                            }
                        }
                        if ($cta!=$cantidad[$y]) {?>
							<div align="center" style="height:37px; width:100%; padding:3px 0px 3px 0px" 
                            	id="divAccion<?php echo $y; ?>">
							  <input type="submit" id="botAccion<?php echo $y; ?>" 
								class="btn btn-success"
								onClick="crearCarrera('<?php echo $cod_hip; ?>', 
								'<?php echo $cantidad[$y]; ?>',
								'<?php echo $idcarrera[$y]; ?>',
								'#divAccion<?php echo $y; ?>',
								'<?php echo $z; ?>');"
								style="height:37px;width:156px; font-size:16px; text-decoration:none;"
								value="Crear carreras" 
					title=" se crearán <?php echo $cantidad[$y]?> carreras &#13; para el hipódromo <?php echo trim($hip); ?>"/>
							</div>

                            <?php
//evento 
$pre_build=$pre_hipodromo[$y];
echo $pre_build;
$cantidad=$cantidad[$y];

$idcarrera=$idcarrera[$y];

	//$url = "http://localhost/includes/programar_carreras_guardar_buildabet2solo.php?hip=".$cod_hip."&can=".$cantidad."&id=".$idcarrera;
   // include($url);
    echo $url;
    $result = file_get_contents($url);


?>

						<?php
                        } else {?>
							<div align="center" style="height:29px;width:100%;padding:9px 0px 0px 0px;color:#009900">
								CARRERAS YA CREADAS
							</div>
						<?php
echo 'fechahoy '.$fechahoy.' cod hipodromo '.$cod_hip.' cantidad de carreras '.$cantidad[$y].' codigo builda carrera '.$idcarrera[$y].'<br>';



$query_buscarhipodromo = sprintf("/* PARSEADORES1 includes\buildabet2_verificador_de_codigos.php - QUERY 1 */ SELECT cod_pagina_rb
FROM hipodromo 
WHERE cod_hipodromo = %s 
LIMIT 1", 
GetSQLValueString($cod_hip, "int"));  
$buscarhipodromo = mysqli_query($conexionbanca, $query_buscarhipodromo) or die(mysqli_error($conexionbanca)); 
$row_buscarhipodromo = mysqli_fetch_assoc($buscarhipodromo);  
$totalRows_buscarhipodromo = mysqli_num_rows($buscarhipodromo);  


echo $row_buscarhipodromo['cod_pagina_rb'].'<br>'.$idcarrera[$y].'<br>';

$pos = strpos($row_buscarhipodromo['cod_pagina_rb'], $idcarrera[$y]);
if ($pos === false) {
    echo ' No esta bien '; 



	$id = explode("/",$idcarrera[$y]);
	$idH=$id[0];
	$idP=$id[1];





	$url2='http://bab2ghc.usofftrack.com/data/ProgramDetail.json?sdt='.$fechahoy.'&aid=&pid='.$idH.'&rid='.$idP.'&init=true';

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

echo $id.'<br>';










///*
    $updateSQL = sprintf("/* PARSEADORES1 includes\buildabet2_verificador_de_codigos.php - QUERY 2 */ UPDATE hipodromo SET 
    cod_pagina_rb=%s 
  WHERE 
  cod_hipodromo=%s",
 GetSQLValueString($id, "text"),
    GetSQLValueString($cod_hip, "int"));
$Result2 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));

			$updateSQL3 = sprintf("/* PARSEADORES1 includes\buildabet2_verificador_de_codigos.php - QUERY 3 */ UPDATE carrera SET 
  					mtp_tipo=%s 
					WHERE 
					cod_hipodromo=%s and fec_carrera=%s",
				   GetSQLValueString(1, "int"),
                   GetSQLValueString($cod_hip, "int"),
                   GetSQLValueString($fechahoy, "date"));
  			$Result23 = mysqli_query($conexionbanca, $updateSQL3) or die(mysqli_error($conexionbanca));

//*/

}else{ 
    echo ' Si esta bien ';
}






                        }
                    } else {?>
                    	<div align="center" style="height:36px; width:100%; padding:3px 0px 3px 0px">
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
            <td colspan="4">NO EXISTEN DATOS</td>
        </tr>
    	<?php
    }?>        
</table>



<?php
list($hipodomo, $idcarrera, $tipocarrera, $cantidad, $horainicio, $pre_hipodromo)=programar_carreras_BuildABet22();


?>
<table width="100%" border="0">
	<tr>
	  <td height="32" colspan="4">&nbsp;</td>
	</tr>
	<tr style="background:#5EAEFF; color:#FFFFFF; height:30px; text-align:center">
        <td width="49%">HIPODROMO</td>
        <td width="4%" style="font-size:9px">Prefijo BuildaBet2</td>
        <td width="17%" align="center">CANTIDAD</td>
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
			<tr class="brillo" style="font-size:18px">
			  <td><?php echo $hip; ?></td>
			  <td><?php echo $pre_hipodromo[$y]; ?></td>
			  <td align="center"><?php echo $cantidad[$y]." Carreras"; ?></td>
				<td align="right">
                <?php
                if ($hip!="") {
                    $cta=0;
                    list($nom_hipodromo, $recibo, $cod_hip)=buscaHipBuild($pre_hipodromo[$y], $hip);
                    if ($recibo!=0) {
                        for ($i = 1; $i <= $cantidad[$y]; $i++) {
                            $existe=verificarCarrera($nom_hipodromo, $i, $fechahoy);
                            if ($existe==1) {
                                $cta++;
                            }
                        }
                        if ($cta!=$cantidad[$y]) {?>
							<div align="center" style="height:37px; width:100%; padding:3px 0px 3px 0px" 
                            	id="divAccion<?php echo $y; ?>">
							  <input type="submit" id="botAccion<?php echo $y; ?>" 
								class="btn btn-success"
								onClick="crearCarrera('<?php echo $cod_hip; ?>', 
								'<?php echo $cantidad[$y]; ?>',
								'<?php echo $idcarrera[$y]; ?>',
								'#divAccion<?php echo $y; ?>',
								'<?php echo $z; ?>');"
								style="height:37px;width:156px; font-size:16px; text-decoration:none;"
								value="Crear carreras" 
					title=" se crearán <?php echo $cantidad[$y]?> carreras &#13; para el hipódromo <?php echo trim($hip); ?>"/>
							</div>

                            <?php
//evento 
$pre_build=$pre_hipodromo[$y];
echo $pre_build;
$cantidad=$cantidad[$y];

$idcarrera=$idcarrera[$y];

	//$url = "http://localhost/includes/programar_carreras_guardar_buildabet2solo.php?hip=".$cod_hip."&can=".$cantidad."&id=".$idcarrera;
   // include($url);
    echo $url;
    $result = file_get_contents($url);


?>

						<?php
                        } else {?>
							<div align="center" style="height:29px;width:100%;padding:9px 0px 0px 0px;color:#009900">
								CARRERAS YA CREADAS
							</div>
						<?php

echo 'fechahoy '.$fechahoy.' cod hipodromo '.$cod_hip.' cantidad de carreras '.$cantidad[$y].' codigo builda carrera '.$idcarrera[$y].'<br>';



$query_buscarhipodromo = sprintf("/* PARSEADORES1 includes\buildabet2_verificador_de_codigos.php - QUERY 4 */ SELECT cod_pagina_rb
FROM hipodromo 
WHERE cod_hipodromo = %s 
LIMIT 1", 
GetSQLValueString($cod_hip, "int"));  
$buscarhipodromo = mysqli_query($conexionbanca, $query_buscarhipodromo) or die(mysqli_error($conexionbanca)); 
$row_buscarhipodromo = mysqli_fetch_assoc($buscarhipodromo);  
$totalRows_buscarhipodromo = mysqli_num_rows($buscarhipodromo);  


echo $row_buscarhipodromo['cod_pagina_rb'].'<br>'.$idcarrera[$y].'<br>';

$pos = strpos($row_buscarhipodromo['cod_pagina_rb'], $idcarrera[$y]);
if ($pos === false) {
    echo ' No esta bien '; 




	$id = explode("/",$idcarrera[$y]);
	$idH=$id[0];
	$idP=$id[1];





	$url2='http://bab2ghc.usofftrack.com/data/ProgramDetail.json?sdt='.$fechahoy.'&aid=&pid='.$idH.'&rid='.$idP.'&init=true';

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

echo $id.'<br>';










///*
    $updateSQL = sprintf("/* PARSEADORES1 includes\buildabet2_verificador_de_codigos.php - QUERY 5 */ UPDATE hipodromo SET 
    cod_pagina_rb=%s 
  WHERE 
  cod_hipodromo=%s",
 GetSQLValueString($id, "text"),
    GetSQLValueString($cod_hip, "int"));
$Result2 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));

			$updateSQL3 = sprintf("/* PARSEADORES1 includes\buildabet2_verificador_de_codigos.php - QUERY 6 */ UPDATE carrera SET 
  					mtp_tipo=%s 
					WHERE 
					cod_hipodromo=%s and fec_carrera=%s",
				   GetSQLValueString(1, "int"),
                   GetSQLValueString($cod_hip, "int"),
                   GetSQLValueString($fechahoy, "date"));
  			$Result23 = mysqli_query($conexionbanca, $updateSQL3) or die(mysqli_error($conexionbanca));

//*/






}else{ 
    echo ' Si esta bien ';
}














                        }
                    } else {?>
                    	<div align="center" style="height:36px; width:100%; padding:3px 0px 3px 0px">
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
            <td colspan="4">NO EXISTEN DATOS</td>
        </tr>
    	<?php
    }?>        
</table>










