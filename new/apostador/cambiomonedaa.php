<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "C"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
if (!isset($_SESSION['MM_id_usuario'])) {
    $id_usuarioO=$_SESSION['MM_id_usuario'];
} else {
    $id_usuarioO=0;
}
    $horaTxt=horaactual();
    $FechaTxt=fechaactualbd();

    
    $query_Recordset13 = sprintf(
        "/* PARSEADORES1 new\apostador\cambiomonedaa.php - QUERY 1 */ SELECT taquilla.cod_taquilla, taquilla.moneda , taquilla.nom_taquilla
					FROM usuario, taquilla
					WHERE
					taquilla.cod_taquilla = usuario.cod_taquilla AND
					usuario.id_usuario = %s",
        GetSQLValueString($_SESSION['MM_id_usuario'], "int")
    );
    $Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
    $row_Recordset13 = mysqli_fetch_assoc($Recordset13);
    $totalRows_Recordset13 = mysqli_num_rows($Recordset13);
    
    
    
    
    
    
    $editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if (isset($_POST['moneda'])) {
    $insertSQL2 = sprintf(
        "/* PARSEADORES1 new\apostador\cambiomonedaa.php - QUERY 2 */ UPDATE taquilla
					SET
					moneda=%s
					WHERE cod_taquilla=%s",
        GetSQLValueString($_POST['moneda'], "int"),
        GetSQLValueString($row_Recordset13['cod_taquilla'], "int")
    );
            
    $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
    
    $insertGoTo = "internacionalesa.php";

    header(sprintf("Location: %s", $insertGoTo));
}

    
    
    
    
    
    
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<title>.:Apuestas:.</title>

<!-- Bootstrap core CSS -->
<link href="../bootstrap4.5.0/css/bootstrap.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="assets/sticky-footer-navbar.css" rel="stylesheet">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
 <script src="../bootstrap4.5.0/js/bootstrap.min.js"></script>
<script>
var statusEnvio = false;
function chequearEnvio() {
    if (!statusEnvio) { statusEnvio = true;
        return true;
    } else { alert("El formulario ya está siendo enviado, por favor aguarde un instante.");
        return false;
    }
}


 $(document).ready(function() {
	 $("#ultimajugada").load('infoultimoa.php?&js='+Math.random());
	 var refreshId6 = setInterval(function() {
	 	infou();
	 }, 70000);
	 	 $("#ultimajugada5").load('infoultimoa5.php?&js='+Math.random());
	 var refreshId6 = setInterval(function() {
	 	infou5();
	 }, 70000);
	 $("#saldocliente").load('saldoapostador.php?&js='+Math.random());
	 var refreshId6 = setInterval(function() {
	 	saldocli();
	 }, 30000);
	 	 $("#carreras").load('carreras.php?&js='+Math.random());
	 var refreshId6 = setInterval(function() {
	 	saldocli();
	 }, 30000);

});
function infou5() {
	var url = 'infoultimoa5.php';
	var js=Math.random();
	$.ajax({ type: "POST", url: url, global : false, data: $("js").serialize(),
		success: function(data) {
			$("#ultimajugada5").html(data);
		}
	});
}
function infou() {
	var url = 'infoultimoa.php';
	var js=Math.random();
	$.ajax({ type: "POST", url: url, global : false, data: $("js").serialize(),
		success: function(data) {
			$("#ultimajugada").html(data);
		}
	});
}
function saldocli() {
	var url = 'saldoapostador.php';
	var js=Math.random();
	$.ajax({ type: "POST", url: url, global : false, data: $("js").serialize(),
		success: function(data) {
			$("#saldocliente").html(data);
		}
	});
	}
	function carreras() {
	var url = 'carreras.php';
	var js=Math.random();
	$.ajax({ type: "POST", url: url, global : false, data: $("js").serialize(),
		success: function(data) {
			$("#carreras").html(data);
		}
	});
}


</script>

	</head>
	
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
	<header> 
  <!-- Fixed navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#"><span id="saldocliente"></span></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="internacionalesa.php">Apostar Hipismo Internacional<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="dropdown-item" href="reportea.php">Reporte General</a>
      </li>
	        <li class="nav-item">
        <a class="dropdown-item" href="cambiomonedaa.php">Cambiar Moneda A Usar</a>
      </li>
	  	        <li class="nav-item">
         <a class="dropdown-item" href="dividendosyretiradosa.php">Dividendos y Retirados</a>
      </li>
	  	        <li class="nav-item">
         <a class="dropdown-item" href="../gacetas/retrospectosa.php">Retrospectos</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="cerrar_sesion_apostador.php">Salir</a>
      </li>
    </ul>

  </div>
</nav>
</header>

		<div class="container">
			<div class="row">
				<h3 style="text-align:center">Cambiar Moneda</h3>
			</div>
			
			<form class="form-horizontal" name="form1" method="POST" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">


				<div class="form-group">
					<label for="nombre" class="col-sm-8 control-label">Nombre De Usuario</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="username" name="username" value="<?php echo$row_Recordset13['nom_taquilla']; ?>" placeholder="Nombre De Usuario"  
						title="indique un nombre de usuario. 4-30 caracteres" size="32"  
maxlength="30" pattern="[A-Z a-z0-9]{4,30}" onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info32');"
						Disabled>
					</div>
					<div id="Info32" style="float: left; padding:0px 0px 0px 0px; font-size:12px; color:#F00"></div>
					
					
					
					
<div class="form-group">
<div class="col-sm-4">
                    <select name="moneda" class="selectpicker" data-style="btn-danger">
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($row_Recordset13['moneda'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>Bolivares Soberanos</option>
                    <option value="3" 
					<?php if (!(strcmp(3, htmlentities($row_Recordset13['moneda'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>Dolar Estadounidense</option>
                    <option value="4" 
					<?php if (!(strcmp(4, htmlentities($row_Recordset13['moneda'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>Peso Colombiano</option>
						                      <option value="5" 
					<?php if (!(strcmp(5, htmlentities($row_Recordset13['moneda'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>Sol Peruano</option>
                  </select>
				  </div>
				  </div>
          <input type="hidden" name="cod_taquilla" value="<?php echo $recordID ?>"/>
		  <input type="hidden" name="id_usuario" value="<?php echo $row_Recordset1['id_usuario']; ?>"/>
		  <input type="hidden" name="cod_taopcame" value="<?php echo $row_Recordset1['cod_taopcame']; ?>"/>
				
				
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<a href="listaapostadora.php" class="btn btn-default">Regresar</a>
						<button type="submit" class="btn btn-primary">Editar Usuario Apostador</button>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>