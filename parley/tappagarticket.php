<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
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



$query_Recordset13 = sprintf(
"/* PARSEADORES1 parley\tappagarticket.php - QUERY 1 */ SELECT *
FROM usuario, p4jugadas
WHERE
p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s  AND  p4jugadas.premioapagarp4 > 0  AND p4jugadas.pverificado = 1  AND
usuario.id_usuario = %s
AND (p4jugadas.estadoticketp4=1 OR  p4jugadas.estadoticketp4=3)
AND p4jugadas.id_usuariop4= %s AND p4jugadas.lineatp4= 1 ORDER BY p4jugadas.nticketp4 DESC",
GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
GetSQLValueString($_SESSION['MM_id_usuario'], "int"),
GetSQLValueString($_SESSION['MM_id_usuario'], "int"));
$Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
$row_Recordset13 = mysqli_fetch_assoc($Recordset13);
$totalRows_Recordset13 = mysqli_num_rows($Recordset13);





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
  <?php include('../parley/menutap.php'); ?>
</header>
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
                 style="width:80px; height:40px"/>
</form>  
<!-- Begin page content -->

<div class="container">
  <hr>
  <div class="row">
    <div class="col-12 col-md-12 table-responsive"> 
      <!-- Contenido -->
      
      <table class="table">
        <thead class="thead-dark">
          <tr>

            <th scope="col"># Ticket Fecha</th>
            <th scope="col">Descripcion</th>
            <th scope="col">Estado</th>
            <th scope="col">Monto Apuesta<br/>Premio</th>
            

          </tr>
        </thead>
        <tbody>
          <?php
if ($totalRows_Recordset13>=1) {
    do {
        ?>
          <tr>

            <td>
<a data-toggle="modal" data-target="#exampleModal" href="detalle_ticket.php" title="" 
onclick="detalle_ticket(<?php echo $row_Recordset13['nticketp4']; ?>, 0, 2); return false">
Nro	: <?php echo $row_Recordset13['pcan_ticket']; ?> <br/>
Ticket #:<?php echo $row_Recordset13['nticketp4']; ?> <br/>
Fecha: <?php
echo substr($row_Recordset13['jugadadtp4'], 0, -9); //2020-09-25?> <br/>
Hora: <?php $nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($row_Recordset13['jugadadtp4']));
        $nuevahora1 = date('Y-m-j H:i:s', $nuevahora1);
        echo date("g:ia", strtotime($nuevahora1)); ?><br/>
</a></br>
			<?php
?>
			
			
			</td>
            <td>
            <a data-toggle="modal" data-target="#exampleModal" href="detalle_ticket.php" title="" 
onclick="detalle_ticket(<?php echo $row_Recordset13['nticketp4']; ?>, 0, 2); return false"><?php
            
            
            echo ' ';
        $query_Recordset14 = sprintf(
            "/* PARSEADORES1 parley\tappagarticket.php - QUERY 2 */ SELECT *
                FROM p4jugadas
                WHERE
         p4jugadas.nticketp4= %s ",
            GetSQLValueString($row_Recordset13['nticketp4'], "int")
        );
        $Recordset14 = mysqli_query($conexionbanca, $query_Recordset14) or die(mysqli_error($conexionbanca));
        $row_Recordset14 = mysqli_fetch_assoc($Recordset14);
        $totalRows_Recordset14 = mysqli_num_rows($Recordset14);
        $estadoticket=0;
        $estadoticketd=0;
        $estadoticketg=0;
        $estadoticketgg=0;
        $estadoticketp=0;
        do {
            # code...
            echo $row_Recordset14['tipojp4'].''.$row_Recordset14['ab_o_rlp4'].''.$row_Recordset14['equipop4'].''.$row_Recordset14['logrop4'].' ';
            if ($row_Recordset14['estadojugadap4']==0) {
                echo 'Pendiente';
                $estadoticketp=1;
            }
            if ($row_Recordset14['estadojugadap4']==1) {
                echo 'Gano';
                $estadoticketg=1;
            }
            if ($row_Recordset14['estadojugadap4']==2) {
                echo 'Perdio';
                $estadoticket=1;
            }
            if ($row_Recordset14['estadojugadap4']==3) {
                echo 'Devolucion';
                $estadoticketd=1;
            }
            echo '</br>';
        } while ($row_Recordset14 = mysqli_fetch_assoc($Recordset14)); ?></a></td>

<td><a data-toggle="modal" data-target="#exampleModal" href="detalle_ticket.php" title="" 
onclick="detalle_ticket(<?php echo $row_Recordset13['nticketp4']; ?>, 0, 2); return false"><?php
if ($estadoticket==1) {
            echo 'Perdio';
        }
if ($estadoticketg==1 && $estadoticket==0 && $estadoticketp==0) {
            echo 'Gano';
            $estadoticketgg=1;
        }
if ($estadoticketgg==0 && $estadoticket==0) {
            echo 'Pendiente';
        } ?>
</a></td>


<td>            <a data-toggle="modal" data-target="#exampleModal" href="detalle_ticket.php" title="" 
onclick="detalle_ticket(<?php echo $row_Recordset13['nticketp4']; ?>, 0, 2); return false"><?php echo $row_Recordset13['mon_ventap4'];
        if ($row_Recordset13['monedap4']==0) {echo ' BSS';}
        if ($row_Recordset13['monedap4']==1) {echo ' BSS';}
        if ($row_Recordset13['monedap4']==2) {echo ' BSS';}
        if ($row_Recordset13['monedap4']==3) {echo ' USD';}
        if ($row_Recordset13['monedap4']==4) {echo ' COP';}
        if ($row_Recordset13['monedap4']==5) {echo ' SOL';} ?>
<br/>
<?php if($row_Recordset13['premioapagarp4']>0){echo '-'.$row_Recordset13['premioapagarp4'];
if ($row_Recordset13['monedap4']==0) {echo ' BSS';}
if ($row_Recordset13['monedap4']==1) {echo ' BSS';}
if ($row_Recordset13['monedap4']==2) {echo ' BSS';}
if ($row_Recordset13['monedap4']==3) {echo ' USD';}
if ($row_Recordset13['monedap4']==4) {echo ' COP';}
if ($row_Recordset13['monedap4']==5) {echo ' SOL';}} ?>
			</a></td>

         
          </tr>
          <?php
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
        $.post("../parley/tappagarticket2.php", 
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
<!-- Fin container -->


<!-- Bootstrap core JavaScript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 

<script src="../js/bootstrap4.js"></script>
</body>
</html>
