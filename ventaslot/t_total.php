<?php
include("../includes/libreria.php");
include("../includes/funciones.php");
$_SESSION['MM_monto']=$_SESSION["ocarrito"]->sumar_carrito();
echo "Total: ";
echo number_format($_SESSION['MM_monto'], 2, ",", ".");
