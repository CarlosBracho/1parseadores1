<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<title>.:Apuestas:.</title>

<!-- Bootstrap core CSS -->
<link href="../css/bootstrapBootswatchv4.5.2.min.css" rel="stylesheet">
<!-- Custom styles for this template -->


</head>

<body>
<header> 
<!-- Fixed navbar -->

</header>




<hr>
<div class="row">
<div class="col-12 col-md-12  table-responsive "> 
<!-- Contenido -->
<table class="table">
<thead class="thead-dark">
<tr>


            

</tr>
</thead>
<tbody style="border: solid 1px #000000; ">
<?php
$beisbol=0;

if ($totalRows_Recordset1b>=1) {
    do {
        $query_Recordset301 = sprintf(
            "/* PARSEADORES1 parley\adresultado_beisbol.php - QUERY 1 */ SELECT * FROM p2juegos, p5resultadosj WHERE 
            p2juegos.Id_p2juegosp2 = p5resultadosj.juegop5 AND
p2juegos.iniciodtp2 > %s AND
p2juegos.iniciodtp2 < %s AND
p5resultadosj.iniciodtp5 > %s AND
p5resultadosj.iniciodtp5 < %s AND
p2juegos.Id_p2juegosp2 = %s 
        ORDER BY p2juegos.competicionp2
        ",
                GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"),
        GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"),
            GetSQLValueString($row_Recordset1b['juegop5'], "int")
        );
        $Recordset301 = mysqli_query($conexionbanca, $query_Recordset301) or die(mysqli_error($conexionbanca));
        $row_Recordset301 = mysqli_fetch_assoc($Recordset301);
        $totalRows_Recordset301 = mysqli_num_rows($Recordset301);
   
//echo por diego
$quienmete2=0;
if($row_Recordset1b['quienmete']<>0 && $row_Recordset1b['quienmete']<>''){
    $query_Recordset301d = sprintf(
        "/* PARSEADORES1 parley\adresultado_beisbol.php - QUERY 2 */ SELECT nom_usuario FROM usuario WHERE 
    id_usuario = %s
    ",
        GetSQLValueString($row_Recordset1b['quienmete'], "int")
    );
    $Recordset301d = mysqli_query($conexionbanca, $query_Recordset301d) or die(mysqli_error($conexionbanca));
    $row_Recordset301d = mysqli_fetch_assoc($Recordset301d);
    $totalRows_Recordset301d = mysqli_num_rows($Recordset301d);
$quienmete=$row_Recordset301d['nom_usuario'];
$quienmete2=1;
}

if($row_Recordset1b['quienmete']==0 && $row_Recordset1b['quienmete']!=''){
    $quienmete='WINNIGBET';   
    $quienmete2=1;
}
if($row_Recordset1b['quienmete']==-1 && $row_Recordset1b['quienmete']!=''){
    $quienmete='SELLATUPARLEY';   
    $quienmete2=1;
}
    //Diego
    if($row_Recordset1b['deportep5']=='beisbol'){
        ?>
        
        <?php if($beisbol==0){ $beisbol=1; ?>
            <tr class="text-center font-weight-bold table-warning" style="border: solid; border-color:black">
                <td>Fecha</td>
                <td>Competicion</td>                              
                <td>Equipos Beisbol</td>
                <td class="text-center">Juego Completo</td><td class="text-center">Mitad de Juego</td>
                <td class="text-center">Anota Primero</td>
                <td class="text-center">SI/NO 1er Inning</td><td class="text-center">HRE</td></tr>							<tr style="background-color: #F2FFFF;"> 
        <?php } ?>
                <td rowspan="2" width="15%" class="text-center"><a href="adpsinresultados2.php?Id_p2juegosp2=<?php echo $row_Recordset1b['juegop5']; ?>&equipo1=<?php echo $row_Recordset1b['equipo1p5']; ?>&equipo2=<?php echo $row_Recordset1b['equipo2p5']; ?>&logrodtp3=<?php echo $row_Recordset1b['iniciodtp2'];?>" class="btn btn-outline-danger" target="_blank"><?php echo substr($row_Recordset1b['iniciodtp5'], 0, -8); ?><br><span class="VsOdds">VS..</span><br><?php echo substr($row_Recordset1b['iniciodtp5'], 10); ?></a><br><?php if($quienmete2==1){echo 'RESUTALDO INGRESADO POR '.$quienmete; }?></td>
                <td rowspan="2" width="20%" class="text-center" style="font-size: 12px;"><?php if($row_Recordset301['competicionp2'] <> ' '){echo $row_Recordset301['competicionp2'];}else{}?></td>

                <td  width="25%" class="text-center" style="font-weight: bold; font-size: 20px;"><?php echo $row_Recordset1b['equipo1p5']; ?></td>

                <?php if ($row_Recordset1b['r21p5']==999) {?>
					<td rowspan="2" colspan="5" class="text-center" style="font-size: 30px;"><?php echo "Juego Aplazado";?></td>
					<?php
					}else {
					?>  

                <td class="text-center"><?php echo $row_Recordset1b['r21p5']; ?></td>
                <td class="text-center"><?php echo $row_Recordset1b['r23p5']; ?></td>
                <td rowspan="2"><?php echo $row_Recordset1b['anotaprimerop5']; ?></td>
                <td rowspan="2"><?php if($row_Recordset1b['r29p5']==0){echo 'NO';} if($row_Recordset1b['r29p5']==1){echo 'SI';} ?></td>
                <td rowspan="2"><?php echo $row_Recordset1b['r30p5']; ?></td>
                <?php
					}
		  			?>
                </tr>
            <tr style="background-color: #F2FFFF;"> 
                <td  width="25%" class="text-center" style="font-weight: bold; font-size: 20px;"><?php echo $row_Recordset1b['equipo2p5']; ?></td>

                <?php if ($row_Recordset1b['r22p5']==999) {?>
									
                                    <?php
                                    }else {
                                    ?>

                <td class="text-center"><?php echo $row_Recordset1b['r22p5']; ?></td>
                <td class="text-center"><?php echo $row_Recordset1b['r24p5']; ?></td>

                <?php
					}
		  			?>
            </tr>
            <tr > 
        <?php
        }

} while ($row_Recordset1b = mysqli_fetch_assoc($Recordset1b));
}
?>
</tbody>
</table>
      
<!-- Fin Contenido --> 
</div>
</div>
<!-- Fin row --> 



<!-- Fin container -->


<!-- Bootstrap core JavaScript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 

<script src="../js/bootstrap4.js"></script>
</body>
</html>
