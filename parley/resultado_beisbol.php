<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');




$inicio=fechaactualbd();


$iniciof=fechaactualbd().' 00:00:01';
$finalf=fechaactualbd().' 23:59:59';

if (!isset($_SESSION['MM_id_usuario'])) {
    $id_usuarioO=$_SESSION['MM_id_usuario'];
} else {
    $id_usuarioO=0;
}
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction = "" . htmlentities($_SERVER['QUERY_STRING']);
}
if (isset($_POST['fecha_inicio']) && isset($_POST['fecha_inicio'])) {
    $inicio=$_POST['fecha_inicio'];
    $final=$_POST['fecha_inicio'];
    $iniciof=$_POST['fecha_inicio'].' 00:00:01';
    $finalf=$_POST['fecha_inicio'].' 23:59:59';
    



}



$query_Recordset13 = sprintf(
	"/* PARSEADORES1 parley\resultado_beisbol.php - QUERY 1 */ SELECT *
	FROM p5resultadosj
	WHERE
	deportep5 = %s AND 
	iniciodtp5 >= %s AND 
	iniciodtp5 <= %s
	ORDER BY deportep5 DESC",
	GetSQLValueString("beisbol", "text"),
	GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"));
	$Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
	$row_Recordset13 = mysqli_fetch_assoc($Recordset13);
	$totalRows_Recordset13 = mysqli_num_rows($Recordset13);
//$row_Recordset13['deportep5']=='beisbol'




?>
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
<script src="../js/jquery-3.5.1.min.js"></script>
<script src="../js/datepicked.gijgo1.9.13.min.js" type="text/javascript"></script>
<link href="../css/datepicked.gijgo1.9.13.min.css" rel="stylesheet" type="text/css" />

</head>

<body>
<header> 
<!-- Fixed navbar -->

</header>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off" onsubmit="return chequearEnvio();">




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

if ($totalRows_Recordset13>=1) {
    do {

        $query_Recordset301 = sprintf(
            "/* PARSEADORES1 parley\resultado_beisbol.php - QUERY 2 */ SELECT * 
            FROM p2juegos, p5resultadosj 
            WHERE 
p2juegos.Id_p2juegosp2 = p5resultadosj.juegop5 AND
p2juegos.iniciodtp2 > %s AND
p2juegos.iniciodtp2 < %s AND
p2juegos.Id_p2juegosp2 = %s 
        ORDER BY p2juegos.competicionp2
        ",
        GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"),
            GetSQLValueString($row_Recordset1b['juegop5'], "int")
        );
        $Recordset301 = mysqli_query($conexionbanca, $query_Recordset301) or die(mysqli_error($conexionbanca));
        $row_Recordset301 = mysqli_fetch_assoc($Recordset301);
        $totalRows_Recordset301 = mysqli_num_rows($Recordset301);
    
    if($row_Recordset13['deportep5']=='beisbol'){
        ?>
        
        <?php if($beisbol==0){ $beisbol=1; ?>
            <tr class="text-center font-weight-bold table-warning" style="border: solid; border-color:black">
                <td>Fecha</td>
                <td>Competicion</td>                              
                <td>Equipos Beisbol</td>
                <td class="text-center">Juego Completo</td><td class="text-center">Mitad de Juego</td><td class="text-center">HRE</td>
                <td class="text-center">Anota Primero</td>
                <td class="text-center">SI/NO 1er Inning</td></tr>							<tr style="background-color: #F2FFFF;"> 
        <?php } ?>
                <td rowspan="2" width="15%" class="text-center" style="border: solid;"><?php echo substr($row_Recordset13['iniciodtp5'], 0, -8); ?><br><span class="VsOdds">VS</span><br><?php echo substr($row_Recordset13['iniciodtp5'], 10); ?></td>
                <td rowspan="2" width="20%" class="text-center" style="font-size: 15px;"><?php if($row_Recordset301['competicionp2'] <> ' '){echo '<b>'. $row_Recordset301['competicionp2'];}else{}?></td>

                <td  width="25%" class="text-center"><?php echo $row_Recordset13['equipo1p5']; ?></td>

                <?php if ($row_Recordset13['r21p5']==999) {?>
					<td rowspan="2" colspan="5" class="text-center" style="font-size: 30px;"><?php echo "Juego Aplazado";?></td>
					<?php
					}else {
					?>  
                <td class="text-center"><?php echo $row_Recordset13['r21p5']; ?></td>
                <td class="text-center"><?php echo $row_Recordset13['r23p5']; ?></td>
                <td rowspan="2"><?php echo $row_Recordset13['r30p5']; ?></td>
                <td rowspan="2"><?php echo $row_Recordset13['anotaprimerop5']; ?></td>
                <td rowspan="2"><?php if($row_Recordset13['r29p5']==0){echo 'NO';} if($row_Recordset13['r29p5']==1){echo 'SI';} ?></td>
                
                    <?php
					}
		  			?>
            
            </tr>
            <tr style="background-color: #F2FFFF;"> 
            <td  width="25%" class="text-center"><?php echo $row_Recordset13['equipo2p5']; ?></td>

            <?php if ($row_Recordset13['r22p5']==999) {?>
									
                <?php
                }else {
                ?>
            <td class="text-center"><?php echo $row_Recordset13['r22p5']; ?></td>
            <td class="text-center"><?php echo $row_Recordset13['r24p5']; ?></td>
                <?php 							
				}
		        ?>
            </tr>
            <tr > 
        <?php
        }

} while ($row_Recordset13 = mysqli_fetch_assoc($Recordset13));
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
