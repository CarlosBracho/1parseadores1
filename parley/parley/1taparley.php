<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$MM_donotCheckaccess = "false";
setlocale(LC_ALL, "es_ES");
$horaTxt=horaactual();
$FechaTxt=fechaactualbd();
$datetime=$FechaTxt.' '.$horaTxt;
//echo $datetime;
$usuario=$_SESSION['MM_id_usuario'];
$query_Recordset5 = sprintf(
    "
/* PARSEADORES1 parley\parley\1taparley.php - QUERY 1 */ SELECT * FROM usuario, taquilla, taquilla_opc_parley, agencia,
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
$taquilla=$row_Recordset5['cod_taquilla'];
$tipotaquilla=$row_Recordset5['tipotaquilla']/1;
$tra_codigo=$row_Recordset5['tra_codigo']/1;
$saldoactual=$row_Recordset5['saldoactual']/1;
$cod_agencia=$row_Recordset5['cod_agencia']/1;
$tipo_pagoa=$row_Recordset5['tipo_pagoa']/1;
$tel_agencia=$row_Recordset5['tel_agencia']/1;
$apu_maxparley=$row_Recordset5['apu_maxparley']/1;
$apu_minparley=$row_Recordset5['apu_minparley']/1;
$comb_minparley=$row_Recordset5['comb_minparley']/1;
$comb_maxparley=$row_Recordset5['comb_maxparley']/1;

$efectivoOt=$row_Recordset5['efectivoO']/1;
$tipo_pago=$row_Recordset5['tipo_pago'];
$moneda=$row_Recordset5['moneda'];
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
                                                "/* PARSEADORES1 parley\parley\1taparley.php - QUERY 2 */ SELECT MAX(Idbalancecli) 
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
                                        "/* PARSEADORES1 parley\parley\1taparley.php - QUERY 3 */ SELECT saldoactualc
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


    $query_Recordset111 = sprintf(
        "/* PARSEADORES1 parley\parley\1taparley.php - QUERY 4 */ SELECT logrop3, Id_p3logrosp3, logroABoRLp3, idjuegop3, equipop3, tipojugadap3
    FROM  p3logros
    WHERE logrodtp3 >= %s AND idjuegop3 >= 0 ORDER BY idjuegop3 DESC",
        GetSQLValueString($datetime, "date")
    );

    
    $Recordset111 =mysqli_query($conexionbanca, $query_Recordset111) or die(mysqli_error($conexionbanca));
    $row_Recordset111 = mysqli_fetch_assoc($Recordset111);
    $totalRows_Recordset111 = mysqli_num_rows($Recordset111);
      //echo  $totalRows_Recordset111;
      $totalvueltas=$totalRows_Recordset111;
     // echo $row_Recordset111['logrop3'];
  
    while ($fila = mysqli_fetch_assoc($Recordset111)) {
        $tlarray[] = $fila;
    }

// print_r($tlarray);
    function Obtenerlogro($Id_p2juegos, $equipo, $tipojugada, $tlarray)
    {
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

   
$query_Recordset1b = sprintf(
    "/* PARSEADORES1 parley\parley\1taparley.php - QUERY 5 */ SELECT * FROM p2juegos WHERE 
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
    "/* PARSEADORES1 parley\parley\1taparley.php - QUERY 6 */ SELECT * FROM p2juegos WHERE 
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
    "/* PARSEADORES1 parley\parley\1taparley.php - QUERY 7 */ SELECT * FROM p2juegos WHERE 
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
    "/* PARSEADORES1 parley\parley\1taparley.php - QUERY 8 */ SELECT * FROM p2juegos WHERE 
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
    <!-- Bootstrap core CSS -->
    <link href="./Vendedor/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="./Vendedor/bootstrap.min(1).css" rel="stylesheet">
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
	 }, 10000);
    });

</script>



</head>

<body onload="inicio()" onkeypress="reset()" onclick="reset()" onmousemove="reset()">
<header> 
  <!-- Fixed navbar -->
  <?php include('../parley/menutap.php'); ?>
</header>
    <div class="container-fluid">
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
<style type="text/css">
    #scroll {
        width: 628px;
        height: 315px;
        background: url(../Images/contenido.jpg);
        overflow: auto;
    }

    .rules-part {

        font-size: 14pt;
        color: #800;
        font-style: italic;
        background-color: #ffffff;
    }

    .inputTextSingleCalc {
        background-color: transparent;
        color: #ffffff;
        text-align: center;
        border-style: none;
    }

    .inputTextSingleLeftCalc {
        background-color: transparent;
        color: #ffffff;
        text-align: left;
        border-style: none;
    }

    .inputTextSingleRightCalc {
        background-color: transparent;
        color: #ffffff;
        text-align: right;
        border-style: none;
    }

    .cabecera_titulo {
        background: #000000;
        font-family: Sans-serif, Helvetica, Arial, Verdana;
        font-size: 13px;
    }

    .fechaJuego {
        font-family: Tahoma;
        font-size: 10px;
        color: yellow;
    }

    .cabecera_titulo1 {
        background: #2d35d2;
        font-size: 16px;
        text-align: center;
    }

    #scrollj {
        top: 0px;
        left: 0;
        right: 0px;
        /*Set right value to WidthOfFrameDiv*/
        bottom: 0;
        overflow: auto;
        background: #00000;
        width: auto;
        height: 450px;
    }

    #scrollmobil {
        top: 0px;
        left: 0;
        right: 0px;
        /*Set right value to WidthOfFrameDiv*/
        bottom: 0;
        overflow: auto;
        background: #00000;
        width: auto;
        height: 350px;
    }


    .logro_ver {
        color: #ff0000;
        font-size: 12px;
    }

    #tabj {
        font-family: Sans-serif, Helvetica, Arial, Verdana;
        font-size: 12px;
        /*margin-top:30px*/
    }
</style>
<script type="text/javascript">
    $(function() {
        $(".hlpdep").button();
    });
</script>



<!-- Pantalla no mobil    XS - LG -->
<span class="d-none d-xl-inline d-lg-inline d-xl-none">
    
    
    
    
    
    
    
    
    
    
    
    
    
    <div class="row border border-danger">


    <div class="col-lg-9 mb-4 border border-danger">
                        <div class="alert alert-warning" role="alert">
                <h6><b></b> Si existe un error evidente en juego y/o logros, dicho logro sera anulado.</h6>
            </div>



            <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
<?php
$quiensm=0;
if ($totalRows_Recordset1b>0) {
    $quiensm=1; ?>
<a class="nav-item nav-link btn btn-outline-danger active show" id="nav-home-tab" data-toggle="tab" href="#nav-Beisbol" role="tab" aria-controls="nav-Beisbol" aria-selected="true">
<div class="sportIcon sportIcon--baseball"></div>Beisbol</a>
<?php
}?>
<?php if ($totalRows_Recordset101>0) {?>
<a class="nav-item nav-link btn btn-outline-primary <?php if ($quiensm==1) {
        echo '';
    } else {
        echo 'active show';
    } ?>" id="nav-profile-tab" data-toggle="tab" href="#nav-Baloncesto"   role="tab" aria-controls="nav-Baloncesto" aria-selected="<?php if ($quiensm==1) {
        echo 'false';
    } else {
        echo 'true';
        $quiensm=1;
    } ?>">
<div class="sportIcon sportIcon--basketball"></div>Baloncesto</a>
<?php }?>
<?php if ($totalRows_Recordset201>0) {?>
<a class="nav-item nav-link btn btn-outline-warning <?php if ($quiensm==1) {
        echo '';
    } else {
        echo 'active show';
    } ?>" id="nav-contact-tab" data-toggle="tab" href="#nav-Futbol" role="tab" aria-controls="nav-Futbol" aria-selected="<?php if ($quiensm==1) {
        echo 'false';
    } else {
        echo 'true';
        $quiensm=1;
    } ?>">
<div class="sportIcon sportIcon--soccer"></div>Futbol</a>
<?php }?>
<?php if ($totalRows_Recordset301>0) {?>
<a class="nav-item nav-link btn btn-outline-success <?php if ($quiensm==1) {
        echo '';
    } else {
        echo 'active show';
    } ?>" id="nav-contact-tab" data-toggle="tab" href="#nav-Hockey" role="tab" aria-controls="nav-Hockey" aria-selected="<?php if ($quiensm==1) {
        echo 'false';
    } else {
        echo 'true';
        $quiensm=1;
    } ?>">
<div class="sportIcon sportIcon--hockey"></div> Hockey</a>
<?php }?>




                    <!--<a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-Hipico" role="tab" aria-controls="nav-Hipico" aria-selected="false"><img width="20px" height="20px" src="https://" class="img-responsive img-circle" alt="User Image"> Hipico</a>
                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-Macuare" role="tab" aria-controls="nav-Macuare" aria-selected="false"><img width="20px" height="20px" src="https://" class="img-responsive img-circle" alt="User Image"> Macuare</a>
                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-Otros" role="tab" aria-controls="nav-Otros" aria-selected="false"><img width="20px" height="20px" src="https://" class="img-responsive img-circle" alt="User Image"> Otros</a>-->
                </div>
            </nav>
			


            </span>

            <div class="tab-content" id="nav-tabContent"> 
			<?php
            $quiensm2=0;
            if ($totalRows_Recordset1b>0) {
                ?>

                <div class="tab-pane fade <?php
                
                if ($quiensm2==1) {
                } else {
                    echo 'active show';
                    $quiensm2=1;
                } ?>" id="nav-Beisbol" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 mb-4">
<?php require_once('apc_beisbol.php'); ?>
                                 </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }?>
				






                <?php if ($totalRows_Recordset101>0) {?>
                <div class="tab-pane fade <?php
                $quiensm2=0;
                if ($quiensm2==1) {
                } else {
                    echo 'active show';
                    $quiensm2=1;
                } ?>" id="nav-Baloncesto" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 mb-4">
<?php require_once('apc_baloncesto.php'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }?>






                <?php if ($totalRows_Recordset201>0) {?>
                <div class="tab-pane fade <?php
                $quiensm2=0;
                if ($quiensm2==1) {
                } else {
                    echo 'active show';
                    $quiensm2=1;
                } ?>" id="nav-Futbol" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 mb-4">
<?php require_once('apc_futbol.php'); ?>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
<?php }?>


<?php if ($totalRows_Recordset301>0) {?>
                <div class="tab-pane fade <?php
                $quiensm2=0;
                if ($quiensm2==1) {
                } else {
                    echo 'active show';
                    $quiensm2=1;
                } ?>" id="nav-Hockey" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 mb-4">
<?php require_once('apc_hockey.php'); ?>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
<?php }?>
</div>
</div>


        <div class="col-lg-3 mb-4 border border-danger">
        <div id="ultimajugada"></div>
            <form action="1taparley.php" method="post" accept-charset="utf-8" id="form" name="form">            
			<input type="hidden" name="agregar" value="false">
            <input type="hidden" name="teaser" id="teaser" value="false">
            <input type="hidden" name="isFree" value="0">
			<input type="hidden" name="usuario" value="<?php echo $usuario; ?>">
			<input type="hidden" name="taquilla" value="<?php echo $taquilla; ?>">
			<input type="hidden" name="monedacod" value="<?php echo $moneda; ?>">
            <input type="hidden" name="simple" value="true">
            <input type="hidden" name="macAddress" value="">
            <input type="hidden" name="moneda" id="moneda" value="Bs.">
            <input type="text" name="n_ticket" size="6" class="inputTextSingleocul" style="text-align:right;display:none;" readonly="yes" value="0001042533">
            <input type="text" name="serial" size="6" class="inputTextSingleocul" style="text-align:right;display:none;" readonly="yes" value="D419Cb1CB4">
            <table class="table table-borderless table-sm">
                <tbody>
                

                <tr class="ui-state-default ui-corner-all ui-state-focus liga">
                    <td colspan="2">
                        <h5 class="card-title">TAQUILLA DE VENTAS:. <?php echo strtoupper($row_Recordset5['nom_taquilla']); ?></h5>
                    </td>
                </tr>



                
                <tr class="ui-state-default ui-corner-all ui-state-focus liga"><?php if ($MM_authorizedUsers=='C') {  ?><td colspan="2">SALDO DISPONIBLE:. <br><span style=" font-size:25px;color:#fc3c03"><?php echo $saldoactualc; ?></span></td> <?php   }?></tr>                <tr>
                    <td colspan="4">
                        <label for="exampleInputMonto">Monto de la Apuesta:. <?php echo $monedanombre; ?></label>
                        <input name="montoApostar" id="montoApostar" type="text" class="form-control" value="10" size="10" style=" height:50px; font-size:30px" maxlength="10" autocomplete="OFF" onkeyup="premio(event,this)">
                    </td>
                </tr>
               
                <tr>
                    <td colspan="2">
                        <div class="row">
                            <div class="col-md-12 col-lg-7">
                                <!--<button type="submit" class="btn btn-primary" style="font-size:12px; height:30px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Grabar e Imprimir</button>-->
                                <button name="enviarChatBoton"  id="enviarChatBoton" type="submit" class="btn btn-primary btn-block btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Registrar e Imprimir</button>
                            </div>
                            <div class="col-md-12 col-lg-5">
                                <!--<button type="button"  id="limpiar_parley"  class="btn btn-danger" onclick="limpiarPantalla()" style="font-size:12px; height:30px;"><i class="fa fa-paint-brush" aria-hidden="true"></i> Limpiar</button>-->
                                <button class="btn btn-danger btn-block btn-sm" onclick="limpiarPantalla();return false"><i class="fa fa-paint-brush" aria-hidden="true"></i> Limpiar</button>
                            </div>
                        </div>

                        <!--<button type="button"  id="limpiar_parley"  class="btn btn-danger" onclick="limpiarPantalla()" style="font-size:12px; height:30px;"><i class="fa fa-paint-brush" aria-hidden="true"></i> Limpiar</button>-->
                    </td>
                </tr>

                
                <tr>
                    <td colspan="2">
                        <label for="exampleInputPremio">Monto del Premio:. <?php echo $monedanombre; ?></label>
                        <input type="text" name="montoPremio" id="xxxmontoPremio" size="10" class="form-control" style="height:50px;text-align:right;font-size:30px" readonly="yes">
                    </td>
                </tr>
                <tr class="ui-state-default ui-corner-all ui-state-focus">
                    <td class="calculadora"></td>
                    <!--<td class="calculadora">&nbsp;Ref.</td>
    <td class="calculadora">&nbsp;Equipo</td>-->
                    <!--<td class="calculadora">&nbsp;Logro</td>-->
                </tr>
                                    <tr style="background:#0b0000;color:#ffffff">
                        <td class="calculadora borde_linea" style="display: ">
                            <input type="hidden" name="codigo" class="inputTextSingleCalc">
                            <input type="hidden" name="padre" class="inputTextSingleCalc">
                            <input type="hidden" name="deporte">
                            <input type="hidden" name="tipo" class="inputTextSingleCalc" readonly="yes" style="width:40px">
                            <input type="hidden" name="cantidad" class="inputTextSingleCalc" style="width:40px" readonly="yes">
                            <input type="hidden" name="referencia" class="inputTextSingleLeftCalc" style="width:60px" readonly="yes">
                            <input type="hidden" name="equipo" class="inputTextSingleCalc" style="width:150px;text-align:left;" readonly="yes">
                            <input type="hidden" name="logro" class="inputTextSingleLeftCalc" size="3" readonly="yes">
                            <input type="hidden" name="juego">
                            <input type="hidden" name="numero">
                            <input type="text" name="descrip" class="inputTextSingleCalc" readonly="yes" style="width:100%">
                        </td>
                    </tr>
                                    <tr style="background:#0b0000;color:#ffffff">
                        <td class="calculadora borde_linea" style="display: ">
                            <input type="hidden" name="codigo" class="inputTextSingleCalc">
                            <input type="hidden" name="padre" class="inputTextSingleCalc">
                            <input type="hidden" name="deporte">
                            <input type="hidden" name="tipo" class="inputTextSingleCalc" readonly="yes" style="width:40px">
                            <input type="hidden" name="cantidad" class="inputTextSingleCalc" style="width:40px" readonly="yes">
                            <input type="hidden" name="referencia" class="inputTextSingleLeftCalc" style="width:60px" readonly="yes">
                            <input type="hidden" name="equipo" class="inputTextSingleCalc" style="width:150px;text-align:left;" readonly="yes">
                            <input type="hidden" name="logro" class="inputTextSingleLeftCalc" size="3" readonly="yes">
                            <input type="hidden" name="juego">
                            <input type="hidden" name="numero">
                            <input type="text" name="descrip" class="inputTextSingleCalc" readonly="yes" style="width:100%">
                        </td>
                    </tr>
                                    <tr style="background:#0b0000;color:#ffffff">
                        <td class="calculadora borde_linea" style="display: ">
                            <input type="hidden" name="codigo" class="inputTextSingleCalc">
                            <input type="hidden" name="padre" class="inputTextSingleCalc">
                            <input type="hidden" name="deporte">
                            <input type="hidden" name="tipo" class="inputTextSingleCalc" readonly="yes" style="width:40px">
                            <input type="hidden" name="cantidad" class="inputTextSingleCalc" style="width:40px" readonly="yes">
                            <input type="hidden" name="referencia" class="inputTextSingleLeftCalc" style="width:60px" readonly="yes">
                            <input type="hidden" name="equipo" class="inputTextSingleCalc" style="width:150px;text-align:left;" readonly="yes">
                            <input type="hidden" name="logro" class="inputTextSingleLeftCalc" size="3" readonly="yes">
                            <input type="hidden" name="juego">
                            <input type="hidden" name="numero">
                            <input type="text" name="descrip" class="inputTextSingleCalc" readonly="yes" style="width:100%">
                        </td>
                    </tr>
                                    <tr style="background:#0b0000;color:#ffffff">
                        <td class="calculadora borde_linea" style="display: ">
                            <input type="hidden" name="codigo" class="inputTextSingleCalc">
                            <input type="hidden" name="padre" class="inputTextSingleCalc">
                            <input type="hidden" name="deporte">
                            <input type="hidden" name="tipo" class="inputTextSingleCalc" readonly="yes" style="width:40px">
                            <input type="hidden" name="cantidad" class="inputTextSingleCalc" style="width:40px" readonly="yes">
                            <input type="hidden" name="referencia" class="inputTextSingleLeftCalc" style="width:60px" readonly="yes">
                            <input type="hidden" name="equipo" class="inputTextSingleCalc" style="width:150px;text-align:left;" readonly="yes">
                            <input type="hidden" name="logro" class="inputTextSingleLeftCalc" size="3" readonly="yes">
                            <input type="hidden" name="juego">
                            <input type="hidden" name="numero">
                            <input type="text" name="descrip" class="inputTextSingleCalc" readonly="yes" style="width:100%">
                        </td>
                    </tr>
                                    <tr style="background:#0b0000;color:#ffffff">
                        <td class="calculadora borde_linea" style="display: ">
                            <input type="hidden" name="codigo" class="inputTextSingleCalc">
                            <input type="hidden" name="padre" class="inputTextSingleCalc">
                            <input type="hidden" name="deporte">
                            <input type="hidden" name="tipo" class="inputTextSingleCalc" readonly="yes" style="width:40px">
                            <input type="hidden" name="cantidad" class="inputTextSingleCalc" style="width:40px" readonly="yes">
                            <input type="hidden" name="referencia" class="inputTextSingleLeftCalc" style="width:60px" readonly="yes">
                            <input type="hidden" name="equipo" class="inputTextSingleCalc" style="width:150px;text-align:left;" readonly="yes">
                            <input type="hidden" name="logro" class="inputTextSingleLeftCalc" size="3" readonly="yes">
                            <input type="hidden" name="juego">
                            <input type="hidden" name="numero">
                            <input type="text" name="descrip" class="inputTextSingleCalc" readonly="yes" style="width:100%">
                        </td>
                    </tr>
                                    <tr style="background:#0b0000;color:#ffffff">
                        <td class="calculadora borde_linea" style="display: ">
                            <input type="hidden" name="codigo" class="inputTextSingleCalc">
                            <input type="hidden" name="padre" class="inputTextSingleCalc">
                            <input type="hidden" name="deporte">
                            <input type="hidden" name="tipo" class="inputTextSingleCalc" readonly="yes" style="width:40px">
                            <input type="hidden" name="cantidad" class="inputTextSingleCalc" style="width:40px" readonly="yes">
                            <input type="hidden" name="referencia" class="inputTextSingleLeftCalc" style="width:60px" readonly="yes">
                            <input type="hidden" name="equipo" class="inputTextSingleCalc" style="width:150px;text-align:left;" readonly="yes">
                            <input type="hidden" name="logro" class="inputTextSingleLeftCalc" size="3" readonly="yes">
                            <input type="hidden" name="juego">
                            <input type="hidden" name="numero">
                            <input type="text" name="descrip" class="inputTextSingleCalc" readonly="yes" style="width:100%">
                        </td>
                    </tr>
                                    <tr style="background:#0b0000;color:#ffffff">
                        <td class="calculadora borde_linea" style="display: ">
                            <input type="hidden" name="codigo" class="inputTextSingleCalc">
                            <input type="hidden" name="padre" class="inputTextSingleCalc">
                            <input type="hidden" name="deporte">
                            <input type="hidden" name="tipo" class="inputTextSingleCalc" readonly="yes" style="width:40px">
                            <input type="hidden" name="cantidad" class="inputTextSingleCalc" style="width:40px" readonly="yes">
                            <input type="hidden" name="referencia" class="inputTextSingleLeftCalc" style="width:60px" readonly="yes">
                            <input type="hidden" name="equipo" class="inputTextSingleCalc" style="width:150px;text-align:left;" readonly="yes">
                            <input type="hidden" name="logro" class="inputTextSingleLeftCalc" size="3" readonly="yes">
                            <input type="hidden" name="juego">
                            <input type="hidden" name="numero">
                            <input type="text" name="descrip" class="inputTextSingleCalc" readonly="yes" style="width:100%">
                        </td>
                    </tr>
                                    <tr style="background:#0b0000;color:#ffffff">
                        <td class="calculadora borde_linea" style="display: ">
                            <input type="hidden" name="codigo" class="inputTextSingleCalc">
                            <input type="hidden" name="padre" class="inputTextSingleCalc">
                            <input type="hidden" name="deporte">
                            <input type="hidden" name="tipo" class="inputTextSingleCalc" readonly="yes" style="width:40px">
                            <input type="hidden" name="cantidad" class="inputTextSingleCalc" style="width:40px" readonly="yes">
                            <input type="hidden" name="referencia" class="inputTextSingleLeftCalc" style="width:60px" readonly="yes">
                            <input type="hidden" name="equipo" class="inputTextSingleCalc" style="width:150px;text-align:left;" readonly="yes">
                            <input type="hidden" name="logro" class="inputTextSingleLeftCalc" size="3" readonly="yes">
                            <input type="hidden" name="juego">
                            <input type="hidden" name="numero">
                            <input type="text" name="descrip" class="inputTextSingleCalc" readonly="yes" style="width:100%">
                        </td>
                    </tr>
                                    <tr style="background:#0b0000;color:#ffffff">
                        <td class="calculadora borde_linea" style="display: ">
                            <input type="hidden" name="codigo" class="inputTextSingleCalc">
                            <input type="hidden" name="padre" class="inputTextSingleCalc">
                            <input type="hidden" name="deporte">
                            <input type="hidden" name="tipo" class="inputTextSingleCalc" readonly="yes" style="width:40px">
                            <input type="hidden" name="cantidad" class="inputTextSingleCalc" style="width:40px" readonly="yes">
                            <input type="hidden" name="referencia" class="inputTextSingleLeftCalc" style="width:60px" readonly="yes">
                            <input type="hidden" name="equipo" class="inputTextSingleCalc" style="width:150px;text-align:left;" readonly="yes">
                            <input type="hidden" name="logro" class="inputTextSingleLeftCalc" size="3" readonly="yes">
                            <input type="hidden" name="juego">
                            <input type="hidden" name="numero">
                            <input type="text" name="descrip" class="inputTextSingleCalc" readonly="yes" style="width:100%">
                        </td>
                    </tr>
                                    <tr style="background:#0b0000;color:#ffffff">
                        <td class="calculadora borde_linea" style="display: ">
                            <input type="hidden" name="codigo" class="inputTextSingleCalc">
                            <input type="hidden" name="padre" class="inputTextSingleCalc">
                            <input type="hidden" name="deporte">
                            <input type="hidden" name="tipo" class="inputTextSingleCalc" readonly="yes" style="width:40px">
                            <input type="hidden" name="cantidad" class="inputTextSingleCalc" style="width:40px" readonly="yes">
                            <input type="hidden" name="referencia" class="inputTextSingleLeftCalc" style="width:60px" readonly="yes">
                            <input type="hidden" name="equipo" class="inputTextSingleCalc" style="width:150px;text-align:left;" readonly="yes">
                            <input type="hidden" name="logro" class="inputTextSingleLeftCalc" size="3" readonly="yes">
                            <input type="hidden" name="juego">
                            <input type="hidden" name="numero">
                            <input type="text" name="descrip" class="inputTextSingleCalc" readonly="yes" style="width:100%">
                        </td>

                    </tr>
                    <tr> <td class="calculadora borde_linea" style="display: ">

</form>

                    </td></tr>

                            </tbody></table>
            <br>
                        </form>
</div>
        <!-- end .grid_1 -->


















        </div>
</span>





















<!-- Pantalla mobil    -->
<span class="d-none d-md-inline d-lg-none d-sm-inline d-md-none d-inline d-sm-none justify-content-between">
            
<div class="row">
    <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12" style="padding:5px">
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <?php if ($totalRows_Recordset1b>0) {?>
		<a class="nav-item nav-link" id="nav-home-tab" data-toggle="tab" href="#nav-Beisbol-mobil" role="tab" aria-controls="nav-Beisbol-mobil" aria-selected="true"><div class="sportIcon sportIcon--baseball"></div>baseball</a>                
<?php }?>
        <?php if ($totalRows_Recordset101>0) {?>
		<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-Baloncesto-mobil" role="tab" aria-controls="nav-Baloncesto-mobil" aria-selected="false"><div class="sportIcon sportIcon--basketball"></div>basketball</a>                                
		<?php }?>
		        <?php if ($totalRows_Recordset201>0) {?>
		<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-Futbol-mobil" role="tab" aria-controls="nav-Futbol-mobil" aria-selected="false"><div class="sportIcon sportIcon--Futbol"></div>Futbol1</a>                                
		<?php }?>
		</div>
</nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade" id="nav-Beisbol-mobil" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="card">
                        <div class="card-body">
                            <div class="row"> 
                                <div class="col-lg-12 mb-4">
                                    <ol class="breadcrumb">
    <li class="breadcrumb-item">
     
            <div class="sportIcon sportIcon--baseball"></div>Baseball
   
</li>
<span class="ml-auto"><b>Balance:</b> <span class="badge badge-primary balance" id="balance"><?php echo $saldoactualc; ?></span></span></ol>
<?php require_once('apc_beisbol_mobile.php'); ?>
</div>                                </div>
                            </div>
                        </div>
                    </div>
                </div>
           
           
           
           
           
            <div class="tab-pane fade" id="nav-Baloncesto-mobil" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="card">
                    <div class="card-body">
                        <div class="row"> 
                            <div class="col-lg-12 mb-4">
                                <ol class="breadcrumb">
    <li class="breadcrumb-item">
        
            <div class="sportIcon sportIcon--basketball"></div>Basketball
        
    </li>
    <span class="ml-auto"><b>Balance:</b> <span class="badge badge-primary balance" id="balance"><?php echo $saldoactualc; ?></span></span></ol>

<?php require_once('apc_nba_mobile.php'); ?>
<?php require_once('apc_wnba_mobile.php'); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>





            <?php if ($totalRows_Recordset201>0) {?>

            <div class="tab-pane fade active show" id="nav-Futbol-mobil" role="tabpanel" aria-labelledby="nav-contact-tab">
                <div class="card">
                    <div class="card-body">
                        <div class="row"> 
                            <div class="col-lg-12 mb-4">
                                <ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="https://wuao.site/taquilla_ticket" style="color:#000000;font-weight: 900;">
            <div class="sportIcon sportIcon--soccer"></div>Soccer
        </a>
    </li>
    <span class="ml-auto"><b>Balance:</b> <span class="badge badge-primary balance" id="balance">100.000,00</span></span></ol>
<div class="scrollj">
    

<?php
 $query_Recordset1fm = sprintf(
                    "/* PARSEADORES1 parley\parley\1taparley.php - QUERY 9 */ SELECT DISTINCT competicionp2
FROM  p2juegos
where deportep2 = %s
 AND 
 iniciodtp2 > %s",
                    GetSQLValueString('futbol', "text"),
                    GetSQLValueString($datetime, "date")
                );
$Recordset1fm =mysqli_query($conexionbanca, $query_Recordset1fm) or die(mysqli_error($conexionbanca));
$row_Recordset1fm = mysqli_fetch_assoc($Recordset1fm);
$totalRows_Recordset1fm = mysqli_num_rows($Recordset1fm);


?>

<?php require_once('apc_futbol_mobile.php'); ?>

<?php }?>
// estoy aqui









        
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
                            <button type="button" class="btn btn-md sbold btn-danger col-sm-12" id="btnImprimir">
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
</div>    </div>
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

<script>
   // alert('deporte');
</script>

    <!-- /.container -->
    <!-- Footer -->
    <!--<footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Your Website 2018</p>
      </div>
      <!-- /.container -->
    <!--</footer>
    <!-- Bootstrap core JavaScript 
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
    <script src="./Vendedor/bootstrap.min.js.descarga" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="./Vendedor/bootstrap-datepicker.js.descarga"></script>
    <script src="./Vendedor/bootstrap-datepicker.es.min.js.descarga"></script>

    <script src="./Vendedor/jquery.dataTables.min.js.descarga"></script>
    <script src="./Vendedor/dataTables.bootstrap4.min.js.descarga"></script>
    <!-- toastr code -->
    <script src="./Vendedor/toastr.min.js.descarga"></script>
    <!-- bootbox code -->
    <script src="./Vendedor/bootbox.min.js.descarga"></script>
    <!-- sweetalert2 code -->
    <script src="./Vendedor/sweetalert2@9"></script>



                            <script src="./Vendedor/taquilla.js"></script>
        <script src="./Vendedor/taqmobil.js.descarga"></script>
        <script src="./Vendedor/validaciones.js.descarga"></script>



        <script type="text/javascript">


    var reglasPago = [{'rangoIni':'0.00','rangoFin':'0.00','multiplo':'0','montoMaximo':'0.00'}];
    var com_bax = 10;
    var comb_min = <?php echo  $comb_minparley; ?>;
    var comb_max = <?php echo  $comb_maxparley; ?>;
    var cupo_derc_gr = 0;
    var cupo_parl_gr = 0;
    var cupo_derc_ve = 0;
    var cupo_parl_ve = 0;
    var sum_cupo_derc_gr = 0;
    var sum_cupo_parl_gr = 0;
    var sum_cupo_derc_ve = 0;
    var sum_cupo_parl_ve = 0;
    var imprime = "S";
    var tipot = "C";
    var monto_premio = 10000000.00;
    var jugada_minima = 0.00;
    var jugada_minima_ve =<?php echo  str_replace(",", ".", $apu_minparley); ?>;
    var jugada_maxima_ve =<?php echo  str_replace(",", ".", $apu_maxparley); ?>;
    var comb_hembra = 3;
    var fact_mult_hem = 200;
    var fact_mult_mac = 200;
    var error_futbol = "1-2,1-5,1-6,2-5,2-6,4-8,5-6,13-9,13-14,13-10,10-14,12-16,10-9,10-1,10-5,1-9,1-13,1-14,2-9,2-13,2-10,2-14,2-12,25-1,25-5,25-2,25-6,25-9,25-10,25-13,25-12,25-16,25-14,25-26,26-1,26-5,26-2,26-6,26-4,26-8,26-9,26-10,26-13,26-14,5-9,5-13,5-12,5-16,5-14,1-12,1-16,6-9,10-6,6-14,6-12,6-16,6-13,2-16,4-13,4-9,4-10,4-14,4-12,4-16,8-13,8-9,8-10,8-14,8-12,8-16,2-4,2-8,6-4,6-8,10-12,10-16,14-12,14-16";
    var error_nhl = "1-2,1-5,1-6,1-25,2-4,2-5,2-6,2-8,2-25,4-6,4-8,5-6,5-25,6-8,6-25,8-25";
    var error_nfl = "1-2,1-5,1-6,1-25,2-4,2-5,2-6,2-8,2-25,4-6,4-8,5-6,5-25,6-8,6-25,8-25";
    var error_basket = "1-2,1-5,1-6,2-5,2-6,4-8,5-6,13-9,13-14,13-10,10-14,12-16,10-9,10-1,10-5,1-9,1-13,1-14,2-9,2-13,2-10,2-14,2-12,25-1,25-5,25-2,25-6,25-9,25-10,25-13,25-14,26-1,26-5,26-2,26-6,26-9,26-10,26-13,26-14,5-9,5-13,5-12,5-16,5-14,1-12,1-16,6-9,10-6,6-14,6-12,6-16,6-13,2-16,4-13,4-9,4-10,4-14,4-12,4-16,8-13,8-9,8-10,8-14,8-12,8-16";
    var error_beisbol = "1-2,1-3,1-5,1-6,1-7,1-9,1-10,1-13,1-14,1-19,2-3,2-5,2-6,2-7,2-9,2-10,2-13,2-14,2-19,3-4,3-5,3-6,3-7,3-8,3-9,3-10,3-13,3-14,3-19,4-7,4-8,4-12,4-16,4-20,5-6,5-7,5-9,5-10,5-13,5-14,5-23,6-7,6-9,6-10,6-13,6-14,6-23,7-9,7-10,7-13,7-14,7-23,8-12,8-16,8-24,9-10,9-13,9-14,9-19,10-13,10-14,10-19,12-16,12-17,12-20,13-14,13-23,14-23,16-21,16-24,17-21,19-23,4-20,8-20,12-20,16-20,17-20,20-24,4-24,8-24,12-24,16-24,17-24,30-32,30-31,30-32,32-33,32-31,33-31,30-20,30-24,32-24,33-24,31-24,31-20,33-20,32-20,21-24";
    var error_otros = "1-2,1-5,1-6,1-25,2-4,2-5,2-6,2-8,2-25,4-6,4-8,5-6,5-25,6-8,6-25,8-25";
    var error_esports = "1-2,1-5,1-6,2-5,2-6,4-8,5-6";
    var pago_macuare = 0.00;
    var tope_macuare = 0.00;
    var tope_venta = 0.00;
    var jdmin_macuare = 0.00;
    <?php if ($MM_authorizedUsers=='C') {  ?>
    var acreditacion = <?php echo $saldoactualc; ?>
    <?php } else { ?>
    var acreditacion = 999999999999999999999;
    <?php } ?>
    var tipo_taquilla = "C";
    var puerto_imp = '';
    var tipo_impresion = 'N';
    var cupoDvend = 0.00;
    var factor_pago = 0.00;
    var factor_pago_c1 = 0;
    var factor_pago_c2 = 0;
    var factor_pago_c3 = 0;
    var factor_pago_c4 = 0;
    var factor_pago_c5 = 0;
    var factor_pago_c6 = 0;
    var factor_pago_c7 = 0;
    var factor_pago_c8 = 0;
    var mxtcrep = "5";
    var mxhemper = "N";
    var mxmachper = "N";
    var mxcombft = "N";
    var mxcombbs = "N";
    var mxcombbk = "N";
    var mxcombotr = "N";
    var jgxder = "N";
    var mxaltafut = "0";
    var solo_macuare = 'N';

</script>
</body></html>
<?php
// orden beisbol baloncesto futbol hoskey
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