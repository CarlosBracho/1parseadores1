<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
set_time_limit(0);
$hoy=fechaactualbd();
//return array($nHi, $dTN, $cCa, $hIn, $tip, $cod_hipodromo, $Horses);

function busHipodromo_twin($identificador)
{
    $hipodromo[0]=0;
    $hipodromo[1]=-1;
    $hipodromo[2]=-1;
    $hipodromo[3]=-1;
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 new\includes\programar_carreras_auto_twin.php - QUERY 1 */ SELECT cod_hipodromo, pro_desde, nom_hipodromo FROM hipodromo WHERE pre_twin = %s LIMIT 1", GetSQLValueString($identificador, "text"));
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    if ($totalRows_ConsultaFuncion>0) {
        $hipodromo[0]=1;
        $hipodromo[1]=$row_ConsultaFuncion['cod_hipodromo'];
        $hipodromo[2]=$row_ConsultaFuncion['pro_desde'];
        $hipodromo[3]=$row_ConsultaFuncion['nom_hipodromo'];
    }
    mysqli_free_result($ConsultaFuncion);
    return $hipodromo;
}
function twinspiresPgm()
{
    $hoy=fechaactualbd();
    $fecUrl=str_replace("-", "", $hoy);
    $urlH = 'http://www.twinspires.com/php/fw/php_BRIS_BatchAPI/2.3/Tote/CurrentRace?ip=71.212.122.168&affid=2800&debug=off&username=my_sports&password=Gltbatm&output=json';
    $str_datos = get_url_contents($urlH);
    $fulldatos = json_decode($str_datos, true);
    $nHi[0]="";
    $dTN[0]="";
    $cCa[0]="";
    $abb[0]="";
    $hIn[0]="";
    $tip[0]="";
    $cHi[0]="";
    $cod_hipodromo[0]="";
    $y=0;
    $i=0;
    $z=0;
    $Horses[0]="";
    $hipHoy=array();
    $TrackType=array();
    if (isset($fulldatos["CurrentRace"])) {
        foreach ($fulldatos["CurrentRace"] as $CurrentRace) {
            $fecCar=explode("T", $CurrentRace["PostTime"]);
            if ($fecCar[0]==$hoy) {
                $hipHoy[$i]=$CurrentRace["BrisCode"];
                $TrackType[$i]=$CurrentRace["TrackType"];
                $i++;
            }
        }
        foreach ($hipHoy as $BrisCode) {
            $urlC = 'http://www.twinspires.com/php/fw/php_BRIS_BatchAPI/2.3/Pgm/Entry?ip=71.212.122.168&affid=2800&debug=off&cDate='.$fecUrl.'&password=Gltbatm&track='.$BrisCode.'&output=json&username=my_sports&type='.$TrackType[$y];
            //echo $y." ".$urlC."<br/><br/>";
            $str_datos = get_url_contents($urlC);
            $fulldatos = json_decode($str_datos, true);
            if (isset($fulldatos["ProgramTracks"]["0"]["DisplayName"])) {
                $nHi[$z]=strtoupper($fulldatos["ProgramTracks"]["0"]["DisplayName"]);
                $dTN[$z]=strtoupper($fulldatos["ProgramTracks"]["0"]["BrisCode"]);
                $tip[$z]=strtoupper($fulldatos["ProgramTracks"]["0"]["Type"]);
        
                $n=strtoupper($fulldatos["ProgramTracks"]["0"]["BrisCode"]);
                $hi=busHipodromo_twin($n);
                if ($hi[0]!=0) {
                    $nHi[$z]=$hi[3];
                }
                $cHi[$z]=$hi[1];
                $cod_hipodromo[$z]=$hi[1];
                $hIn[$z]="01:00:00";
                $x=0;
                foreach ($fulldatos["ProgramTracks"]["0"]["Races"] as $Races) {
                    $cantEjem=count($Races["Horses"]);
                    if ($x==0) {
                        $Horses[$z]=$cantEjem;
                    } else {
                        $Horses[$z].=",".$cantEjem;
                    }
                    $x++;
                }
                $cCa[$z]=$x;
                $z++;
            }
            $y++;
        }
    }
    return array($nHi, $dTN, $cCa, $hIn, $tip, $cod_hipodromo, $Horses);
}
list($hipodomo, $pre, $cantidad, $horainicio, $tipocarrera, $cod_hipodromo, $Horses)=twinspiresPgm();
// nombre de	prefijo		cantidad	hora de		tipo
// hipodromo 	hipodromo 	carreras	inicio		carrera
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" 
	style="font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;">
	<tr>
	  <td height="32" colspan="6">&nbsp;</td>
  </tr>
	<tr style="background: #028A96; color:#FFFFFF; height:30px; text-align:center">
        <td width="32%">HIPODROMO</td>
        <td width="6%" style="font-size:10px">PREFIJO</td>
        <td width="11%" align="center">CANTIDAD</td>
        <td width="12%" align="center">HORA</td>
        <td width="13%" align="center">TIPO</td>
        <td width="25%" align="center">ACCIÓN</td>
	</tr>
    <?php
    $y=0;
    $z=count($hipodomo);
    if ($z>0 && $hipodomo[0]!="") {
        foreach ($hipodomo as $hip) {?>
			<tr class="brillo" style="font-size:16px;border-bottom:1px solid #D5D5D5">
			  <td><?php echo $hip ?></td>
			  <td align="center"><?php echo $pre[$y]; ?></td>
			  <td align="center"><?php echo $cantidad[$y]." Carreras"; ?></td>
				<td align="center"><?php echo $horainicio[$y]; ?></td>
				<td align="center"><?php echo $tipocarrera[$y]; ?></td>
				<td align="right">
                <?php
                if ($hip!="" && $cod_hipodromo[$y]>0) {
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
                            onClick="crearCarrera('<?php echo $cantidad[$y]; ?>',
                            '<?php echo $pre[$y]; ?>',
                            '<?php echo $Horses[$y]; ?>',
                            '<?php echo $cod_hipodromo[$y]; ?>',
                            '#divAccion<?php echo $y; ?>',
                            '<?php echo $z; ?>');"
                            style="padding:4px 0px 0px 0px; height:37px;width:156px; font-size:16px; text-decoration:none;background: #C6F;"
                            value="Crear carreras" 
                            title=" se crearán <?php echo $cantidad[$y]?> carreras &#13; para el hipódromo <?php echo $hip ?>"/>
                      </div>
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
                        title="Hipodromo no existe o no configurado para TWINSPIRES">
  							<i class="fa fa-cog fa-2x pull-center"></i> IR A HIPÓDROMOS
                        </a>
						</div>
					<?php
                }
                ?>  
				</td>
			</tr>
		<?php
            $y++;
        }
    } else {?>
        <tr style="text-align:center; font-size:28px; height:100px">
            <td colspan="6">NO EXISTEN DATOS</td>
        </tr>
    	<?php
    }?>        
</table>