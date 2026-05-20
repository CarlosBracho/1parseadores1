<?php
$hostname_conexionbanca = "p:172.233.161.9";
$database_conexionbanca = "apuestas";
$username_conexionbanca = "externo95";
$password_conexionbanca = "951029384756super";
$conexionbanca = mysqli_connect($hostname_conexionbanca, $username_conexionbanca, $password_conexionbanca, $database_conexionbanca);
mysqli_set_charset($conexionbanca, 'utf8');
if (is_file("includes/funciones.php")) {
    include("includes/funciones.php");
    include("includes/fecha.php");
}else{
if (is_file("../includes/funciones.php")) {
    include("../includes/funciones.php");
    include("../includes/fecha.php");
}else{

if (is_file("../../includes/funciones.php")) {
    include("../../includes/funciones.php");
    include("../../includes/fecha.php");
}
}//else2

}//else1