<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$horasistema=horaactual();
$fechasistema=fechaactualbd();
$query_Carrera= sprintf("/* PARSEADORES1 new\includes\carreras_programadas1.php - QUERY 1 */ SELECT nom_hipodromo,num_carrera,hor_mtp,hor_carrera FROM carrera WHERE carrera.fec_carrera = %s AND carrera.hor_carrera >= %s AND carrera.est_carrera = 1 ORDER BY carrera.hor_mtp", GetSQLValueString($fechasistema, "date"), GetSQLValueString($horasistema, "date"));
$Carrera = mysqli_query($conexionbanca, $query_Carrera) or die(mysqli_error($conexionbanca));
$row_Carrera = mysqli_fetch_assoc($Carrera);
$totalRows_Carrera = mysqli_num_rows($Carrera);?>
<div style="background: #333; width:100%; float:left; text-align:right; padding:10px 2px 2px 2px;
  	color:#FFF; font-size:18px; text-align:center">
    	<?php  echo horaampm(horaactual()); ?>
        <hr/>
    	PENDIENTE DE LAS QUE SE CIERRAN Y ABREN 
  </div><!-- end .container -->

<?php
  if ($totalRows_Carrera >=1) { ?> 
<table BORDER=1  style="width:100%; font-size:14px">
 <?php
        $f=0;
        do {
            list($h, $m, $s)=restahoraVenta(horaactual(), $row_Carrera['hor_carrera']);
            if ($h<11 && $m<60) {
                $horaactualcarrera=horaactual();
                $faltan=restahoras($horaactualcarrera, $row_Carrera['hor_carrera']); ?>
				  <td HEIGHT=57 align="left"><strong><?php echo $row_Carrera['nom_hipodromo']."---".$row_Carrera['num_carrera']; ?></strong></td>
				  <?php $faltan=restahoras($horaactualcarrera, $row_Carrera['hor_mtp']);
                if ($horaactualcarrera>$row_Carrera['hor_mtp']) {
                    $faltan="000:00";
                } ?>
				  <td HEIGHT=57 align="left" style="font-size:18px"><strong><br><?php echo $faltan; ?></strong></td>
				</tr>
    			<?php
                $f++;
            } ?>
    <?php
        } while ($row_Carrera = mysqli_fetch_assoc($Carrera)); ?>
</table>
-las que vayan a verlas en el televisor pasarlas a opcion 3 para que no se cierre antes<br/>
-si se cierra y abre cuando le faltan menos de 3min pasarla a opcion 2<br/>
-si se cierran todas o la mayoria pasarlas a opcion 3<br/>
-si pasan ambas cosas arriba detalladas pasarlas a opcion 4<br/>
-recuerden solo pasarlas si se estan cerrando y <br/>
solo las que se estan cerrando<br/>
-cualquier cosa distinta a todas estas opciones comunicarmelas 

<?php } else { ?>
  <table width="85%" border="0" align="center">
  <tr>
    <td align="center"><?php echo "EN ESTOS MOMENTOS NO EXISTEN CARRERAS PROGRAMADAS"; ?></td>
  </tr>
</table>
</div>
 <?php  }
 if (isset($f) && $f==0) {?>
	<table width="85%" border="0" align="center">
		<tr>
			<td align="center"><?php echo "AUN NO EXISTEN CARRERAS PROGRAMADAS"; ?></td>
		</tr>
	</table>

 <?php
 }
mysqli_free_result($Carrera);
?>