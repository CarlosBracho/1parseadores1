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

$query_Recordset1b = sprintf(
    "/* PARSEADORES1 parley\presultados.php - QUERY 1 */ SELECT * FROM p5resultadosj WHERE 
deportep5 = %s AND 
iniciodtp5 >= %s AND
iniciodtp5 <= %s AND
equipo1p5 > ' ' AND
equipo2p5 > ' '
ORDER BY iniciodtp5 
DESC",
    GetSQLValueString("beisbol", "text"),
    GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"));
    $Recordset1b = mysqli_query($conexionbanca, $query_Recordset1b) or die(mysqli_error($conexionbanca));
    $row_Recordset1b = mysqli_fetch_assoc($Recordset1b);
    $totalRows_Recordset1b = mysqli_num_rows($Recordset1b);

    
    
    
    
$query_Recordset1baloncesto = sprintf(
    "/* PARSEADORES1 parley\presultados.php - QUERY 2 */ SELECT * FROM p5resultadosj WHERE 
deportep5 = %s AND 
iniciodtp5 >= %s AND
iniciodtp5 <= %s AND
equipo1p5 > ' ' AND
equipo2p5 > ' '
ORDER BY iniciodtp5 
DESC",
    GetSQLValueString("baloncesto", "text"),
    GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"));
$Recordset1baloncesto = mysqli_query($conexionbanca, $query_Recordset1baloncesto) or die(mysqli_error($conexionbanca));
$row_Recordset1baloncesto = mysqli_fetch_assoc($Recordset1baloncesto);
$totalRows_Recordset1baloncesto = mysqli_num_rows($Recordset1baloncesto);

$query_Recordset1futbol = sprintf(
    "/* PARSEADORES1 parley\presultados.php - QUERY 3 */ SELECT * FROM p5resultadosj WHERE 
deportep5 = %s AND 
iniciodtp5 >= %s AND
iniciodtp5 <= %s AND
equipo1p5 > ' ' AND
equipo2p5 > ' '
ORDER BY iniciodtp5 
DESC
",
    GetSQLValueString("futbol", "text"),
    GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"));
$Recordset1futbol = mysqli_query($conexionbanca, $query_Recordset1futbol) or die(mysqli_error($conexionbanca));
$row_Recordset1futbol = mysqli_fetch_assoc($Recordset1futbol);
$totalRows_Recordset1futbol = mysqli_num_rows($Recordset1futbol);

$query_Recordset1hockey = sprintf(
    "/* PARSEADORES1 parley\presultados.php - QUERY 4 */ SELECT * FROM p5resultadosj WHERE 
deportep5 = %s AND 
iniciodtp5 >= %s AND
iniciodtp5 <= %s AND
equipo1p5 > ' ' AND
equipo1p5 > ' '
ORDER BY iniciodtp5",
    GetSQLValueString("hockey", "text"),
    GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"));
$Recordset1hockey = mysqli_query($conexionbanca, $query_Recordset1hockey) or die(mysqli_error($conexionbanca));
$row_Recordset1hockey = mysqli_fetch_assoc($Recordset1hockey);
$totalRows_Recordset1hockey = mysqli_num_rows($Recordset1hockey);

$query_Recordset1futbolame = sprintf(
    "/* PARSEADORES1 parley\presultados.php - QUERY 5 */ SELECT * FROM p5resultadosj WHERE 
deportep5 = %s AND 
iniciodtp5 >= %s AND
iniciodtp5 <= %s AND
equipo1p5 > ' ' AND
equipo2p5 > ' '
ORDER BY iniciodtp5 
DESC",
    GetSQLValueString("futbolamericano", "text"),
    GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"));
$Recordset1futbolame = mysqli_query($conexionbanca, $query_Recordset1futbolame) or die(mysqli_error($conexionbanca));
$row_Recordset1futbolame = mysqli_fetch_assoc($Recordset1futbolame);
$totalRows_Recordset1futbolame = mysqli_num_rows($Recordset1futbolame);





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
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off" onsubmit="return chequearEnvio();">

<input name="fecha_inicio" id="datepicker" width="276" value="<?php echo htmlentities($inicio, ENT_COMPAT, 'utf-8'); ?>" />
    <script>
        $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4',
            dateFormat: 'yyyy-mm-dd'
        });
    </script>

                    <input type="submit" value="Buscar" class="btn-warning" title="iniciar busqueda" onClick="return enviado()"
                 style="width:80px; height:40px"/>
</form>  

<br>
<div class="container-fluid">

<ul class="nav nav-tabs">
<li class="nav-item">
    <a class="nav-link active" data-toggle="tab"  href="#" id="show_all">Todo <?php echo $totalRows_Recordset1b+$totalRows_Recordset1baloncesto+$totalRows_Recordset1futbol+$totalRows_Recordset1futbolame+$totalRows_Recordset1hockey;?></a>
</li>
<li class="nav-item">
<a class="nav-link btn-outline-warning" data-toggle="tab" href="#beisbol"><i class="fa-solid fa-baseball-bat-ball"></i>Beisbol <?php echo $totalRows_Recordset1b;?></a>
</li>
<li class="nav-item">
<a class="nav-link btn-outline-primary" data-toggle="tab" href="#baloncesto"><i class="fa-solid fa-basketball"></i>Baloncesto <?php echo $totalRows_Recordset1baloncesto;?></a>
</li>
<li class="nav-item">
<a class="nav-link btn-outline-success" data-toggle="tab" href="#futbol"><i class="fa-solid fa-futbol"></i>Futbol <?php echo $totalRows_Recordset1futbol;?></a>
</li>
<li class="nav-item">
<a class="nav-link btn-outline-info" data-toggle="tab" href="#futbolamericano"><i class="fa-solid fa-football"></i>Futbol Americano <?php echo $totalRows_Recordset1futbolame;?></a>
</li>
<li class="nav-item">
<a class="nav-link btn-outline-danger" data-toggle="tab" href="#hockey"><i class="fa-solid fa-hockey-puck"></i>Hockey <?php echo $totalRows_Recordset1hockey;?></a>
</li>

</ul>
<div id="myTabContent" class="tab-content">
<div class="tab-pane fade active show" id="beisbol">
<?php if ($totalRows_Recordset1b>0) { ?>
<div class="card">
                    <div class="card-body border border-warning" style="padding: 0;">
                        <div class="row">
                            <div class="col-lg-12 mb-4 table-responsive">
<?php require_once('resultado_beisbol.php'); ?>
                             </div>
                        </div>
                    </div>
                </div>
                <?php
}?>

</div>
<div class="tab-pane fade" id="baloncesto">
<?php if ($totalRows_Recordset1baloncesto>0) { ?>
<div class="card">
                    <div class="card-body border border-primary" style="padding: 0;">
                        <div class="row">
                            <div class="col-lg-12 mb-4 table-responsive">
<?php require_once('resultado_baloncesto.php'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
}?>
              </div>
<div class="tab-pane fade" id="futbol">
<?php if ($totalRows_Recordset1futbol>0) { ?>
<div class="card">
                    <div class="card-body border border-success" style="padding: 0;">
                        <div class="row">
                            <div class="col-lg-12 mb-4 table-responsive">
<?php require_once('resultado_futbol.php'); ?>
                            </div>
                        </div>
                    </div>
                </div> 
                <?php
}?>
             </div>
<div class="tab-pane fade" id="futbolamericano">
<?php if ($totalRows_Recordset1futbolame>0) { ?>
<div class="card">
                    <div class="card-body border border-info" style="padding: 0;">
                        <div class="row">
                            <div class="col-lg-12 mb-4 table-responsive">
<?php require_once('resultado_futbolamericano.php'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
}?>
              </div>

              <div class="tab-pane fade" id="hockey">
              <?php if ($totalRows_Recordset1hockey>0) { ?>
<div class="card">
                    <div class="card-body border border-danger" style="padding: 0;">
                        <div class="row">
                            <div class="col-lg-12 mb-4 table-responsive">
<?php require_once('resultado_hockey.php'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
}?>
              </div>
</div>

<script>
      $(this).addClass("active").parent("li").siblings().find("a").removeClass("active");
  $(".tab-pane").removeClass("fade").addClass("active").addClass("show");
  console.log(this.hash);


$("#show_all").on("click", function() {
  //  alert("Texto a mostrar");
  $(this).addClass("active").parent("li").siblings().find("a").removeClass("active");
  $(".tab-pane").removeClass("fade").addClass("active").addClass("show");
});
$(".nav-link").not("#show_all").on("click", function() {
  console.log(this.hash);
  $(".tab-pane").not(this.hash).removeClass("active").removeClass("show");
});
    </script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js" integrity="sha512-yFjZbTYRCJodnuyGlsKamNE/LlEaEAxSUDe5+u61mV8zzqJVFOH7TnULE2/PP/l5vKWpUNnF4VGVkXh3MjgLsg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</div>


