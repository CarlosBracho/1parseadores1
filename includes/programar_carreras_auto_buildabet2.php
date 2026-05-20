<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
set_time_limit(0);
$hoy=fechaactualbd();
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
                            $existe=verificarCarrera($nom_hipodromo, $i, $hoy);
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
                        } else {?>
							<div align="center" style="height:29px;width:100%;padding:9px 0px 0px 0px;color:#009900">
								CARRERAS YA CREADAS
							</div>
						<?php
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