<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
set_time_limit(0);
//$cantCarreras, $hora, $distancia, $NumEjem, $ejeCarr, $jinCarr, $enCarre
$dia=diaactual();
$hoy=fechaactualbd();
include('simple_html_dom.php');
list($nomHip, $cantCarreras, $hora, $distancia, $NumEjem, $ejeCarr, $jinCarr, $enCarre)=pNacMaqAzul($dia);
$hip=hipodromoNac($nomHip);
?>
<table width="100%" border="0">
      <tr style="background:#333; color:#FFFFFF; height:30px; text-align:center">
        <td colspan="5">&nbsp;</td>
      </tr>
    <?php
    $y=0;
    if (isset($cantCarreras) && $cantCarreras>0 && isset($hip[1])) {?>
          <tr>
            <td height="39" colspan="5" style="font-size:24px; background:#333; color:#FFFFFF">
            	HIPÓDROMO:&nbsp;<?php echo $hip[1]; ?>
                <?php echo " | cantidad de carreras: ".$cantCarreras ?></td>
          </tr>
          <tr style="font-size:14px;color:#FFFFFF">
            <td width="16%" height="43" align="center" valign="bottom">&nbsp;</td>
            <td width="48%" align="center" valign="bottom" bgcolor="#333">&nbsp;</td>
            <td width="15%" align="center" valign="bottom" bgcolor="#333">HORA INICIO</td>
            <td width="13%" align="center" valign="bottom" bgcolor="#333">DISTANCIA</td>
            <td width="8%" align="center" valign="bottom" bgcolor="#333">INSCRITOS</td>
          </tr>
		
	  <?php
        for ($i = 1;  $i <= $cantCarreras; $i++) {
            $tit="";
            for ($x = 1;  $x <= $enCarre[$i]; $x++) {
                $tit=$tit."&#13;".$x."-".$ejeCarr[$i][$x-1]; ?>
			<?php
            } ?>
			<tr>
            	<td height="30">&nbsp;</td>
            	<td height="30">CARRERA #<?php echo $i; ?></td>
                <td align="center"><?php echo $hora[$i]; ?></td>
                <td align="right"><?php echo $distancia[$i]; ?>mts</td>
                <td align="center" title="<?php echo $tit; ?>">
					<?php echo $enCarre[$i]; ?>
                </td>
            </tr>
			<?php
        }?>
          <tr>
              <td colspan="5">&nbsp;</td>
  </tr>
          <tr>
            <td colspan="5" style="font-size:12px">
            ATENCIÓN: este proceso puede tardar un poco 
            <div align="center" style="height:38px;width:100%;border-top: 1px solid #333;padding:18px 0px 0px 0px" 
            	id="divAccion">
                
				<input type="submit" id="bverde"  name="bverde"
					class="btn badge-success" 
                    onClick='crearCarrera("<?php echo $hip[0]; ?>", "<?php echo $dia; ?>")'
					style="width:180px; height:50px; font-size:16px; background:#093; color: #000"
					value="CREAR CARRERAS" 
					title=" se crearán <?php echo $cantCarreras;?> carreras &#13; para el hipódromo <?php echo $hip[1]; ?>"/>
            </div>
            </td>
          </tr>
	<?php
        
    } else {?>
        <tr style="text-align:center; font-size:28px; height:100px">
            <td height="220" colspan="5">
            <?php
            if (!isset($hip[1]) && isset($cantCarreras) && $cantCarreras>0) {
                echo "EXITEN DATOS DE CARRERAS pero aún no ha configurado un<br/><br/>";
                echo "Hipódromo para ellas<br/><br/>";
                echo "Seleccione la opción HIPODROMO y cree o modifique uno";
            } else {
                echo"NO EXISTEN DATOS";
            }
            ?>
            </td>
      </tr>
    	<?php
    }?>        
</table>