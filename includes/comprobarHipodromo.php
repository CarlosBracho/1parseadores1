<?php
sleep(1);
if ($_REQUEST) {
    $username = $_REQUEST['nom_taquilla'];
    require_once('../Connections/conexionbanca.php');
    $query = "/* PARSEADORES1 includes\comprobarHipodromo.php - QUERY 1 */ select nom_hipodromo from hipodromo where nom_hipodromo = '".strtolower($username)."'";
    $results = mysqli_query($conexionbanca, $query) or die('ok');
    if (mysqli_num_rows(@$results) > 0) {
        echo '<div style="color:#FF6666">No Disponible<br/></div>';
    }
}
