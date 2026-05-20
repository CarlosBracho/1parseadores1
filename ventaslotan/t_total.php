<?php
include("../includes/libreria.php");
include("../includes/funciones.php");
$_SESSION['MM_montoAni']=$_SESSION["ocarritoAni"]->sumar_carrito();
echo "Total: ";
echo number_format($_SESSION['MM_montoAni'], 2, ",", ".");
