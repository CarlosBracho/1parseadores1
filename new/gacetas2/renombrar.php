<?php
$viejonombre=$_GET["viejonombre"];
$nuevonombre=trim($_GET["nuevonombre"]);
rename("/home/apuestas/public_html/gacetas/".$viejonombre, "/home/apuestas/public_html/gacetas/".trim($nuevonombre).".pdf");
header("Location: /gacetas/gacetascontrol.php");
