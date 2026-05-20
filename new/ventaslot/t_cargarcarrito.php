<?php
include("../includes/libreria.php");
require_once('../Connections/conexionbanca.php');
$_SESSION['MM_monto']=$_SESSION["ocarrito"]->imprime_carrito();
