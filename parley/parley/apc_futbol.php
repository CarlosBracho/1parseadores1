<?php
if (!isset($_SESSION)) {
    session_start();
}?>                                  <div id="scrollj">
        <table class="table table-bordered table-sm">
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
        "/* PARSEADORES1 parley\parley\apc_futbol.php - QUERY 1 */ SELECT * FROM p2juegos 
	WHERE deportep2 = %s AND 
iniciodtp2 >= %s ORDER BY Id_p2juegosp2 
ASC
",
        GetSQLValueString("futbol", "text"),
        GetSQLValueString($datetime, "date")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
do {
    $query_Recordset21 = sprintf(
        "/* PARSEADORES1 parley\parley\apc_futbol.php - QUERY 2 */ SELECT *
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
        "/* PARSEADORES1 parley\parley\apc_futbol.php - QUERY 3 */ SELECT *
FROM p1equipos WHERE Id_p1equiposp1 = %s",
        GetSQLValueString($row_Recordset1['idequipo2p2'], "int")
    );
    $Recordset22 =mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
    $row_Recordset22 = mysqli_fetch_assoc($Recordset22);
    $totalRows_Recordset22 = mysqli_num_rows($Recordset22); ?>
            <tr class="table-warning"><td colspan="8"><div><?php  echo $row_Recordset1['competicionp2']; ?></div></td></tr><tr class="table-dark">
		
		<th><h6><small class="font-weight-bold"><?php echo strftime("%A %d ", strtotime($row_Recordset1['iniciodtp2']));
    $nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($row_Recordset1['iniciodtp2']));
    $nuevahora1 = date('Y-m-j H:i:s', $nuevahora1);
    echo date("g:ia", strtotime($nuevahora1)); ?>
    </small></h6></th><th><h6><small class="font-weight-bold">Ganar</small></h6></th>
        <th><h6><small class="font-weight-bold">A/B</small></h6></th>
        <th><h6><small class="font-weight-bold">Spread</small></h6></th>
        <th><h6><small class="font-weight-bold">Ganar 1er T.</small></h6></th>
        <th><h6><small class="font-weight-bold">A/B 1er T.</small></h6></th>
        <th><h6><small class="font-weight-bold">RL 1er T.</small></h6></th>
        </tr>
		
		
<tr class="table-light">
<td>
<div class="">
<div class="tdright"><h6 class="font-weight-bold">EMPATE - <small><?php echo $row_Recordset21['nomequipop1']; ?> VS <?php echo $row_Recordset22['nomequipop1']; ?></small></h6></div></div></td>

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 0, 'EML', $tlarray);
    if ($logro!=0) {?>
<td id="<?php echo $idequipo1 ?><?php echo $idequipo2 ?>0<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" 
class="<?php echo $idequipo1 ?>0<?php echo $idequipo2 ?>,EML, ,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,<?php  echo $logro; ?>,<?php echo
$row_Recordset21['nomequipop1']; ?> VS <?php echo $row_Recordset22['nomequipop1']; ?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,25,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo $row_Recordset21['nomequipop1']; ?> VS <?php echo $row_Recordset22['nomequipop1'];?>">
<?php echo $logro; ?></td>
<?php } else {?><td></td><?php } ?>


<td></td>

<td></td>

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 0, 'E5ML', $tlarray);
    if ($logro!=0) {?>
<td id="<?php echo $idequipo1 ?><?php echo $idequipo2 ?>0<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" 
class="<?php echo $idequipo1 ?>0<?php echo $idequipo2 ?>,E5ML, ,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,<?php  echo $logro; ?>,<?php echo
$row_Recordset21['nomequipop1'];?> VS <?php echo $row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,26,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo $row_Recordset21['nomequipop1'];?> VS <?php echo $row_Recordset22['nomequipop1'];?>">
<?php echo $logro; ?></td>
<?php } else {?><td></td><?php } ?>

<td></td>


<td></td>


</tr>


<tr></tr>

<tr class="table-light"><td>
<div class="">
<div class="tdright"><?php echo $row_Recordset21['nomequipop1']; ?></div></div></td>

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, 'ML', $tlarray);
    if ($logro!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" 
class="<?php echo $idequipo1; ?>1,ML, ,<?php echo $Id_p3logros; ?>,<?php  echo $logro; ?>,<?php echo
$row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,1,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo $row_Recordset21['nomequipop1'];?>">
<?php if ($logro>0) {
    echo "+";
}  echo $logro;?></td>
<?php } else {?><td></td><?php } ?>

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, 'A', $tlarray);
    if ($logro!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" 
class="<?php echo $idequipo1; ?>1,A,<?php echo $logroABoRL; ?>,<?php  echo $Id_p3logros; ?>,<?php  echo
$logro; ?>,<?php echo $row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,"><small class="text-warning"><b>
A.. <?php echo $logroABoRL; ?></b></small>
<?php  echo $logro; ?></td>
<?php } else {?><td></td><?php } ?>


<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, 'RL', $tlarray);
    if ($logro!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="<?php echo $idequipo1; ?>1,RL,<?php echo $logroABoRL; ?>,<?php  echo $Id_p3logros; ?>,<?php  echo
$logro; ?>,<?php echo $row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,2,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,3,,22:00:00,"><?php echo $logroABoRL; ?> <?php echo ' '.$logro; ?></td>
<?php } else {?><td></td><?php } ?>

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, '5ML', $tlarray);
    if ($logro!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" 
 class="<?php echo $idequipo1; ?>1,5ML, ,<?php  echo $Id_p3logros; ?>,<?php  echo $logro; ?>,<?php echo
$row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,9,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,9,,13:10:00,<?php echo $row_Recordset21['nomequipop1'];?>">
<?php  echo $logro; ?></td>
<?php } else {?><td></td><?php } ?>

<td></td>

<td></td>

</tr><tr>

</tr>


<tr class="table-light">
<td>
<div class="">
<div class="tdright"><?php echo $row_Recordset22['nomequipop1']; ?></div></div></td>

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, 'ML', $tlarray);
    if ($logro!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" 
class="<?php echo $idequipo2; ?>2,ML, ,<?php echo $Id_p3logros; ?>,<?php  echo $logro; ?>,<?php echo
$row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,5,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo $row_Recordset22['nomequipop1'];?>">
<?php  echo $logro; ?></td>
<?php } else {?><td></td><?php } ?>

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, 'B', $tlarray);
    if ($logro!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" 
class="<?php echo $idequipo2; ?>2,B,<?php echo $logroABoRL; ?>,<?php echo $Id_p3logros; ?>,<?php  echo
$logro; ?>,<?php echo $row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,8,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo $row_Recordset22['nomequipop1'];?>"><small class="text-warning"><b>
B <?php echo $logroABoRL; ?></b></small>
<?php  echo $logro; ?></td>
<?php } else {?><td></td><?php } ?>


<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, 'RL', $tlarray);
    if ($logro!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="<?php echo $idequipo2; ?>2,RL,<?php echo $logroABoRL; ?>,<?php echo $Id_p3logros; ?>,<?php  echo
$logro; ?>,<?php echo $row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,3,,22:00:00,"><?php echo $logroABoRL; ?> <?php echo ' '.$logro; ?></td>
<?php } else {?><td></td><?php } ?>


<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, '5ML', $tlarray);
    if ($logro!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" 
 class="<?php echo $idequipo2; ?>2,5ML, ,<?php echo $Id_p3logros; ?>,<?php echo $logro; ?>,<?php echo
$row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,13,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo $row_Recordset22['nomequipop1'];?>">
<?php  echo $logro; ?></td>
<?php } else {?><td></td><?php } ?>

<td></td>

<td></td>

</tr><tr>

</tr>
<?php
} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));

?>
		</tbody>
    </table>
</div>                    