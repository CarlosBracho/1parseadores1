<?php
if (!isset($_SESSION)) {
    session_start();
}
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 new\parley\apc_wnba_mobile.php - QUERY 1 */ SELECT * FROM p2juegos 
WHERE competicionp2 = %s  AND
 deportep2 = %s  AND
iniciodtp2 >= %s ORDER BY iniciodtp2 
ASC
",
    GetSQLValueString("WNBA", "text"),
    GetSQLValueString("baloncesto", "text"),
    GetSQLValueString($datetime, "date")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
if ($totalRows_Recordset1>0) {
    ?>
<div class="scrollj_mobil">
<div id="accordion">
<div class="card"> <div class="card-header-mobil" id="headingOneNBA">
<h5 class="mb-0">
<button style="color:#000000;font-weight: 900;" class="btn btn-link" data-toggle="collapse" data-target="#collapseOneWNBA" aria-expanded="true" aria-controls="collapseOneWNBA">
<small>WNBA </small>
</button>
</h5>
</div>
<div id="collapseOneWNBA" class="collapse" aria-labelledby="headingOneWNBA" data-parent="#accordion">
<div class="card-body">
<table class="table table-bordered table-sm">
<thead>
</thead>
<tbody>
<?php
do {
        $query_Recordset21 = sprintf(
            "/* PARSEADORES1 new\parley\apc_wnba_mobile.php - QUERY 2 */ SELECT *
FROM p1equipos WHERE Id_p1equiposp1 = %s",
            GetSQLValueString($row_Recordset1['idequipo1p2'], "int")
        );
        $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
        $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
        $totalRows_Recordset21 = mysqli_num_rows($Recordset21);
        $idequipo1=$row_Recordset1['Id_p2juegosp2'];
        $idequipo2=$row_Recordset1['Id_p2juegosp2'];
        $compex=$row_Recordset1['competicionp2'];

        $query_Recordset22 = sprintf(
            "/* PARSEADORES1 new\parley\apc_wnba_mobile.php - QUERY 3 */ SELECT *
FROM p1equipos WHERE Id_p1equiposp1 = %s",
            GetSQLValueString($row_Recordset1['idequipo2p2'], "int")
        );
        $Recordset22 =mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
        $row_Recordset22 = mysqli_fetch_assoc($Recordset22);
        $totalRows_Recordset22 = mysqli_num_rows($Recordset22); ?>

<tr class="tr-border-mobil">
<td colspan="6"><div class="text-center">
<span class="font-equipo"> 
<b>(V)</b><?php echo $row_Recordset21['nomequipop1']; ?></span> <small class="font-weight-bold">vs</small>  <span class="font-equipo"> 
<b>(H)</b><?php echo $row_Recordset22['nomequipop1']; ?></span><br> 
<span class="badge badge-primary"><?php echo strftime("%A %d ", strtotime($row_Recordset1['iniciodtp2']));
        $nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($row_Recordset1['iniciodtp2']));
        $nuevahora1 = date('Y-m-j H:i:s', $nuevahora1);
        echo date("g:ia", strtotime($nuevahora1)); ?></span> </div></td></tr>
<tr class="table-dark"></tr>
<tr class="table-dark"><th><small class="font-weight-bold">Ganar</small></th><th><small class="font-weight-bold">A/B</small></th><th><small class="font-weight-bold">Spread</small></th><th><small class="font-weight-bold">Ganar MJ</small></th><th><small class="font-weight-bold">A/B MJ</small></th><th><small class="font-weight-bold">Spread MJ</small></th></tr>
<tr class="table-light">

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, 'ML', $tlarray, $tlarray1);
        if ($logro!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
class="<?php echo $idequipo1; ?>1,ML, ,<?php echo $Id_p3logros; ?>,<?php  echo $logro; ?>,<?php echo
$row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,1,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo $row_Recordset21['nomequipop1'];?>">
<div class="text-center"><span class="badge badge-pill badge-primary">Ganar <small class="font-weight-bold">(V)</small></span><small class="font-weight-bold"> <br><b><?php  echo $logro; ?></b></small></div></td>
<?php } else {?><td></td><?php } ?>

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, 'A', $tlarray, $tlarray1);
        if ($logro!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
class="<?php echo $idequipo1; ?>1,A,<?php echo $logroABoRL; ?>,<?php  echo $Id_p3logros; ?>,<?php  echo
$logro; ?>,<?php echo $row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,">
<div class="text-center"><small class="text-primary"><b>A <?php echo $logroABoRL; ?></b></small> <b><?php if ($logro>0) {
    echo "+";
}  echo $logro; ?><b></b></b></div></td>
<?php } else {?><td></td><?php } ?>

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, 'RL', $tlarray, $tlarray1);
        if ($logro!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
class="<?php echo $idequipo2; ?>2,RL,<?php echo $logroABoRL; ?>,<?php echo $Id_p3logros; ?>,<?php  echo
$logro; ?>,<?php echo $row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,2,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo $row_Recordset22['nomequipop1'];?>">
<div class="text-center"><span class="badge badge-pill badge-primary">Spread <small class="font-weight-bold">(V)</small></span><small class="font-weight-bold"> <br><small class="text-primary"><b><?php echo $logroABoRL; ?></b></small> <b><?php if ($logro>0) {
    echo "+";
}  echo $logro; ?><b></b></b></small></div></td>
<?php } else {?><td></td><?php } ?>

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, '5ML', $tlarray, $tlarray1);
        if ($logro!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" 
class="<?php echo $idequipo1; ?>1,5ML, ,<?php  echo $Id_p3logros; ?>,<?php  echo $logro; ?>,<?php echo
$row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,9,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,9,,13:10:00,<?php echo $row_Recordset21['nomequipop1'];?>">
<div class="text-center"><b><?php if ($logro>0) {
    echo "+";
}  echo $logro; ?></b></div></td>
<?php } else {?><td></td><?php } ?>

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, '5A', $tlarray, $tlarray1);
        if ($logro!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" 
class="<?php echo $idequipo1; ?>1,5A,<?php echo $logroABoRL; ?>,<?php  echo $Id_p3logros; ?>,
<?php  echo $logro; ?>,<?php echo $row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,12,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo
$row_Recordset21['nomequipop1'];?>">
<div class="text-center"><small class="text-primary"><b>A <?php echo $logroABoRL; ?></b></small><b><br><?php if ($logro>0) {
    echo "+";
}  echo $logro; ?></b></div></td>
<?php } else {?><td></td><?php } ?>

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, '5RL', $tlarray, $tlarray1);
        if ($logro!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" 
class="<?php echo $idequipo1; ?>1,5RL,<?php echo $logroABoRL; ?>,<?php  echo $Id_p3logros; ?>,
<?php  echo $logro; ?>,<?php echo $row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,10,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,"">
<div class="text-center"><small class="text-primary"><b><?php echo $logroABoRL; ?></b></small><b><br><?php if ($logro>0) {
            echo "+";
        }  echo $logro; ?></b></div></td></tr>
<?php } else {?><td></td><?php } ?>


<tr class="table-light">

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, 'ML', $tlarray, $tlarray1);
        if ($logro!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
class="<?php echo $idequipo2; ?>2,ML, ,<?php echo $Id_p3logros; ?>,<?php  echo $logro; ?>,<?php echo
$row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,5,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo $row_Recordset22['nomequipop1'];?>">
<div class="text-center"><span class="badge badge-pill badge-primary">Ganar <small class="font-weight-bold">(H)</small></span><small class="font-weight-bold"> <br><b>100</b></small></div></td>
<?php } else {?><td></td><?php } ?>

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, 'B', $tlarray, $tlarray1);
        if ($logro!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
class="<?php echo $idequipo2; ?>2,B,<?php echo $logroABoRL; ?>,<?php echo $Id_p3logros; ?>,<?php  echo
$logro; ?>,<?php echo $row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,8,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo $row_Recordset22['nomequipop1'];?>">
<div class="text-center"><small class="text-primary"><b>B 212</b></small> <b>-110<b></b></b></div></td>
<?php } else {?><td></td><?php } ?>

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, 'RL', $tlarray, $tlarray1);
        if ($logro!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" 
class="<?php echo $idequipo2; ?>2,RL,<?php echo $logroABoRL; ?>,<?php echo $Id_p3logros; ?>,<?php  echo
$logro; ?>,<?php echo $row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo $row_Recordset22['nomequipop1'];?>">
<div class="text-center"><span class="badge badge-pill badge-primary">Spread <small class="font-weight-bold">(H)</small></span><small class="font-weight-bold"> <br><small class="text-primary"><b>+1.5</b></small> <b>-110<b></b></b></small></div></td>
<?php } else {?><td></td><?php } ?>

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, '5ML', $tlarray, $tlarray1);
        if ($logro!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" 
class="<?php echo $idequipo2; ?>2,5ML, ,<?php echo $Id_p3logros; ?>,<?php echo $logro; ?>,<?php echo
$row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,13,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo $row_Recordset21['nomequipop1'];?>">
<div class="text-center"><b>100</b></div></td>
<?php } else {?><td></td><?php } ?>

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, '5B', $tlarray, $tlarray1);
        if ($logro!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" 
class="<?php echo $idequipo2; ?>2,5B,<?php echo $logroABoRL; ?>,<?php echo $Id_p3logros; ?>,
<?php echo $logro; ?>,<?php echo $row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,16,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo
$row_Recordset22['nomequipop1'];?>">
<div class="text-center"><small class="text-primary"><b>B 104.5</b></small><b><br>-110</b></div></td>
<?php } else {?><td></td><?php } ?>

<?php list($logro, $Id_p3logros, $logroABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, '5RL', $tlarray, $tlarray1);
        if ($logro!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" 
class="<?php echo $idequipo2; ?>2,5RL,<?php echo $logroABoRL; ?>,<?php echo $Id_p3logros; ?>,<?php echo
$logro; ?>,<?php echo $row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,14,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo $row_Recordset22['nomequipop1'];?>">
<div class="text-center"><small class="text-primary"><b>+0.5</b></small><b><br>-110</b></div></td></tr>
<?php } else {?><td></td><?php } ?>

<?php
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
</tbody>
</table>
</div></div></div>    </div>
</div>
<?php
}?>