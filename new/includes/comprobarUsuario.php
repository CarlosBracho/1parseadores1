<?php
sleep(1);
if ($_REQUEST) {
    $username = $_REQUEST['username'];
    require_once('../Connections/conexionbanca.php');
    $query = "/* PARSEADORES1 new\includes\comprobarUsuario.php - QUERY 1 */ select * from usuario where nom_usuario = '".strtolower($username)."'";
    $results = mysqli_query($conexionbanca, $query) or die('ok');
    if (mysqli_num_rows(@$results) > 0) {
        echo '<div style="color:#C00">Usuario no disponible<br/></div>';
    }
}
?>


