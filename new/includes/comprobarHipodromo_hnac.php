<?php
sleep(1);
if ($_REQUEST) {
    $username = $_REQUEST['nom_taquilla'];
    require_once('../Connections/conexionbanca.php');
    $query = "/* PARSEADORES1 new\includes\comprobarHipodromo_hnac.php - QUERY 1 */ select nom_hipodromo_hnac from hipodromo_hnac where nom_hipodromo_hnac = '".strtolower($username)."'";
    $results = mysqli_query($conexionbanca, $query) or die('ok');
    if (mysqli_num_rows(@$results) > 0) {
        echo '<div style="color:#FF6666">No Disponible<br/></div>';
    }
}
