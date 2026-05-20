<?php
if (!isset($_SESSION)) {
    session_start();
}?>

<div <?php if($scroll==1){ echo 'id=scrollj'; } ?> class="border border-warning">
									
									
<table class="table table-bordered table-sm" CELLPADDING="10"
	BORDER="1">                <thead>
                        <tr class="table-dark">
                                <td colspan="12">
                                        <h6 class="font-weight-bold">Beisbol</h6>
                                </td>
                        </tr>
</thead>
<tbody>
<?php




    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 new\parley\apc_beisbol.php - QUERY 1 */ SELECT * FROM p2juegos 
	WHERE deportep2 = %s AND 
iniciodtp2 >= %s AND 
p2time >= %s ORDER BY competicionp2 
ASC",
        GetSQLValueString("beisbol", "text"),
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

    $query_Recordset111D = sprintf(
        "/* PARSEADORES1 new\parley\apc_beisbol.php - QUERY 2 */ SELECT logrop3, Id_p3logrosp3, logroABoRLp3, idjuegop3, equipop3, tipojugadap3, logroactualdt
    FROM  p3logros
    WHERE logrodtp3 >= %s AND idjuegop3 >= 0 AND idjuegop3 = %s ORDER BY idjuegop3 DESC",
        GetSQLValueString($datetime, "date"),
        GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "date")
    );
    $Recordset111D =mysqli_query($conexionbanca, $query_Recordset111D) or die(mysqli_error($conexionbanca));
    $row_Recordset111D = mysqli_fetch_assoc($Recordset111D);
    $totalRows_Recordset111D = mysqli_num_rows($Recordset111D);

    //echo $row_Recordset111D['idjuegop3'];
    



    $query_Recordset21 = sprintf(
        "/* PARSEADORES1 new\parley\apc_beisbol.php - QUERY 3 */ SELECT *
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

<tr class="table-warning"><td colspan="12"><div class="equipos">
    <?php if(($tipo==7) && $row_Recordset1['competicionp2']==''){?>
    <a class="" style="color:white" data-toggle="modal" data-target="#exampleModal100"  onclick="crearcompeticion(0, <?php echo $row_Recordset1['Id_p2juegosp2'];?>, 5);">Crear Competicion</a>
<?php
}elseif($tipo==7){?>

<a class="" style="color:white" data-toggle="modal" data-target="#exampleModal100"  onclick="crearcompeticion(0, <?php echo $row_Recordset1['Id_p2juegosp2']; ?>, 5);"><?php } 
if($row_Recordset1['competicionp2']<>$competicionp2){   echo $row_Recordset1['competicionp2'];                  }
//

?></a> 
</div></td></tr>
<?php  

if($emcab==0 or $emcab==5 or $emcab==10 or $emcab==15 or $emcab==20 or $emcab==25 or $emcab==30 or $emcab==35 or $emcab==40 or $emcab==45){
?>


			<tr class="table-dark">
            
			<th rowspan='2'><h6><small class="font-weight-bold">HORA INICIO<br>
            <?php echo strftime("%A %d ", strtotime($row_Recordset1['iniciodtp2']));
    $nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($row_Recordset1['iniciodtp2']));
    $nuevahora1 = date('Y-m-j H:i:s', $nuevahora1);
    echo date("g:ia", strtotime($nuevahora1)); ?></p>
</small></h6></th>
            <th colspan='4'><h6><small class="font-weight-bold">Juego Completo</small></h6></th>
            <th colspan='3'><h6><small class="font-weight-bold">Medio Juego</small></h6></th>
            <th colspan='4'><h6><small class="font-weight-bold">Jugadas Exoticas</small></h6></th>

            </tr>
            <tr class="table-dark">
           
            <th><h6><small class="font-weight-bold">Ganar</small></h6></th>
            <th><h6><small class="font-weight-bold">RL</small></h6></th>
            <th><h6><small class="font-weight-bold">SRL</small></h6></th>
            <th><h6><small class="font-weight-bold">A/B</small></h6></th>

            <th><h6><small class="font-weight-bold">Ganar</small></h6></th>
            <th><h6><small class="font-weight-bold">RL</small></h6></th>
            <th><h6><small class="font-weight-bold">A/B</small></h6></th>

            <th><h6><small class="font-weight-bold">S/N</small></h6></th>
            <th><h6><small class="font-weight-bold">AP</small></h6></th>
            <th><h6><small class="font-weight-bold">HCE</small></h6></th>
            </tr>
            <?php  }else{?>

                <tr class="table-dark">
            
			<th rowspan='1' colspan='11'>
            <?php echo strftime("%A %d ", strtotime($row_Recordset1['iniciodtp2']));
    $nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($row_Recordset1['iniciodtp2']));
    $nuevahora1 = date('Y-m-j H:i:s', $nuevahora1);
    echo date("g:ia", strtotime($nuevahora1)); ?>
</th>
</tr>

<?php }?>
<tr class="table-light"> 

<td><?php echo $row_Recordset21['nomequipop1']; ?><p><small class="text-danger font-weight-bold">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row_Recordset1['pichee1p2']  ?> </small>




    

</td>

<?php if ($row_Recordset5['beisbol_ml'] == 1) {?>
    <td style="color: red;">
    BLOQUEADO
    </td>

<?php
}?>
<?php

if ($row_Recordset5['beisbol_ml'] == 0) {?>

<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, 'ML', $tlarray, $tlarray1);
    if ($lg!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo1; ?>1,ML, ,<?php echo $Id_p3logros; ?>,<?php  echo $lg; ?>,<?php echo
$row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,1,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,13:10:00,<?php echo $row_Recordset21['nomequipop1'];?>"></br>
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?>

</div>
</td><?php } else {?><td></td><?php } ?>	
<?php
}?>


<?php if ($row_Recordset5['beisbol_runline'] == 1) {?>
    <td style="color: red;">
    BLOQUEADO
    </td>

<?php
}?>
<?php

if ($row_Recordset5['beisbol_runline'] == 0) {?>
<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, 'RL', $tlarray, $tlarray1);
    if ($lg!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo1; ?>1,RL,<?php echo $lgABoRL; ?>,<?php echo $Id_p3logros; ?>,<?php  echo
$lg; ?>,<?php echo $row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,2,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,13:10:00,<?php echo $row_Recordset21['nomequipop1'];?>"><small class="text-muted"><b><?php echo $lgABoRL; ?></b></small></br>
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td></td><?php } ?>	
<?php
}?>

<?php if ($row_Recordset5['beisbol_superl'] == 1) {?>
    <td style="color: red;">
    BLOQUEADO
    </td>

<?php
}?>
<?php

if ($row_Recordset5['beisbol_superl'] == 0) {?>
<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, 'SRL', $tlarray, $tlarray1);
    if ($lg!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo1; ?>1,SRL,<?php echo $lgABoRL; ?>,<?php echo $Id_p3logros; ?>,<?php  echo
$lg; ?>,<?php echo $row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,3,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,13:10:00,<?php echo $row_Recordset21['nomequipop1'];?>"><small class="text-danger"><b><?php echo $lgABoRL; ?></b></small></br>
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td></td><?php } ?>		
<?php
}?>

<?php if ($row_Recordset5['beisbol_alta'] == 1) {?>
    <td style="color: red;">
    BLOQUEADO
    </td>

<?php
}?>
<?php

if ($row_Recordset5['beisbol_alta'] == 0) {?>
<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, 'A', $tlarray, $tlarray1);
    if ($lg!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo1; ?>1,A,<?php echo $lgABoRL; ?>,<?php  echo $Id_p3logros; ?>,<?php  echo
$lg; ?>,<?php echo $row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,13:10:00,"><small class="text-danger"><b>A <?php echo $lgABoRL; ?></b></small></br>
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td></td><?php } ?>	
<?php
}?>

<?php if ($row_Recordset5['beisbol_mj_ml'] == 1) {?>
    <td style="color: red;">
    BLOQUEADO
    </td>

<?php
}?>
<?php

if ($row_Recordset5['beisbol_mj_ml'] == 0) {?>
<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, '5ML', $tlarray, $tlarray1);
    if ($lg!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo1; ?>1,5ML, ,<?php  echo $Id_p3logros; ?>,<?php  echo $lg; ?>,<?php echo
$row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,9,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,13:10:00,<?php echo $row_Recordset21['nomequipop1'];?>"></br>
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td></td><?php } ?>	
<?php
}?>

<?php if ($row_Recordset5['beisbol_runline'] == 1) {?>
    <td style="color: red;">
    BLOQUEADO
    </td>

<?php
}?>
<?php

if ($row_Recordset5['beisbol_runline'] == 0) {?>
<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, '5RL', $tlarray, $tlarray1);
    if ($lg!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo1; ?>1,5RL,<?php echo $lgABoRL; ?>,<?php  echo $Id_p3logros; ?>,
<?php  echo $lg; ?>,<?php echo $row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,10,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,13:10:00,"><small 
class="text-danger"><b><?php echo $lgABoRL; ?></b></small></br>
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?>    </td>
<?php } else {?><td></td><?php } ?>	
<?php
}?>

<?php if ($row_Recordset5['beisbol_mj_alta'] == 1) {?>
    <td style="color: red;">
    BLOQUEADO
    </td>

<?php
}?>
<?php

if ($row_Recordset5['beisbol_mj_alta'] == 0) {?>
<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, '5A', $tlarray, $tlarray1);
    if ($lg!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo1; ?>1,5A,<?php echo $lgABoRL; ?>,<?php  echo $Id_p3logros; ?>,
<?php  echo $lg; ?>,<?php echo $row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,12,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,13:10:00,<?php echo
$row_Recordset21['nomequipop1'];?>"><small class="text-danger"><b>A <?php echo $lgABoRL; ?></b></small></br>
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td></td><?php } ?>
<?php
}?>

<?php if ($row_Recordset5['beisbol_si'] == 1) {?>
    <td style="color: red;">
    BLOQUEADO
    </td>

<?php
}?>
<?php

if ($row_Recordset5['beisbol_si'] == 0) {?>
<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, 'SI', $tlarray, $tlarray1);
    if ($lg!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo1; ?>1,SI, ,<?php  echo $Id_p3logros; ?>,<?php  echo $lg; ?>,<?php echo
$row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,17,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,13:10:00,<?php echo $row_Recordset21['nomequipop1'];?>">
<small class="text-danger"><b>SI</b></small></br>
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td></td><?php } ?>
<?php
}?>

<?php if ($row_Recordset5['beisbol_anotap'] == 1) {?>
    <td style="color: red;">
    BLOQUEADO
    </td>

<?php
}?>
<?php

if ($row_Recordset5['beisbol_anotap'] == 0) {?>
<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, 'AP', $tlarray, $tlarray1);
    if ($lg!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo1; ?>1,AP, ,<?php  echo $Id_p3logros; ?>,<?php  echo $lg; ?>,<?php echo
$row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,19,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,13:10:00,<?php echo $row_Recordset21['nomequipop1'];?>"></br>
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td></td><?php } ?>
<?php
}?>

<?php if ($row_Recordset5['beisbol_hce'] == 1) {?>
    <td style="color: red;">
    BLOQUEADO
    </td>

<?php
}?>
<?php

if ($row_Recordset5['beisbol_hce'] == 0) {?>
<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, 'AG', $tlarray, $tlarray1);
    if ($lg!=0) {?>
<td style="display:" id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo1; ?>1,AG,<?php echo $lgABoRL; ?>,<?php  echo $Id_p3logros; ?>,<?php  echo $lg; ?>,
<?php echo $row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,20,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,13:10:00,<?php echo $row_Recordset21['nomequipop1'];?>">
<small class="text-danger"><b>A <?php echo $lgABoRL; ?></b></small> <br>
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td></td><?php } ?>


</tr>
<tr></tr>
<?php
}?>

<?php
$query_Recordset22 = sprintf(
        "/* PARSEADORES1 new\parley\apc_beisbol.php - QUERY 4 */ SELECT *
FROM p1equipos WHERE Id_p1equiposp1 = %s",
        GetSQLValueString($row_Recordset1['idequipo2p2'], "int")
    );
    $Recordset22 =mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
    $row_Recordset22 = mysqli_fetch_assoc($Recordset22);
    $totalRows_Recordset22 = mysqli_num_rows($Recordset22); ?>



<tr class="table-light">
<td> <?php echo $row_Recordset22['nomequipop1']; ?><p><small class="text-danger font-weight-bold">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row_Recordset1['pichee2p2'] ?> </small></p></td>

<?php if ($row_Recordset5['beisbol_ml'] == 1) {?>
    <td style="color: red;">
    BLOQUEADO
    </td>

<?php
}?>
<?php

if ($row_Recordset5['beisbol_ml'] == 0) {?>
<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, 'ML', $tlarray, $tlarray1);
    if ($lg!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo2; ?>2,ML, ,<?php echo $Id_p3logros; ?>,<?php  echo $lg; ?>,<?php echo
$row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,5,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,13:10:00,<?php echo $row_Recordset22['nomequipop1'];?>"></br>
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td></td><?php } ?>
<?php
}?>

<?php if ($row_Recordset5['beisbol_runline'] == 1) {?>
    <td style="color: red;">
    BLOQUEADO
    </td>

<?php
}?>
<?php

if ($row_Recordset5['beisbol_runline'] == 0) {?>
<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, 'RL', $tlarray, $tlarray1);
    if ($lg!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo2; ?>2,RL,<?php echo $lgABoRL; ?>,<?php echo $Id_p3logros; ?>,<?php  echo
$lg; ?>,<?php echo $row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,13:10:00,<?php echo $row_Recordset22['nomequipop1'];?>"><small class="text-muted"><b><?php echo $lgABoRL; ?></br></b></small>
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td></td><?php } ?>
<?php
}?>

<?php if ($row_Recordset5['beisbol_superl'] == 1) {?>
    <td style="color: red;">
    BLOQUEADO
    </td>

<?php
}?>
<?php

if ($row_Recordset5['beisbol_superl'] == 0) {?>
<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, 'SRL', $tlarray, $tlarray1);
    if ($lg!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo2; ?>2,SRL,<?php echo $lgABoRL; ?>,<?php echo $Id_p3logros; ?>,<?php  echo
$lg; ?>,<?php echo $row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,7,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,20:10:00,<?php echo $row_Recordset22['nomequipop1'];?>" style="cursor: pointer; color: rgb(0, 0, 0);"><small class="text-danger"><b><?php echo $lgABoRL; ?></br></b></small>
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td></td><?php } ?>
<?php
}?>

<?php if ($row_Recordset5['beisbol_baja'] == 1) {?>
    <td style="color: red;">
    BLOQUEADO
    </td>

<?php
}?>
<?php

if ($row_Recordset5['beisbol_baja'] == 0) {?>
<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, 'B', $tlarray, $tlarray1);
    if ($lg!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" <?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?> 
class="<?php echo $idequipo2; ?>2,B,<?php echo $lgABoRL; ?>,<?php echo $Id_p3logros; ?>,<?php  echo
$lg; ?>,<?php echo $row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,8,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,13:10:00,<?php echo $row_Recordset22['nomequipop1'];?>"><small class="text-danger">
<b>B <?php echo $lgABoRL; ?></br></b></small> 
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td></td><?php } ?>
<?php
}?>

<?php if ($row_Recordset5['beisbol_mj_ml'] == 1) {?>
    <td style="color: red;">
    BLOQUEADO
    </td>

<?php
}?>
<?php

if ($row_Recordset5['beisbol_mj_ml'] == 0) {?>
<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, '5ML', $tlarray, $tlarray1);
    if ($lg!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo2; ?>2,5ML, ,<?php echo $Id_p3logros; ?>,<?php echo $lg; ?>,<?php echo
$row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,13,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,13:10:00,<?php echo $row_Recordset21['nomequipop1'];?>"></br>
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td></td><?php } ?>
<?php
}?>

<?php if ($row_Recordset5['beisbol_mj_rl'] == 1) {?>
    <td style="color: red;">
    BLOQUEADO
    </td>

<?php
}?>
<?php

if ($row_Recordset5['beisbol_mj_rl'] == 0) {?>
<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, '5RL', $tlarray, $tlarray1);
    if ($lg!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo2; ?>2,5RL,<?php echo $lgABoRL; ?>,<?php echo $Id_p3logros; ?>,<?php echo
$lg; ?>,<?php echo $row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,14,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,13:10:00,<?php echo $row_Recordset22['nomequipop1'];?>"><small 
class="text-danger"><b><?php echo $lgABoRL; ?></b></small></br>
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td></td><?php } ?>
<?php
}?>

<?php if ($row_Recordset5['beisbol_mj_baja'] == 1) {?>
    <td style="color: red;">
    BLOQUEADO
    </td>

<?php
}?>
<?php

if ($row_Recordset5['beisbol_mj_baja'] == 0) {?>
<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, '5B', $tlarray, $tlarray1);
    if ($lg!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo2; ?>2,5B,<?php echo $lgABoRL; ?>,<?php echo $Id_p3logros; ?>,
<?php echo $lg; ?>,<?php echo $row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,16,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,13:10:00,<?php echo
$row_Recordset22['nomequipop1'];?>"><small class="text-danger"><b>B <?php echo $lgABoRL; ?></br></b></small> 
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td></td><?php } ?>
<?php
}?>

<?php if ($row_Recordset5['beisbol_no'] == 1) {?>
    <td style="color: red;">
    BLOQUEADO
    </td>

<?php
}?>
<?php

if ($row_Recordset5['beisbol_no'] == 0) {?>
<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, 'NO', $tlarray, $tlarray1);
    if ($lg!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo2; ?>2,NO, ,<?php  echo $Id_p3logros; ?>,<?php  echo $lg; ?>,<?php echo
$row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,21,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,13:10:00,<?php echo $row_Recordset22['nomequipop1'];?>">
<small class="text-danger"><b>NO</b></small></br>
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td></td><?php } ?>
<?php
}?>

<?php if ($row_Recordset5['beisbol_anotap'] == 1) {?>
    <td style="color: red;">
    BLOQUEADO
    </td>

<?php
}?>
<?php

if ($row_Recordset5['beisbol_anotap'] == 0) {?>
<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, 'AP', $tlarray, $tlarray1);
    if ($lg!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo2; ?>2,AP, ,<?php  echo $Id_p3logros; ?>,<?php  echo $lg; ?>,<?php echo
$row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,23,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,13:10:00,<?php echo $row_Recordset22['nomequipop1'];?>"></br>
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td></td><?php } ?>
<?php
}?>

<?php if ($row_Recordset5['beisbol_hce'] == 1) {?>
    <td style="color: red;">
    BLOQUEADO
    </td>

<?php
}?>
<?php

if ($row_Recordset5['beisbol_hce'] == 0) {?>
<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, 'BG', $tlarray, $tlarray1);
    if ($lg!=0) {?>
<td style="display:" id="<?php echo $idequipo2; ?>2_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo2; ?>2,BG,<?php echo $lgABoRL; ?>,<?php  echo $Id_p3logros; ?>,<?php  echo $lg; ?>,<?php echo
$row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,24,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,,13:10:00,<?php echo $row_Recordset22['nomequipop1'];?>">
<small class="text-danger"><b>B <?php echo $lgABoRL; ?></b></small><br>
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
</tr><tr></tr><tr class="table-dark">
<?php } else {?><td></td><?php } ?>


</tr><tr>

</tr>
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

