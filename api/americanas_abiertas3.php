<?php
if (!isset($_SESSION)) {
    session_start();
}
error_reporting(E_ALL);
ini_set('display_errors', '1');
//include ("file.php");

require_once('../Connections/conexionbanca.php');
echo 'V1<br>';
//get_url_contents($url)
$json1=json_decode(get_url_contents('americanas_abiertas2'),true);
//print_r($json1);
echo '<br>';
echo '<br>';
if(isset($json1['CarrerasAbiertas'])){
   // print_r($json1['CarrerasAbiertas'][0]['nom_hipodromo']);
    foreach($json1['CarrerasAbiertas'] as $fulldatos2) {
      //  print_r($fulldatos2['nom_hipodromo']);
      //  echo ' ';
      //  print_r($fulldatos2['num_carrera']);
      //  echo '<br>';
}
}

//var_dump($json1);




$horasistema=horaactual();
$fechasistema=fechaactualbd();
?>
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
  if (isset($json1['CarrerasAbiertas'])) { ?> 
  <div style="float:left; width:50%; color:#FFFFFF; background: #333; font-size:18px">HIPODROMO</div>
  <div style="float:left; width:25%; color:#FFFFFF; background: #333; font-size:18px">HORA</div>
  <div style="float:left; width:25%; color:#FFFFFF; background: #333; font-size:18px">FALTAN</div>
  <div style="float:left; width:100%"><hr/>
<table style="width:100%; font-size:14px">
 <?php
        $f=0;
        foreach($json1['CarrerasAbiertas'] as $fulldatos3) {
            
            list($h, $m, $s)=restahoraVenta(horaactual(), $fulldatos3['hor_carrera']);
         //   echo $f.' '.$h.' '.$m.''.'<br>';
            if ($h<11 && $m<59) {
                $horaactualcarrera=horaactual();
                $faltan=restahoras($horaactualcarrera, $fulldatos3['hor_carrera']); ?>
				<tr class="brillo">
				  <td align="left"><?php echo $fulldatos3['nom_hipodromo']." Carr: ...".$fulldatos3['num_carrera']; ?></td>
				  <td align="center">
<?php
$hora1=$fulldatos3['hor_carrera'];
                $nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
                $nuevahora1 = date('H:i:s', $nuevahora1);
                echo horaampm($nuevahora1); ?></td>
				  <?php $horaactualcarrera=horaactual();
                $faltan=restahoras($horaactualcarrera, $fulldatos3['hor_carrera']);
                if ($horaactualcarrera>$fulldatos3['hor_carrera']) {
                    $faltan="00:00:00";
                } ?>
				  <td align="right" style="font-size:18px"><strong><?php echo $faltan; ?></strong></td>
				</tr>
    			<?php
                $f++;
         } 
            ?>
    <?php
        } ?>
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

?>























