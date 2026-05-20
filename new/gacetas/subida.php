<?php
$subida=$_GET["subida"];
exec("wget ".$subida);
header("Location: /gacetas/gacetascontrol.php");
