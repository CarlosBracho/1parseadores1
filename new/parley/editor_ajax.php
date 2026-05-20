<?php
//if (!isset($_SESSION)) {    session_start();} 
require_once('../Connections/conexionbanca.php');
//$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; 
//include("../includes/comprobar_acceso.php");
//var_dump($_SESSION);
$tipo=7; //0 taquilla 1 agente 2 distribuidor 7 adminitrador

echo 'si es este archivo';
$MM_donotCheckaccess = "false";
setlocale(LC_ALL, "es_ES");
$horaTxt=horaactual();
$FechaTxt=fechaactualbd();
$datetime=$FechaTxt.' '.$horaTxt;
$datetime2=$FechaTxt.' '.'23:59:59';


$dtime2 =$datetime; 
$dtime2 = strtotime(' 6 hour , 30 minute', strtotime($dtime2)); 
$dtime2 = date('Y-m-d H:i:s', $dtime2);

//$usuario=$_SESSION['MM_id_usuario'];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

//inicio funciones
//funcion agregar logro manual
if (isset($_POST['logromanual'])) {
echo 'rrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr<br>';


if (empty($_POST['logroABoRLp6'])) {
    $logroABoRL="";
} else {
    $logroABoRL=$_POST['logroABoRLp6'];
}



echo $logroABoRL.' uuuuuuuuuuuuuuuuuu<br>';

$query_Recordset1111 = sprintf(
"/* PARSEADORES1 new\parley\editor_ajax.php - QUERY 1 */ SELECT logrop6, idp6logrosind, logroABoRLp6, idjuegop6, equipop6, tipojugadap6
FROM  p6logrosind
WHERE logrodtp6 >= %s AND idlogrop6 = %s AND idjuegop6 >= 0 ORDER BY idjuegop6 DESC",
GetSQLValueString($datetime, "date"),
GetSQLValueString($_POST['Id_p3logrosp3'], "int"));
$Recordset1111 =mysqli_query($conexionbanca, $query_Recordset1111) or die(mysqli_error($conexionbanca));
$row_Recordset1111 = mysqli_fetch_assoc($Recordset1111);
$totalRows_Recordset1111 = mysqli_num_rows($Recordset1111);

if($totalRows_Recordset1111==1){ 
    echo 'Si hay logro manual<br>'; 

    $insertSQL1 = sprintf(
        "/* PARSEADORES1 new\parley\editor_ajax.php - QUERY 2 */ UPDATE p6logrosind
				SET logrop6=%s, logroABoRLp6=%s			
				WHERE idlogrop6=%s",
        GetSQLValueString($_POST['logromanual'], "double"),
        GetSQLValueString($_POST['logroABoRLp6'], "text"),
        GetSQLValueString($_POST['Id_p3logrosp3'], "int"));        
    $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));

}else{ 
    echo 'No hay logro manual<br>'; 

    $insertSQL = sprintf(
        "/* PARSEADORES1 new\parley\editor_ajax.php - QUERY 3 */ INSERT 
				INTO p6logrosind
				(idjuegop6, equipop6, tipojugadap6, logrop6, idlogrop6, logrodtp6, logroABoRLp6) 
				VALUES (%s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString($_POST['idjuegop3'], "int"),
        GetSQLValueString($_POST['equipop3'], "int"),
        GetSQLValueString($_POST['tipojugada'], "text"),
        GetSQLValueString($_POST['logromanual'], "double"),
        GetSQLValueString($_POST['Id_p3logrosp3'], "int"),
        GetSQLValueString($_POST['logrodtp6'], "date"),
        GetSQLValueString($_POST['logroABoRLp6'], "text"));
        $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));





}












/*
    if (empty($_POST['logroABoRL'])) {
        $logroABoRL="";
    } else {
        $logroABoRL=$_POST['logroABoRL'];
    }
    

    $insertSQL = sprintf(
        "INSERT 
				INTO p3logros
				(idjuegop3, Id_p1equiposp3, equipop3, tipojugadap3, logrop3, logrodtp3, logroABoRLp3) 
				VALUES (%s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString($_POST['idjuego'], "int"),
        GetSQLValueString($_POST['Id_p1equipos'], "int"),
        GetSQLValueString($_POST['equipo'], "int"),
        GetSQLValueString($_POST['tipojugada'], "text"),
        GetSQLValueString($_POST['logro'], "double"),
        GetSQLValueString($_POST['logrodtp3'], "date"),
        GetSQLValueString($_POST['logroABoRL'], "text")
    );
        
    $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
    
    
    */
    
            

    
    
    //$insertGoTo = "adlistajuegos.php";

    //header(sprintf("Location: %s", $insertGoTo));
}
//fin funcion agregar logro manual

//fin funciones















$query_Recordset5 = sprintf(
    "/* PARSEADORES1 new\parley\editor_ajax.php - QUERY 4 */ SELECT * FROM usuario, taquilla, taquilla_opc_parley, agencia,
			banca
WHERE usuario.id_usuario = %s AND 
usuario.cod_taquilla = taquilla.cod_taquilla AND
taquilla_opc_parley.cod_taquilla = usuario.cod_taquilla AND
taquilla.cod_agencia = agencia.cod_agencia AND
agencia.cod_banca = banca.cod_banca
LIMIT 1",
    GetSQLValueString($_SESSION['MM_id_usuario'], "int")
);
$Recordset5 = mysqli_query($conexionbanca, $query_Recordset5) or die(mysqli_error($conexionbanca));
$row_Recordset5 = mysqli_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysqli_num_rows($Recordset5);
$taquilla=10;
$tipotaquilla=10;
$tra_codigo=10;
$saldoactual=10;
$cod_agencia=10;
$tipo_pagoa=10;
$tel_agencia=10;
$apu_maxparley=10;
$apu_minparley=10;
$comb_minparley=10;
$comb_maxparley=10;
$comb_hembra=10;

$efectivoOt=10;
$tipo_pago=10;
$moneda=10;
$scroll=10;
$ttl=0;



if ($moneda<=2) {
    $monedanombre='Bss';
}
if ($moneda==3) {
    $monedanombre='Usd';
}
if ($moneda==4) {
    $monedanombre='Cop';
}
if ($moneda==5) {
    $monedanombre='Sol';
}
if ($moneda==10) {
    $monedanombre='Usd';
}
$ejemMax=30;
$totalRows_Recordset1=0;


                                            $query_Recordset13 = sprintf(
                                                "/* PARSEADORES1 new\parley\editor_ajax.php - QUERY 5 */ SELECT MAX(Idbalancecli) 
					FROM balanceclientes
					WHERE monedac = %s AND 
					cod_taquilla = %s",
                                                GetSQLValueString($moneda, "int"),
                                                GetSQLValueString($taquilla, "int")
                                            );
    $Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
    $row_Recordset13 = mysqli_fetch_assoc($Recordset13);
    $totalRows_Recordset13 = mysqli_num_rows($Recordset13);
    $Idbalancecli=((int)$row_Recordset13['MAX(Idbalancecli)']);
    
                                    $query_Recordset14 = sprintf(
                                        "/* PARSEADORES1 new\parley\editor_ajax.php - QUERY 6 */ SELECT saldoactualc
					FROM balanceclientes
					WHERE monedac = %s AND
					Idbalancecli = %s",
                                        GetSQLValueString($moneda, "int"),
                                        GetSQLValueString($Idbalancecli, "int")
                                    );
    $Recordset14 = mysqli_query($conexionbanca, $query_Recordset14) or die(mysqli_error($conexionbanca));
    $row_Recordset14 = mysqli_fetch_assoc($Recordset14);
    $totalRows_Recordset14 = mysqli_num_rows($Recordset14);
    $saldoactualc=((float)$row_Recordset14['saldoactualc']);

//inicio select logros colocados por agente

$tlarray1222 = array(
    "logrop6"    => "99999",
    "idp6logrosind"  => "99999",
    "logroABoRLp6"  => "99999",
    "idjuegop6" => "99999",
    "equipop6" => "99999",
    "tipojugadap6" => "99999",
);

//print_r($tlarray1);


$query_Recordset1111 = sprintf(
    "/* PARSEADORES1 new\parley\editor_ajax.php - QUERY 7 */ SELECT logrop6, idp6logrosind, logroABoRLp6, idjuegop6, equipop6, tipojugadap6, idlogrop6
FROM  p6logrosind
WHERE logrodtp6 >= %s AND idjuegop6 >= 0 ORDER BY idjuegop6 DESC",
    GetSQLValueString($datetime, "date"));
$Recordset1111 =mysqli_query($conexionbanca, $query_Recordset1111) or die(mysqli_error($conexionbanca));
$row_Recordset1111 = mysqli_fetch_assoc($Recordset1111);
$totalRows_Recordset1111 = mysqli_num_rows($Recordset1111);
  //echo  $totalRows_Recordset111;
  $totalvueltas=$totalRows_Recordset1111;
 // echo $row_Recordset111['logrop3'];

while ($fila = mysqli_fetch_assoc($Recordset1111)) {
    $tlarray1[] = $fila;
}
//print_r($tlarray1);
//$tlarray1='';
//if (!isset($tlarray1)) {$tlarray1=1;}
//final logros colocados por agente
    $query_Recordset111 = sprintf(
        "/* PARSEADORES1 new\parley\editor_ajax.php - QUERY 8 */ SELECT logrop3, Id_p3logrosp3, logroABoRLp3, idjuegop3, equipop3, tipojugadap3
    FROM  p3logros
    WHERE logrodtp3 >= %s AND idjuegop3 >= 0 ORDER BY idjuegop3 DESC",
        GetSQLValueString($datetime, "date"));
    $Recordset111 =mysqli_query($conexionbanca, $query_Recordset111) or die(mysqli_error($conexionbanca));
    $row_Recordset111 = mysqli_fetch_assoc($Recordset111);
    $totalRows_Recordset111 = mysqli_num_rows($Recordset111);
      //echo  $totalRows_Recordset111;
      $totalvueltas=$totalRows_Recordset111;
     // echo $row_Recordset111['logrop3'];
  
    while ($fila = mysqli_fetch_assoc($Recordset111)) {
        $tlarray[] = $fila;
    }

//print_r($tlarray1)."date";
    function Obtenerlogro($Id_p2juegos, $equipo, $tipojugada, $tlarray, $tlarray1)
    {
//inicio logros individual
$o2=0; 
$palabra_a_buscar  = $Id_p2juegos;
//if (isset($tlarray1)) {
//if(is_array($tlarray1)=='true'){
foreach ($tlarray1 as $clave=>$valor) {
    $indice = array_search($palabra_a_buscar, $valor);
    if ($valor["idjuegop6"]==$Id_p2juegos & $valor["equipop6"]==$equipo & $valor["tipojugadap6"]==$tipojugada) {
        if ($indice) {
            $logro=$valor['logrop6'];
            $Id_p3logros=$valor['idlogrop6'];
            $logroABoRL=$valor['logroABoRLp6'];
            $o2=1;
        }
        return array($logro, $Id_p3logros, $logroABoRL);
    }
}//}



//fin logros individual

//inicio logros sistema usare un if si hay individual no usara este
if($o2==0){
        $palabra_a_buscar  = $Id_p2juegos;
        foreach ($tlarray as $clave=>$valor) {
            $indice = array_search($palabra_a_buscar, $valor);
            if ($valor["idjuegop3"]==$Id_p2juegos & $valor["equipop3"]==$equipo & $valor["tipojugadap3"]==$tipojugada) {
                if ($indice) {
                    $logro=$valor['logrop3'];
                    $Id_p3logros=$valor['Id_p3logrosp3'];
                    $logroABoRL=$valor['logroABoRLp3'];
                }
                return array($logro, $Id_p3logros, $logroABoRL);
            }
        }
    }
//fin logros sistema



    }



    function deam($psi, $lgam, $ttl)
    {
        if($psi==1){ $vlpsi='+'; $deci=($lgam/100)+1;}else{ $vlpsi=''; $deci=(100/str_replace('-', '', $lgam))+1;}
$deci=number_format($deci, 2, ".", ","); 
if($ttl==0){ echo $vlpsi.$lgam; }
if($ttl==1){ echo $deci; }
if($ttl==2){ echo $vlpsi.$lgam.'<br>'.$deci; }            
            }
   
$query_Recordset1b = sprintf(
    "/* PARSEADORES1 new\parley\editor_ajax.php - QUERY 9 */ SELECT * FROM p2juegos WHERE 
deportep2 = %s AND 
iniciodtp2 > %s AND
idequipo1p2 > 0 AND
idequipo1p2 > 0
ORDER BY iniciodtp2 
DESC",
    GetSQLValueString("beisbol", "text"),
    GetSQLValueString($datetime, "date")
);
    $Recordset1b = mysqli_query($conexionbanca, $query_Recordset1b) or die(mysqli_error($conexionbanca));
    $row_Recordset1b = mysqli_fetch_assoc($Recordset1b);
    $totalRows_Recordset1b = mysqli_num_rows($Recordset1b);

    
    
    
    
$query_Recordset101 = sprintf(
    "/* PARSEADORES1 new\parley\editor_ajax.php - QUERY 10 */ SELECT * FROM p2juegos WHERE 
deportep2 = %s AND 
iniciodtp2 > %s AND
idequipo1p2 > 0 AND
idequipo1p2 > 0
ORDER BY iniciodtp2 
DESC",
    GetSQLValueString("baloncesto", "text"),
    GetSQLValueString($datetime, "date")
);
$Recordset101 = mysqli_query($conexionbanca, $query_Recordset101) or die(mysqli_error($conexionbanca));
$row_Recordset101 = mysqli_fetch_assoc($Recordset101);
$totalRows_Recordset101 = mysqli_num_rows($Recordset101);

$query_Recordset201 = sprintf(
    "/* PARSEADORES1 new\parley\editor_ajax.php - QUERY 11 */ SELECT * FROM p2juegos WHERE 
deportep2 = %s AND 
iniciodtp2 > %s AND
idequipo1p2 > 0 AND
idequipo2p2 > 0
ORDER BY iniciodtp2 
DESC",
    GetSQLValueString("futbol", "text"),
    GetSQLValueString($datetime, "date")
);
$Recordset201 = mysqli_query($conexionbanca, $query_Recordset201) or die(mysqli_error($conexionbanca));
$row_Recordset201 = mysqli_fetch_assoc($Recordset201);
$totalRows_Recordset201 = mysqli_num_rows($Recordset201);

$query_Recordset301 = sprintf(
    "/* PARSEADORES1 new\parley\editor_ajax.php - QUERY 12 */ SELECT * FROM p2juegos WHERE 
deportep2 = %s AND 
iniciodtp2 > %s AND
idequipo1p2 > 0 AND
idequipo2p2 > 0
ORDER BY iniciodtp2 
DESC",
    GetSQLValueString("hockey", "text"),
    GetSQLValueString($datetime, "date")
);
$Recordset301 = mysqli_query($conexionbanca, $query_Recordset301) or die(mysqli_error($conexionbanca));
$row_Recordset301 = mysqli_fetch_assoc($Recordset301);
$totalRows_Recordset301 = mysqli_num_rows($Recordset301);

$query_Recordset401 = sprintf(
    "/* PARSEADORES1 new\parley\editor_ajax.php - QUERY 13 */ SELECT * FROM p2juegos WHERE 
deportep2 = %s AND 
iniciodtp2 > %s AND
idequipo1p2 > 0 AND
idequipo2p2 > 0
ORDER BY iniciodtp2 
DESC",
    GetSQLValueString("futbolamericano", "text"),
    GetSQLValueString($datetime, "date")
);
$Recordset401 = mysqli_query($conexionbanca, $query_Recordset401) or die(mysqli_error($conexionbanca));
$row_Recordset401 = mysqli_fetch_assoc($Recordset401);
$totalRows_Recordset401 = mysqli_num_rows($Recordset401);




$emcab=0; $emcaf=0; $emcafa=0;

?>
<!DOCTYPE html>
<!-- saved from url=(0033)https:// -->
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>.:Apuestas:.</title>
    <!-- Bootstrap core CSS 
    <link href="./Vendedor/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    -->
    <link href="../css/bootstrapv452bootswatchv452yeti.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="./Vendedor/modern-business.css" rel="stylesheet">
    <link href="./Vendedor/bootstrap-datepicker3.min.css" rel="stylesheet">
    <!--<link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://bootswatch.com/4/yeti/bootstrap.min.css" rel="stylesheet">-->

    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css" rel="stylesheet">-->
    <link href="./Vendedor/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./Vendedor/toastr.min.css">
    <link href="./Vendedor/css.css" rel="stylesheet">
    <link href="./Vendedor/css2018.css" rel="stylesheet">
	    <link href="../fonts/font-awesome.min4.7.0.css" rel="stylesheet">

        <script src="../js/jquery3.6.0.min.js"></script>


<script language="javascript">
var usuario = <?php echo $usuario;?>;

//alert(usuario);
function infou() {
 $.get( "ultimotickettap.php?recordID="+usuario, function( data ) {
 $( "#ultimajugada" ).html( data );
});
}
$(document).ready(function() {
$.get( "ultimotickettap.php?recordID="+usuario, function( data ) {
$( "#ultimajugada" ).html( data );
});
var refreshId6 = setInterval(function() {
infou();
}, 100000); //100 segundos
});


function mensajes() {
 $.get( "../includes/mensajes.php?recordID=7", function( data ) {
 $( "#mensajes" ).html( data );
});
}
$(document).ready(function() {
$.get( "../includes/mensajes.php?recordID=7", function( data ) {
$( "#mensajes" ).html( data );
});
var refreshId6 = setInterval(function() {
    mensajes();
}, 10000); //10 segundos
});




</script>
<script type="text/javascript">
    var time;

    function inicio() {
        time = setTimeout(function() {
            $(document).ready(function(e) {
                $("#form").submit(function() {
                    //alert("SUBMIT");
                    return false; //Si devolvemos false, el formulario ya no se enviarÃ¡.
                });
                //enviar();
                /* $.ajax({
		url:'server/include/verisession.php',
		type:'POST',
		data:'veri=1',
		success: function(data){			
			if(data == 1)
			{
				alert("Sesion Caducada");
			        document.location.href='index.html';			   
			}			
		}	
	});*/
            });
        }, 1800000); //fin timeout
    } //fin inicio
    function reset() {
        clearTimeout(time); //limpia el timeout para resetear el tiempo desde cero 
        time = setTimeout(function() {
            $(document).ready(function(e) {
                $("#form").submit(function() {
                    //alert("SUBMIT");
                    return false; //Si devolvemos false, el formulario ya no se enviarÃ¡.
                });
                //enviar();
                /*$.ajax({
		url:'server/include/verisession.php',
		type:'POST',
		data:'veri=1',
		success: function(data){			
			if(data == 1)
			{
			   alert("Sesion Caducada");
			   document.location.href='index.html';			   
			}			
		}	
	});*/
            });
        }, 1800000); //fin timeout
    } //fin reset
    function autoservicio() {
        $.post("taquilla_ticket/autoservicio",
            function(eData) {
                $("#detalleAutoservicio").html(eData);
            });
    }
</script>

<script type="text/javascript">
    $(function() {
        $(".hlpdep").button();
    });
</script>
<script>
    function funciones(funcion, idfuncion, operador){
        //alert('asdasdasdasdas');	// aqui estoy
        $.post("../parley/ageditorparleyfunciones.php", 
        {
		funcion:funcion,
		idfuncion:idfuncion,
		operador:operador
		},
        function(eData){				
            $("#dialog-message7").html(eData);
        });	
    } 

</script>


<script>
    function crearjuego(funcion, idfuncion, operador){
        //alert('asdasdasdasdas');	// estoyd aqui
        $.post("../parley/adagregarjuego.php", 
        {
		funcion:funcion,
		idfuncion:idfuncion,
		operador:operador
		},
        function(eData){				
            $("#dialog-message88").html(eData);
        });	
    } 

</script>


<script>
    function crearequipo(funcion, idfuncion, operador){
        //alert('asdasdasdasdas');	// estoyd aqui
        $.post("../parley/adagregarequipo.php", 
        {
		funcion:funcion,
		idfuncion:idfuncion,
		operador:operador
		},
        function(eData){				
            $("#dialog-message90").html(eData);
        });	
    } 

</script>

<script>
    function actualizahora(funcion, idfuncion, operador){
        //alert('asdasdasdasdas');	// estoyd aqui
        $.post("../parley/cambiarhora.php", 
        {
		funcion:funcion,
		idfuncion:idfuncion,
		operador:operador
		},
        function(eData){				
            $("#dialog-message94").html(eData);
        });	
    } 

</script>



<script>
    function crearcompeticion(funcion, idfuncion, operador){
        //alert('asdasdasdasdas');	// estoyd aqui
        $.post("../parley/editarcompeticion.php", 
        {
		funcion:funcion,
		idfuncion:idfuncion,
		operador:operador
		},
        function(eData){				
            $("#dialog-message100").html(eData);
        });	
    } 

</script>



<script>
    function crearcompeticion2(funcion, idfuncion, operador){
        //alert('asdasdasdasdas');	// estoyd aqui
        $.post("../parley/logros_ajax.php", 
        {
		funcion:funcion,
		idfuncion:idfuncion,
		operador:operador
		},
        function(eData){				
            $("#dialog-message101").html(eData);
        });	
    } 

</script>
<script>
    function agregarlogros(idjuego, idequipo, tipoapuesta, num_equipo){
        //alert('asdasdasdasdas');	// estoyd aqui
        $.post("../parley/adagregarlogro.php", 
        {
            idjuego:idjuego,
            idequipo:idequipo,
            tipoapuesta:tipoapuesta,
            num_equipo:num_equipo
		},
        function(eData){				
            $("#dialog-message101d").html(eData);
        });	
    }  

</script>





</head>

<body onload="inicio()" onkeypress="reset()" onclick="reset()" onmousemove="reset()" style="background-color:#fff5f1;">
<header> 
  <!-- Fixed navbar -->
  <?php //include('../parley/menutap.php'); 
  ?>
</header>
    <div class="container-fluid">
       


<!-- Pantalla no mobil    XS - LG -->
<span>

    <div class="row border border-warning">


    <div class="col-lg-9 mb-4 border border-warning">
    <h6><div id="mensajes" role="alert"></div></h6>
            


    <ul class="nav nav-tabs">
    <li class="nav-item">
    <a class="nav-link active" data-toggle="tab"  href="#" id="show_all">Todo <?php echo $totalRows_Recordset1b+$totalRows_Recordset101+$totalRows_Recordset201+$totalRows_Recordset401+$totalRows_Recordset301;?></a>
    <a class="nav-link active" data-toggle="modal" data-target="#exampleModal90"  onclick="crearequipo(10, 1, 1);">Crear equipo</a>
  </li>
  <li class="nav-item">
    <a class="nav-link btn-outline-warning" data-toggle="tab" href="#beisbol">Beisbol <?php echo $totalRows_Recordset1b;?></a>
    <a class="nav-link btn-outline-warning" data-toggle="modal" data-target="#exampleModal88"  onclick="crearjuego(0, 1, 1);">Crear juego beisbol</a>
  </li>
  <li class="nav-item">
    <a class="nav-link btn-outline-primary" data-toggle="tab" href="#baloncesto">Baloncesto <?php echo $totalRows_Recordset101;?></a>
    <a class="nav-link btn-outline-primary" data-toggle="modal" data-target="#exampleModal88"  onclick="crearjuego(1, 1, 1);">Crear juego baloncesto</a>
  </li>
  <li class="nav-item">
    <a class="nav-link btn-outline-success" data-toggle="tab" href="#futbol">Futbol <?php echo $totalRows_Recordset201;?></a>
    <a class="nav-link btn-outline-success" data-toggle="modal" data-target="#exampleModal88"  onclick="crearjuego(2, 1, 1);">Crear juego futbol</a>
  </li>
  <li class="nav-item">
    <a class="nav-link btn-outline-info" data-toggle="tab" href="#futbolamericano">Futbol Americano <?php echo $totalRows_Recordset401;?></a>
    <a class="nav-link btn-outline-info" data-toggle="modal" data-target="#exampleModal88"  onclick="crearjuego(4, 1, 1);">Crear juego F.Americano</a>
  </li>
  <li class="nav-item">
    <a class="nav-link btn-outline-danger" data-toggle="tab" href="#hockey">Hockey <?php echo $totalRows_Recordset301;?></a>


    <a class="nav-link btn-outline-danger" data-toggle="modal" data-target="#exampleModal88"  onclick="crearjuego(5, 1, 1);">Crear juego Hockey</a>
    

  </li>

</ul>
<div id="myTabContent" class="tab-content">
  <div class="tab-pane fade active show" id="beisbol">
  <?php if ($totalRows_Recordset1b>0) { ?>
  <div class="card">
                        <div class="card-body border border-warning" style="padding: 0;">
                            <div class="row">
                                <div class="col-lg-12 mb-4 table-responsive">
<?php require_once('apc_beisbol1.php'); ?>
                                 </div>
                            </div>
                        </div>
                    </div>
                    <?php
}?>

</div>
  <div class="tab-pane fade" id="baloncesto">
  <?php if ($totalRows_Recordset101>0) { ?>
  <div class="card">
                        <div class="card-body border border-primary" style="padding: 0;">
                            <div class="row">
                                <div class="col-lg-12 mb-4 table-responsive">
<?php require_once('apc_baloncesto1.php'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
}?>
                  </div>
  <div class="tab-pane fade" id="futbol">
  <?php if ($totalRows_Recordset201>0) { ?>
  <div class="card">
                        <div class="card-body border border-success" style="padding: 0;">
                            <div class="row">
                                <div class="col-lg-12 mb-4 table-responsive">
<?php require_once('apc_futbol1.php'); ?>
								</div>
                            </div>
                        </div>
                    </div> 
                    <?php
}?>
                 </div>
  <div class="tab-pane fade" id="futbolamericano">
  <?php if ($totalRows_Recordset401>0) { ?>
  <div class="card">
                        <div class="card-body border border-info" style="padding: 0;">
                            <div class="row">
                                <div class="col-lg-12 mb-4 table-responsive">
<?php require_once('apc_futbolamericano1.php'); ?>
								</div>
                            </div>
                        </div>
                    </div>
                    <?php
}?>
                  </div>

                  <div class="tab-pane fade" id="hockey">
                  <?php if ($totalRows_Recordset301>0) { ?>
  <div class="card">
                        <div class="card-body border border-danger" style="padding: 0;">
                            <div class="row">
                                <div  class="col-lg-12 mb-4 table-responsive">
<?php require_once('apc_hockey1.php'); ?>
								</div>
                            </div>
                        </div>
                    </div>
                    <?php
}?>
                  </div>
</div>


<script>
      $(this).addClass("active").parent("li").siblings().find("a").removeClass("active");
  $(".tab-pane").removeClass("fade").addClass("active").addClass("show");
  console.log(this.hash);


$("#show_all").on("click", function() {
  //  alert("Texto a mostrar");
  $(this).addClass("active").parent("li").siblings().find("a").removeClass("active");
  $(".tab-pane").removeClass("fade").addClass("active").addClass("show");
});
$(".nav-link").not("#show_all").on("click", function() {
  console.log(this.hash);
  $(".tab-pane").not(this.hash).removeClass("active").removeClass("show");
});
    </script>
<?php

?>
</div>



        <div class="col-lg-3 mb-4 border border-warning">

</div>
        <!-- end .grid_1 -->


        </div>
</span>


        
</div>
    </div>


    <div class="modal fade" id="exampleModal88" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detalle</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form method="POST" name="Finalizar" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">

      <div class="modal-body">
          <div id="dialog-message88"></div>
      </div>
      <div class="modal-footer">
            <input type="hidden" name="Aprovado" value="1">
            <input type="hidden" name="FinalizarReabrir" value="1">
            <div class="d-grid gap-2">
                
            </div>
        
        
      </div>
    </div>
  </div>
  </div>

  <div class="modal fade" id="exampleModal94" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detalle</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
     

      <div class="modal-body">
          <div id="dialog-message94"></div>
      </div>
      <div class="modal-footer">
            <input type="hidden" name="Aprovado" value="1">
            <input type="hidden" name="FinalizarReabrir" value="1">
            <div class="d-grid gap-2">
                
            </div>
        </div>
    </div>
  </div>
  </div>

    <div class="modal fade" id="exampleModal101d" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detalle</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
     

      <div class="modal-body">
          <div id="dialog-message101d"></div>
      </div>
      <div class="modal-footer">
            <input type="hidden" name="Aprovado" value="1">
            <input type="hidden" name="FinalizarReabrir" value="1">
            <div class="d-grid gap-2">
                
            </div>
        </div>
    </div>
  </div>
  </div>

 

    <div class="modal fade" id="exampleModal101" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detalle</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
     

      <div class="modal-body">
          <div id="dialog-message101"></div>
      </div>
      <div class="modal-footer">
            <input type="hidden" name="Aprovado" value="1">
            <input type="hidden" name="FinalizarReabrir" value="1">
            <div class="d-grid gap-2">
                
            </div>
        </div>
    </div>
  </div>
  </div>


    <div class="modal fade" id="exampleModal100" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detalle</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
     

      <div class="modal-body">
          <div id="dialog-message100"></div>
      </div>
      <div class="modal-footer">
            <input type="hidden" name="Aprovado" value="1">
            <input type="hidden" name="FinalizarReabrir" value="1">
            <div class="d-grid gap-2">
                
            </div>
        </div>
    </div>
  </div>
  </div>




  

  


  



    <div class="modal fade" id="exampleModal90" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detalle</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form method="POST" name="Finalizar" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">

      <div class="modal-body">
          <div id="dialog-message90"></div>
      </div>
      <div class="modal-footer">
            <input type="hidden" name="Aprovado" value="1">
            <input type="hidden" name="FinalizarReabrir" value="1">
            <div class="d-grid gap-2">
                
            </div>
        
        
      </div>
    </div>
  </div>
  </div>





    








<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Jugadas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <div class="modal-body">
          <div id="scrollmobil">
            <div id="viewLogro"></div>
          </div>
      </div>
      <div class="modal-footer">
          <div id="row">
              <div class="col-lg-12 mb-4">
                  <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-secondary" id="btnjuegocompsoccer">Juego Completo</button>
                    <button type="button" class="btn btn-secondary" id="btnmediojuegosoccer">Medio Juego</button>
                </div>
            </div>
        </div>
          <div id="row">
              <div class="col-lg-12 mb-4">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                    <button type="button" class="btn btn-primary">Jugar</button>
                </div>
        </div>
      </div>
    </div>
  </div>
</div></span>

<div id="dialog-autoservicio" title="Auto Servicio"></div>
<div id="dialog-alerts" title="InformaciÃ³n"></div>
<!--<div id="dialog-message" title="Detalle Ticket">
  <span id="det_ticket"></span>
</div>>-->
<!--<div id="DialogoAjax" title="Por favor espere"><img src="https://" alt="Cargando" ></div>	-->

<!-- Modal -->
<div class="modal" id="modalTicket" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div>
                <div class="col-lg-12 mt-4 mb-3">
                    <div class="card">
                        <div class="card-header">
                            Detalle Ticket
                        </div>
                        <div class="card-body">
                            <div style="display:none" class="zona_impresion info hide" id="zona_impresion"></div>
                            <div class="panel panel-default" id="detalleTickets">
                                <div class="bg-gray disabled color-palette text-center info hide" id="info2"></div>
                                <textarea class="form-control" rows="10" id="informacion_ticket" readonly=""></textarea>
                            </div>
                            <button type="button" class="btn btn-md sbold btn-warning col-sm-12" id="btnImprimir">
                                <i class="fa fa-print"></i>
                                <span>Imprimir Contenido (I)</span>
                            </button>
                            <button type="button" class="btn btn-md sbold btn-primary col-sm-12" id="copy_clipboard">
                                <i class="fa fa-copy"></i>
                                <span>Copiar Contenido</span>
                            </button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Seguir Jugando</button>
                            <small id="emailHelp" class="form-text text-muted">
                                Puede Copiar el Contenido del Ticket y enviar por:
                                <a id="btnwhatsapp" href="https://web.whatsapp.com/" style="text-decoration:none;" target="_blank" title="whatsapp WEB" class="tooltips">
                                    <i class="fa fa-whatsapp"></i>&nbsp;WhatApp
                                </a>
                                &nbsp;
                                <!--
    <a 
                                href="https://web.telegram.org" 
                                style="text-decoration:none;"
                                target="_blank"
                                title="Telegram" 
                                class="tooltips" 
                                >
                                <i class="fa fa-send"></i>&nbsp;Telegram
                                </a>
                                , etc.-->
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModalAuto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">TICKET AUTO SERVICIO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body" id="detalleAutoservicio">
                Cargando.....
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div>
    </div>
</div>

<!-- Modal -->

<div class="modal fade" id="exampleModalDetalle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">DETALLE TICKET</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body" id="dialog-message">
                Cargando.....
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal_mobil" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fonth" id="exampleModalLabel">DETALLE TICKET</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body" id="dialog-message-mobil">
                <textarea class="form-control fonth" id="detalleticketmobil" rows="5"></textarea>
                <!--<h5 class="modal-title fonth1" id="exampleModalLabel"><b>Monto Apuesta:</b> <span id="montojugadomobil"></span> <small>Bs.</small></h5>
        <h5 class="modal-title fonth1" id="exampleModalLabel"><b>Monto Premio:</b> <span id="montopremiomobil"></span> <small>Bs.</small></h5>-->
                <table class="table table-borderless table-sm">
                    <tbody><tr>
                        <td>
                            <label><small class="font-weight-bold">Monto de la Apuesta:</small></label>
                            <input type="number" placeholder="Monto Apuesta" id="montoApostar_mobil" value="10000" name="montoApostar_mobil" required="" class="form-control form-control-sm" maxlength="10" autocomplete="OFF" onkeyup="premio_mobil(event,this)">
                        </td>
                        <td>
                            <label><small class="font-weight-bold">Monto del Premio:</small></label>
                            <input disabled="" type="number" placeholder="Monto Premio" id="montoPremio_mobil" name="montoPremio_mobil" class="form-control form-control-sm form-input-premio" autofocus="">
                        </td>
                    </tr>
                </tbody></table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal"><i class="fa fa-exchange" aria-hidden="true"></i> Seguir Jugando</button>
                <button type="button" id="btnregistrarjugadamovil" class="btn btn-warning btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Registrar Jugadas</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detalle</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
          <div id="dialog-message2"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div> 
<!-- Modal -->
<div class="modal fade" id="exampleModal_mobil1" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fonth" id="exampleModalScrollableTitle"> Ticket Jugados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body" id="tablaTicketjugados"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>    
<div id="divImprime" style="display:none;">
		    </div>
            <div id="divOculto" style="display:none;">
		    </div>
            <?php
            $numerotiket2=11111;
            $exito=1;
            ?>

<script>
//imprimeTicketall(<?php echo $numerotiket2; ?>,<?php echo $exito; ?>);
</script>

<div class="modal fade" id="exampleModal7" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detalle</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form method="POST" name="Finalizar" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">

      <div class="modal-body">
          <div id="dialog-message7"></div>
      </div>
      <div class="modal-footer">
            <input type="hidden" name="Aprovado" value="1">
            <input type="hidden" name="FinalizarReabrir" value="1">
            <div class="d-grid gap-2">
                <button class="btn btn-primary" type="submit">Guardar Logro Manual</button>
            </div>
        </form>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>



</div> 

<script>
   // aqui estoy
</script>

    <!-- /.container -->
    <!-- Footer -->
    <!--<footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Your Website 2018</p>
      </div>
       /.container -->
    <!--</footer>
     Bootstrap core JavaScript 
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    -->


  

    <!-- jQuery Validation Plugin -->
    <script src="./Vendedor/jquery.validate.min.js.descarga"></script>
    <script src="./Vendedor/additional-methods.min.js.descarga"></script>

    <script src="../js/popper.min1.16.1.js"></script>
    <script src="../js/bootstrap4.min.js"></script>


    <script src="./Vendedor/jquery.dataTables.min.js.descarga"></script>
    <script src="./Vendedor/dataTables.bootstrap4.min.js.descarga"></script>
    <!-- toastr code -->
    <script src="../js/toastr.min.js"></script>
    <!-- bootbox code -->
    <script src="./Vendedor/bootbox.min.js.descarga"></script>
    <!-- sweetalert2 code -->
    <script src="../js/sweetalert2.all.js"></script>



            <!--                <script src="./Vendedor/taquilla.js"></script> -->
        

</body></html>
<?php
// orden beisbol baloncesto futbol hockey
//
//
//
//
//
//
//
//
//

 ?>