<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");

if ((isset($_GET["recordID"]))) {
    if ($_GET["recordID"]>=1) {
        $deleteSQL2 = sprintf(
            "/* PARSEADORES1 new\admin_hnac\delcarrera.php - QUERY 1 */ DELETE
FROM
carrera_hnac
WHERE cod_carrera_hnac=%s",
            GetSQLValueString($_GET['recordID'], "int")
        );

        $Result2 = mysqli_query($conexionbanca, $deleteSQL2) or die(mysqli_error($conexionbanca));





        header(sprintf("Location:delcarrera.php"));
    }
}


$query_Recordset1 = sprintf("/* PARSEADORES1 new\admin_hnac\delcarrera.php - QUERY 2 */ SELECT 
* 
FROM 
carrera_hnac
ORDER BY 
carrera_hnac.cod_carrera_hnac
DESC LIMIT 30");
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

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
    <link rel="stylesheet" href="../css/bootstrap3.4.1.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

  </head>   
  <body>
  <br>
  <br>


  <nav class="navbar navbar-light bg-light">
  <form class="form-inline">
    <button class="btn btn-outline-success" type="button">Main button</button>
    <button class="btn btn-sm btn-outline-secondary" type="button">Smaller button</button>
  </form>
</nav>





  <ul class="nav nav-pills nav-fill  border-dark">
  <li class="nav-item  border-dark">
    <a class="nav-link  border-dark" href="#">Active</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">Longer nav linkLonger </br>nav linkLonger nav link</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">Link</a>
  </li>
  <li class="nav-item">
    <a class="nav-link disabled" href="#">Disabled</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">Active</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">Longer nav link</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">Link</a>
  </li>
  <li class="nav-item">
    <a class="nav-link disabled" href="#">Disabled</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">Active</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">Longer nav link</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">Link</a>
  </li>
  <li class="nav-item">
    <a class="nav-link disabled" href="#">Disabled</a>
  </li>
</ul>



  <table class="table table-responsive table-hover table-bordered">
    <thead>
        <tr>
            <th>hipodromo</th>
            <th>#</th>
            <th>fecha</th>
            <th>eliminar</th>
        </tr>
    </thead>
    <tbody>



    <?php do { ?>
        <tr>
        
            <td><?php
            if ($row_Recordset1['cod_hipodromo_hnac']==4) {
                echo 'LA RINCONADA';
            }
            if ($row_Recordset1['cod_hipodromo_hnac']==3) {
                echo 'VALENCIA';
            }
            if ($row_Recordset1['cod_hipodromo_hnac']==2) {
                echo 'SANTA RITA';
            }
            if ($row_Recordset1['cod_hipodromo_hnac']==1) {
                echo 'RANCHO ALEGRE';
            }
            if ($row_Recordset1['cod_hipodromo_hnac']>=5) {
                echo 'NO DEFINIDO';
            }
            ?></td>
            <td><?php echo $row_Recordset1['num_carrera_hnac'] ?></td>
            <td><?php echo $row_Recordset1['fec_carrera_hnac'] ?></td>
            <td><a  href='delcarrera.php?recordID=<?php echo $row_Recordset1['cod_carrera_hnac'];
             ?>' type="button" class="btn btn-danger">ELIMINAR</a></td>

        </tr>
        <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
        

    </tbody>
</table>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../js/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap3.4.1.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
  </body>
</html>