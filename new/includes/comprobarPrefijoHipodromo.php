<?php
sleep(1);
if ($_REQUEST) {
    $username = $_REQUEST['username'];
    require_once('../Connections/conexionbanca.php');
    $query = "/* PARSEADORES1 new\includes\comprobarPrefijoHipodromo.php - QUERY 1 */ select pre_hipodromo from hipodromo where pre_hipodromo = '".strtolower($username)."'";
    $results = mysqli_query($conexionbanca, $query) or die('ok');
    if (mysqli_num_rows(@$results) > 0) {
        echo '<div style="color:#C00">No disponible<br/></div>';
    }
}
?>


