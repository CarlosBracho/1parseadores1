<?php
$subida=$_GET["subida"];
echo $fichero;
exec("wget ".$subida);

header("Location: /gacetas2/gacetascontrol.php");
