<?php
require_once('../Connections/conexionbanca.php');

$query_Recordset1 = sprintf("/* PARSEADORES1 admin\cambiodeagente.php - QUERY 1 */ SELECT 
* 
FROM 
taquilla, agencia
WHERE
taquilla.cod_agencia=agencia.cod_agencia
ORDER BY 
agencia.nom_agencia");
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
//echo $totalRows_Recordset1;
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title></title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <br>
  <br>
  <br>
  <br>
  <table class="table table-responsive table-striped">
    <thead>
        <tr>
            <th>TAQUILLA</th>
            <th>AGENTE ACTUAL</th>
            <th>CAMBIAR A OTRO AGENTE</th>
            
        </tr>
    </thead>
    <tbody>

    <?php do { ?>
        <tr>
            <td><?php echo $row_Recordset1['nom_taquilla'] ?></td>
            <td><?php echo $row_Recordset1['nom_agencia'] ?></td>
            <td><a  href='cambiodeagente2.php?recordID=<?php echo $row_Recordset1['cod_taquilla']; ?>' type="button" class="btn btn-danger">CAMBIAR DE AGENTE</a></td>
        </tr>
        <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>

    </tbody>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
  </body>
</html>