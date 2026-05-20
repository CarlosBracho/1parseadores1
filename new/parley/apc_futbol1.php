<script>
function imprim3(imp3){
var printContents = document.getElementById('imp3').innerHTML;
        w = window.open();
        w.document.write(printContents);
        w.document.close(); // necessary for IE >= 10
        w.focus(); // necessary for IE >= 10
		w.print();
		w.close();
        return true;}
</script>
<div <?php if($scroll==1){ echo 'id=scrollj'; } ?> class="border border-success">

<center>
        <table class="table table-bordered table-sm">
            <br>
            <center>
        <button type="button" class='btn-success' onclick="javascript:imprim3(imp3);">IMPRIMIR HOJA DE LOGROS FUTBOL</button>
            </center>
            <br>

        <thead>
            <tr class="table-dark">
                <td colspan="8">
                    <h6 class="font-weight-bold">Futbol</h6>
                </td>
            </tr>
        </thead>
        <tbody>
		<?php




    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 new\parley\apc_futbol1.php - QUERY 1 */ SELECT * FROM p2juegos 
	WHERE deportep2 = %s AND
iniciodtp2 >= %s AND
iniciodtp2 <= %s ORDER BY competicionp2 
ASC
",
        GetSQLValueString("futbol", "text"),
        GetSQLValueString($datetime, "date"),
        GetSQLValueString($datetime2, "date")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
do {
    $query_Recordset21 = sprintf(
        "/* PARSEADORES1 new\parley\apc_futbol1.php - QUERY 2 */ SELECT *
FROM p1equipos
WHERE  
Id_p1equiposp1 = %s",
        GetSQLValueString($row_Recordset1['idequipo1p2'], "int")
    );
    $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
    $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
    $totalRows_Recordset21 = mysqli_num_rows($Recordset21);
    $idequipo1=$row_Recordset1['Id_p2juegosp2'];
    $idequipo2=$row_Recordset1['Id_p2juegosp2'];
    $compex=$row_Recordset1['competicionp2'];
    $query_Recordset22 = sprintf(
        "/* PARSEADORES1 new\parley\apc_futbol1.php - QUERY 3 */ SELECT *
FROM p1equipos WHERE Id_p1equiposp1 = %s",
        GetSQLValueString($row_Recordset1['idequipo2p2'], "int")
    );
    $Recordset22 =mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
    $row_Recordset22 = mysqli_fetch_assoc($Recordset22);
    $totalRows_Recordset22 = mysqli_num_rows($Recordset22); 
    
    if($emcaf==0 or $emcaf==5 or $emcaf==10 or $emcaf==15 or $emcaf==20 or $emcaf==25 or $emcaf==30 or $emcaf==35 or $emcaf==40 or $emcaf==45 or $emcaf==50 or $emcaf==55 or $emcaf==60 or $emcaf==65 or $emcaf==70){ }?>
    <tr class="table-success"><td colspan="8"><div class="equipos"><?php if(($tipo==7) && $row_Recordset1['competicionp2']==''){?>
    <a class="" style="color:white" data-toggle="modal" data-target="#exampleModal100"  onclick="crearcompeticion(2, <?php echo $row_Recordset1['Id_p2juegosp2'];?>, 5);">Crear Competicion</a>
<?php
}elseif($tipo==7){?><a class="" style="color:white" data-toggle="modal" data-target="#exampleModal100"  onclick="crearcompeticion(2, <?php echo $row_Recordset1['Id_p2juegosp2']; ?>, 5);"><?php } echo '<br>'.$row_Recordset1['competicionp2']; ?></a></div></td></tr>
                 
            
            <tr class="table-dark">
		

            <th rowspan='2'><h6><small data-toggle="modal" data-target="#exampleModal94"  onclick="actualizahora(<?php echo $row_Recordset1['Id_p2juegosp2']; ?>);">EQUIPOS<br>HORA INICIO</a>
</small></h6></th>
            <th colspan='3'><h6><small class="font-weight-bold">Juego Completo</small></h6></th>
            <th colspan='3'><h6><small class="font-weight-bold">Solo Primer Tiempo</small></h6></th>

            </tr>
            <tr class="table-dark">
            <th><h6><small class="font-weight-bold">Ganar</small></h6></th><th><h6><small class="font-weight-bold">A/B</small></h6></th><th><h6><small class="font-weight-bold">Empate</small></h6></th><th><h6><small class="font-weight-bold">Ganar Primer Tiempo</small></h6></th><th><h6><small class="font-weight-bold">A/B</small></h6></th><th><h6><small class="font-weight-bold">Empate</small></h6></th></tr>

            </tr>

    




		
<tr class="table-light">
<td>
<div class="">
<div class="tdright"><h6 class="font-weight-bold">INICIO <br><small><?php echo $row_Recordset21['nomequipop1']; ?> VS <?php echo $row_Recordset22['nomequipop1']; ?></small>
<br>
<small class="font-weight-bold"><?php echo strftime("%A %d ", strtotime($row_Recordset1['iniciodtp2']));
    $nuevahora1 = strtotime('+6 hour', strtotime($row_Recordset1['iniciodtp2']));
    $nuevahora1 = date('Y-m-j H:i:s', $nuevahora1);
    echo date("g:ia", strtotime($nuevahora1)); ?>
    </small>

</h6></div></div></td>


<td></td>

<td></td>


<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 0, 'EML', $tlarray, $tlarray1);
    if(isset($lg)){
        $tipojugada='EMPATE';
        $ver = [$lg, $lgABoRL,$Id_p3logros, $tipojugada];
        $datos=$ver[0]."||".
               $ver[1]."||".
               $ver[2]."||".
               $ver[3];
    if ($lg!=0) {?>
<td  id="<?php echo $idequipo1 ?><?php echo $idequipo2 ?>0<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#modalEdicion2" onclick="agregaformlogros('<?php echo $datos ?>')" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo1 ?>0<?php echo $idequipo2 ?>,EML, ,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,<?php  echo $lg; ?>,<?php echo
$row_Recordset21['nomequipop1']; ?> VS <?php echo $row_Recordset22['nomequipop1']; ?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,25,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo $row_Recordset21['nomequipop1']; ?> VS <?php echo $row_Recordset22['nomequipop1'];?>">
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td  id="<?php echo $idequipo1 ?><?php echo $idequipo2 ?>0<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#modalEdicion2" onclick="agregaformlogros('<?php echo $datos ?>')" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo1 ?>0<?php echo $idequipo2 ?>,EML, ,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,<?php  echo $lg; ?>,<?php echo
$row_Recordset21['nomequipop1']; ?> VS <?php echo $row_Recordset22['nomequipop1']; ?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,25,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo $row_Recordset21['nomequipop1']; ?> VS <?php echo $row_Recordset22['nomequipop1'];?>">
<?php $psi=0; if ($lg==0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td><?php }}else{$tipojugada='EML';
    $ver = [$row_Recordset1['Id_p2juegosp2'], $tipojugada, $row_Recordset1['idequipo1p2'],$row_Recordset21['nomequipop1'].' VS '.$row_Recordset22['nomequipop1'], 0];
    $datos=$ver[0]."||".
           $ver[1]."||".
           $ver[2]."||".
           $ver[3]."||".
           $ver[4];?>

<td  onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#modalNuevologros" onclick="agregaridlogros('<?php echo $datos ?>')" <?php //estoyd aqui
} ?>
>

</div>
</td>

<?php } ?>


<td></td>


<td></td>

<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 0, 'E5ML', $tlarray, $tlarray1);
    if(isset($lg)){
        $tipojugada='5EMPATE';
        $ver = [$lg, $lgABoRL,$Id_p3logros, $tipojugada];
        $datos=$ver[0]."||".
               $ver[1]."||".
               $ver[2]."||".
               $ver[3];
    if ($lg!=0) {?>
<td id="<?php echo $idequipo1 ?><?php echo $idequipo2 ?>0<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" <?php if($tipo==7){?>  data-toggle="modal" data-target="#modalEdicion2" onclick="agregaformlogros('<?php echo $datos ?>')" <?php //estoyd aqui
 } ?> 
class="<?php echo $idequipo1 ?>0<?php echo $idequipo2 ?>,E5ML, ,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,<?php  echo $lg; ?>,<?php echo
$row_Recordset21['nomequipop1'];?> VS <?php echo $row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,26,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo $row_Recordset21['nomequipop1'];?> VS <?php echo $row_Recordset22['nomequipop1'];?>">
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td id="<?php echo $idequipo1 ?><?php echo $idequipo2 ?>0<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" <?php if($tipo==7){?>  data-toggle="modal" data-target="#modalEdicion2" onclick="agregaformlogros('<?php echo $datos ?>')" <?php //estoyd aqui
 } ?> 
class="<?php echo $idequipo1 ?>0<?php echo $idequipo2 ?>,E5ML, ,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,<?php  echo $lg; ?>,<?php echo
$row_Recordset21['nomequipop1'];?> VS <?php echo $row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,26,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo $row_Recordset21['nomequipop1'];?> VS <?php echo $row_Recordset22['nomequipop1'];?>">
<?php $psi=0; if ($lg==0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td><?php }}else{$tipojugada='E5ML';
    $ver = [$row_Recordset1['Id_p2juegosp2'], $tipojugada, $row_Recordset1['idequipo1p2'],$row_Recordset21['nomequipop1'].' VS '.$row_Recordset22['nomequipop1'], 0];
    $datos=$ver[0]."||".
           $ver[1]."||".
           $ver[2]."||".
           $ver[3]."||".
           $ver[4];?>

<td  onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#modalNuevologros" onclick="agregaridlogros('<?php echo $datos ?>')" <?php //estoyd aqui
} ?>
>

</div>
</td>

<?php } ?>


</tr>


<tr></tr>

<tr class="table-light"><td>
<div class="">
<div class="tdright"><?php echo $row_Recordset21['nomequipop1']; ?></div></div></td>

<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, 'ML', $tlarray, $tlarray1);
    if(isset($lg)){
        $tipojugada='ML';
        $ver = [$lg, $lgABoRL,$Id_p3logros, $tipojugada];
        $datos=$ver[0]."||".
               $ver[1]."||".
               $ver[2]."||".
               $ver[3];
    if ($lg!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#modalEdicion2" onclick="agregaformlogros('<?php echo $datos ?>')" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo1; ?>1,ML, ,<?php echo $Id_p3logros; ?>,<?php  echo $lg; ?>,<?php echo
$row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,1,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo $row_Recordset21['nomequipop1'];?>">
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#modalEdicion2" onclick="agregaformlogros('<?php echo $datos ?>')" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo1; ?>1,ML, ,<?php echo $Id_p3logros; ?>,<?php  echo $lg; ?>,<?php echo
$row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,1,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo $row_Recordset21['nomequipop1'];?>">
<?php $psi=0; if ($lg==0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td><?php }}else{$tipojugada='ML';
    $ver = [$row_Recordset1['Id_p2juegosp2'], $tipojugada, $row_Recordset1['idequipo1p2'],$row_Recordset21['nomequipop1'], 1];
    $datos=$ver[0]."||".
           $ver[1]."||".
           $ver[2]."||".
           $ver[3]."||".
           $ver[4];?>

<td  onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#modalNuevologros" onclick="agregaridlogros('<?php echo $datos ?>')" <?php //estoyd aqui
} ?>
>

</div>
</td>

<?php } ?>

<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, 'A', $tlarray, $tlarray1);
    if(isset($lg)){
        $tipojugada='ALTA';
        $ver = [$lg, $lgABoRL,$Id_p3logros, $tipojugada];
        $datos=$ver[0]."||".
               $ver[1]."||".
               $ver[2]."||".
               $ver[3];
    if ($lg!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#modalEdicion2" onclick="agregaformlogros('<?php echo $datos ?>')" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo1; ?>1,A,<?php echo $lgABoRL; ?>,<?php  echo $Id_p3logros; ?>,<?php  echo
$lg; ?>,<?php echo $row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,"><small class="text-warning"><b>
A <?php echo $lgABoRL; ?></b></small>
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-toggle="modal" data-target="#modalEdicion2" onclick="agregaformlogros('<?php echo $datos ?>')" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo1; ?>1,A,<?php echo $lgABoRL; ?>,<?php  echo $Id_p3logros; ?>,<?php  echo
$lg; ?>,<?php echo $row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,"><small class="text-warning"><b>
A <?php echo $lgABoRL; ?></b></small>
<?php $psi=0; if ($lg==0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td><?php }}else{$tipojugada='A';
    $ver = [$row_Recordset1['Id_p2juegosp2'], $tipojugada, $row_Recordset1['idequipo1p2'],$row_Recordset21['nomequipop1'], 1];
    $datos=$ver[0]."||".
           $ver[1]."||".
           $ver[2]."||".
           $ver[3]."||".
           $ver[4];?>

    <td  onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#modalNuevologros" onclick="agregaridlogros('<?php echo $datos ?>')" <?php //estoyd aqui
} ?>
>

</div>
</td>

<?php } ?>


<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, 'RL', $tlarray, $tlarray1);
    if(isset($lg)){
        $tipojugada='RUN LANE';
        $ver = [$lg, $lgABoRL,$Id_p3logros, $tipojugada];
        $datos=$ver[0]."||".
               $ver[1]."||".
               $ver[2]."||".
               $ver[3];
    if ($lg!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#modalEdicion2" onclick="agregaformlogros('<?php echo $datos ?>')" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo1; ?>1,RL,<?php echo $lgABoRL; ?>,<?php  echo $Id_p3logros; ?>,<?php  echo
$lg; ?>,<?php echo $row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,2,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,3,,22:00:00,"><?php echo $lgABoRL; ?> <?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#modalEdicion2" onclick="agregaformlogros('<?php echo $datos ?>')" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo1; ?>1,RL,<?php echo $lgABoRL; ?>,<?php  echo $Id_p3logros; ?>,<?php  echo
$lg; ?>,<?php echo $row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,2,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,3,,22:00:00,"><?php echo $lgABoRL; ?> <?php $psi=0; if ($lg==0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td><?php }}else{$tipojugada='RL';
    $ver = [$row_Recordset1['Id_p2juegosp2'], $tipojugada, $row_Recordset1['idequipo1p2'],$row_Recordset21['nomequipop1'], 1];
    $datos=$ver[0]."||".
           $ver[1]."||".
           $ver[2]."||".
           $ver[3]."||".
           $ver[4];?>

    <td  onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#modalNuevologros" onclick="agregaridlogros('<?php echo $datos ?>')" <?php //estoyd aqui
} ?>
>

</div>
</td>

<?php } ?>

<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, '5ML', $tlarray, $tlarray1);
    if(isset($lg)){
        $tipojugada='ML';
        $ver = [$lg, $lgABoRL,$Id_p3logros, $tipojugada];
        $datos=$ver[0]."||".
               $ver[1]."||".
               $ver[2]."||".
               $ver[3];
    if ($lg!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#modalEdicion2" onclick="agregaformlogros('<?php echo $datos ?>')" <?php //estoyd aqui
 } ?>  
 class="<?php echo $idequipo1; ?>1,5ML, ,<?php  echo $Id_p3logros; ?>,<?php  echo $lg; ?>,<?php echo
$row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,9,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,9,,13:10:00,<?php echo $row_Recordset21['nomequipop1'];?>">
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#modalEdicion2" onclick="agregaformlogros('<?php echo $datos ?>')" <?php //estoyd aqui
 } ?>  
 class="<?php echo $idequipo1; ?>1,5ML, ,<?php  echo $Id_p3logros; ?>,<?php  echo $lg; ?>,<?php echo
$row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,9,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,9,,13:10:00,<?php echo $row_Recordset21['nomequipop1'];?>">
<?php $psi=0; if ($lg==0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td><?php }}else{$tipojugada='5ML';
    $ver = [$row_Recordset1['Id_p2juegosp2'], $tipojugada, $row_Recordset1['idequipo1p2'],$row_Recordset21['nomequipop1'], 1];
    $datos=$ver[0]."||".
           $ver[1]."||".
           $ver[2]."||".
           $ver[3]."||".
           $ver[4];?>

<td  onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#modalNuevologros" onclick="agregaridlogros('<?php echo $datos ?>')" <?php //estoyd aqui
} ?>
>

</div>
</td>

<?php } ?>

<td></td>

<td></td>

</tr><tr>

</tr>


<tr class="table-light">
<td>
<div class="">
<div class="tdright"><?php echo $row_Recordset22['nomequipop1']; ?></div></div></td>

<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, 'ML', $tlarray, $tlarray1);
    if(isset($lg)){
        $tipojugada='ML';
        $ver = [$lg, $lgABoRL,$Id_p3logros, $tipojugada];
        $datos=$ver[0]."||".
               $ver[1]."||".
               $ver[2]."||".
               $ver[3];
    if ($lg!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#modalEdicion2" onclick="agregaformlogros('<?php echo $datos ?>')" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo2; ?>2,ML, ,<?php echo $Id_p3logros; ?>,<?php  echo $lg; ?>,<?php echo
$row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,5,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo $row_Recordset22['nomequipop1'];?>">
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#modalEdicion2" onclick="agregaformlogros('<?php echo $datos ?>')" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo2; ?>2,ML, ,<?php echo $Id_p3logros; ?>,<?php  echo $lg; ?>,<?php echo
$row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,5,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo $row_Recordset22['nomequipop1'];?>">
<?php $psi=0; if ($lg==0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td><?php }}else{$tipojugada='ML';
    $ver = [$row_Recordset1['Id_p2juegosp2'], $tipojugada, $row_Recordset1['idequipo2p2'],$row_Recordset22['nomequipop1'], 2];
    $datos=$ver[0]."||".
           $ver[1]."||".
           $ver[2]."||".
           $ver[3]."||".
           $ver[4];?>

<td  onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#modalNuevologros" onclick="agregaridlogros('<?php echo $datos ?>')" <?php //estoyd aqui
} ?>
>

</div>
</td>

<?php } ?>

<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, 'B', $tlarray, $tlarray1);
    if(isset($lg)){
        $tipojugada='BAJA';
        $ver = [$lg, $lgABoRL,$Id_p3logros, $tipojugada];
        $datos=$ver[0]."||".
               $ver[1]."||".
               $ver[2]."||".
               $ver[3];
    if ($lg!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" <?php if($tipo==7){?>  data-toggle="modal" data-target="#modalEdicion2" onclick="agregaformlogros('<?php echo $datos ?>')" <?php //estoyd aqui
 } ?> 
class="<?php echo $idequipo2; ?>2,B,<?php echo $lgABoRL; ?>,<?php echo $Id_p3logros; ?>,<?php  echo
$lg; ?>,<?php echo $row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,8,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo $row_Recordset22['nomequipop1'];?>"><small class="text-warning"><b>
B <?php echo $lgABoRL; ?></b></small>
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" <?php if($tipo==7){?>  data-toggle="modal" data-target="#modalEdicion2" onclick="agregaformlogros('<?php echo $datos ?>')" <?php //estoyd aqui
 } ?> 
class="<?php echo $idequipo2; ?>2,B,<?php echo $lgABoRL; ?>,<?php echo $Id_p3logros; ?>,<?php  echo
$lg; ?>,<?php echo $row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,8,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo $row_Recordset22['nomequipop1'];?>"><small class="text-warning"><b>
B <?php echo $lgABoRL; ?></b></small>
<?php $psi=0; if ($lg==0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td><?php }}else{$tipojugada='B';
    $ver = [$row_Recordset1['Id_p2juegosp2'], $tipojugada, $row_Recordset1['idequipo2p2'],$row_Recordset22['nomequipop1'], 2];
    $datos=$ver[0]."||".
           $ver[1]."||".
           $ver[2]."||".
           $ver[3]."||".
           $ver[4];?>

<td  onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#modalNuevologros" onclick="agregaridlogros('<?php echo $datos ?>')" <?php //estoyd aqui
} ?>
>

</div>
</td>

<?php } ?>


<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, 'RL', $tlarray, $tlarray1);
    if(isset($lg)){
        $tipojugada='RUN LANE';
        $ver = [$lg, $lgABoRL,$Id_p3logros, $tipojugada];
        $datos=$ver[0]."||".
               $ver[1]."||".
               $ver[2]."||".
               $ver[3];
    if ($lg!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-toggle="modal" data-target="#modalEdicion2" onclick="agregaformlogros('<?php echo $datos ?>')" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo2; ?>2,RL,<?php echo $lgABoRL; ?>,<?php echo $Id_p3logros; ?>,<?php  echo
$lg; ?>,<?php echo $row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,3,,22:00:00,"><?php echo $lgABoRL; ?> <?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#modalEdicion2" onclick="agregaformlogros('<?php echo $datos ?>')" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo2; ?>2,RL,<?php echo $lgABoRL; ?>,<?php echo $Id_p3logros; ?>,<?php  echo
$lg; ?>,<?php echo $row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,3,,22:00:00,"><?php echo $lgABoRL; ?> <?php $psi=0; if ($lg==0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td><?php }}else{$tipojugada='RL';
    $ver = [$row_Recordset1['Id_p2juegosp2'], $tipojugada, $row_Recordset1['idequipo2p2'],$row_Recordset22['nomequipop1'], 2];
    $datos=$ver[0]."||".
           $ver[1]."||".
           $ver[2]."||".
           $ver[3]."||".
           $ver[4];?>

    <td  onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#modalNuevologros" onclick="agregaridlogros('<?php echo $datos ?>')" <?php //estoyd aqui
} ?>
>

</div>
</td>

<?php } ?>


<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, '5ML', $tlarray, $tlarray1);
    if(isset($lg)){
        $tipojugada='5ML';
        $ver = [$lg, $lgABoRL,$Id_p3logros, $tipojugada];
        $datos=$ver[0]."||".
               $ver[1]."||".
               $ver[2]."||".
               $ver[3];
    if ($lg!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#modalEdicion2" onclick="agregaformlogros('<?php echo $datos ?>')" <?php //estoyd aqui
 } ?>  
 class="<?php echo $idequipo2; ?>2,5ML, ,<?php echo $Id_p3logros; ?>,<?php echo $lg; ?>,<?php echo
$row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,13,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo $row_Recordset22['nomequipop1'];?>">
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#modalEdicion2" onclick="agregaformlogros('<?php echo $datos ?>')" <?php //estoyd aqui
 } ?>  
 class="<?php echo $idequipo2; ?>2,5ML, ,<?php echo $Id_p3logros; ?>,<?php echo $lg; ?>,<?php echo
$row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,13,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo $row_Recordset22['nomequipop1'];?>">
<?php $psi=0; if ($lg==0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td><?php } }else{$tipojugada='5ML';
    $ver = [$row_Recordset1['Id_p2juegosp2'], $tipojugada, $row_Recordset1['idequipo2p2'],$row_Recordset22['nomequipop1'], 2];
    $datos=$ver[0]."||".
           $ver[1]."||".
           $ver[2]."||".
           $ver[3]."||".
           $ver[4];?>

<td  onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#modalNuevologros" onclick="agregaridlogros('<?php echo $datos ?>')" <?php //estoyd aqui
} ?>
>

</div>
</td>

<?php } ?>


<td></td>

<td></td>

</tr><tr>

</tr>
<?php
$emcaf++;
} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));

?>
		</tbody>
    </table>
</div>   


</center>