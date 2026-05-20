<?php
// 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$hostname_conexionbanca = "p:localhost";
$database_conexionbanca = "catalogo";
$username_conexionbanca = "root";
$password_conexionbanca = "6C6eUvzfT4rI";
$conexionbanca = mysqli_connect($hostname_conexionbanca, $username_conexionbanca, $password_conexionbanca, $database_conexionbanca);
mysqli_set_charset($conexionbanca, 'utf8');
include("funciones.php");


//Si se quiere subir una imagen
if (isset($_POST['subir'])) {
  if (isset($_POST['cod_item'])) {
    if (isset($_POST['nom_item1'])) {
      if (isset($_POST['nom_item2'])) {
        if (isset($_POST['cantidad'])) {


          $_POST['precio']= str_replace(',', '.', $_POST['precio']);




   //Recogemos el archivo enviado por el formulario
   $archivo = $_FILES['archivo']['name'];
   //Si el archivo contiene algo y es diferente de vacio
   if (isset($archivo) && $archivo != "") {
      //Obtenemos algunos datos necesarios sobre el archivo
      $tipo = $_FILES['archivo']['type'];
      echo $tipo;
      $tamano = $_FILES['archivo']['size'];
      $temp = $_FILES['archivo']['tmp_name'];
      //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
      if ($tipo=="image/gif") {$tipo1='.gif'; $tipo_img=1;}   if ($tipo=="image/jpeg") {$tipo1='.jpeg'; $tipo_img=2;}   if ($tipo=="image/jpg") {$tipo1='.jpg'; $tipo_img=3;}  if ($tipo=="image/png") {$tipo1='.png'; $tipo_img=4;} if ($tipo=="image/webp") {$tipo1='.webp'; $tipo_img=5;}

      $insertSQL = sprintf(
        "/* PARSEADORES1 catalogo\catalogo_crear.php - QUERY 1 */ INSERT 
    INTO item
    (cod_item, tipo_img, nom_item1, nom_item2, cantidad, precio) 
    VALUES (%s, %s, %s, %s, %s, %s)",
    
    GetSQLValueString($_POST['cod_item'], "text"),
    GetSQLValueString($tipo_img, "int"),
    GetSQLValueString($_POST['nom_item1'], "text"),
    GetSQLValueString($_POST['nom_item2'], "text"),
    GetSQLValueString($_POST['cantidad'], "int"),
    GetSQLValueString($_POST['precio'], "double")
    );
    
    $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));


    $query_Recordset1 = "/* PARSEADORES1 catalogo\catalogo_crear.php - QUERY 2 */ SELECT MAX(id_item) FROM item";
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $numeroitem=((int)$row_Recordset1['MAX(id_item)']);





     if (!((strpos($tipo, "gif") || strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png") || strpos($tipo, "webp")) && ($tamano < 9999999))) {
        echo '<div><b>Error. La extensión o el tamaño de los archivos no es correcta.<br/>
        - Se permiten archivos .gif, .jpg, .png. y de 9999999 kb como máximo.</b></div>';
     }
     else {
        //Si la imagen es correcta en tamaño y tipo
        //Se intenta subir al servidor
        if (move_uploaded_file($temp, 'catalogo_imagenes/'.$numeroitem.$tipo1)) {
            //Cambiamos los permisos del archivo a 777 para poder modificarlo posteriormente
            chmod('catalogo_imagenes/'.$numeroitem.$tipo1, 0777);
            //Mostramos el mensaje de que se ha subido co éxito
            echo '<div><b>Se ha subido correctamente la imagen.</b></div>';
            //Mostramos la imagen subida
            echo '<p><img src="catalogo_imagenes/'.$numeroitem.$tipo1.'"></p>';
        }
        else {
           //Si no se ha podido subir la imagen, mostramos un mensaje de error
           echo '<div><b>Ocurrió algún error al subir el fichero. No pudo guardarse.</b></div>';
        }
      }
   }
}}}}}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
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
  
<form action="catalogo_crear.php" method="POST" enctype="multipart/form-data"/>


CODIGO PRODUCTO: <input type="text" name="cod_item"><BR>
LINEA 1: <input type="text" name="nom_item1"><BR>
LINEA 2: <input type="text" name="nom_item2"><BR>
PRECIO: <input type="text" name="precio"><BR>
CANTIDAD: <input type="text" name="cantidad"><BR>




Añadir imagen: <input name="archivo" id="archivo" type="file"/><BR>
<input type="submit" name="subir" value="Subir imagen"/>
</form>

</div></div>
</body>
</html>