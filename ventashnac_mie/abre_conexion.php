<?php
$hostname_conexionbanca = "p:localhost";
$database_conexionbanca = "tiempo";
$username_conexionbanca = "root";
$password_conexionbanca = "MARnGIGVwh4t";
$conexionbanca = mysqli_connect($hostname_conexionbanca, $username_conexionbanca, $password_conexionbanca, $database_conexionbanca);
mysqli_set_charset($conexionbanca, 'utf8');
if (is_file("includes/funciones.php")) {
    include("includes/funciones.php");
    include("includes/fecha.php");
} else {
    include("../includes/funciones.php");
    include("../includes/fecha.php");
}
