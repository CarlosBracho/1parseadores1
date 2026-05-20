<?php
if (!isset($_SESSION)) {
    session_start();
} include("../includes/funciones.php");
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>.:Apuestas:.</title>


<link rel="stylesheet" href="../bootstrap4.5.0/css/bootstrap.min.css">
 <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
 <script src="../bootstrap4.5.0/js/bootstrap.min.js"></script>
 
<script src="../js/jquery-3.5.1.min.js"></script>
    <title>.:Apuestas:.</title>
	<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
	<script type="text/javascript">
 $(document).ready(function() {
	 $("#saldocliente").load('saldocliente.php?&js='+Math.random());
	 var refreshId6 = setInterval(function() {
	 	saldocli();
	 }, 30000);

});
</script>
</head>







<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#"><span id="saldocliente"></span></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="../cliente/internacionalesc.php">Apostar Hipismo Internacional<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="dropdown-item" href="../cliente/reportec.php">Reporte General</a>
      </li>
	  	        <li class="nav-item">
         <a class="dropdown-item" href="../cliente/dividendosyretirados.php">Dividendos y Retirados</a>
      </li>
	  	        <li class="nav-item">
         <a class="dropdown-item" href="retrospectosc.php">Retrospectos</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../cliente/cerrar_sesion_cliente.php">Salir</a>
      </li>
    </ul>

  </div>
</nav>
	
    <?php
    $the_file_array = array();
    $dir = "./";
    $handle = opendir('./');
    while (false !== ($file = readdir($handle))) {
        if (filetype($file) == "file" && (fnmatch("*.PDF", strtoupper($file)))) {
            $the_file_array[] = $file;
        }
    }
    closedir($handle);
    sort($the_file_array);
    reset($the_file_array);
    while (list($key, $val) = each($the_file_array)) {
        $largo = strlen($val);
        echo '<div style="font-size:16px;width:600px; text-align:left; padding:5px 0px 1px 50px">';
        echo '<a href="'.$val.'" target="_blank">'.substr($val, 0, $largo-4).'</a>';
        echo '</div>';
    }
    ?> 
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>

</body>
</html>