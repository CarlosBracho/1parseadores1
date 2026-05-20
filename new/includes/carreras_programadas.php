<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$horasistema=horaactual();
$fechasistema=fechaactualbd();
$query_Carrera= sprintf("/* PARSEADORES1 new\includes\carreras_programadas.php - QUERY 1 */ SELECT nom_hipodromo,num_carrera,hor_mtp,hor_carrera FROM carrera WHERE carrera.fec_carrera = %s AND carrera.hor_carrera >= %s AND carrera.est_carrera = 1 ORDER BY carrera.hor_mtp", GetSQLValueString($fechasistema, "date"), GetSQLValueString($horasistema, "date"));
$Carrera = mysqli_query($conexionbanca, $query_Carrera) or die(mysqli_error($conexionbanca));
$row_Carrera = mysqli_fetch_assoc($Carrera);
$totalRows_Carrera = mysqli_num_rows($Carrera);?>
  <div style="background: #333; width:100%; float:left; text-align:right; padding:10px 2px 2px 2px;
  	color:#FFF; font-size:28px; text-align:center">
    	<?php
$hora1=horaactual();
$nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
$nuevahora1 = date('H:i:s', $nuevahora1);
echo horaampm($nuevahora1); ?>
        <hr/>
    	CARRERAS PROGRAMADAS
  </div><!-- end .container -->
  <div style="float:left; width:100%; text-align: right;font-size:11px">|</div>
<?php
  if ($totalRows_Carrera >=1) { ?> 
  <div style="float:left; width:50%; color:#FFFFFF; background: #333; font-size:18px">HIPODROMO</div>
  <div style="float:left; width:25%; color:#FFFFFF; background: #333; font-size:18px">HORA</div>
  <div style="float:left; width:25%; color:#FFFFFF; background: #333; font-size:18px">FALTAN</div>
  <div style="float:left; width:100%"><hr/>
<table style="width:100%; font-size:14px">
 <?php
        $f=0;
        do {
            list($h, $m, $s)=restahoraVenta(horaactual(), $row_Carrera['hor_carrera']);
            if ($h<11 && $m<59) {
                $horaactualcarrera=horaactual();
                $faltan=restahoras($horaactualcarrera, $row_Carrera['hor_carrera']); ?>
				<tr class="brillo">
				  <td align="left"><?php echo $row_Carrera['nom_hipodromo']." Carr: ...".$row_Carrera['num_carrera']; ?></td>
				  <td align="center">
<?php
$hora1=$row_Carrera['hor_mtp'];
                $nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
                $nuevahora1 = date('H:i:s', $nuevahora1);
                echo horaampm($nuevahora1); ?></td>
				  <?php $horaactualcarrera=horaactual();
                $faltan=restahoras($horaactualcarrera, $row_Carrera['hor_mtp']);
                if ($horaactualcarrera>$row_Carrera['hor_mtp']) {
                    $faltan="00:00:00";
                } ?>
				  <td align="right" style="font-size:18px"><strong><?php echo $faltan; ?></strong></td>
				</tr>
    			<?php
                $f++;
            } ?>
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
mysqli_free_result($Carrera);
?>