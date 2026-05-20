<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');

$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");

//echo "  ".$_SESSION['MM_nom_usuario'];

$usuario=$_SESSION['MM_nom_usuario'];
$codus=$_SESSION['MM_id_usuario'];


    $horaTxt=horaactual();
    $FechaTxt=fechaactualbd();
    if (empty($_GET['Id_p2juegosp2'])) {
        $Id_p2juegosp2=$_POST['Id_p2juegosp2'];
    } else {
        $Id_p2juegosp2=$_GET['Id_p2juegosp2'];
    }


    

    
            $query_Recordset111 = sprintf(
                "/* PARSEADORES1 new\parley\adpsinresultados2.php - QUERY 1 */ SELECT * FROM p5resultadosj WHERE 
			juegop5 = %s",
                GetSQLValueString($Id_p2juegosp2, "int")
            );
    $Recordset111 = mysqli_query($conexionbanca, $query_Recordset111) or die(mysqli_error($conexionbanca));
    $r111 = mysqli_fetch_assoc($Recordset111);

    

    
    
    
    
    
    
        $editFormAction = $_SERVER['PHP_SELF'];
    if (empty($Id_p2juegosp2)) {
    } else {
        $query_Recordset1 = sprintf(
            "/* PARSEADORES1 new\parley\adpsinresultados2.php - QUERY 2 */ SELECT * FROM p2juegos WHERE 
			Id_p2juegosp2 = %s",
            GetSQLValueString($Id_p2juegosp2, "int")
        );
        $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
        $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
        $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    }
if (!isset($_POST['1e1'])) {$_POST['1e1']='';}
if (empty($_POST['1e1']!='')) {
    echo 'no creando';
} else {


    if (isset($_POST['resultado'])){
    echo 'revisando';


    $query_Recordset14 = sprintf(
        "/* PARSEADORES1 new\parley\adpsinresultados2.php - QUERY 3 */ SELECT * FROM p5resultadosj WHERE 
			juegop5 = %s",
        GetSQLValueString($_POST['Id_p2juegosp2'], "int")
    );
    $Recordset14 = mysqli_query($conexionbanca, $query_Recordset14) or die(mysqli_error($conexionbanca));
    $row_Recordset14 = mysqli_fetch_assoc($Recordset14);
    $totalRows_Recordset14 = mysqli_num_rows($Recordset14);
    
    if ($totalRows_Recordset14==0) {
        if ($_POST['Id_p2juegosp2']>0) {

            if(isset($_POST['23e1']) && $_POST['deporte']<>'beisbol'){

            $Mitad2e1=$_POST['23e1'] - $_POST['21e1'];
            $Mitad2e2=$_POST['24e1'] - $_POST['22e1'];
        
        }else{
            $Mitad2e1=$_POST['23e1'];
            $Mitad2e2=$_POST['24e1'];
        }
            echo 'creando';

            $insertSQL155 = sprintf(
                "/* PARSEADORES1 new\parley\adpsinresultados2.php - QUERY 4 */ INSERT INTO p5resultadosj  
(deportep5, juegop5, equipo1p5, equipo2p5, anotaprimerop5, iniciodtp5, tiemposjugadosp5,
 r1p5, r2p5, r3p5, r4p5, r5p5, r6p5, r7p5, r8p5, r9p5, r10p5, 
 r11p5, r12p5, r13p5, r14p5, r15p5, r16p5, r17p5, r18p5, r19p5, r20p5, 
 r21p5, r22p5, r23p5, r24p5, r25p5, r26p5, r27p5, r28p5, r29p5, r30p5, quienmete)
VALUES (%s, %s, %s, %s, %s, %s, %s, %s, 
%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                GetSQLValueString($_POST['deporte'], "text"),
                GetSQLValueString($_POST['Id_p2juegosp2'], "int"),
                GetSQLValueString($_POST['equipo1p5'], "text"),
                GetSQLValueString($_POST['equipo2p5'], "text"),
                GetSQLValueString($_POST['anotaprimerop5'], "text"),
                GetSQLValueString($_POST['iniciodtp5'], "date"),
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
                GetSQLValueString($Mitad2e1, "int"),
                GetSQLValueString($Mitad2e2, "int"),
                GetSQLValueString($_POST['25e1'], "int"),
                GetSQLValueString($_POST['26e1'], "int"),
                GetSQLValueString($_POST['27e1'], "int"),
                GetSQLValueString($_POST['28e1'], "int"),
                GetSQLValueString($_POST['29e1'], "int"),
                GetSQLValueString($_POST['30e1'], "int"),
                GetSQLValueString($_POST['quienmete'], "int")
            );
            $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));


$msj='El Administrador ' .$usuario . ' Coloco resultado para el juego entre '.$_POST['equipo1p5']. ' y ' .$_POST['equipo2p5'];
$msjx=utf8_encode($msj);
$post=[
  'chat_id'=>-1001639542248,
  'text'=>$msjx,
];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://api.telegram.org/bot5335385470:AAE0nAUC8c7ZDTPR3UPofIylv6TbkMsXGr8/sendMessage");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_exec ($ch);
curl_close ($ch);
        
        }
    } else {
        echo 'actualizando';


        $insertSQL155 = sprintf(
            "/* PARSEADORES1 new\parley\adpsinresultados2.php - QUERY 5 */ UPDATE p5resultadosj  SET 
deportep5=%s, equipo1p5=%s, equipo2p5=%s, anotaprimerop5=%s, tiemposjugadosp5=%s, iniciodtp5=%s,
r1p5=%s, r2p5=%s, r3p5=%s, r4p5=%s, r5p5=%s, r6p5=%s, r7p5=%s, r8p5=%s, r9p5=%s, r10p5=%s, r11p5=%s, r12p5=%s, r13p5=%s, r14p5=%s, r15p5=%s, r16p5=%s, r17p5=%s, r18p5=%s, r19p5=%s, r20p5=%s, r21p5=%s, r22p5=%s, r23p5=%s, r24p5=%s, r25p5=%s, r26p5=%s, r27p5=%s, r28p5=%s, r29p5=%s, r30p5=%s
WHERE juegop5=%s",
            GetSQLValueString($_POST['deporte'], "text"),
            GetSQLValueString($_POST['equipo1p5'], "text"),
            GetSQLValueString($_POST['equipo2p5'], "text"),
            GetSQLValueString($_POST['anotaprimerop5'], "text"),
            GetSQLValueString($_POST['tiemposjugadosp5'], "int"),
            GetSQLValueString($_POST['iniciodtp5'], "date"),
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
            GetSQLValueString($_POST['Id_p2juegosp2'], "int")
        );
        $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));

$msj='El Administrador ' .$usuario . ' edito el resultado del juego entre '.$_POST['equipo1p5']. ' y ' .$_POST['equipo2p5'];
$msjx=utf8_encode($msj);
$post=[
  'chat_id'=>-1001639542248,
  'text'=>$msjx,
];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://api.telegram.org/bot5335385470:AAE0nAUC8c7ZDTPR3UPofIylv6TbkMsXGr8/sendMessage");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_exec ($ch);
curl_close ($ch);

    }
    //include('../parley/carculojparley.php?Id_p2juegosp2='.$_POST['Id_p2juegosp2']);
    $insertGoTo =('../parley/carculojparley.php?Id_p2juegosp2='.$_POST['Id_p2juegosp2'].'&Fechacal='.$newDate);

    header(sprintf("Location: %s", $insertGoTo));
}elseif((isset($_POST['diego']))){

    


    $query_Recordset14 = sprintf(
        "/* PARSEADORES1 new\parley\adpsinresultados2.php - QUERY 6 */ SELECT * FROM p5resultadosj WHERE 
			juegop5 = %s",
        GetSQLValueString($_POST['Id_p2juegosp2'], "int")
    );
    $Recordset14 = mysqli_query($conexionbanca, $query_Recordset14) or die(mysqli_error($conexionbanca));
    $row_Recordset14 = mysqli_fetch_assoc($Recordset14);
    $totalRows_Recordset14 = mysqli_num_rows($Recordset14);

    


    if ($totalRows_Recordset14==0) {
        if ($_POST['Id_p2juegosp2']>0) {


            echo 'Anulando';
            
            $insertSQL155 = sprintf(
                "/* PARSEADORES1 new\parley\adpsinresultados2.php - QUERY 7 */ INSERT INTO p5resultadosj  
(deportep5, juegop5, equipo1p5, equipo2p5, anotaprimerop5, iniciodtp5, tiemposjugadosp5,
 r1p5, r2p5, r3p5, r4p5, r5p5, r6p5, r7p5, r8p5, r9p5, r10p5, 
 r11p5, r12p5, r13p5, r14p5, r15p5, r16p5, r17p5, r18p5, r19p5, r20p5, 
 r21p5, r22p5, r23p5, r24p5, r25p5, r26p5, r27p5, r28p5, r29p5, r30p5, quienmete)
VALUES (%s, %s, %s, %s, %s, %s, %s, %s, 
%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                GetSQLValueString($_POST['deporte'], "text"),
                GetSQLValueString($_POST['Id_p2juegosp2'], "int"),
                GetSQLValueString($_POST['equipo1p5'], "text"),
                GetSQLValueString($_POST['equipo2p5'], "text"),
                GetSQLValueString($_POST['anotaprimerop5'], "text"),
                GetSQLValueString($_POST['iniciodtp5'], "date"),
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
                GetSQLValueString(999, "int"),
                GetSQLValueString(999, "int"),
                GetSQLValueString(999, "int"),
                GetSQLValueString(999, "int"),
                GetSQLValueString($_POST['25e1'], "int"),
                GetSQLValueString($_POST['26e1'], "int"),
                GetSQLValueString($_POST['27e1'], "int"),
                GetSQLValueString($_POST['28e1'], "int"),
                GetSQLValueString($_POST['29e1'], "int"),
                GetSQLValueString($_POST['30e1'], "int"),
                GetSQLValueString($_POST['quienmete'], "int")
            );
            $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));

	$msj='El Administrador ' .$usuario . ' Anulo el juego entre '.$_POST['equipo1p5']. ' y ' .$_POST['equipo2p5'];
$msjx=utf8_encode($msj);
$post=[
  'chat_id'=>-1001639542248,
  'text'=>$msjx,
];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://api.telegram.org/bot5335385470:AAE0nAUC8c7ZDTPR3UPofIylv6TbkMsXGr8/sendMessage");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_exec ($ch);
curl_close ($ch);
         

        } 
        
        $Dfecha=$_POST['iniciodtp5'];
        $timestamp = strtotime($Dfecha);
        $newDate = date("Y-m-d", $timestamp);
        echo $newDate.' 00:00:02';
        

        $insertSQL156 = sprintf(
            "/* PARSEADORES1 new\parley\adpsinresultados2.php - QUERY 8 */ UPDATE p2juegos 
            SET 
            iniciodtp2 = %s
        WHERE Id_p2juegosp2 = %s",
            GetSQLValueString($newDate.' 00:00:02', "date"),
            GetSQLValueString($Id_p2juegosp2, "int")
        );
        $Result156 = mysqli_query($conexionbanca, $insertSQL156) or die(mysqli_error($conexionbanca));

//include('../parley/carculojparley.php?Id_p2juegosp2='.$_POST['Id_p2juegosp2']);
$insertGoTo =('../parley/carculojparley.php?Id_p2juegosp2='.$_POST['Id_p2juegosp2'].'&Fechacal='.$newDate);

header(sprintf("Location: %s", $insertGoTo));

}
}
}

if (isset($_POST['eliminar'])){


$query_delete =  sprintf(
    "/* PARSEADORES1 new\parley\adpsinresultados2.php - QUERY 9 */ DELETE FROM p5resultadosj WHERE juegop5 = %s",
    
    GetSQLValueString($Id_p2juegosp2, "int"));
    $Result1 = mysqli_query($conexionbanca, $query_delete) or die(mysqli_error($conexionbanca));
    //aqui termina el delete
    $insertGoTo =('../parley/carculojparley.php?Id_p2juegosp2='.$_POST['Id_p2juegosp2'].'&Fechacal='.$newDate);

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
    } else { alert("El formulario ya estÃ¡ siendo enviado, por favor aguarde un instante.");
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
	
<?php if ($row_Recordset1['deportep2']=='beisbol') {?>
    <button type="button" class="btn btn-primary btn-lg btn-block"><?php echo $row_Recordset1['deportep2']; ?></button>

        <thead class="thead-dark">
          <tr>

<th scope="col">equipo1</br>equipo2</br>fecha</br>hora inicio</th>
<th scope="col">Ganar</th>
<th scope="col">Ganar 5to Inn</th>
<th scope="col">Anota 1ero</th>
<th scope="col">SI/NO</th>
<th scope="col">H+R+E</th>
          </tr>
        </thead>
		          <tr>

<th scope="col"><?php
$query_Recordset21 = sprintf(
    "/* PARSEADORES1 new\parley\adpsinresultados2.php - QUERY 10 */ SELECT *
FROM p1equipos
WHERE  

Id_p1equiposp1 = %s",
    GetSQLValueString($row_Recordset1['idequipo1p2'], "int")
);
$Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
$row_Recordset21 = mysqli_fetch_assoc($Recordset21);
$totalRows_Recordset21 = mysqli_num_rows($Recordset21);
$equipo1=$row_Recordset21['nomequipop1'];
$query_Recordset22 = sprintf(
    "/* PARSEADORES1 new\parley\adpsinresultados2.php - QUERY 11 */ SELECT *
FROM p1equipos
WHERE  

Id_p1equiposp1 = %s",
    GetSQLValueString($row_Recordset1['idequipo2p2'], "int")
);
$Recordset22 =mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
$row_Recordset22 = mysqli_fetch_assoc($Recordset22);
$totalRows_Recordset22 = mysqli_num_rows($Recordset22);
$equipo2=$row_Recordset22['nomequipop1'];
echo $equipo1; echo '</br>';?></th>
<th scope="col"><input type="number" class="form-control" id="21e1" name="21e1" maxlength="2" value="<?php if (empty($r111['r21p5'])) {
    echo'0';
} else {
    echo $r111['r21p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="23e1" name="23e1" maxlength="2" value="<?php if (empty($r111['r23p5'])) {
    echo'0';
} else {
    echo $r111['r23p5'];
}?>"></th>
<th scope="col">


<?php if (empty($r111['anotaprimerop5'])) {?>
<select id="anotaprimerop5" name="anotaprimerop5" class="form-control">
<option>Seleccione</option>
<option  value="<?php echo $equipo1; ?>"><?php echo $equipo1; ?></option>
<option  value="<?php echo $equipo2; ?>"><?php echo $equipo2; ?></option>
</select>
<?php } else { ?>
<select name="anotaprimerop5" class="form-control">
<option value="<?php echo $equipo1; ?>" 
<?php if (!(strcmp($equipo1, htmlentities($r111['anotaprimerop5'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>><?php echo $equipo1; ?></option>
<option value="<?php echo $equipo2; ?>" 
<?php if (!(strcmp($equipo2, htmlentities($r111['anotaprimerop5'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>><?php echo $equipo2; ?></option>
</select>
<?php } ?>



</th>
<th scope="col">

<?php if (empty($r111['r29p5'])) {?>
<select id="29e1" name="29e1" class="form-control">
<option>Seleccione</option>
<option  value="1">SI</option>
<option  value="2">NO</option>
</select>
<?php } else { ?>
<select id="29e1" name="29e1" class="form-control">
<option value="1" 
<?php if (!(strcmp(1, htmlentities($r111['r29p5'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>SI</option>
<option value="2" 
<?php if (!(strcmp(2, htmlentities($r111['r29p5'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>NO</option>
</select>
<?php } ?>


</th>
<th scope="col"><input type="number" class="form-control" id="30e1" name="30e1" maxlength="2" value="<?php if (empty($r111['r30p5'])) {
    echo'0';
} else {
    echo $r111['r30p5'];
}?>"></th>


          </tr>
		  		          <tr>

<th scope="col"><?php


echo $equipo2; echo '</br>';?></th>
<th scope="col"><input type="number" class="form-control" id="22e1" name="22e1" maxlength="2" value="<?php if (empty($r111['r22p5'])) {
    echo'0';
} else {
    echo $r111['r22p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="24e1" name="24e1" maxlength="2" value="<?php if (empty($r111['r24p5'])) {
    echo'0';
} else {
    echo $r111['r24p5'];
}?>"></th>
<th scope="col"></th>
<th scope="col"></th>
<th scope="col"></th>
          </tr>
<input type="hidden" name="equipo1p5" value="<?php echo $equipo1; ?>"/>
<input type="hidden" name="equipo2p5" value="<?php echo $equipo2; ?>"/>
<input type="hidden" name="Id_p2juegosp2" value="<?php echo $Id_p2juegosp2; ?>"/>


<input type="hidden" name="tiemposjugadosp5" value="0"/>

<input type="hidden" name="deporte" value="beisbol"/>
<input type="hidden" name="iniciodtp5" value="<?php echo $row_Recordset1['iniciodtp2'];?>"/>



<input type="hidden" name="1e1" value="0"/>
<input type="hidden" name="2e1" value="0"/>
<input type="hidden" name="3e1" value="0"/>
<input type="hidden" name="4e1" value="0"/>
<input type="hidden" name="5e1" value="0"/>
<input type="hidden" name="6e1" value="0"/>
<input type="hidden" name="7e1" value="0"/>
<input type="hidden" name="8e1" value="0"/>
<input type="hidden" name="9e1" value="0"/>
<input type="hidden" name="10e1" value="0"/>
<input type="hidden" name="11e1" value="0"/>
<input type="hidden" name="12e1" value="0"/>
<input type="hidden" name="13e1" value="0"/>
<input type="hidden" name="14e1" value="0"/>
<input type="hidden" name="15e1" value="0"/>
<input type="hidden" name="16e1" value="0"/>
<input type="hidden" name="17e1" value="0"/>
<input type="hidden" name="18e1" value="0"/>
<input type="hidden" name="19e1" value="0"/>
<input type="hidden" name="20e1" value="0"/>

<input type="hidden" name="25e1" value="0"/>
<input type="hidden" name="26e1" value="0"/>
<input type="hidden" name="27e1" value="0"/>
<input type="hidden" name="28e1" value="0"/>
<input type="hidden" name="quienmete" value="<?php echo $codus; ?>"/>


<?php }?>




<?php if ($row_Recordset1['deportep2']=='baloncesto') {?>
    <button type="button" class="btn btn-primary btn-lg btn-block"><?php echo $row_Recordset1['deportep2']; ?></button>

<thead class="thead-dark">
  <tr>

<th scope="col">equipo1</br>equipo2</br>fecha</br>hora inicio</th>

<?php if (empty($r111['r23p5'])) {?>
    <th scope="col">Juego Completo</th>
    <th scope="col">1era MITAD</th>
    <?php
}else{
    ?>
<th scope="col">2da MITAD</th>
<th scope="col">1era MITAD</th>


<?php   
}
?>
  </tr>
</thead>
          <tr>

<th scope="col"><?php
$query_Recordset21 = sprintf(
    "/* PARSEADORES1 new\parley\adpsinresultados2.php - QUERY 12 */ SELECT *
FROM p1equipos
WHERE  

Id_p1equiposp1 = %s",
    GetSQLValueString($row_Recordset1['idequipo1p2'], "int")
);
$Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
$row_Recordset21 = mysqli_fetch_assoc($Recordset21);
$totalRows_Recordset21 = mysqli_num_rows($Recordset21);
$equipo1=$row_Recordset21['nomequipop1'];
$query_Recordset22 = sprintf(
    "/* PARSEADORES1 new\parley\adpsinresultados2.php - QUERY 13 */ SELECT *
FROM p1equipos
WHERE  

Id_p1equiposp1 = %s",
    GetSQLValueString($row_Recordset1['idequipo2p2'], "int")
);
$Recordset22 =mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
$row_Recordset22 = mysqli_fetch_assoc($Recordset22);
$totalRows_Recordset22 = mysqli_num_rows($Recordset22);
$equipo2=$row_Recordset22['nomequipop1'];
echo $equipo1; echo '</br>';?></th>
<th scope="col"><input type="number" max="999" class="form-control" id="23e1" name="23e1" maxlength="2" value="<?php if (empty($r111['r24p5'])) {
    echo'0';
} else {
    echo $r111['r23p5'];
}?>"></th>
<th scope="col"><input type="number" max="999" class="form-control" id="21e1" name="21e1" maxlength="2" value="<?php if (empty($r111['r22p5'])) {
    echo'0';
} else {
    echo $r111['r21p5'];
}?>">
</th>
<th scope="col">





</th>
<th scope="col">



</th>
<th scope="col"></th>


  </tr>
                    <tr>

<th scope="col"><?php

echo $equipo2; echo '</br>';?></th>
<th scope="col"><input type="number" max="999" class="form-control" id="24e1" name="24e1" maxlength="2" value="<?php if (empty($r111['r23p5'])) {
    echo'0';
} else {
    echo $r111['r24p5'];
}?>"></th>
<th scope="col"><input type="number" max="999" class="form-control" id="22e1" name="22e1" maxlength="2" value="<?php if (empty($r111['r21p5'])) {
    echo'0';
} else {
    echo $r111['r22p5'];
}?>"></th>
<th scope="col"></th>
<th scope="col"></th>
<th scope="col"></th>
  </tr>
<input type="hidden" name="equipo1p5" value="<?php echo $equipo1; ?>"/>
<input type="hidden" name="equipo2p5" value="<?php echo $equipo2; ?>"/>
<input type="hidden" name="Id_p2juegosp2" value="<?php echo $Id_p2juegosp2; ?>"/>


<input type="hidden" name="tiemposjugadosp5" value="0"/>

<input type="hidden" name="deporte" value="baloncesto"/>
<input type="hidden" name="iniciodtp5" value="<?php echo $row_Recordset1['iniciodtp2'];?>"/>



<input type="hidden" name="1e1" value="0"/>
<input type="hidden" name="2e1" value="0"/>
<input type="hidden" name="3e1" value="0"/>
<input type="hidden" name="4e1" value="0"/>
<input type="hidden" name="5e1" value="0"/>
<input type="hidden" name="6e1" value="0"/>
<input type="hidden" name="7e1" value="0"/>
<input type="hidden" name="8e1" value="0"/>
<input type="hidden" name="9e1" value="0"/>
<input type="hidden" name="10e1" value="0"/>
<input type="hidden" name="11e1" value="0"/>
<input type="hidden" name="12e1" value="0"/>
<input type="hidden" name="13e1" value="0"/>
<input type="hidden" name="14e1" value="0"/>
<input type="hidden" name="15e1" value="0"/>
<input type="hidden" name="16e1" value="0"/>
<input type="hidden" name="17e1" value="0"/>
<input type="hidden" name="18e1" value="0"/>
<input type="hidden" name="19e1" value="0"/>
<input type="hidden" name="20e1" value="0"/>

<input type="hidden" name="25e1" value="0"/>
<input type="hidden" name="26e1" value="0"/>
<input type="hidden" name="27e1" value="0"/>
<input type="hidden" name="28e1" value="0"/>
<input type="hidden" name="quienmete" value="<?php echo $codus; ?>"/>


<?php }?>













<?php if ($row_Recordset1['deportep2']=='futbol') {?>

    <button type="button" class="btn btn-primary btn-lg btn-block"><?php echo $row_Recordset1['deportep2']; ?></button>

<thead class="thead-dark">
  <tr>

<th scope="col">equipo1fff</br>equipo2</br>fecha</br>hora inicio</th>

<?php if (empty($r111['r23p5'])) {?>

    
<th scope="col">Juego Completo</th>
<th scope="col">1era MITAD</th>
<?php
}else{
?>
<th scope="col">2da MITAD</th>
<th scope="col">1era MITAD</th>


<?php   
}
?>
  </tr>
</thead>
          <tr>

<th scope="col"><?php
$query_Recordset21 = sprintf(
    "/* PARSEADORES1 new\parley\adpsinresultados2.php - QUERY 14 */ SELECT *
FROM p1equipos
WHERE  

Id_p1equiposp1 = %s",
    GetSQLValueString($row_Recordset1['idequipo1p2'], "int")
);
$Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
$row_Recordset21 = mysqli_fetch_assoc($Recordset21);
$totalRows_Recordset21 = mysqli_num_rows($Recordset21);
$equipo1=$row_Recordset21['nomequipop1'];
$query_Recordset22 = sprintf(
    "/* PARSEADORES1 new\parley\adpsinresultados2.php - QUERY 15 */ SELECT *
FROM p1equipos
WHERE  

Id_p1equiposp1 = %s",
    GetSQLValueString($row_Recordset1['idequipo2p2'], "int")
);
$Recordset22 =mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
$row_Recordset22 = mysqli_fetch_assoc($Recordset22);
$totalRows_Recordset22 = mysqli_num_rows($Recordset22);
$equipo2=$row_Recordset22['nomequipop1'];
echo $equipo1; echo '</br>';?></th>
<th scope="col"><input type="number" max="99" class="form-control" id="23e1" name="23e1" maxlength="2" value="<?php if (empty($r111['r24p5'])) {
    echo'0';
} else {
    echo $r111['r23p5'];
}?>"></th>
<th scope="col"><input type="number" max="99" class="form-control" id="21e1" name="21e1" maxlength="2" value="<?php if (empty($r111['r22p5'])) {
    echo'0';
} else {
    echo $r111['r21p5'];
}?>">
</th>
<th scope="col">





</th>
<th scope="col">



</th>
<th scope="col"></th>


  </tr>
                    <tr>

<th scope="col"><?php

echo $equipo2; echo '</br>';?></th>
<th scope="col"><input type="number" max="99" class="form-control" id="24e1" name="24e1" maxlength="2" value="<?php if (empty($r111['r23p5'])) {
    echo'0';
} else {
    echo $r111['r24p5'];
}?>"></th>
<th scope="col"><input type="number" max="99" class="form-control" id="22e1" name="22e1" maxlength="2" value="<?php if (empty($r111['r21p5'])) {
    echo'0';
} else {
    echo $r111['r22p5'];
}?>"></th>
<th scope="col"></th>
<th scope="col"></th>
<th scope="col"></th>
  </tr>
<input type="hidden" name="equipo1p5" value="<?php echo $equipo1; ?>"/>
<input type="hidden" name="equipo2p5" value="<?php echo $equipo2; ?>"/>
<input type="hidden" name="Id_p2juegosp2" value="<?php echo $Id_p2juegosp2; ?>"/>


<input type="hidden" name="tiemposjugadosp5" value="0"/>

<input type="hidden" name="deporte" value="futbol"/>
<input type="hidden" name="iniciodtp5" value="<?php echo $row_Recordset1['iniciodtp2'];?>"/>



<input type="hidden" name="1e1" value="0"/>
<input type="hidden" name="2e1" value="0"/>
<input type="hidden" name="3e1" value="0"/>
<input type="hidden" name="4e1" value="0"/>
<input type="hidden" name="5e1" value="0"/>
<input type="hidden" name="6e1" value="0"/>
<input type="hidden" name="7e1" value="0"/>
<input type="hidden" name="8e1" value="0"/>
<input type="hidden" name="9e1" value="0"/>
<input type="hidden" name="10e1" value="0"/>
<input type="hidden" name="11e1" value="0"/>
<input type="hidden" name="12e1" value="0"/>
<input type="hidden" name="13e1" value="0"/>
<input type="hidden" name="14e1" value="0"/>
<input type="hidden" name="15e1" value="0"/>
<input type="hidden" name="16e1" value="0"/>
<input type="hidden" name="17e1" value="0"/>
<input type="hidden" name="18e1" value="0"/>
<input type="hidden" name="19e1" value="0"/>
<input type="hidden" name="20e1" value="0"/>

<input type="hidden" name="25e1" value="0"/>
<input type="hidden" name="26e1" value="0"/>
<input type="hidden" name="27e1" value="0"/>
<input type="hidden" name="28e1" value="0"/>
<input type="hidden" name="quienmete" value="<?php echo $codus; ?>"/>


<?php }?>


<?php if ($row_Recordset1['deportep2']=='futbolamericano') {?>

<button type="button" class="btn btn-primary btn-lg btn-block"><?php echo $row_Recordset1['deportep2']; ?></button>

<thead class="thead-dark">
<tr>

<th scope="col">equipo1</br>equipo2</br>fecha</br>hora inicio</th>

<?php if (empty($r111['r23p5'])) {?>

    
<th scope="col">Juego Completo</th>
<th scope="col">1era MITAD</th>
<?php
}else{
?>
<th scope="col">2da MITAD</th>
<th scope="col">1era MITAD</th>


<?php   
}
?>

</tr>
</thead>
      <tr>

<th scope="col"><?php
$query_Recordset21 = sprintf(
"/* PARSEADORES1 new\parley\adpsinresultados2.php - QUERY 16 */ SELECT *
FROM p1equipos
WHERE  

Id_p1equiposp1 = %s",
GetSQLValueString($row_Recordset1['idequipo1p2'], "int")
);
$Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
$row_Recordset21 = mysqli_fetch_assoc($Recordset21);
$totalRows_Recordset21 = mysqli_num_rows($Recordset21);
$equipo1=$row_Recordset21['nomequipop1'];
$query_Recordset22 = sprintf(
"/* PARSEADORES1 new\parley\adpsinresultados2.php - QUERY 17 */ SELECT *
FROM p1equipos
WHERE  

Id_p1equiposp1 = %s",
GetSQLValueString($row_Recordset1['idequipo2p2'], "int")
);
$Recordset22 =mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
$row_Recordset22 = mysqli_fetch_assoc($Recordset22);
$totalRows_Recordset22 = mysqli_num_rows($Recordset22);
$equipo2=$row_Recordset22['nomequipop1'];
echo $equipo1; echo '</br>';?></th>
<th scope="col"><input type="number" class="form-control" id="23e1" name="23e1" maxlength="2" value="<?php if (empty($r111['r24p5'])) {
    echo'0';
} else {
    echo $r111['r23p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="21e1" name="21e1" maxlength="2" value="<?php if (empty($r111['r22p5'])) {
    echo'0';
} else {
    echo $r111['r21p5'];
}?>">
</th>
<th scope="col">





</th>
<th scope="col">



</th>
<th scope="col"></th>


</tr>
                <tr>

<th scope="col"><?php

echo $equipo2; echo '</br>';?></th>
<th scope="col"><input type="number" class="form-control" id="24e1" name="24e1" maxlength="2" value="<?php if (empty($r111['r23p5'])) {
    echo'0';
} else {
    echo $r111['r24p5'];
}?>"></th>
<th scope="col"><input type="number" class="form-control" id="22e1" name="22e1" maxlength="2" value="<?php if (empty($r111['r21p5'])) {
    echo'0';
} else {
    echo $r111['r22p5'];
}?>"></th>
<th scope="col"></th>
<th scope="col"></th>
<th scope="col"></th>
</tr>
<input type="hidden" name="equipo1p5" value="<?php echo $equipo1; ?>"/>
<input type="hidden" name="equipo2p5" value="<?php echo $equipo2; ?>"/>
<input type="hidden" name="Id_p2juegosp2" value="<?php echo $Id_p2juegosp2; ?>"/>


<input type="hidden" name="tiemposjugadosp5" value="0"/>

<input type="hidden" name="deporte" value="futbolamericano"/>
<input type="hidden" name="iniciodtp5" value="<?php echo $row_Recordset1['iniciodtp2'];?>"/>



<input type="hidden" name="1e1" value="0"/>
<input type="hidden" name="2e1" value="0"/>
<input type="hidden" name="3e1" value="0"/>
<input type="hidden" name="4e1" value="0"/>
<input type="hidden" name="5e1" value="0"/>
<input type="hidden" name="6e1" value="0"/>
<input type="hidden" name="7e1" value="0"/>
<input type="hidden" name="8e1" value="0"/>
<input type="hidden" name="9e1" value="0"/>
<input type="hidden" name="10e1" value="0"/>
<input type="hidden" name="11e1" value="0"/>
<input type="hidden" name="12e1" value="0"/>
<input type="hidden" name="13e1" value="0"/>
<input type="hidden" name="14e1" value="0"/>
<input type="hidden" name="15e1" value="0"/>
<input type="hidden" name="16e1" value="0"/>
<input type="hidden" name="17e1" value="0"/>
<input type="hidden" name="18e1" value="0"/>
<input type="hidden" name="19e1" value="0"/>
<input type="hidden" name="20e1" value="0"/>

<input type="hidden" name="25e1" value="0"/>
<input type="hidden" name="26e1" value="0"/>
<input type="hidden" name="27e1" value="0"/>
<input type="hidden" name="28e1" value="0"/>
<input type="hidden" name="quienmete" value="<?php echo $codus; ?>"/>


<?php }?>









































<?php if ($row_Recordset1['deportep2']=='hockey') {?>

<button type="button" class="btn btn-primary btn-lg btn-block"><?php echo $row_Recordset1['deportep2']; ?></button>

<thead class="thead-dark">
<tr>

<th scope="col">equipo1</br>equipo2</br>fecha</br>hora inicio</th>
<th scope="col">juego</th>

</tr>
</thead>
      <tr>

<th scope="col"><?php
$query_Recordset21 = sprintf(
    "/* PARSEADORES1 new\parley\adpsinresultados2.php - QUERY 18 */ SELECT *
FROM p1equipos
WHERE  

Id_p1equiposp1 = %s",
    GetSQLValueString($row_Recordset1['idequipo1p2'], "int")
);
$Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
$row_Recordset21 = mysqli_fetch_assoc($Recordset21);
$totalRows_Recordset21 = mysqli_num_rows($Recordset21);
$equipo1=$row_Recordset21['nomequipop1'];
$query_Recordset22 = sprintf(
    "/* PARSEADORES1 new\parley\adpsinresultados2.php - QUERY 19 */ SELECT *
FROM p1equipos
WHERE  

Id_p1equiposp1 = %s",
    GetSQLValueString($row_Recordset1['idequipo2p2'], "int")
);
$Recordset22 =mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
$row_Recordset22 = mysqli_fetch_assoc($Recordset22);
$totalRows_Recordset22 = mysqli_num_rows($Recordset22);
$equipo2=$row_Recordset22['nomequipop1'];
echo $equipo1; echo '</br>';?></th>
<th scope="col"><input type="number" max="999" class="form-control" id="21e1" name="21e1" maxlength="2" value="<?php if (empty($r111['r21p5'])) {
    echo'0';
} else {
    echo $r111['r21p5'];
}?>"></th>

<th scope="col">





</th>
<th scope="col">



</th>
<th scope="col"></th>


</tr>
                <tr>

<th scope="col"><?php

echo $equipo2; echo '</br>';?></th>
<th scope="col"><input type="number" max="999" class="form-control" id="22e1" name="22e1" maxlength="2" value="<?php if (empty($r111['r22p5'])) {
    echo'0';
} else {
    echo $r111['r22p5'];
}?>"></th>

<th scope="col"></th>
<th scope="col"></th>
<th scope="col"></th>
</tr>
<input type="hidden" name="equipo1p5" value="<?php echo $equipo1; ?>"/>
<input type="hidden" name="equipo2p5" value="<?php echo $equipo2; ?>"/>
<input type="hidden" name="Id_p2juegosp2" value="<?php echo $Id_p2juegosp2; ?>"/>


<input type="hidden" name="tiemposjugadosp5" value="0"/>

<input type="hidden" name="deporte" value="hockey"/>
<input type="hidden" name="iniciodtp5" value="<?php echo $row_Recordset1['iniciodtp2'];?>"/>



<input type="hidden" name="1e1" value="0"/>
<input type="hidden" name="2e1" value="0"/>
<input type="hidden" name="3e1" value="0"/>
<input type="hidden" name="4e1" value="0"/>
<input type="hidden" name="5e1" value="0"/>
<input type="hidden" name="6e1" value="0"/>
<input type="hidden" name="7e1" value="0"/>
<input type="hidden" name="8e1" value="0"/>
<input type="hidden" name="9e1" value="0"/>
<input type="hidden" name="10e1" value="0"/>
<input type="hidden" name="11e1" value="0"/>
<input type="hidden" name="12e1" value="0"/>
<input type="hidden" name="13e1" value="0"/>
<input type="hidden" name="14e1" value="0"/>
<input type="hidden" name="15e1" value="0"/>
<input type="hidden" name="16e1" value="0"/>
<input type="hidden" name="17e1" value="0"/>
<input type="hidden" name="18e1" value="0"/>
<input type="hidden" name="19e1" value="0"/>
<input type="hidden" name="20e1" value="0"/>


<input type="hidden" name="23e1" value="0"/>
<input type="hidden" name="24e1" value="0"/>
<input type="hidden" name="25e1" value="0"/>
<input type="hidden" name="26e1" value="0"/>
<input type="hidden" name="27e1" value="0"/>
<input type="hidden" name="28e1" value="0"/>
<input type="hidden" name="quienmete" value="<?php echo $codus; ?>"/>


<?php }?>







<?php
} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
?>

        </tbody>
      </table>
      				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<table>
                    <td>
                    <a href="<?php echo $_SERVER['HTTP_REFERER'] ?>" class="btn btn-default">Regresar</a>
                    </td>
						<td>
                        <button type="submit" name="resultado" class="btn btn-primary">agregar o modificar resultados</button>
                        </td>
                        <?php if ($r111['r23p5'] || $r111['r22p5'] ||  $r111['r21p5'] ||  $r111['r24p5'] > ' ') {?>
                            <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>
                        <td>    
                        <button type="submit" name="eliminar"  class="btn btn-warning">Eliminar Resultado</button>
                        </td>
                         <?php
                        } 
                        ?>
                        
                        <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>

                        <td>
                        <button name="diego" style="float: right;" class="btn btn-danger">ANULAR JUEGO</button>
                        </td>
                        </table>					
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