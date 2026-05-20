<?php
if (!isset($_SESSION)) {
    session_start();
}?>
<div id="scrollj">
    <table class="table table-bordered table-sm">
        <tbody>
            <tr class="table-danger"><td colspan="12"><div class="equipos">MLB</div></td></tr>
			
			          <?php

    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 new\parley\apc_beisbol_mobile.php - QUERY 1 */ SELECT * FROM p2juegos 
	WHERE deportep2 = %s AND
iniciodtp2 > %s ORDER BY iniciodtp2 
ASC
",
        GetSQLValueString("beisbol", "text"),
        GetSQLValueString($datetime, "date")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);

do {
    $query_Recordset21 = sprintf(
        "/* PARSEADORES1 new\parley\apc_beisbol_mobile.php - QUERY 2 */ SELECT *
FROM p1equipos
WHERE  

Id_p1equiposp1 = %s",
        GetSQLValueString($row_Recordset1['idequipo1p2'], "int")
    );
    $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
    $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
    $totalRows_Recordset21 = mysqli_num_rows($Recordset21);
    $idequipo1=$row_Recordset1['Id_p2juegosp2'];
    $idequipo2=$row_Recordset1['Id_p2juegosp2']; ?>
			
			<tr class="table-dark">
            
			
			
            <th><h6><small class="font-weight-bold"><?php echo strftime("%A %d", strtotime($row_Recordset1['iniciodtp2'])); ?> 
			</br>
<?php $nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($row_Recordset1['iniciodtp2']));
    $nuevahora1 = date('Y-m-j H:i:s', $nuevahora1);
    echo date("g:ia", strtotime($nuevahora1)); ?>
</small></h6></th>
            <th><h6><small class="font-weight-bold">Ganar</small></h6></th>
            <th><h6><small class="font-weight-bold">RL</small></h6></th>
            <th><h6><small class="font-weight-bold">SRL</small></h6></th>
            <th><h6><small class="font-weight-bold">A/B</small></h6></th>
            <th><h6><small class="font-weight-bold">½j Ganar</small></h6></th>
            <th><h6><small class="font-weight-bold">½j RL</small></h6></th>
            <th><h6><small class="font-weight-bold">½j A/B</small></h6></th>
            <th><h6><small class="font-weight-bold">S/N</small></h6></th>
            <th><h6><small class="font-weight-bold">AP</small></h6></th>
            <th><h6><small class="font-weight-bold">HCE</small></h6></th>
            </tr><tr class="table-light">
			
			

						<td><img width="22px" height="22px" class="img-fluid" 
			src=""> <?php echo $row_Recordset21['nomequipop1']; ?><p>
			<small class="text-danger font-weight-bold"><?php echo $row_Recordset1['pichee1p2'] ?> </small></p></td>
			
			

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, 'ML', $tlarray);
    if ($logro!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
class="<?php echo $idequipo1; ?>1,ML, ,<?php  echo $Id_p3logros; ?>,<?php  echo $logro; ?>,<?php echo $row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,1,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,20:05:00,<?php echo $row_Recordset21['nomequipop1'];?>"><?php if ($logro>0) {
        echo "+";
    }  echo $logro; ?></td>
<?php } else {?><td></td><?php } ?>

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, 'RL', $tlarray);
    if ($logro!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
class="<?php echo $idequipo1; ?>1,RL,<?php echo $logroABoRL; ?>,<?php  echo $Id_p3logros; ?>,<?php  echo $logro; ?>,<?php echo $row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,2,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,20:05:00,<?php echo $row_Recordset21['nomequipop1'];?>">
<small class="text-muted"><b><?php echo $logroABoRL; ?></b></small> <?php if ($logro>0) {
        echo "+";
    }  echo $logro; ?></td>
<?php } else {?><td></td><?php } ?>

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, 'SR', $tlarray);
    if ($logro!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
class="<?php echo $idequipo1; ?>1,SR,<?php echo $logroABoRL; ?>,<?php  echo $Id_p3logros; ?>,<?php  echo $logro; ?>,<?php echo $row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,3,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,20:05:00,<?php echo $row_Recordset21['nomequipop1'];?>">
<small class="text-danger"><b><?php echo $logroABoRL; ?></b></small> <?php if ($logro>0) {
        echo "+";
    }  echo $logro; ?></td>
<?php } else {?><td></td><?php } ?>

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, 'A', $tlarray);
    if ($logro!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
class="<?php echo $idequipo1; ?>1,A,<?php echo $logroABoRL; ?>,<?php  echo $Id_p3logros; ?>,<?php  echo $logro; ?>,<?php echo $row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,20:05:00,<?php echo $row_Recordset21['nomequipop1'];?>">
<small class="text-danger"><b>A <?php echo $logroABoRL; ?></b></small> <?php if ($logro>0) {
        echo "+";
    }  echo $logro; ?></td>
<?php } else {?><td></td><?php } ?>

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, '5ML', $tlarray);
    if ($logro!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
class="<?php echo $idequipo1; ?>1,5ML, ,<?php  echo $Id_p3logros; ?>,<?php  echo $logro; ?>,<?php echo $row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,9,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,20:05:00,<?php echo $row_Recordset21['nomequipop1'];?>">
<?php if ($logro>0) {
        echo "+";
    }  echo $logro; ?></td>
<?php } else {?><td></td><?php } ?>

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, '5RL', $tlarray);
    if ($logro!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
class="<?php echo $idequipo1; ?>1,5RL,<?php echo $logroABoRL; ?>,<?php  echo $Id_p3logros; ?>,<?php  echo $logro; ?>,<?php echo $row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,10,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,20:05:00,<?php echo $row_Recordset21['nomequipop1'];?>">
<small class="text-danger"><b><?php echo $logroABoRL; ?></b></small> <?php if ($logro>0) {
        echo "+";
    }  echo $logro; ?></td>
<?php } else {?><td></td><?php } ?>

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, '5A', $tlarray);
    if ($logro!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
class="<?php echo $idequipo1; ?>1,5A,<?php echo $logroABoRL; ?>,<?php  echo $Id_p3logros; ?>,<?php  echo $logro; ?>,<?php echo $row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,12,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,20:05:00,<?php echo $row_Recordset21['nomequipop1'];?>">
<small class="text-danger"><b>A <?php echo $logroABoRL; ?></b></small> <?php if ($logro>0) {
        echo "+";
    }  echo $logro; ?></td>
<?php } else {?><td></td><?php } ?>

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, 'SI', $tlarray);
    if ($logro!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
class="<?php echo $idequipo1; ?>1,SI, ,<?php  echo $Id_p3logros; ?>,<?php  echo $logro; ?>,<?php echo $row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,17,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,20:05:00,<?php echo $row_Recordset21['nomequipop1'];?>">
<small class="text-danger"><b>SI</b></small> <?php if ($logro>0) {
        echo "+";
    }  echo $logro; ?></td>
<?php } else {?><td></td><?php } ?>

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, 'AP', $tlarray);
    if ($logro!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
class="<?php echo $idequipo1; ?>1,AP, ,<?php  echo $Id_p3logros; ?>,<?php  echo $logro; ?>,<?php echo $row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,19,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,20:05:00,<?php echo $row_Recordset21['nomequipop1'];?>"><?php if ($logro>0) {
        echo "+";
    }  echo $logro; ?>
</td>
<?php } else {?><td></td><?php } ?>

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, 'AG', $tlarray);
    if ($logro!=0) {?>
<td style="display:" id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
class="<?php echo $idequipo1; ?>1,AG,<?php echo $logroABoRL; ?>,<?php  echo $Id_p3logros; ?>,<?php  echo $logro; ?>,<?php echo $row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,20,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,20:05:00,<?php echo $row_Recordset21['nomequipop1'];?>">
<small class="text-danger"><b>A <?php echo $logroABoRL; ?></b></small> <br><?php if ($logro>0) {
        echo "+";
    }  echo $logro; ?></td></tr><tr></tr><tr class="table-light">
<?php } else {?><td></td><?php } ?>
</tr>
<?php
$query_Recordset22 = sprintf(
        "/* PARSEADORES1 new\parley\apc_beisbol_mobile.php - QUERY 3 */ SELECT *
FROM p1equipos WHERE Id_p1equiposp1 = %s",
        GetSQLValueString($row_Recordset1['idequipo2p2'], "int")
    );
    $Recordset22 =mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
    $row_Recordset22 = mysqli_fetch_assoc($Recordset22);
    $totalRows_Recordset22 = mysqli_num_rows($Recordset22); ?>
			
			<td><img width="22px" height="22px" class="img-fluid" src="">
			<?php echo $row_Recordset22['nomequipop1']; ?><p><small class="text-danger font-weight-bold"><?php echo $row_Recordset1['pichee2p2'] ?> </small></p></td>
			
			
			
<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, 'ML', $tlarray);
    if ($logro!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
class="<?php echo $idequipo2; ?>2,ML, ,<?php  echo $Id_p3logros; ?>,<?php  echo $logro; ?>,<?php echo $row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,5,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,20:05:00,<?php echo $row_Recordset22['nomequipop1'];?>"><?php if ($logro>0) {
        echo "+";
    }  echo $logro; ?></td>
<?php } else {?><td></td><?php } ?>

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, 'RL', $tlarray);
    if ($logro!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
class="<?php echo $idequipo2; ?>2,RL,<?php echo $logroABoRL; ?>,<?php  echo $Id_p3logros; ?>,<?php  echo $logro; ?>,<?php echo $row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,20:05:00,<?php echo $row_Recordset22['nomequipop1'];?>">
<small class="text-muted"><b><?php echo $logroABoRL; ?></b></small> <?php if ($logro>0) {
        echo "+";
    }  echo $logro; ?></td>
<?php } else {?><td></td><?php } ?>

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, 'SR', $tlarray);
    if ($logro!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
class="<?php echo $idequipo2; ?>2,SR,<?php echo $logroABoRL; ?>,<?php  echo $Id_p3logros; ?>,<?php  echo $logro; ?>,<?php echo $row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,7,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,20:05:00,<?php echo $row_Recordset22['nomequipop1'];?>"><small 
class="text-danger"><b><?php echo $logroABoRL; ?></b></small> <?php if ($logro>0) {
        echo "+";
    }  echo $logro; ?></td>
<?php } else {?><td></td><?php } ?>

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, 'B', $tlarray);
    if ($logro!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
class="<?php echo $idequipo2; ?>2,B,<?php echo $logroABoRL; ?>,<?php  echo $Id_p3logros; ?>,<?php  echo $logro; ?>,<?php echo $row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,8,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,20:05:00,<?php echo $row_Recordset22['nomequipop1'];?>">
<small class="text-danger"><b>B <?php echo $logroABoRL; ?></b></small> <?php if ($logro>0) {
        echo "+";
    }  echo $logro; ?></td>
<?php } else {?><td></td><?php } ?>

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, '5ML', $tlarray);
    if ($logro!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
class="<?php echo $idequipo2; ?>2,5ML, ,<?php  echo $Id_p3logros; ?>,<?php  echo $logro; ?>,<?php echo $row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,13,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,20:05:00,<?php echo $row_Recordset22['nomequipop1'];?>"><?php if ($logro>0) {
        echo "+";
    }  echo $logro; ?></td>
<?php } else {?><td></td><?php } ?>

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, '5RL', $tlarray);
    if ($logro!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
class="<?php echo $idequipo2; ?>2,5RL,<?php echo $logroABoRL; ?>,<?php  echo $Id_p3logros; ?>,<?php  echo $logro; ?>,<?php echo $row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,14,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,20:05:00,<?php echo $row_Recordset22['nomequipop1'];?>">
<small class="text-danger"><b><?php echo $logroABoRL; ?></b></small> <?php if ($logro>0) {
        echo "+";
    }  echo $logro; ?></td>
<?php } else {?><td></td><?php } ?>

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, '5B', $tlarray);
    if ($logro!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
class="<?php echo $idequipo2; ?>2,5B,<?php echo $logroABoRL; ?>,<?php  echo $Id_p3logros; ?>,<?php  echo $logro; ?>,<?php echo $row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,16,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,20:05:00,<?php echo $row_Recordset22['nomequipop1'];?>">
<small class="text-danger"><b>B <?php echo $logroABoRL; ?></b></small> <?php if ($logro>0) {
        echo "+";
    }  echo $logro; ?></td>
<?php } else {?><td></td><?php } ?>

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, 'NO', $tlarray);
    if ($logro!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
class="<?php echo $idequipo2; ?>2,NO, ,<?php  echo $Id_p3logros; ?>,<?php  echo $logro; ?>,<?php echo $row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,21,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,20:05:00,<?php echo $row_Recordset22['nomequipop1'];?>">
<small class="text-danger"><b>NO</b></small> <?php if ($logro>0) {
        echo "+";
    }  echo $logro; ?></td>
<?php } else {?><td></td><?php } ?>

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, 'AP', $tlarray);
    if ($logro!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
class="<?php echo $idequipo2; ?>2,AP, ,<?php  echo $Id_p3logros; ?>,<?php  echo $logro; ?>,<?php echo $row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,23,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,20:05:00,<?php echo $row_Recordset22['nomequipop1'];?>"><?php if ($logro>0) {
        echo "+";
    }  echo $logro; ?></td>
<?php } else {?><td></td><?php } ?>

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, 'BG', $tlarray);
    if ($logro!=0) {?>
<td style="display:" id="<?php echo $idequipo2; ?>2_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
class="<?php echo $idequipo2; ?>2,BG,<?php echo $logroABoRL; ?>,<?php  echo $Id_p3logros; ?>,<?php  echo $logro; ?>,<?php echo $row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,24,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,20:05:00,<?php echo $row_Recordset22['nomequipop1'];?>">
<small class="text-danger"><b>B <?php echo $logroABoRL; ?></b></small> <br><?php if ($logro>0) {
        echo "+";
    }  echo $logro; ?></td>
<?php } else {?><td></td><?php } ?>
</tr><tr></tr>
          <?php
} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));

?>
    </table>