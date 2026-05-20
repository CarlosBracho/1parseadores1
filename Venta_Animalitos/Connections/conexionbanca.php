<?php
$hostname_conexionbanca = "p:localhost";
$database_conexionbanca = "apuestas_con_animalitos";
$username_conexionbanca = "root";
$password_conexionbanca = "12345678qwe.";
$conexionbanca = mysqli_connect($hostname_conexionbanca, $username_conexionbanca, $password_conexionbanca, $database_conexionbanca);
mysqli_set_charset($conexionbanca, 'utf8');
if (is_file("includes/funciones.php")) {
    include("includes/funciones.php");
    include("includes/fecha.php");
}
if (is_file("../includes/funciones.php")) {
    include("../includes/funciones.php");
    include("../includes/fecha.php");
}
if (is_file("../../includes/funciones.php")) {
    include("../../includes/funciones.php");
    include("../../includes/fecha.php");
}
