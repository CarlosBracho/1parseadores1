<?php
include("../includes/libreria.php");
require_once('../Connections/conexionbanca.php');
if (isset($_POST["id"])) {
    $varjugada = $_POST["id"];
    $_SESSION['ocarrito']->elimina_jugada($varjugada);
    $_SESSION['MM_monto']=$_SESSION["ocarrito"]->imprime_carrito();
}
