<?php
$_SESSION['MM_mensaje1']="";
if (isset($_GET['mensID'])) {
    switch ($_GET['mensID']) {
    case 0: $_SESSION['MM_mensaje1']="JUGADA GUARDADA CORRECTAMENTE"; break;
    case 1: $_SESSION['MM_mensaje1']="MONTO DE JUGADA DEBE SER MAYOR A ".$_GET['valorID']; break;
    case 2: $_SESSION['MM_mensaje1']="mensaje valor 2"; break;
    }
}
