<?php
//incluyo el código de la clase stoper
include_once('class.stoper.php');
//instancio un objeto de la clase stoper
$s = new Stoper();

echo 'Empiezo...<br>';
//ejecuto el método Start() para que el objeto stoper comience a contar el tiempo
$s->Start();
//////////////////////////////comienza///////////////////////////////////////
phpinfo();
//////////////////////////////termina//////////////////////////////////
//paro la cuenta del tiempo por el objeto stoper con el método Stop()
$s->Stop();

//acabo mostrando el tiempo total de ejecución del script
echo $s->showResult('Tiempo total de ejecución: ').'<br>';
$tiempo = $s->showResult(' ');

include("abre_conexion.php");
$_GRABAR_SQL = "/* PARSEADORES1 new\includes\tiempo.php - QUERY 1 */ INSERT INTO $tabla_db2 (tiempo) VALUES ('$tiempo')";
mysql_query($_GRABAR_SQL);
include("cierra_conexion.php");
