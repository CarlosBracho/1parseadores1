<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$horasistema=horaactual();
$fechasistema=fechaactualbd();
$query_Carrera= sprintf(
    "/* PARSEADORES1 includes\carreras_programadas_hnac2.php - QUERY 1 */ SELECT 
	hipodromo_hnac.nom_hipodromo_hnac,
	carrera_hnac.num_carrera_hnac,
	carrera_hnac.hor_carrera_hnac 
FROM 
	carrera_hnac, 
	hipodromo_hnac
WHERE
	carrera_hnac.cod_hipodromo_hnac =  hipodromo_hnac.cod_hipodromo_hnac AND
	carrera_hnac.fec_carrera_hnac = %s AND 
	carrera_hnac.est_carrera_hnac = 1
ORDER BY 
	carrera_hnac.hor_carrera_hnac",
    GetSQLValueString($fechasistema, "date")
);
$Carrera = mysqli_query($conexionbanca, $query_Carrera) or die(mysqli_error($conexionbanca));
$row_Carrera = mysqli_fetch_assoc($Carrera);
$totalRows_Carrera = mysqli_num_rows($Carrera);?>
  <div style="background: #0E5157; width:100%; float:left; text-align:right; padding:10px 2px 2px 2px;
  	color:#FFF; font-size:18px; text-align:left">
    	<?php
$hora1=horaactual();
$nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
$nuevahora1 = date('H:i:s', $nuevahora1);
echo horaampm($nuevahora1); ?>
        <hr/>

  </div><!-- end .container -->
<?php
  if ($totalRows_Carrera >=1) { ?> 
<table style="width:100%; font-size:14px">
 <?php
        $f=0;
        do {
            list($h, $m, $s)=restahoraVenta(horaactual(), $row_Carrera['hor_carrera_hnac']);

            $horaactualcarrera=horaactual();
            $faltan=restahoras($horaactualcarrera, $row_Carrera['hor_carrera_hnac']);
            if ($faltan<"00:00:11" or $faltan=="00:00:00") {
                $link = "../sonido/sms-alert-5-daniel_simon.mp3";
                $audio = "<embed src='".$link."' AUTOSTART=TRUE WIDTH=144 HEIGHT=60>";
                echo $audio;
            }
            
            //if ($h<11 && $m<59) { ?>
				  <?php $horaactualcarrera=horaactual();
            $faltan=restahoras($horaactualcarrera, $row_Carrera['hor_carrera_hnac']);
            if ($horaactualcarrera>$row_Carrera['hor_carrera_hnac']) {
                $faltan="00:00:00";
            } ?>

				<tr class="brillo">
				  <td align="left" style="font-size:18px"><strong><?php echo $row_Carrera['nom_hipodromo_hnac']." <br>Carr: ...".$row_Carrera['num_carrera_hnac']; ?><br><?php echo $faltan; ?></strong></td>
				  				</tr>
    			<?php
                $f++;

            //}
            ?>
    <?php
        } while ($row_Carrera = mysqli_fetch_assoc($Carrera)); ?>
</table>
<?php } else { ?>
  <table width="100%" border="0" align="center">
  <tr>
    <td align="center"><?php echo "AUN NO EXISTEN CARRERAS PROGRAMADAS"; ?></td>
  </tr>
</table>
</div>
 <?php  }
 if (isset($f) && $f==0) {?>
	<table width="100%" border="0" align="center">
		<tr>
			<td align="center"><?php echo "AUN NO EXISTEN CARRERAS PROGRAMADAS"; ?></td>
		</tr>
	</table>

 <?php
 }
 // queria que me avisara cuando unja carrerano se a confirmado no e podido
 $query_Carrera2= sprintf(
     "/* PARSEADORES1 includes\carreras_programadas_hnac2.php - QUERY 2 */ SELECT 
	hipodromo_hnac.nom_hipodromo_hnac,
	carrera_hnac.num_carrera_hnac,
	carrera_hnac.hor_carrera_hnac 
FROM 
	carrera_hnac, 
	hipodromo_hnac
WHERE
	carrera_hnac.cod_hipodromo_hnac =  hipodromo_hnac.cod_hipodromo_hnac AND
	carrera_hnac.fec_carrera_hnac = %s AND 
	carrera_hnac.est_carrera_hnac = 0 AND
	carrera_hnac.est_cierre_hnac = 1 AND
	carrera_hnac.est_confirmacion_hnac = 2
ORDER BY 
	carrera_hnac.hor_carrera_hnac",
     GetSQLValueString($fechasistema, "date")
 );
$Carrera2 = mysqli_query($conexionbanca, $query_Carrera2) or die(mysqli_error($conexionbanca));
$row_Carrera2 = mysqli_fetch_assoc($Carrera2);
$totalRows_Carrera2 = mysqli_num_rows($Carrera2);
mysqli_free_result($Carrera2);
if ($totalRows_Carrera2 >=1) {
    echo "HAY CARRERA SIN RECONFIRMAR";
    echo "<br/>";
    $link = "../sonido/sms-alert-2-daniel_simon.mp3";
    $audio = "<embed src='".$link."' AUTOSTART=TRUE WIDTH=144 HEIGHT=60>";
    echo $audio;
}
?>