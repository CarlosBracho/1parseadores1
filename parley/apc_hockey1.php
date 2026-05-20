
<?php
if (!isset($_SESSION)) {
    session_start();
}?><script>
function imprim5(imp5){
var printContents = document.getElementById('imp5').innerHTML;
        w = window.open();
        w.document.write(printContents);
        w.document.close(); // necessary for IE >= 10
        w.focus(); // necessary for IE >= 10
		w.print();
		w.close();
        return true;}
</script>          
<div <?php if($scroll==1){ echo 'id=scrollj'; } ?> class="border border-danger">

<center>
    <table class="table table-bordered table-sm">
        <br>
        <center>
    <button type="button" class='btn-danger' onclick="javascript:imprim5(imp5);">IMPRIMIR HOJA DE LOGROS HOCKEY</button>
        </center>
        <br>
        <thead>
            <tr class="table-dark">
                <td colspan="5">
                    <h6 class="font-weight-bold">Hockey</h6>
                </td>
            </tr>


            
        </thead>
        <tbody>


        
		<?php




    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 parley\apc_hockey1.php - QUERY 1 */ SELECT * FROM p2juegos 
	WHERE deportep2 = %s AND
iniciodtp2 >= %s AND
iniciodtp2 <= %s ORDER BY competicionp2 
ASC
",
        GetSQLValueString("hockey", "text"),
        GetSQLValueString($datetime, "date"),
        GetSQLValueString($datetime2, "date")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
do {
    $query_Recordset21 = sprintf(
        "/* PARSEADORES1 parley\apc_hockey1.php - QUERY 2 */ SELECT *
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
        "/* PARSEADORES1 parley\apc_hockey1.php - QUERY 3 */ SELECT *
FROM p1equipos WHERE Id_p1equiposp1 = %s",
        GetSQLValueString($row_Recordset1['idequipo2p2'], "int")
    );
    $Recordset22 =mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
    $row_Recordset22 = mysqli_fetch_assoc($Recordset22);
    $totalRows_Recordset22 = mysqli_num_rows($Recordset22); ?>


<tr class="table-danger"><td colspan="12"><div class="equipos"><?php if(($tipo==7) && $row_Recordset1['competicionp2']==''){?>
    <a class=""  style="color:white" data-toggle="modal" data-target="#exampleModal100"  onclick="crearcompeticion(5, <?php echo $row_Recordset1['Id_p2juegosp2'];?>, 5);">Crear Competicion</a>
<?php
}else{?><a class="" style="color:white" data-toggle="modal" data-target="#exampleModal100"  onclick="crearcompeticion(5, <?php echo $row_Recordset1['Id_p2juegosp2'];?>, 5);"><?php echo $row_Recordset1['competicionp2']; }?></a>  </div></td>


</tr>

<tr class="table-dark">

<th><h6><small class="font-weight-bold"><?php echo strftime("%A %d ", strtotime($row_Recordset1['iniciodtp2']));
    $nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($row_Recordset1['iniciodtp2']));
    $nuevahora1 = date('Y-m-j H:i:s', $nuevahora1);
    echo date("g:ia", strtotime($nuevahora1));   echo ' Codigo de juego '.$row_Recordset1['Id_p2juegosp2']; ?></small></h6></th><th><h6><small class="font-weight-bold">Ganar</small></h6></th><th><h6><small class="font-weight-bold">A/B</small></h6></th><th><h6><small class="font-weight-bold">RunLine</small></h6></th></tr>
    
<tr class="table-light"><td>
<div class="equipos">
<div class="tdright" style="padding-left:0;padding-right:30px;">

<?php echo $row_Recordset21['nomequipop1']; ?></div></div></td>

<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, 'ML', $tlarray, $tlarray1);
    if(isset($lg)){
    if ($lg!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>"<?php if($tipo==0){?> onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" <?php } ?> <?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal7" onclick="funciones(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoy aqui
 } ?>
class="<?php echo $idequipo1; ?>1,ML, ,<?php echo $lgABoRL; ?>,<?php  echo $lg; ?>,<?php echo $row_Recordset21['nomequipop1']; ?>,<?php echo $row_Recordset1['Id_p2juegosp2']; ?>,1,<?php echo $row_Recordset1['Id_p2juegosp2']; ?>,1, ,17:08:00,<?php echo $row_Recordset21['nomequipop1']; ?>">
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>"<?php if($tipo==0){?> onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" <?php } ?> <?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal7" onclick="funciones(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoy aqui
 } ?>
class="<?php echo $idequipo1; ?>1,ML, ,<?php echo $lgABoRL; ?>,<?php  echo $lg; ?>,<?php echo $row_Recordset21['nomequipop1']; ?>,<?php echo $row_Recordset1['Id_p2juegosp2']; ?>,1,<?php echo $row_Recordset1['Id_p2juegosp2']; ?>,1, ,17:08:00,<?php echo $row_Recordset21['nomequipop1']; ?>">
<?php $psi=0; if ($lg==0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td><?php } }else{?>

<td  onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101d" onclick="agregarlogros(<?php echo $row_Recordset1['Id_p2juegosp2']; ?>, <?php echo $row_Recordset1['idequipo2p2']; ?>, 'ML', 1);" <?php //estoyd aqui
} ?>
>

</div>
</td>

<?php } ?>

<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, 'A', $tlarray, $tlarray1);
    if(isset($lg)){
    if ($lg!=0) {?>
<td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?> 
class="<?php echo $idequipo1; ?>1,A,<?php echo $lgABoRL; ?>,<?php  echo $Id_p3logros; ?>,<?php  echo $lg; ?>,<?php echo $row_Recordset21['nomequipop1']; ?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,<?php echo $row_Recordset1['Id_p2juegosp2']; ?>,1, ,17:08:00,<?php echo $row_Recordset21['nomequipop1']; ?>"><small class="text-success"><b>A <?php echo $lgABoRL; ?></b></small>
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td id="<?php echo $idequipo1; ?>1_<?php  echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?> 
class="<?php echo $idequipo1; ?>1,A,<?php echo $lgABoRL; ?>,<?php  echo $Id_p3logros; ?>,<?php  echo $lg; ?>,<?php echo $row_Recordset21['nomequipop1']; ?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,4,<?php echo $row_Recordset1['Id_p2juegosp2']; ?>,1, ,17:08:00,<?php echo $row_Recordset21['nomequipop1']; ?>"><small class="text-success"><b>A <?php echo $lgABoRL; ?></b></small>
<?php $psi=0; if ($lg==0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td><?php } }else{?>

<td  onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101d" onclick="agregarlogros(<?php echo $row_Recordset1['Id_p2juegosp2']; ?>, <?php echo $row_Recordset1['idequipo2p2']; ?>, 'A', 1);" <?php //estoyd aqui
} ?>
>

</div>
</td>

<?php } ?>

<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 1, 'RL', $tlarray, $tlarray1);
    if(isset($lg)){
    if ($lg!=0) {?>
<td id="<?php echo $idequipo2; ?>1_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo2; ?>1,RL,<?php echo $lgABoRL; ?>,<?php echo $Id_p3logros; ?>,<?php  echo
$lg; ?>,<?php echo $row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,2,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo $row_Recordset22['nomequipop1'];?>"><small class="text-success"><b><?php echo $lgABoRL; ?> </b></small> 
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td id="<?php echo $idequipo2; ?>1_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?>  
class="<?php echo $idequipo2; ?>1,RL,<?php echo $lgABoRL; ?>,<?php echo $Id_p3logros; ?>,<?php  echo
$lg; ?>,<?php echo $row_Recordset21['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,2,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo $row_Recordset22['nomequipop1'];?>"><small class="text-success"><b><?php echo $lgABoRL; ?> </b></small> 
<?php $psi=0; if ($lg==0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td><?php } }else{?>

<td  onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101d" onclick="agregarlogros(<?php echo $row_Recordset1['Id_p2juegosp2']; ?>, <?php echo $row_Recordset1['idequipo2p2']; ?>, 'RL', 1);" <?php //estoyd aqui
} ?>
>

</div>
</td>

<?php } ?>


</tr>



<tr class="table-light"><td>
<div class="equipos">
<div class="tdright" style="padding-left:0;padding-right:30px;">

<?php echo $row_Recordset22['nomequipop1']; ?></div></div></td>

<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, 'ML', $tlarray, $tlarray1);
    if(isset($lg)){
    if ($lg!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoy aqui
 } ?> 
class="<?php echo $idequipo2; ?>2,ML, ,<?php  echo $Id_p3logros; ?>,<?php  echo $lg; ?>,<?php echo $row_Recordset22['nomequipop1']; ?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,5,<?php echo $row_Recordset1['Id_p2juegosp2']; ?>,1, ,17:08:00,<?php echo $row_Recordset22['nomequipop1']; ?>">
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoy aqui
 } ?> 
class="<?php echo $idequipo2; ?>2,ML, ,<?php  echo $Id_p3logros; ?>,<?php  echo $lg; ?>,<?php echo $row_Recordset22['nomequipop1']; ?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,5,<?php echo $row_Recordset1['Id_p2juegosp2']; ?>,1, ,17:08:00,<?php echo $row_Recordset22['nomequipop1']; ?>">
<?php $psi=0; if ($lg==0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td><?php } }else{?>

<td  onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101d" onclick="agregarlogros(<?php echo $row_Recordset1['Id_p2juegosp2']; ?>, <?php echo $row_Recordset1['idequipo2p2']; ?>, 'ML', 2);" <?php //estoyd aqui
} ?>
>

</div>
</td>

<?php } ?>


<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, 'B', $tlarray, $tlarray1);
    if(isset($lg)){
    if ($lg!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?> 
class="<?php echo $idequipo2; ?>2,B,<?php echo $lgABoRL; ?>,<?php  echo $Id_p3logros; ?>,<?php  echo $lg; ?>,<?php echo $row_Recordset22['nomequipop1']; ?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,8,<?php echo $row_Recordset1['Id_p2juegosp2']; ?>,1, ,17:08:00,<?php echo $row_Recordset22['nomequipop1']; ?>"><small class="text-success"><b>B  <?php echo $lgABoRL; ?></b></small>
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?> 
class="<?php echo $idequipo2; ?>2,B,<?php echo $lgABoRL; ?>,<?php  echo $Id_p3logros; ?>,<?php  echo $lg; ?>,<?php echo $row_Recordset22['nomequipop1']; ?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,8,<?php echo $row_Recordset1['Id_p2juegosp2']; ?>,1, ,17:08:00,<?php echo $row_Recordset22['nomequipop1']; ?>"><small class="text-success"><b>B  <?php echo $lgABoRL; ?></b></small>
<?php $psi=0; if ($lg==0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td><?php } }else{?>

<td  onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101d" onclick="agregarlogros(<?php echo $row_Recordset1['Id_p2juegosp2']; ?>, <?php echo $row_Recordset1['idequipo2p2']; ?>, 'B', 2);" <?php //estoyd aqui
} ?>
>

</div>
</td>

<?php } ?>

<?php list($lg, $Id_p3logros, $lgABoRL)=Obtenerlogro($row_Recordset1['Id_p2juegosp2'], 2, 'RL', $tlarray, $tlarray1);
    if(isset($lg)){
    if ($lg!=0) {?>
<td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?> 
class="<?php echo $idequipo2; ?>2,RL,<?php echo $lgABoRL; ?>,<?php echo $Id_p3logros; ?>,<?php echo
$lg; ?>,<?php echo $row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,14,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo $row_Recordset22['nomequipop1'];?>"><small 
class="text-success"><b><?php echo $lgABoRL; ?></b></small> 
<?php $psi=0; if ($lg>0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td>
<?php } else {?><td id="<?php echo $idequipo2; ?>2_<?php echo $Id_p3logros; ?>" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101" onclick="crearcompeticion2(1, <?php echo $Id_p3logros; ?>, 1);" <?php //estoyd aqui
 } ?> 
class="<?php echo $idequipo2; ?>2,RL,<?php echo $lgABoRL; ?>,<?php echo $Id_p3logros; ?>,<?php echo
$lg; ?>,<?php echo $row_Recordset22['nomequipop1'];?>,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,14,<?php echo $row_Recordset1['Id_p2juegosp2'];?>,6,,13:10:00,<?php echo $row_Recordset22['nomequipop1'];?>"><small 
class="text-success"><b><?php echo $lgABoRL; ?></b></small> 
<?php $psi=0; if ($lg==0) { $psi=1;  } deam($psi, $lg, $ttl); ?></td><?php } }else{?>

<td  onmouseover="changeCell(this)" onmouseout="changeCellOut(this)"<?php if($tipo==7){?>  data-toggle="modal" data-target="#exampleModal101d" onclick="agregarlogros(<?php echo $row_Recordset1['Id_p2juegosp2']; ?>, <?php echo $row_Recordset1['idequipo2p2']; ?>, 'RL', 2);" <?php //estoyd aqui
} ?>
>

</div>
</td>

<?php } ?>


</tr>


<?php
} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));

 
?>






		</tbody>
</table>
</div>
</center>