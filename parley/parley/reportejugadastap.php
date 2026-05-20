<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
if (!isset($_SESSION['MM_id_usuario'])) {
    $id_usuarioO=$_SESSION['MM_id_usuario'];
} else {
    $id_usuarioO=0;
}
                            $query_Recordset13 = sprintf(
                                "/* PARSEADORES1 parley\parley\reportejugadastap.php - QUERY 1 */ SELECT *
					FROM usuario, p4jugadas
					WHERE
					usuario.id_usuario = %s
          AND p4jugadas.id_usuariop4= %s AND p4jugadas.lineatp4= 1 ORDER BY p4jugadas.nticketp4 DESC",
                                GetSQLValueString($_SESSION['MM_id_usuario'], "int"),
                                GetSQLValueString($_SESSION['MM_id_usuario'], "int")
                            );
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
<link href="../css/bootstrap4.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<script src="../js/jquery-3.5.1.min.js"></script>

</head>

<body>
<header> 
  <!-- Fixed navbar -->
  <?php include('../parley/menutap.php'); ?>
</header>

<!-- Begin page content -->

<div class="container">
  <hr>
  <div class="row">
    <div class="col-12 col-md-12"> 
      <!-- Contenido -->
      
      <table class="table">
        <thead class="thead-dark">
          <tr>

            <th scope="col"># Ticket Fecha</th>
            <th scope="col">Descripcion</th>
            <th scope="col">Estado</th>
            <th scope="col">Monto Apuesta</th>

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
            "/* PARSEADORES1 parley\parley\reportejugadastap.php - QUERY 2 */ SELECT *
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
        if ($row_Recordset13['monedap4']==0) {
            echo ' BSS';
        }
        if ($row_Recordset13['monedap4']==1) {
            echo ' BSS';
        }
        if ($row_Recordset13['monedap4']==2) {
            echo ' BSS';
        }
        if ($row_Recordset13['monedap4']==3) {
            echo ' USD';
        }
        if ($row_Recordset13['monedap4']==4) {
            echo ' COP';
        }
        if ($row_Recordset13['monedap4']==5) {
            echo ' SOL';
        } ?>
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
        $.post("../parley/detalle_ticket.php", 
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
<!-- Fin container -->


<!-- Bootstrap core JavaScript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 

<script src="../js/bootstrap4.min.js"></script>
</body>
</html>
