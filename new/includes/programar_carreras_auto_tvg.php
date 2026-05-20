<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
set_time_limit(0);
$hoy=fechaactualbd();
list($hipodomo, $mTn, $pre, $cantidad, $horainicio, $tipocarrera, $codHipo, $cod_hipodromo)=programar_carreras_tvg();
?>
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