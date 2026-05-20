<?php
if (!isset($_SESSION)) {
    session_start();
}?>
                                   
<div <?php if($scroll==1){ echo 'id=scrollj'; } ?> class="border border-primary">
    <table class="table table-bordered table-sm">
        <thead>
            <tr class="table-dark">
                <td colspan="8">
                    <h6 class="font-weight-bold">Baloncesto</h6>
                </td>
            </tr>
        </thead>
        <tbody>
<?php
    $query_Recordset1 = sprintf(
    "/* PARSEADORES1 new\parley\apc_baloncesto.php - QUERY 1 */ SELECT * FROM p2juegos 
	WHERE deportep2 = %s  AND
iniciodtp2 >= %s AND 
p2time >= %s ORDER BY competicionp2 
ASC
",
    GetSQLValueString("baloncesto", "text"),
    GetSQLValueString($datetime, "date"),
    GetSQLValueString($dtime2, "date")
);
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $compex='0';
    $emcab=0;
    $competicionp2='0';
do { 
    $query_Recordset21 = sprintf(
        "/* PARSEADORES1 new\parley\apc_baloncesto.php - QUERY 2 */ SELECT *
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
    $compex=$row_Recordset1['competicionp2']
?>
		
<tr class="table-primary"><td colspan="8"><div class="equipos"><?php if(($tipo==7) && $row_Recordset1['competicionp2']==''){?>
    <a class="" style="color:white" data-toggle="modal" data-target="#exampleModal100"  onclick="crearcompeticion(1, <?php echo $row_Recordset1['Id_p2juegosp2'];?>, 5);">Crear Competicion</a>
<?php
}elseif(($tipo==7)){?><a class="" style="color:white" data-toggle="modal" data-target="#exampleModal100"  onclick="crearcompeticion(1, <?php echo $row_Recordset1['Id_p2juegosp2'];?>, 5);"><?php } 

if($row_Recordset1['competicionp2']<>$competicionp2){   echo $row_Recordset1['competicionp2'];                  }




?></a></div></td></tr>

<tr class="table-dark">

<th><h6><small class="font-weight-bold"><?php echo strftime("%A %d ", strtotime($row_Recordset1['iniciodtp2']));
    $nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($row_Recordset1['iniciodtp2']));
    $nuevahora1 = date('Y-m-j H:i:s', $nuevahora1);
    echo date("g:ia", strtotime($nuevahora1)); ?></small></h6></th><th><h6><small class="font-weight-bold">Ganar</small></h6></th><th><h6><small class="font-weight-bold">A/B</small></h6></th><th><h6><small class="font-weight-bold">RL</small></h6></th><th><h6><small class="font-weight-bold">Ganar MJ</small></h6></th><th><h6><small class="font-weight-bold">A/B MJ</small></h6></th><th><h6><small class="font-weight-bold">RL MJ</small></h6></th></tr>

<tr class="table-light"><td><div class="equipos"><?php echo $row_Recordset21['nomequipop1']; ?></div></td>

<?php if ($row_Recordset5['baloncesto_ml'] == 1) {?>
    <td style="color: red;">
    BLOQUEADO
    </td>
<?php
}?>
<?php

if ($row_Recordset5['baloncesto_ml'] == 0) {?>
<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, 'ML', $tlarray, $tlarray1);
    if ($lg!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo1; ?>1,ML, ,<?php echo $Id_p3logros; ?>,<?php  echo $lg; ?>,<?php echo
$row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,1,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo $row_Recordset21['nomequipop1'];?>">
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td></td><?php } ?>
<?php
}?>

<?php if ($row_Recordset5['baloncesto_alta'] == 1) {?>
    <td style="color: red;">
    BLOQUEADO
    </td>
<?php
}?>
<?php

if ($row_Recordset5['baloncesto_alta'] == 0) {?>
<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, 'A', $tlarray, $tlarray1);
    if ($lg!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo1; ?>1,A,<?php echo $lgABoRL; ?>,<?php  echo $Id_p3logros; ?>,<?php  echo
$lg; ?>,<?php echo $row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,"><small class="text-primary"><b>A <?php echo $lgABoRL; ?></b></small> 
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td></td><?php } ?>
<?php
}?>

<?php if ($row_Recordset5['baloncesto_runline'] == 1) {?>
    <td style="color: red;">
    BLOQUEADO
    </td>
<?php
}?>
<?php

if ($row_Recordset5['baloncesto_runline'] == 0) {?>
<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, 'RL', $tlarray, $tlarray1);
    if ($lg!=0) {?>
<td id="<?php echo $idequipo2; ?>1_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo2; ?>1,RL,<?php echo $lgABoRL; ?>,<?php echo $Id_p3logros; ?>,<?php  echo
$lg; ?>,<?php echo $row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,2,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo $row_Recordset22['nomequipop1'];?>"><small class="text-primary"><b><?php echo $lgABoRL; ?> </b></small> 
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td></td><?php } ?>
<?php
}?>

<?php if ($row_Recordset5['baloncesto_mj_ml'] == 1) {?>
    <td style="color: red;">
    BLOQUEADO
    </td>
<?php
}?>
<?php

if ($row_Recordset5['baloncesto_mj_ml'] == 0) {?>
<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, '5ML', $tlarray, $tlarray1);
    if ($lg!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo1; ?>1,5ML, ,<?php  echo $Id_p3logros; ?>,<?php  echo $lg; ?>,<?php echo
$row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,9,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,9,,13:10:00,<?php echo $row_Recordset21['nomequipop1'];?>">
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td></td><?php } ?>	
<?php
}?>

<?php if ($row_Recordset5['baloncesto_mj_alta'] == 1) {?>
    <td style="color: red;">
    BLOQUEADO
    </td>
<?php
}?>
<?php

if ($row_Recordset5['baloncesto_mj_alta'] == 0) {?>
<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, '5A', $tlarray, $tlarray1);
    if ($lg!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo1; ?>1,5A,<?php echo $lgABoRL; ?>,<?php  echo $Id_p3logros; ?>,
<?php  echo $lg; ?>,<?php echo $row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,12,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo
$row_Recordset21['nomequipop1'];?>"><small class="text-primary"><b>A <?php echo $lgABoRL; ?></b></small> 
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td></td><?php } ?>
<?php
}?>

<?php if ($row_Recordset5['baloncesto_mj_rl'] == 1) {?>
    <td style="color: red;">
    BLOQUEADO
    </td>
<?php
}?>
<?php

if ($row_Recordset5['baloncesto_mj_rl'] == 0) {?>
<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, '5RL', $tlarray, $tlarray1);
    if ($lg!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo1; ?>1,5RL,<?php echo $lgABoRL; ?>,<?php  echo $Id_p3logros; ?>,
<?php  echo $lg; ?>,<?php echo $row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,10,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,"><small 
class="text-primary"><b><?php echo $lgABoRL; ?></b></small> 
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td></td><?php } ?>	
<?php
}?>

<?php
$query_Recordset22 = sprintf(
        "/* PARSEADORES1 new\parley\apc_baloncesto.php - QUERY 3 */ SELECT *
FROM p1equipos WHERE Id_p1equiposp1 = %s",
        GetSQLValueString($row_Recordset1['idequipo2p2'], "int")
    );
    $Recordset22 =mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
    $row_Recordset22 = mysqli_fetch_assoc($Recordset22);
    $totalRows_Recordset22 = mysqli_num_rows($Recordset22); ?>

<tr class="table-light"><td><div class="equipos"><?php echo $row_Recordset22['nomequipop1']; ?></div></td>


<?php if ($row_Recordset5['baloncesto_ml'] == 1) {?>
    <td style="color: red;">
    BLOQUEADO
    </td>
<?php
}?>
<?php

if ($row_Recordset5['baloncesto_ml'] == 0) {?>
<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, 'ML', $tlarray, $tlarray1);
    if ($lg!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo2; ?>2,ML, ,<?php echo $Id_p3logros; ?>,<?php  echo $lg; ?>,<?php echo
$row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,5,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo $row_Recordset22['nomequipop1'];?>">
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td></td><?php } ?>
<?php
}?>

<?php if ($row_Recordset5['baloncesto_baja'] == 1) {?>
    <td style="color: red;">
    BLOQUEADO
    </td>
<?php
}?>
<?php

if ($row_Recordset5['baloncesto_baja'] == 0) {?>
<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, 'B', $tlarray, $tlarray1);
    if ($lg!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo2; ?>2,B,<?php echo $lgABoRL; ?>,<?php echo $Id_p3logros; ?>,<?php  echo
$lg; ?>,<?php echo $row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,8,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo $row_Recordset22['nomequipop1'];?>"><small class="text-primary">
<b>B <?php echo $lgABoRL; ?></b></small> 
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td></td><?php } ?>
<?php
}?>

<?php if ($row_Recordset5['baloncesto_runline'] == 1) {?>
    <td style="color: red;">
    BLOQUEADO
    </td>
<?php
}?>
<?php

if ($row_Recordset5['baloncesto_runline'] == 0) {?>
<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, 'RL', $tlarray, $tlarray1);
    if ($lg!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo2; ?>2,RL,<?php echo $lgABoRL; ?>,<?php echo $Id_p3logros; ?>,<?php  echo
$lg; ?>,<?php echo $row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo $row_Recordset22['nomequipop1'];?>"><small class="text-primary"><b><?php echo $lgABoRL; ?></b></small> 
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td></td><?php } ?>
<?php
}?>

<?php if ($row_Recordset5['baloncesto_mj_ml'] == 1) {?>
    <td style="color: red;">
    BLOQUEADO
    </td>
<?php
}?>
<?php

if ($row_Recordset5['baloncesto_mj_ml'] == 0) {?>
<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, '5ML', $tlarray, $tlarray1);
    if ($lg!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo2; ?>2,5ML, ,<?php echo $Id_p3logros; ?>,<?php echo $lg; ?>,<?php echo
$row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,13,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo $row_Recordset21['nomequipop1'];?>">
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td></td><?php } ?>
<?php
}?>

<?php if ($row_Recordset5['baloncesto_mj_baja'] == 1) {?>
    <td style="color: red;">
    BLOQUEADO
    </td>
<?php
}?>
<?php

if ($row_Recordset5['baloncesto_mj_baja'] == 0) {?>
<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, '5B', $tlarray, $tlarray1);
    if ($lg!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo2; ?>2,5B,<?php echo $lgABoRL; ?>,<?php echo $Id_p3logros; ?>,
<?php echo $lg; ?>,<?php echo $row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,16,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo
$row_Recordset22['nomequipop1'];?>"><small class="text-primary"><b>B <?php echo $lgABoRL; ?></b></small> 
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td></td><?php } ?>
<?php
}?>

<?php if ($row_Recordset5['baloncesto_mj_rl'] == 1) {?>
    <td style="color: red;">
    BLOQUEADO
    </td>
<?php
}?>
<?php
if ($row_Recordset5['baloncesto_mj_rl'] == 0) {?>

<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, '5RL', $tlarray, $tlarray1);
    if ($lg!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo2; ?>2,5RL,<?php echo $lgABoRL; ?>,<?php echo $Id_p3logros; ?>,<?php echo
$lg; ?>,<?php echo $row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,14,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo $row_Recordset22['nomequipop1'];?>"><small 
class="text-primary"><b><?php echo $lgABoRL; ?></b></small> 
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td></td><?php } ?>
<?php
}?>

         <?php
                   $competicionp2=$row_Recordset1['competicionp2'];
                   $emcab++;
} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));

?>
	</tbody>
    </table>
</div>