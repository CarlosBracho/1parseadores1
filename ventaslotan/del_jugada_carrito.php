<?php
include("../includes/libreria.php");
require_once('../Connections/conexionbanca.php');
if (isset($_POST["id"])) {
    $varjugada = $_POST["id"];
    $_SESSION['ocarritoAni']->elimina_jugada($varjugada);
    $_SESSION['MM_montoAni']=$_SESSION["ocarritoAni"]->imprime_carrito();
}
