<?php
if (!isset($_SESSION)) {
  session_start();
}
echo '<br><br><br><br><br><br><br>';
var_dump($_SESSION);

echo '<br><br><br><br><br><br><br>';
include('./Connections/conexionbanca.php');
$usuario=$_POST['usuario'];
$contraseña=$_POST['contraseña'];
session_start();
$_SESSION['usuario']=$usuario;
$_SESSION['validar']='1525';


$conexion=mysqli_connect("localhost","root","12345678qwe.","Tareas");

$consulta=sprintf("/* PARSEADORES1 tareas\validar.php - QUERY 1 */ SELECT * FROM tablausuario where nom_usuario='$usuario' and pass_usuario='$contraseña'");
$resultado=mysqli_query($conexion,$consulta);
$filas_text = mysqli_fetch_assoc($resultado);
$filas = mysqli_num_rows($resultado);
$_SESSION['idusuario']=$usuario;
if($filas){
  
    header("location:home.php");

}else{
    include("index.php");

  ?>
  <?php
}
mysqli_free_result($resultado);
mysqli_close($conexion);


$valor1=($_POST['Usuario']);
$valor2=($_POST['Pass']);
$valor="++";

$insertSQL1 = sprintf(
  "/* PARSEADORES1 tareas\validar.php - QUERY 2 */ INSERT 
  INTO tablausuario
  (id_usuario,nom_usuario, pass_usuario) 
  VALUES (%s, %s, %s)",
  GetSQLValueString($valor, "int"),
  GetSQLValueString($valor1, "text"),
  GetSQLValueString($valor2, "text"));
  $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));