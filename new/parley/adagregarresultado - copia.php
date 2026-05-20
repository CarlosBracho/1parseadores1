<?php  ?>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
    $horaTxt=horaactual();
    $FechaTxt=fechaactualbd();
    if (empty($_GET['Id_p2juegosp2'])) {
        $Id_p2juegosp2=$_POST['juegop5'];
    } else {
        $Id_p2juegosp2=$_GET['Id_p2juegosp2'];
    }


        $query_Recordset12 = sprintf(
            "/* PARSEADORES1 new\parley\adagregarresultado - copia.php - QUERY 1 */ SELECT * FROM p5resultadosj WHERE 
			juegop5 = %s",
            GetSQLValueString($_GET['Id_p2juegosp2'], "int")
        );
    $Recordset12 = mysqli_query($conexionbanca, $query_Recordset12) or die(mysqli_error($conexionbanca));
    $row_Recordset12 = mysqli_fetch_assoc($Recordset12);
    $totalRows_Recordset12 = mysqli_num_rows($Recordset12);
    
    if ($totalRows_Recordset12>0) {
        $query_Recordset111 = sprintf(
            "/* PARSEADORES1 new\parley\adagregarresultado - copia.php - QUERY 2 */ SELECT * FROM p5resultadosj WHERE 
			juegop5 = %s AND equipop5 = %s ",
            GetSQLValueString($Id_p2juegosp2, "int"),
            GetSQLValueString($_GET['equipo1'], "text")
        );
        $Recordset111 = mysqli_query($conexionbanca, $query_Recordset111) or die(mysqli_error($conexionbanca));
        $r111 = mysqli_fetch_assoc($Recordset111);
        $totalRows_Recordset111 = mysqli_num_rows($Recordset111);
        $query_Recordset112 = sprintf(
            "/* PARSEADORES1 new\parley\adagregarresultado - copia.php - QUERY 3 */ SELECT * FROM p5resultadosj WHERE 
			juegop5 = %s AND equipop5 = %s ",
            GetSQLValueString($Id_p2juegosp2, "int"),
            GetSQLValueString($_GET['equipo2'], "text")
        );
        $Recordset112 = mysqli_query($conexionbanca, $query_Recordset112) or die(mysqli_error($conexionbanca));
        $r112 = mysqli_fetch_assoc($Recordset112);
        $totalRows_Recordset112 = mysqli_num_rows($Recordset112);
    }
    if (empty($row_Recordset111['tiemposjugadosp5'])) {
        echo'0';
    } else {
        echo $row_Recordset111['tiemposjugadosp5'];
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
        $editFormAction = $_SERVER['PHP_SELF'];
    if (empty($Id_p2juegosp2)) {
    } else {
        $query_Recordset1 = sprintf(
            "/* PARSEADORES1 new\parley\adagregarresultado - copia.php - QUERY 4 */ SELECT * FROM p2juegos WHERE 
			Id_p2juegosp2 = %s",
            GetSQLValueString($Id_p2juegosp2, "int")
        );
        $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
        $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
        $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    }
if (empty($_POST['1e1']!='')) {
    echo 'no creando';
} else {
    echo 'revisando';


    $query_Recordset14 = sprintf(
        "/* PARSEADORES1 new\parley\adagregarresultado - copia.php - QUERY 5 */ SELECT * FROM p5resultadosj WHERE 
			juegop5 = %s",
        GetSQLValueString($_POST['juegop5'], "int")
    );
    $Recordset14 = mysqli_query($conexionbanca, $query_Recordset14) or die(mysqli_error($conexionbanca));
    $row_Recordset14 = mysqli_fetch_assoc($Recordset14);
    $totalRows_Recordset14 = mysqli_num_rows($Recordset14);
    
    if ($totalRows_Recordset14==0) {
        if ($_POST['juegop5']>0) {
            echo 'creando';
            $insertSQL155 = sprintf(
                "/* PARSEADORES1 new\parley\adagregarresultado - copia.php - QUERY 6 */ INSERT INTO p5resultadosj  
(deportep5, juegop5, equipop5, fec_inciop5, hor_inciop5, tiemposjugadosp5, r1p5, r2p5, r3p5, r4p5, r5p5, r6p5, r7p5, r8p5, r9p5, r10p5, r11p5, r12p5, r13p5, r14p5, r15p5, r16p5, r17p5, r18p5, r19p5, r20p5, r21p5, r22p5, r23p5, r24p5, r25p5, r26p5, r27p5, r28p5, r29p5, r30p5)
VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                GetSQLValueString($_POST['deporte'], "text"),
                GetSQLValueString($_POST['juegop5'], "int"),
                GetSQLValueString($_POST['equipo1'], "text"),
                GetSQLValueString($_POST['fec_inciop5'], "date"),
                GetSQLValueString($_POST['hor_inciop5'], "date"),
                GetSQLValueString($_POST['tiemposjugadosp5'], "int"),
                GetSQLValueString($_POST['1e1'], "int"),
                GetSQLValueString($_POST['2e1'], "int"),
                GetSQLValueString($_POST['3e1'], "int"),
                GetSQLValueString($_POST['4e1'], "int"),
                GetSQLValueString($_POST['5e1'], "int"),
                GetSQLValueString($_POST['6e1'], "int"),
                GetSQLValueString($_POST['7e1'], "int"),
                GetSQLValueString($_POST['8e1'], "int"),
                GetSQLValueString($_POST['9e1'], "int"),
                GetSQLValueString($_POST['10e1'], "int"),
                GetSQLValueString($_POST['11e1'], "int"),
                GetSQLValueString($_POST['12e1'], "int"),
                GetSQLValueString($_POST['13e1'], "int"),
                GetSQLValueString($_POST['14e1'], "int"),
                GetSQLValueString($_POST['15e1'], "int"),
                GetSQLValueString($_POST['16e1'], "int"),
                GetSQLValueString($_POST['17e1'], "int"),
                GetSQLValueString($_POST['18e1'], "int"),
                GetSQLValueString($_POST['19e1'], "int"),
                GetSQLValueString($_POST['20e1'], "int"),
                GetSQLValueString($_POST['21e1'], "int"),
                GetSQLValueString($_POST['22e1'], "int"),
                GetSQLValueString($_POST['23e1'], "int"),
                GetSQLValueString($_POST['24e1'], "int"),
                GetSQLValueString($_POST['25e1'], "int"),
                GetSQLValueString($_POST['26e1'], "int"),
                GetSQLValueString($_POST['27e1'], "int"),
                GetSQLValueString($_POST['28e1'], "int"),
                GetSQLValueString($_POST['29e1'], "int"),
                GetSQLValueString($_POST['30e1'], "int")
            );
            $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
            $insertSQL155 = sprintf(
                "/* PARSEADORES1 new\parley\adagregarresultado - copia.php - QUERY 7 */ INSERT INTO p5resultadosj  
(deportep5, juegop5, equipop5, fec_inciop5, hor_inciop5, tiemposjugadosp5, r1p5, r2p5, r3p5, r4p5, r5p5, r6p5, r7p5, r8p5, r9p5, r10p5, r11p5, r12p5, r13p5, r14p5, r15p5, r16p5, r17p5, r18p5, r19p5, r20p5, r21p5, r22p5, r23p5, r24p5, r25p5, r26p5, r27p5, r28p5, r29p5, r30p5)
VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                GetSQLValueString($_POST['deporte'], "text"),
                GetSQLValueString($_POST['juegop5'], "int"),
                GetSQLValueString($_POST['equipo2'], "text"),
                GetSQLValueString($_POST['fec_inciop5'], "date"),
                GetSQLValueString($_POST['hor_inciop5'], "date"),
                GetSQLValueString($_POST['tiemposjugadosp5'], "int"),
                GetSQLValueString($_POST['1e2'], "int"),
                GetSQLValueString($_POST['2e2'], "int"),
                GetSQLValueString($_POST['3e2'], "int"),
                GetSQLValueString($_POST['4e2'], "int"),
                GetSQLValueString($_POST['5e2'], "int"),
                GetSQLValueString($_POST['6e2'], "int"),
                GetSQLValueString($_POST['7e2'], "int"),
                GetSQLValueString($_POST['8e2'], "int"),
                GetSQLValueString($_POST['9e2'], "int"),
                GetSQLValueString($_POST['10e2'], "int"),
                GetSQLValueString($_POST['11e2'], "int"),
                GetSQLValueString($_POST['12e2'], "int"),
                GetSQLValueString($_POST['13e2'], "int"),
                GetSQLValueString($_POST['14e2'], "int"),
                GetSQLValueString($_POST['15e2'], "int"),
                GetSQLValueString($_POST['16e2'], "int"),
                GetSQLValueString($_POST['17e2'], "int"),
                GetSQLValueString($_POST['18e2'], "int"),
                GetSQLValueString($_POST['19e2'], "int"),
                GetSQLValueString($_POST['20e2'], "int"),
                GetSQLValueString($_POST['21e2'], "int"),
                GetSQLValueString($_POST['22e2'], "int"),
                GetSQLValueString($_POST['23e2'], "int"),
                GetSQLValueString($_POST['24e2'], "int"),
                GetSQLValueString($_POST['25e2'], "int"),
                GetSQLValueString($_POST['26e2'], "int"),
                GetSQLValueString($_POST['27e2'], "int"),
                GetSQLValueString($_POST['28e2'], "int"),
                GetSQLValueString($_POST['29e2'], "int"),
                GetSQLValueString($_POST['30e2'], "int")
            );
            $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
        }
    } else {
        echo 'actualizando';







        $insertSQL155 = sprintf(
            "/* PARSEADORES1 new\parley\adagregarresultado - copia.php - QUERY 8 */ UPDATE p5resultadosj  SET 
deportep5=%s, juegop5=%s, equipop5=%s, fec_inciop5=%s, hor_inciop5=%s, tiemposjugadosp5=%s, r1p5=%s, r2p5=%s, r3p5=%s, r4p5=%s, r5p5=%s, r6p5=%s, r7p5=%s, r8p5=%s, r9p5=%s, r10p5=%s, r11p5=%s, r12p5=%s, r13p5=%s, r14p5=%s, r15p5=%s, r16p5=%s, r17p5=%s, r18p5=%s, r19p5=%s, r20p5=%s, r21p5=%s, r22p5=%s, r23p5=%s, r24p5=%s, r25p5=%s, r26p5=%s, r27p5=%s, r28p5=%s, r29p5=%s, r30p5=%s
WHERE juegop5=%s AND equipop5=%s",
            GetSQLValueString($_POST['deporte'], "text"),
            GetSQLValueString($_POST['juegop5'], "int"),
            GetSQLValueString($_POST['equipo1'], "text"),
            GetSQLValueString($_POST['fec_inciop5'], "date"),
            GetSQLValueString($_POST['hor_inciop5'], "date"),
            GetSQLValueString($_POST['tiemposjugadosp5'], "int"),
            GetSQLValueString($_POST['1e1'], "int"),
            GetSQLValueString($_POST['2e1'], "int"),
            GetSQLValueString($_POST['3e1'], "int"),
            GetSQLValueString($_POST['4e1'], "int"),
            GetSQLValueString($_POST['5e1'], "int"),
            GetSQLValueString($_POST['6e1'], "int"),
            GetSQLValueString($_POST['7e1'], "int"),
            GetSQLValueString($_POST['8e1'], "int"),
            GetSQLValueString($_POST['9e1'], "int"),
            GetSQLValueString($_POST['10e1'], "int"),
            GetSQLValueString($_POST['11e1'], "int"),
            GetSQLValueString($_POST['12e1'], "int"),
            GetSQLValueString($_POST['13e1'], "int"),
            GetSQLValueString($_POST['14e1'], "int"),
            GetSQLValueString($_POST['15e1'], "int"),
            GetSQLValueString($_POST['16e1'], "int"),
            GetSQLValueString($_POST['17e1'], "int"),
            GetSQLValueString($_POST['18e1'], "int"),
            GetSQLValueString($_POST['19e1'], "int"),
            GetSQLValueString($_POST['20e1'], "int"),
            GetSQLValueString($_POST['21e1'], "int"),
            GetSQLValueString($_POST['22e1'], "int"),
            GetSQLValueString($_POST['23e1'], "int"),
            GetSQLValueString($_POST['24e1'], "int"),
            GetSQLValueString($_POST['25e1'], "int"),
            GetSQLValueString($_POST['26e1'], "int"),
            GetSQLValueString($_POST['27e1'], "int"),
            GetSQLValueString($_POST['28e1'], "int"),
            GetSQLValueString($_POST['29e1'], "int"),
            GetSQLValueString($_POST['30e1'], "int"),
            GetSQLValueString($_POST['juegop5'], "int"),
            GetSQLValueString($_POST['equipo1'], "text")
        );
        $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
        $insertSQL156 = sprintf(
            "/* PARSEADORES1 new\parley\adagregarresultado - copia.php - QUERY 9 */ UPDATE p5resultadosj  SET 
deportep5=%s, juegop5=%s, equipop5=%s, fec_inciop5=%s, hor_inciop5=%s, tiemposjugadosp5=%s, r1p5=%s, r2p5=%s, r3p5=%s, r4p5=%s, r5p5=%s, r6p5=%s, r7p5=%s, r8p5=%s, r9p5=%s, r10p5=%s, r11p5=%s, r12p5=%s, r13p5=%s, r14p5=%s, r15p5=%s, r16p5=%s, r17p5=%s, r18p5=%s, r19p5=%s, r20p5=%s, r21p5=%s, r22p5=%s, r23p5=%s, r24p5=%s, r25p5=%s, r26p5=%s, r27p5=%s, r28p5=%s, r29p5=%s, r30p5=%s
WHERE juegop5=%s AND equipop5=%s",
            GetSQLValueString($_POST['deporte'], "text"),
            GetSQLValueString($_POST['juegop5'], "int"),
            GetSQLValueString($_POST['equipo2'], "text"),
            GetSQLValueString($_POST['fec_inciop5'], "date"),
            GetSQLValueString($_POST['hor_inciop5'], "date"),
            GetSQLValueString($_POST['tiemposjugadosp5'], "int"),
            GetSQLValueString($_POST['1e2'], "int"),
            GetSQLValueString($_POST['2e2'], "int"),
            GetSQLValueString($_POST['3e2'], "int"),
            GetSQLValueString($_POST['4e2'], "int"),
            GetSQLValueString($_POST['5e2'], "int"),
            GetSQLValueString($_POST['6e2'], "int"),
            GetSQLValueString($_POST['7e2'], "int"),
            GetSQLValueString($_POST['8e2'], "int"),
            GetSQLValueString($_POST['9e2'], "int"),
            GetSQLValueString($_POST['10e2'], "int"),
            GetSQLValueString($_POST['11e2'], "int"),
            GetSQLValueString($_POST['12e2'], "int"),
            GetSQLValueString($_POST['13e2'], "int"),
            GetSQLValueString($_POST['14e2'], "int"),
            GetSQLValueString($_POST['15e2'], "int"),
            GetSQLValueString($_POST['16e2'], "int"),
            GetSQLValueString($_POST['17e2'], "int"),
            GetSQLValueString($_POST['18e2'], "int"),
            GetSQLValueString($_POST['19e2'], "int"),
            GetSQLValueString($_POST['20e2'], "int"),
            GetSQLValueString($_POST['21e2'], "int"),
            GetSQLValueString($_POST['22e2'], "int"),
            GetSQLValueString($_POST['23e2'], "int"),
            GetSQLValueString($_POST['24e2'], "int"),
            GetSQLValueString($_POST['25e2'], "int"),
            GetSQLValueString($_POST['26e2'], "int"),
            GetSQLValueString($_POST['27e2'], "int"),
            GetSQLValueString($_POST['28e2'], "int"),
            GetSQLValueString($_POST['29e2'], "int"),
            GetSQLValueString($_POST['30e2'], "int"),
            GetSQLValueString($_POST['juegop5'], "int"),
            GetSQLValueString($_POST['equipo2'], "text")
        );
        $Result156 = mysqli_query($conexionbanca, $insertSQL156) or die(mysqli_error($conexionbanca));
    }

    $insertGoTo = "adlistajuegos.php";

    header(sprintf("Location: %s", $insertGoTo));
}

    
?>
<!doctype html>
<html lang="es">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min4.5.2.css">
	<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
    <link href="../fonts/font-awesome.min4.7.0.css" rel="stylesheet">
<title>.:Apuestas:.</title>
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
    $('#nom_taquilla').blur(function(){
		var taquilla = $('input[name=nom_taquilla]').val();
		if(taquilla != '') {
			var nom_taquilla = $(this).val();        
			var dataString = 'nom_taquilla='+nom_taquilla;
			$.ajax({
				type: "POST",
				url: "../includes/comprobarTaquilla.php",
				data: dataString,
				success: function(data) {
					$('#Info1').fadeIn(200).html(data);
				}
			});
		};
    });              
    $('#username').blur(function(){
		var usern = $('input[name=username]').val();
		if(usern != '') {
			var username = $(this).val();        
			var dataString = 'username='+username;
			$.ajax({
				type: "POST",
				url: "../includes/comprobarUsuario.php",
				data: dataString,
				success: function(data) {
					$('#Info32').fadeIn(200).html(data);
				}
			});
		};	
    });
	$('#exp_agencia').change(function(){
		if($("#exp_agencia").val()>0) {
			
			$("#botExp").removeAttr("disabled");
		}
		else {
			$("#botExp").attr('disabled', 'disabled');
		}
  });
});    
function FX_passGenerator(form,element) {
  var thePass = "";
  var randomchar = "";
  var numberofdigits = '5';
  for (var count=1; count<=numberofdigits; count++) {
    var chargroup = Math.floor((Math.random() * 3) + 1);
    if (chargroup==1) {
      randomchar = Math.floor((Math.random() * 26) + 65);
    }
    if (chargroup==2) {
      randomchar = Math.floor((Math.random() * 10) + 48);
    }
    if (chargroup==3) {
      randomchar = Math.floor((Math.random() * 26) + 97);
    }
    thePass+=String.fromCharCode(randomchar);
  }
  thePass = thePass.toUpperCase();
  eval('document.'+form+'.'+element+'.value = thePass');
}
function ValidaSoloNumeros() {
	if (event.keyCode != 46) {
		if ((event.keyCode < 48) || (event.keyCode > 57)) 
			event.returnValue = false;
	}
}    
function ocultaDiv(elemento) {
	document.getElementById(elemento).style.display = "none";
}
</script>
</head>

<body>
<?php
require_once('../parley/admenu.php');
?>
<form class="form-horizontal" name="form1" method="POST" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">

<div class="container">
  <hr>
  <div class="row">
    <div class="col-12 col-md-12"> 
      <!-- Contenido -->

      <table class="table">

        <tbody>
          <?php

do {?>
	
<?php if ($row_Recordset1['deportep2']=='Baseball') {?>
INING JUHADOS<input type="number" class="form-control" id="tiemposjugadosp5" name="tiemposjugadosp5" maxlength="2" value="<?php if (empty($r111['tiemposjugadosp5'])) {
    echo'0';
} else {
    echo $r111['tiemposjugadosp5'];
}?>">

        <thead class="thead-dark">
          <tr>

<th scope="col">equipo1</br>equipo2</br>fecha</br>hora inicio</th>
<th scope="col">C</th>
<th scope="col">H</th>
<th scope="col">E</th>

          </tr>
        </thead>
		          <tr>

<th scope="col"><?php
$query_Recordset21 = sprintf(
    "/* PARSEADORES1 new\parley\adagregarresultado - copia.php - QUERY 10 */ SELECT *
FROM p1equipos
WHERE  

p1equipos.Id_p1equipos = %s",
    GetSQLValueString($row_Recordset1['idequipo1p2'], "int")
);
$Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
$row_Recordset21 = mysqli_fetch_assoc($Recordset21);
$totalRows_Recordset21 = mysqli_num_rows($Recordset21);
$equipo1=$row_Recordset21['nomequipo'];
echo $equipo1; echo '</br>';?></th>
<th scope="col"><input type="number" class="form-control" id="26e1" name="26e1" maxlength="2" value="<?php if (empty($r111['r26p5'])) {
    echo'0';
} else {
    echo $r111['r26p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="27e1" name="27e1" maxlength="2" value="<?php if (empty($r111['r27p5'])) {
    echo'0';
} else {
    echo $r111['r27p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="28e1" name="28e1" maxlength="2" value="<?php if (empty($r111['r28p5'])) {
    echo'0';
} else {
    echo $r111['r28p5'];
}?>"></th>


          </tr>
		  		          <tr>

<th scope="col"><?php
$query_Recordset21 = sprintf(
    "/* PARSEADORES1 new\parley\adagregarresultado - copia.php - QUERY 11 */ SELECT *
FROM p1equipos
WHERE  

p1equipos.Id_p1equipos = %s",
    GetSQLValueString($row_Recordset1['idequipo2p2'], "int")
);
$Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
$row_Recordset21 = mysqli_fetch_assoc($Recordset21);
$totalRows_Recordset21 = mysqli_num_rows($Recordset21);
$equipo2=$row_Recordset21['nomequipo'];
echo $equipo2; echo '</br>';?></th>
<th scope="col"><input type="number" class="form-control" id="26e2" name="26e2" maxlength="2" value="<?php if (empty($r112['r26p5'])) {
    echo'0';
} else {
    echo $r112['r26p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="27e2" name="27e2" maxlength="2" value="<?php if (empty($r112['r27p5'])) {
    echo'0';
} else {
    echo $r112['r27p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="28e2" name="28e2" maxlength="2" value="<?php if (empty($r112['r28p5'])) {
    echo'0';
} else {
    echo $r112['r28p5'];
}?>"></th>

          </tr>
		  
		  
		  
		  
		  
		  
		  
		          <thead class="thead-dark">
          <tr>

<th scope="col">equipo1</br>equipo2</br>fecha</br>hora inicio</th>
<th scope="col">1</th>
<th scope="col">2</th>
<th scope="col">3</th>
<th scope="col">4</th>
<th scope="col">5</th>
<th scope="col">6</th>
<th scope="col">7</th>
<th scope="col">8</th>
<th scope="col">9</th>
<th scope="col">10</th>

          </tr>
        </thead>
		          <tr>

<th scope="col"><?php

echo $equipo1; echo '</br>';?></th>
<th scope="col"><input type="number" class="form-control" id="1e1" name="1e1" maxlength="2" value="<?php if (empty($r111['r1p5'])) {
    echo'0';
} else {
    echo $r111['r1p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="2e1" name="2e1" maxlength="2" value="<?php if (empty($r111['r2p5'])) {
    echo'0';
} else {
    echo $r111['r2p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="3e1" name="3e1" maxlength="2" value="<?php if (empty($r111['r3p5'])) {
    echo'0';
} else {
    echo $r111['r3p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="4e1" name="4e1" maxlength="2" value="<?php if (empty($r111['r4p5'])) {
    echo'0';
} else {
    echo $r111['r4p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="5e1" name="5e1" maxlength="2" value="<?php if (empty($r111['r5p5'])) {
    echo'0';
} else {
    echo $r111['r5p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="6e1" name="6e1" maxlength="2" value="<?php if (empty($r111['r6p5'])) {
    echo'0';
} else {
    echo $r111['r6p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="7e1" name="7e1" maxlength="2" value="<?php if (empty($r111['r7p5'])) {
    echo'0';
} else {
    echo $r111['r7p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="8e1" name="8e1" maxlength="2" value="<?php if (empty($r111['r8p5'])) {
    echo'0';
} else {
    echo $r111['r8p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="9e1" name="9e1" maxlength="2" value="<?php if (empty($r111['r9p5'])) {
    echo'0';
} else {
    echo $r111['r9p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="10e1" name="10e1" maxlength="2" value="<?php if (empty($r111['r10p5'])) {
    echo'0';
} else {
    echo $r111['r10p5'];
}?>"></th>

          </tr>
		  		          <tr>

<th scope="col"><?php
echo $equipo2; echo '</br>';?></th>
<th scope="col"><input type="number" class="form-control" id="1e2" name="1e2" maxlength="2" value="<?php if (empty($r112['r1p5'])) {
    echo'0';
} else {
    echo $r112['r1p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="2e2" name="2e2" maxlength="2" value="<?php if (empty($r112['r2p5'])) {
    echo'0';
} else {
    echo $r112['r2p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="3e2" name="3e2" maxlength="2" value="<?php if (empty($r112['r3p5'])) {
    echo'0';
} else {
    echo $r112['r3p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="4e2" name="4e2" maxlength="2" value="<?php if (empty($r112['r4p5'])) {
    echo'0';
} else {
    echo $r112['r4p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="5e2" name="5e2" maxlength="2" value="<?php if (empty($r112['r5p5'])) {
    echo'0';
} else {
    echo $r112['r5p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="6e2" name="6e2" maxlength="2" value="<?php if (empty($r112['r6p5'])) {
    echo'0';
} else {
    echo $r112['r6p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="7e2" name="7e2" maxlength="2" value="<?php if (empty($r112['r7p5'])) {
    echo'0';
} else {
    echo $r112['r7p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="8e2" name="8e2" maxlength="2" value="<?php if (empty($r112['r8p5'])) {
    echo'0';
} else {
    echo $r112['r8p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="9e2" name="9e2" maxlength="2" value="<?php if (empty($r112['r9p5'])) {
    echo'0';
} else {
    echo $r112['r9p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="10e2" name="10e2" maxlength="2" value="<?php if (empty($r112['r10p5'])) {
    echo'0';
} else {
    echo $r112['r10p5'];
}?>"></th>
</tr>

		          <thead class="thead-dark">
          <tr>

<th scope="col">equipo1</br>equipo2</br>fecha</br>hora inicio</th>
<th scope="col">11</th>
<th scope="col">12</th>
<th scope="col">13</th>
<th scope="col">14</th>
<th scope="col">15</th>
<th scope="col">16</th>
<th scope="col">17</th>
<th scope="col">18</th>
<th scope="col">19</th>
<th scope="col">20</th>

          </tr>
        </thead>
		          <tr>

<th scope="col"><?php


echo $equipo1; echo '</br>';?></th>
<th scope="col"><input type="number" class="form-control" id="11e1" name="11e1" maxlength="2" value="<?php if (empty($r111['r11p5'])) {
    echo'0';
} else {
    echo $r111['r11p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="12e1" name="12e1" maxlength="2" value="<?php if (empty($r111['r12p5'])) {
    echo'0';
} else {
    echo $r111['r12p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="13e1" name="13e1" maxlength="2" value="<?php if (empty($r111['r13p5'])) {
    echo'0';
} else {
    echo $r111['r13p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="14e1" name="14e1" maxlength="2" value="<?php if (empty($r111['r14p5'])) {
    echo'0';
} else {
    echo $r111['r14p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="15e1" name="15e1" maxlength="2" value="<?php if (empty($r111['r15p5'])) {
    echo'0';
} else {
    echo $r111['r15p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="16e1" name="16e1" maxlength="2" value="<?php if (empty($r111['r16p5'])) {
    echo'0';
} else {
    echo $r111['r16p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="17e1" name="17e1" maxlength="2" value="<?php if (empty($r111['r17p5'])) {
    echo'0';
} else {
    echo $r111['r17p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="18e1" name="18e1" maxlength="2" value="<?php if (empty($r111['r18p5'])) {
    echo'0';
} else {
    echo $r111['r18p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="19e1" name="19e1" maxlength="2" value="<?php if (empty($r111['r19p5'])) {
    echo'0';
} else {
    echo $r111['r19p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="20e1" name="20e1" maxlength="2" value="<?php if (empty($r111['r20p5'])) {
    echo'0';
} else {
    echo $r111['r20p5'];
}?>"></th>

          </tr>
		  		          <tr>

<th scope="col"><?php
echo $equipo2; echo '</br>';?></th>
<th scope="col"><input type="number" class="form-control" id="11e2" name="11e2" maxlength="2" value="<?php if (empty($r112['r11p5'])) {
    echo'0';
} else {
    echo $r112['r11p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="12e2" name="12e2" maxlength="2" value="<?php if (empty($r112['r12p5'])) {
    echo'0';
} else {
    echo $r112['r12p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="13e2" name="13e2" maxlength="2" value="<?php if (empty($r112['r13p5'])) {
    echo'0';
} else {
    echo $r112['r13p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="14e2" name="14e2" maxlength="2" value="<?php if (empty($r112['r14p5'])) {
    echo'0';
} else {
    echo $r112['r14p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="15e2" name="15e2" maxlength="2" value="<?php if (empty($r112['r15p5'])) {
    echo'0';
} else {
    echo $r112['r15p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="16e2" name="16e2" maxlength="2" value="<?php if (empty($r112['r16p5'])) {
    echo'0';
} else {
    echo $r112['r16p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="17e2" name="17e2" maxlength="2" value="<?php if (empty($r112['r17p5'])) {
    echo'0';
} else {
    echo $r112['r17p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="18e2" name="18e2" maxlength="2" value="<?php if (empty($r112['r18p5'])) {
    echo'0';
} else {
    echo $r112['r18p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="19e2" name="19e2" maxlength="2" value="<?php if (empty($r112['r19p5'])) {
    echo'0';
} else {
    echo $r112['r19p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="20e2" name="20e2" maxlength="2" value="<?php if (empty($r112['r20p5'])) {
    echo'0';
} else {
    echo $r112['r20p5'];
}?>"></th>
</tr>
		          <thead class="thead-dark">
          <tr>

<th scope="col">equipo1</br>equipo2</br>fecha</br>hora inicio</th>
<th scope="col">21</th>
<th scope="col">22</th>
<th scope="col">23</th>
<th scope="col">24</th>
<th scope="col">25</th>


          </tr>
        </thead>
		          <tr>

<th scope="col"><?php


echo $equipo1; echo '</br>';?></th>
<th scope="col"><input type="number" class="form-control" id="21e1" name="21e1" maxlength="2" value="<?php if (empty($r111['r21p5'])) {
    echo'0';
} else {
    echo $r111['r21p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="22e1" name="22e1" maxlength="2" value="<?php if (empty($r111['r22p5'])) {
    echo'0';
} else {
    echo $r111['r22p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="23e1" name="23e1" maxlength="2" value="<?php if (empty($r111['r23p5'])) {
    echo'0';
} else {
    echo $r111['r23p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="24e1" name="24e1" maxlength="2" value="<?php if (empty($r111['r24p5'])) {
    echo'0';
} else {
    echo $r111['r24p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="25e1" name="25e1" maxlength="2" value="<?php if (empty($r111['r25p5'])) {
    echo'0';
} else {
    echo $r111['r25p5'];
}?>"></th>


          </tr>
		  		          <tr>

<th scope="col"><?php
echo $equipo2; echo '</br>';?></th>
<th scope="col"><input type="number" class="form-control" id="21e2" name="21e2" maxlength="2" value="<?php if (empty($r112['r21p5'])) {
    echo'0';
} else {
    echo $r112['r21p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="22e2" name="22e2" maxlength="2" value="<?php if (empty($r112['r22p5'])) {
    echo'0';
} else {
    echo $r112['r22p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="23e2" name="23e2" maxlength="2" value="<?php if (empty($r112['r23p5'])) {
    echo'0';
} else {
    echo $r112['r23p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="24e2" name="24e2" maxlength="2" value="<?php if (empty($r112['r24p5'])) {
    echo'0';
} else {
    echo $r112['r24p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="25e2" name="25e2" maxlength="2" value="<?php if (empty($r112['r25p5'])) {
    echo'0';
} else {
    echo $r112['r25p5'];
}?>"></th>

</tr>
<input type="hidden" name="deporte" value="Baseball"/>
<input type="hidden" name="juegop5" value="<?php echo $_GET['Id_p2juegosp2']; ?>"/>
<input type="hidden" name="equipo1" value="<?php echo $equipo1; ?>"/>
<input type="hidden" name="equipo2" value="<?php echo $equipo2; ?>"/>
<input type="hidden" name="fec_inciop5" value="<?php echo $row_Recordset1['fechajuegop2']; ?>"/>
<input type="hidden" name="hor_inciop5" value="<?php echo $row_Recordset1['horainiciop2']; ?>"/>


<input type="hidden" name="29e1" value="0"/>
<input type="hidden" name="29e2" value="0"/>
<input type="hidden" name="30e1" value="0"/>
<input type="hidden" name="30e2" value="0"/>
<?php }?>








<?php
} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
?>

        </tbody>
      </table>
      				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<a href="adlistajuegos.php" class="btn btn-default">Regresar</a>
						<button type="submit" class="btn btn-primary">Crear equipo</button>
					</div>
				</div>
		
      <!-- Fin Contenido --> 
    </div>
  </div>
  <!-- Fin row --> 
  
</div>
</form>
<!-- Fin container -->


<!-- Bootstrap core JavaScript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="../js/jquery-3.5.1.slim.min.js"></script>
    <script src="../js/popper.min1.16.1.js"></script>
    <script src="../js/bootstrap.min4.5.2.js"></script>
  </body>
</html>