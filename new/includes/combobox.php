<?php
require_once('../Connections/conexionbanca.php');
if ($_GET['buscar']=="hijos") {
    global $conexionbanca;
    $consulta = sprintf("/* PARSEADORES1 new\includes\combobox.php - QUERY 1 */ SELECT * FROM taquilla WHERE taquilla.cod_agencia = %s order by nom_taquilla", $_GET["idpadre"]);
    
    mysql_select_db($database_conexionbanca);
    $result = mysqli_query($conexionbanca, $consulta);
    // Comienzo a imprimir el select
    $registro=mysql_fetch_array($result);
    echo "<label>Hijo:</label><select name='idhijo' id='idhijo'>";
    echo "<option value=''>Seleccione taquilla...</option>";
    while ($registro=mysql_fetch_array($result)) {
        echo "<option value='".$registro["cod_taquilla"]."'>".utf8_encode($registro["nom_taquilla"])."</option>\r\n";
    }
    echo "</select>";
}

if ($_GET['buscar']=="nietos") {
    global $conexionbanca;
    $consulta="/* PARSEADORES1 new\includes\combobox.php - QUERY 2 */ SELECT * FROM usuario WHERE cod_taquilla='".mysql_real_escape_string(intval($_GET['idhijo']))."' order by nom_usuario";
    mysql_select_db($database_conexionbanca);
    $todos=mysqli_query($conexionbanca, $consulta);
    
    // Comienzo a imprimir el select
    echo "<label>Nieto:</label><select name='idnieto' id='idnieto'>";
    echo "<option value=''>Seleccione vendedor...</option>";
    while ($registro=mysql_fetch_array($todos)) {
        // Convierto los caracteres conflictivos a sus entidades HTML correspondientes para su correcta visualizacion
        // Imprimo las opciones del select
        echo "<option value='".$registro["id_usuario"]."'>".$registro["nom_usuario"]."</option>\r\n";
    }
    echo "</select>";
}
