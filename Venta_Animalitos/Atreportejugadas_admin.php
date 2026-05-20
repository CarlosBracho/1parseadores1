<?php
  //opcache_reset();
 // echo 'opcache_reset<br>';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$MM_donotCheckaccess = "false";
setlocale(LC_ALL, "es_ES");

$inicioD=fechaactualbd();
$timestamp = strtotime('-6 day', strtotime($inicioD));
$newDate = date("Y-m-d", $timestamp );

$inicio=$newDate;
$final=fechaactualbd();

$iniciof=$newDate.' 00:00:01';
$finalf=fechaactualbd().' 23:59:59';

if (!isset($_SESSION['MM_id_usuario'])) {
    $id_usuarioO=$_SESSION['MM_id_usuario'];
} else {
    $id_usuarioO=0;
}
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction = "" . htmlentities($_SERVER['QUERY_STRING']);
}
if (isset($_POST['fecha_inicio']) && isset($_POST['fecha_fin'])) {
    $inicio=$_POST['fecha_inicio'];
    $final=$_POST['fecha_fin'];
    $iniciof=$_POST['fecha_inicio'].' 00:00:01';
     $finalf=$_POST['fecha_fin'].' 23:59:59';


}


$query_Recordset1111 = sprintf(
  "/* PARSEADORES1 Venta_Animalitos\Atreportejugadas_admin.php - QUERY 1 */ SELECT id_Loterias_y_nombres_ani1, nom_Loterias_y_nombres_ani1, animales_Loterias_y_nombres_ani1
FROM  ani1_loterias_y_nombres
 ORDER BY id_Loterias_y_nombres_ani1 ASC");
$Recordset1111 =mysqli_query($conexionbanca, $query_Recordset1111) or die(mysqli_error($conexionbanca));
$row_Recordset1111 = mysqli_fetch_assoc($Recordset1111);
$totalRows_Recordset1111 = mysqli_num_rows($Recordset1111);

$dir = array();
$cont = 0;
if ($totalRows_Recordset1111>=1) {
  do {
   $dir[$cont] = $row_Recordset1111;
   $cont++;
  } while ($row_Recordset1111 = mysqli_fetch_assoc($Recordset1111));
}

//$dir=json_encode($dir);
//print_r($dir);
//var_dump($dir);


$query_Recordset1111_solteos = sprintf(
  "/* PARSEADORES1 Venta_Animalitos\Atreportejugadas_admin.php - QUERY 2 */ SELECT id_solteo_ani4,
  id_Loterias_y_nombres_ani4,
  fechahora_solteo_ani4
FROM  ani4_solteos
WHERE 
fechahora_solteo_ani4 >= %s AND fechahora_solteo_ani4 <= %s
 ORDER BY id_solteo_ani4 ASC",
      GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date") );
$Recordset1111_solteos =mysqli_query($conexionbanca, $query_Recordset1111_solteos) or die(mysqli_error($conexionbanca));
$row_Recordset1111_solteos = mysqli_fetch_assoc($Recordset1111_solteos);
$totalRows_Recordset1111_solteos = mysqli_num_rows($Recordset1111_solteos);

$dir_solteos = array();
$cont_solteos = 0;
if ($totalRows_Recordset1111_solteos>=1) {
  do {
   $dir_solteos[$cont_solteos] = $row_Recordset1111_solteos;
   $cont_solteos++;
  } while ($row_Recordset1111_solteos = mysqli_fetch_assoc($Recordset1111_solteos));
}


//print_r($dir_solteos);


                            $query_Recordset13 = sprintf(
                                "/* PARSEADORES1 Venta_Animalitos\Atreportejugadas_admin.php - QUERY 3 */ SELECT *
					FROM ani5_jugadas 
					WHERE
          ani5_jugadas.fechahora_creacion_ani5 >= %s AND ani5_jugadas.fechahora_creacion_ani5 <= %s  AND
					
          
          ani5_jugadas.linea_ticket_ani5= 1 
          ORDER BY ani5_jugadas.id_ticket_ani5 DESC",
                               
                               GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"));
    $Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
    $row_Recordset13 = mysqli_fetch_assoc($Recordset13);
    $totalRows_Recordset13 = mysqli_num_rows($Recordset13);
//echo $_SESSION['MM_id_usuario'].' '.$totalRows_Recordset13.' totalRows_Recordset13<br>';

if(isset($_POST[''])){
 
    $query_Recordset13 = sprintf(
        "/* PARSEADORES1 Venta_Animalitos\Atreportejugadas_admin.php - QUERY 4 */ SELECT *
FROM ani5_jugadas 
WHERE
ani5_jugadas.fechahora_creacion_ani5 >= %s AND ani5_jugadas.fechahora_creacion_ani5 <= %s  AND


ani5_jugadas.linea_ticket_ani5= 1 
ORDER BY ani5_jugadas.id_ticket_ani5 DESC",
       
       GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"));
$Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
$row_Recordset13 = mysqli_fetch_assoc($Recordset13);
$totalRows_Recordset13 = mysqli_num_rows($Recordset13);


}


        $factordehembra=100;
        $factordemacho=100;
        if($factordehembra==0){
          $factordehembra=100;
      }
      if($factordemacho==0){
          $factordemacho=100;
      }


    $query_Recordset1 = sprintf(
      "/* PARSEADORES1 Venta_Animalitos\Atreportejugadas_admin.php - QUERY 5 */ SELECT 
    *
    
    FROM
    ani5_jugadas
    WHERE
    
    num_ticket_ani5 = %s   ORDER BY linea_ticket_ani5 DESC
    ",
      GetSQLValueString($row_Recordset13['num_ticket_ani5'], "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $premio=0;

    



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
<div class="container">
<div class="header" style="height:100px; background:#0084B4">
		<?php include("../includes/cabeceraamericana.php");?>
		<div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
			<div class="triangulo_sup" style=" margin:0px 0px 0px 205px"></div>
			<div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
				position:absolute;border-radius: 0px 0px 5px 5px;">
				<?php include("../includes/cabecera_lot.php");?>
			</div>
		</div> <!-- end .menu -->
	</div> <!-- end .header -->
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off"  
onsubmit="return chequearEnvio();">

<input name="fecha_inicio" id="datepicker" width="276" value="<?php echo htmlentities($inicio, ENT_COMPAT, 'utf-8'); ?>" />
    <script>
        $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4',
            dateFormat: 'yyyy-mm-dd'
        });
    </script>
    <input name="fecha_fin" id="datepicker2" width="276" value="<?php echo htmlentities($final, ENT_COMPAT, 'utf-8'); ?>" />
    <script>
        $('#datepicker2').datepicker({
            uiLibrary: 'bootstrap4'            ,
            dateFormat: 'yyyy-mm-dd'
        });
    </script>
                    <input type="submit" value="Buscar" class="btn-warning" title="iniciar busqueda" onClick="return enviado()"
                 style="width:80px; height:40px"/><br><br>

</form>  
<!-- Begin page content -->


  <hr>
  <div class="row">
    <div class="col-12 col-md-12  table-responsive "> 
      <!-- Contenido -->
      
      <table class="table">
        <thead class="thead-dark">
          <tr>

            <th scope="col"># Ticket Fecha</th>
            <th scope="col">Descripcion</th>
            <th scope="col">Monto Apuesta<br/>Ticket</th>
            <th scope="col"> </th>
            <th scope="col"> </th>

          </tr>
        </thead>
        <tbody>
          <?php
if ($totalRows_Recordset13>=1) {

  $ganadorodevolucion=0;
    do {

        $query_Recordset18 = sprintf(
            "/* PARSEADORES1 Venta_Animalitos\Atreportejugadas_admin.php - QUERY 6 */ SELECT 
            ta.cod_taquilla, ta.nom_taquilla, ta.cod_agencia, ag.cod_agencia, ag.nom_agencia, ag.cod_banca,
            ba.cod_banca, ba.nom_banca, us.nom_usuario, us.cod_taquilla
            FROM
            taquilla ta, agencia ag, banca ba, usuario us
           WHERE
           ta.cod_taquilla = %s AND ag.cod_agencia = ta.cod_agencia AND ba.cod_banca = ag.cod_banca AND us.cod_taquilla = ta.cod_taquilla",
            GetSQLValueString($row_Recordset13['cod_taquilla_ani5'], "int"));
                    $Recordset18= mysqli_query($conexionbanca, $query_Recordset18) or die(mysqli_error($conexionbanca));
                    $row_Recordset18 = mysqli_fetch_assoc($Recordset18);
                    $totalRows_Recordset18 = mysqli_num_rows($Recordset18);


        ?>
          <tr>

            <td>
<a data-toggle="modal" data-target="#exampleModal" href="ATdetalle_ticket.php" title="" 
onclick="detalle_ticket(<?php echo $row_Recordset13['num_ticket_ani5']; ?>, 0, 3); return false">
Nro	: <?php echo $row_Recordset13['can_ticket_ani5']; ?> <br/>
Ticket #:<?php echo $row_Recordset13['num_ticket_ani5']; ?> <br/>
Fecha: <?php
echo substr($row_Recordset13['fechahora_creacion_ani5'], 0, -9); //2020-09-25?> <br/>
Hora: <?php $nuevahora1 = strtotime('+6 hour', strtotime($row_Recordset13['fechahora_creacion_ani5']));
        $nuevahora1 = date('Y-m-j H:i:s', $nuevahora1);
        echo date("g:ia", strtotime($nuevahora1)); ?><br/>
        Taquilla: <?php echo $row_Recordset18['nom_taquilla']; ?>
</a></br>
			<?php
?>
			
			
			</td>
            <td>
            <a data-toggle="modal" data-target="#exampleModal" href="ATdetalle_ticket.php" title="" 
onclick="detalle_ticket(<?php echo $row_Recordset13['num_ticket_ani5']; ?>, 0, 3); return false"><?php
            
            
            echo ' ';
        $query_Recordset14 = sprintf(
            "/* PARSEADORES1 Venta_Animalitos\Atreportejugadas_admin.php - QUERY 7 */ SELECT *
                FROM ani5_jugadas, ani4_solteos
                WHERE
                ani5_jugadas.num_ticket_ani5 = %s AND
                ani5_jugadas.id_solteo_ani5 = ani4_solteos.id_solteo_ani4",
            GetSQLValueString($row_Recordset13['num_ticket_ani5'], "int")
        );
        $Recordset14 = mysqli_query($conexionbanca, $query_Recordset14) or die(mysqli_error($conexionbanca));
        $row_Recordset14 = mysqli_fetch_assoc($Recordset14);
        $totalRows_Recordset14 = mysqli_num_rows($Recordset14);
        $estadoticket=0;
        $estadoticketd=0;
        $estadoticketg=0;
        $estadoticketgg=0;
        $estadoticketp=0;
        $totalapostadoenticket=0;
        $Eliminada=0;
        $yacancelado=0;
        $estadojugada_ani5_sihayganadora=0;
        $yacerrada=0;
        do {

          $horaTxt=horaactual();
$FechaTxt=fechaactualbd();
          $datetime=$FechaTxt.' '.$horaTxt;
          $datetime2 = strtotime('+6 hour', strtotime($datetime));
          $datetime2 = $datetime2;
          $datetime2 = date('Y-m-d H:i:s', $datetime2);
          //echo $datetime2.$row_Recordset14['fechahora_solteo_ani4'].' 1111<br>';

if($row_Recordset14['fechahora_solteo_ani4']<$datetime2){$yacerrada=1;
  //echo $datetime2.$row_Recordset14['fechahora_solteo_ani4'].' 2222<br>';


}



foreach ($dir as $clave) { 
if($clave['id_Loterias_y_nombres_ani1']==$row_Recordset14['id_loteria_ani5']){ echo $clave['nom_Loterias_y_nombres_ani1'].' -- '; 
$claveexp=explode(',', $clave['animales_Loterias_y_nombres_ani1']);
foreach ($claveexp as $claveexp2) { 
$claveexp3=explode('.', $claveexp2);
if($claveexp3[0]==$row_Recordset14['id_animalito_ani5']){  echo $claveexp3[2].' -- ';  }}}
}


        foreach ($dir_solteos as $clave_solteos) { 
if($clave_solteos['id_solteo_ani4']==$row_Recordset14['id_solteo_ani5']){


$clave_solteos_fechahora_solteo_ani4 = date("h:i A", strtotime($clave_solteos['fechahora_solteo_ani4']));
echo $clave_solteos_fechahora_solteo_ani4.' -- ';
}
        }

          //echo 'id_solteo_ani5='.$row_Recordset14['id_solteo_ani5'].' -- ';



          echo $row_Recordset14['mon_venta_ani5'].' ';
          $totalapostadoenticket=$totalapostadoenticket+$row_Recordset14['mon_venta_ani5'];
          if ($row_Recordset13['moneda_ani5']==0) {echo ' BSS';}
          if ($row_Recordset13['moneda_ani5']==1) {echo ' BSS';}
          if ($row_Recordset13['moneda_ani5']==2) {echo ' BSS';}
          if ($row_Recordset13['moneda_ani5']==3) {echo ' USD';}
          if ($row_Recordset13['moneda_ani5']==4) {echo ' COP';}
          if ($row_Recordset13['moneda_ani5']==5) {echo ' SOL';} 
          if ($row_Recordset13['moneda_ani5']==12) {echo ' USD';}

          echo ' -- ';









            # code...
            if ($row_Recordset14['estadojugada_ani5']==0) {
                echo 'Pendiente';
                $estadoticketp=1;
                
            }
            if ($row_Recordset14['estadojugada_ani5']==1) {
                echo 'Gano';
                $estadoticketg=1;
                $estadojugada_ani5_sihayganadora=1;
                $ganadorodevolucion=1;
            }
            if ($row_Recordset14['estadojugada_ani5']==2) {
                echo 'Perdio';
                $estadoticket=1;
            }
            if ($row_Recordset14['estadojugada_ani5']==3) {
                echo 'Devolucion';
                $estadoticketd=1;
                $ganadorodevolucion=1;
            }
            if ($row_Recordset14['estadojugada_ani5']==4) {
              echo 'Eliminada';
              $estadoticketd=1;
              $ganadorodevolucion=1;
              $Eliminada=1;
          }
          if ($row_Recordset14['estadojugada_ani5']==5) {
            echo 'Ganador ya cancelado ';
            echo ' Premio= '.$row_Recordset14['mon_pago_ani5'];
            if ($row_Recordset14['moneda_ani5']==0) {echo ' BSS';}
if ($row_Recordset14['moneda_ani5']==1) {echo ' BSS';}
if ($row_Recordset14['moneda_ani5']==2) {echo ' BSS';}
if ($row_Recordset14['moneda_ani5']==3) {echo ' USD';}
if ($row_Recordset14['moneda_ani5']==4) {echo ' COP';}
if ($row_Recordset14['moneda_ani5']==5) {echo ' SOL';}

            $estadoticketd=1;
            $yacancelado=1;
        }
        if ($row_Recordset14['estadojugada_ani5']==6) {
          echo 'Devolucion ya cancelada';
          $estadoticketd=1;
          $yacancelado=1;
      }

            echo '</br>';
        } while ($row_Recordset14 = mysqli_fetch_assoc($Recordset14)); ?></a></td>

<td><a data-toggle="modal" data-target="#exampleModal" href="ATdetalle_ticket.php" title="" 
onclick="detalle_ticket(<?php echo $row_Recordset13['num_ticket_ani5']; ?>, 0, 3); return false"><?php
                            $query_Recordset135 = sprintf(
                                "/* PARSEADORES1 Venta_Animalitos\Atreportejugadas_admin.php - QUERY 8 */ SELECT *
					FROM usuario, ani5_jugadas
					WHERE
          ani5_jugadas.fechahora_creacion_ani5 >= %s AND 
          ani5_jugadas.fechahora_creacion_ani5 <= %s  AND
					usuario.id_usuario = %s    AND 
          ani5_jugadas.id_usuario_ani5= %s AND 
          ani5_jugadas.num_ticket_ani5= %s AND 
          ani5_jugadas.linea_ticket_ani5= 1 ORDER BY ani5_jugadas.num_ticket_ani5 DESC",
                               
                               GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
                               GetSQLValueString($_SESSION['MM_id_usuario'], "int"),
                                GetSQLValueString($_SESSION['MM_id_usuario'], "int"),
                                GetSQLValueString($row_Recordset13['num_ticket_ani5'], "int"));
    $Recordset135 = mysqli_query($conexionbanca, $query_Recordset135) or die(mysqli_error($conexionbanca));
    $row_Recordset135 = mysqli_fetch_assoc($Recordset135);
    $totalRows_Recordset135 = mysqli_num_rows($Recordset135);





    echo $totalapostadoenticket;
    if ($row_Recordset13['moneda_ani5']==0) {echo ' BSS';}
if ($row_Recordset13['moneda_ani5']==1) {echo ' BSS';}
if ($row_Recordset13['moneda_ani5']==2) {echo ' BSS';}
if ($row_Recordset13['moneda_ani5']==3) {echo ' USD';}
if ($row_Recordset13['moneda_ani5']==4) {echo ' COP';}
if ($row_Recordset13['moneda_ani5']==5) {echo ' SOL';}
 ?>
</a></td>


<td>
<?php



$datetime7 = strtotime('+0 hour', strtotime($row_Recordset135['fechahora_creacion_ani5']));
$datetime7 = $datetime7;
$datetime7 = date('Y-m-d H:i:s', $datetime7);
//echo $datetime7.' >= '.$datetime.' 1111<br>';





?>

</td>
<td>
<?php


          

          ?>

</td>

      <td>

      <?php


$query_Recordset1 = sprintf(
  "/* PARSEADORES1 Venta_Animalitos\Atreportejugadas_admin.php - QUERY 9 */ SELECT 
*

FROM
ani5_jugadas
WHERE

num_ticket_ani5 = %s   ORDER BY linea_ticket_ani5 DESC
",
  GetSQLValueString($row_Recordset13['num_ticket_ani5'], "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$premio=0;

      
          
          ?>




      </td>



      <td>



         
          </tr>
          <?php
          $ganadorodevolucion=0;
    } while ($row_Recordset13 = mysqli_fetch_assoc($Recordset13));
}





?>
        </tbody>
      </table>
      
      <!-- Fin Contenido --> 
    </div>
  </div>
  <!-- Fin row --> 
  
</div>
<script>
    function detalle_ticket(nticket, jtipo, modulo){
        $.post("ATdetalle_ticket.php", 
        {
		nticket:nticket,
		jtipo:jtipo,
		modulo:modulo
		},
        function(eData){				
            $("#dialog-message").html(eData);
        });	
    } 
</script>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detalle</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
          <div id="dialog-message"></div>
      </div>
      <div class="modal-footer">
        
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div> 



<!-- Pagar Ticket -->
<script>
    function detalle_ticket2(id_ticket_ani5, num_ticket_ani5, tmodificacion){
        $.post("ATreportejugadas_pagos2.php", 
        {
          id_ticket_ani5:id_ticket_ani5,
          num_ticket_ani5:num_ticket_ani5,
		tmodificacion:tmodificacion
		},
        function(eData){				
            $("#dialog-message").html(eData);
        });	
    } 
</script>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pago De apuesta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
          <div id="dialog-message"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div> 
<!-- Fin Pagar Ticket -->


<!-- Fin container -->


<!-- Bootstrap core JavaScript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 

<script src="../js/bootstrap4.js"></script>
</body>
</html>
