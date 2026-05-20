
<?php
 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("funciones.php");
//phpinfo()
$serverName = "45.79.218.157";
$connectionOptions = array(
    "database" => "EnterpriseAdminDB",
    "uid" => "s01",
    "pwd" => "Valeria2023*",
    "CharacterSet" => "UTF-8"
);

// Establishes the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);
if ($conn === false) {
    die(formatErrors(sqlsrv_errors()));
}

// Select Query
//$tsql = "SELECT count(*) FROM EnterpriseAdminDB.dbo.inventario";
//$tsql = "SELECT * FROM EnterpriseAdminDB.dbo.SAPROD";
//$tsql = "SELECT CodProd,Descrip,Precio1,Precio2,Precio3 FROM EnterpriseAdminDB.dbo.SAPROD ORDER BY Descrip";
$tsql = "/* PARSEADORES1 catalogo\catalogo.php - QUERY 1 */ SELECT CodProd,Descrip,Precio1,Precio2,Precio3 FROM EnterpriseAdminDB.dbo.SAPROD ORDER BY Descrip ASC OFFSET 0 ROWS FETCH NEXT 500 ROWS ONLY";

// Executes the query
$stmt = sqlsrv_query($conn, $tsql);
$totalRows_stmt = sqlsrv_num_rows($stmt);
echo $totalRows_stmt.' totalRows_stmt<br>';
//$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
//$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
//$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
//$totaltotalRows=$totalRows_Recordset1;

$cantidaditem=0;
echo 'cantidaditem '.$cantidaditem.' totalRows_stmt '.$totalRows_stmt.'<br>';

//var_dump(sqlsrv_fetch_array($stmt));
echo '<br>';
while ($row = sqlsrv_fetch_array($stmt)) {
  $cantidaditem++;
  echo $cantidaditem.'<br>';
  echo 'CodProd1 '.$row["CodProd"].'<br>';
echo 'Descrip '.$row["Descrip"].'<br>';
  echo 'Precio1 '.$row["Precio1"].'<br>';
  echo 'Precio2 '.$row["Precio2"].'<br>';
  echo 'Precio3 '.$row["Precio3"].'<br>';

  echo '<br><br><br><br><br>';







}
/*
// Select Query
$tsql = "/* PARSEADORES1 catalogo\catalogo.php - QUERY 2 */ SELECT @@Version AS SQL_VERSION";

// Executes the query
$stmt = sqlsrv_query($conn, $tsql);

// Error handling
if ($stmt === false) {
    die(formatErrors(sqlsrv_errors()));
}
?>

<h1> Results : </h1>

<?php
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    echo $row['SQL_VERSION'] . PHP_EOL;
}

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);

function formatErrors($errors)
{
    // Display errors
    echo "Error information: <br/>";
    foreach ($errors as $error) {
        echo "SQLSTATE: ". $error['SQLSTATE'] . "<br/>";
        echo "Code: ". $error['code'] . "<br/>";
        echo "Message: ". $error['message'] . "<br/>";
    }
}

//phpinfo();


/*
$serverName = "45.79.218.157\MSSQLSERVER"; //serverName\instanceName
$connectionInfo = array( "Database"=>"EnterpriseAdminDB", "UID"=>"s01", "PWD"=>"Valeria2023*");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
     echo "Conexión establecida.<br />";
}else{
     echo "Conexión no se pudo establecer.<br />";
     die( print_r( sqlsrv_errors(), true));
}



$servername = "45.79.218.157";
$username = "s01";
$password = "Valeria2023*";
$dbname = "EnterpriseAdminDB";

// Create connection
$conn = sqlsrv_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . sqlsrv_errors());
}




/*


$hostname_conexionbanca = "p:localhost";
$database_conexionbanca = "catalogo";
$username_conexionbanca = "root";
$password_conexionbanca = "6C6eUvzfT4rI";
$conexionbanca = mysqli_connect($hostname_conexionbanca, $username_conexionbanca, $password_conexionbanca, $database_conexionbanca);
mysqli_set_charset($conexionbanca, 'utf8');


$query_Recordset1 = sprintf(
  "/* PARSEADORES1 catalogo\catalogo.php - QUERY 3 */ SELECT *
FROM item"
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$totaltotalRows=$totalRows_Recordset1;


?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>COLINA LUGO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link href="catalogo.css" rel="stylesheet"> 
</head>
  <body>
  <header> 
  <!-- Fixed navbar -->

</header>

<div class="container-fluid">
<div class="row text-center"> 
<img src="./tope.png" class="img-fluid" alt="..."  width="70" height="170">



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
  





<?php
$order9=1;
$order=10;
do {
  //echo $row_Recordset1['id_item'].'<br>';
  ?>

<div id="silverfox" class="col-sm-4 order-<?php echo $order?> table-responsive" >
<TABLE class="table" WIDTH="200" HEIGHT="180"  align="center" border="4">
<tr border="4">
<td colspan="2" style="font-size:20px;padding: 0; line-height: 55%;" align="center"  border="4">
<FONT SIZE=1 face="Arial"><strong><?php echo $row_Recordset1['nom_item1']?></strong></font><br>
<FONT SIZE=1 face="Arial"><strong><?php echo $row_Recordset1['nom_item2']?></strong></font><br>
<FONT SIZE=1 face="Arial" style="color:#FF0000";><strong>CÓDIGO:<?php echo $row_Recordset1['cod_item']?></strong></font>
</td>
</tr>
<tr border="4">
<td align="center"  colspan="2">

<?php 
$extencionimagen='';
if($row_Recordset1['tipo_img']==1){$extencionimagen='gif';}
if($row_Recordset1['tipo_img']==2){$extencionimagen='jpeg';}
if($row_Recordset1['tipo_img']==3){$extencionimagen='jpg';}
if($row_Recordset1['tipo_img']==4){$extencionimagen='png';}
if($row_Recordset1['tipo_img']==5){$extencionimagen='webp';}

$nombre_ficheroimg = 'catalogo_imagenes/'.$row_Recordset1['id_item'].'.'.$extencionimagen;

if (file_exists($nombre_ficheroimg)) {

  $archivoimg=$nombre_ficheroimg;

} else {

  $archivoimg='catalogo_imagenes/no_disponible.png';

}





?>

<div class="contenedorimagen"  >
<img  src="<?php echo $archivoimg; ?>" class="img-fluid  " alt="Responsive image" >
</div>
</td>
</tr>



<tr style="line-height: 70%;" >
<td colspan="2" class="bg-danger">
<FONT SIZE=1 face="Arial" style="color:#ffffff";><strong>(EMP.<?php echo $row_Recordset1['cantidad']?>UND)</strong></font>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<FONT SIZE=2 face="Arial"style="color:#000000";><strong>$<?php echo $row_Recordset1['precio']?></strong></font>
</td>
</tr>
</TABLE> 
</div>

<?php

if($order9==12){
  ?>

<br><p style="color:#ffffff";>.<br>.</p><br>


<div class="saltopagina"></div>

<img src="./tope.png" class="img-fluid" alt="..."  width="170" height="170">




  <?php
  $order9=0;
}



$order9++;
$order++;
} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
?>











</div></div>
</body>
</html>