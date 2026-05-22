<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_Recordset1 = 10000;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
    $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}

$horaTxt=horaactual();
$hora=horaactual();
$fecha=fechaactualbd();
if(isset($_POST['ESTADO_CODIGO'])){
  $insertSQL1 = sprintf(
    "/* admin\alertas_lista.php - QUERY 1 */ UPDATE alertas

SET
activo_archivo = %s
    WHERE
    Idalertas = %s
    ",
  GetSQLValueString(($_POST['ESTADO_CODIGO']), "int"),
  GetSQLValueString(($_POST['Idalertas']), "int"));
    $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
  }

  if(isset($_POST['FinalizarReabrir'])){
    $insertSQL1 = sprintf(
      "/* admin\alertas_lista.php - QUERY 2 */ UPDATE alertas
  
  SET
  pausa = %s
      WHERE
      Idalertas = %s
      ",
    GetSQLValueString(($_POST['pausa']), "int"),
    GetSQLValueString(($_POST['Idalertas']), "int"));
      $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
    }




$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;
$query_Recordset1 = sprintf(
"/* admin\alertas_lista.php - QUERY 3 */ SELECT *
	FROM 
	alertas ORDER BY nombrealerta"
);



$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysqli_query($conexionbanca, $query_limit_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
    $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
    $all_Recordset1 = mysqli_query($conexionbanca, $query_Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
    $params = explode("&", $_SERVER['QUERY_STRING']);
    $newParams = array();
    foreach ($params as $param) {
        if (stristr($param, "pageNum_Recordset1") == false &&
        stristr($param, "totalRows_Recordset1") == false) {
            array_push($newParams, $param);
        }
    }
    if (count($newParams) != 0) {
        $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
    }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>í</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<!--[if lte IE 7]>
<link type="text/css" rel="stylesheet" media="all" href="../css/screen_ie.css" />
<![endif]-->
<style>
body {
	background-color: #eeeeee;
	padding:0;
	margin:0 auto;
	font-family:"Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
	font-size:11px;
}
</style>
<link href="../estilo/admin.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="../css/tcal.css" />
<script type="text/javascript" src="../js/tcal.js"></script>
<script src="../js/jquery-1.9.1.min.js"></script>
<script>
 $(document).ready(function() { 
 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
 var refreshId1 = setInterval(function() {
 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
 }, 60000);
});
</script>
<!-- InstanceBeginEditable name="aHead" -->
<script>var nav=navigator.userAgent.toLowerCase();if(nav.indexOf("firefox")!=-1){document.write('<link href="../estilo/adminFirefox.css" rel="stylesheet" type="text/css" />');}</script>
<script src="../js/bootstrap.bundle.min.js"></script>
<!-- InstanceEndEditable -->
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
  <div class="header" style="height:100px; background:#333">
			<?php include("../includes/cabeceraamericana.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
                    <!-- InstanceBeginEditable name="Menu" -->
                    <?php include("../includes/cabeceraadmin.php");?>
                    <!-- InstanceEndEditable -->        	
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#333; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background: #333;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            			margin:20px 0px 0px 0px; width:240px; font-size:16px ">
                <!-- InstanceBeginEditable name="pagina" -->
                Panel de Alertas
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->  	<div style="height:100%; font-size:18px; padding-top: 30px;" class="xfirefox">
        
        <?php if ($totalRows_Recordset1 > 0) { ?>
            <div style="height:100%; padding:0px 0px 100px 0px">   
                <div class="row">
                  <?php do { 
                    $nuevahora1 = date('H:i:s', strtotime('+6 hour', strtotime($row_Recordset1['horainicio'])));
                    $nuevahora2 = date('H:i:s', strtotime('+6 hour', strtotime($row_Recordset1['horafin'])));
                  ?>
                  <div class="col-12 col-md-6 mb-4">
                    <div class="card shadow-sm border-0">
                      <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-truncate" style="max-width: 80%; font-size: 15px; font-weight: bold;"><?php echo htmlspecialchars($row_Recordset1['nombrealerta']); ?></h5>
                        <span class="badge badge-secondary" style="font-size: 11px;">ID: <?php echo $row_Recordset1['Idalertas']; ?></span>
                      </div>
                      <div class="card-body bg-white p-3">
                        <div class="row">
                          <div class="col-7">
                            <p class="mb-1 text-muted" style="font-size: 11px; margin: 0;"><strong>Link Principal:</strong></p>
                            <p class="mb-2 text-truncate" style="font-size: 12px; margin: 0;"><a href="<?php echo htmlspecialchars($row_Recordset1['link_principal']); ?>" target="_blank"><?php echo htmlspecialchars($row_Recordset1['link_principal']); ?></a></p>
                            
                            <p class="mb-1 text-muted" style="font-size: 11px; margin: 5px 0 0 0;"><strong>Comentario:</strong></p>
                            <p class="mb-3 text-muted" style="font-size: 12px; min-height: 38px; margin: 0; line-height: 14px;"><?php echo htmlspecialchars($row_Recordset1['comentario']); ?></p>
                            
                            <div class="row text-center border-top border-bottom py-1" style="font-size: 11px; margin: 0; background-color: #f8f9fa;">
                              <div class="col-6 border-right">
                                <strong>Inicio:</strong> <?php echo horaampm($nuevahora1); ?>
                              </div>
                              <div class="col-6">
                                <strong>Fin:</strong> <?php echo horaampm($nuevahora2); ?>
                              </div>
                            </div>
                            <div class="row text-center pt-1" style="font-size: 11px; margin: 0;">
                              <div class="col-4 border-right">
                                <strong>Fallos:</strong> <?php echo $row_Recordset1['cont_fallos_reporte']; ?>
                              </div>
                              <div class="col-4 border-right">
                                <strong>Rep. (m):</strong> <?php echo $row_Recordset1['min_para_reportar']; ?>
                              </div>
                              <div class="col-4">
                                <strong>Repetir:</strong> <?php echo $row_Recordset1['mini_para_repetir']; ?>s
                              </div>
                            </div>
                          </div>
                          <div class="col-5 border-left d-flex flex-column justify-content-between">
                            <!-- Acciones -->
                            <div class="mb-2">
                              <?php if($row_Recordset1['pausa']==0){ ?>
                                <form method="POST" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">
                                    <input type="hidden" name="Idalertas" value="<?php echo $row_Recordset1['Idalertas']; ?>">
                                    <input type="hidden" name="pausa" value="1">
                                    <input type="hidden" name="FinalizarReabrir" value="1">
                                    <button class="btn btn-sm btn-danger btn-block mb-2 font-weight-bold" type="submit">PAUSAR</button>
                                </form>
                              <?php } else { ?>
                                <form method="POST" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">
                                    <input type="hidden" name="Idalertas" value="<?php echo $row_Recordset1['Idalertas']; ?>">
                                    <input type="hidden" name="pausa" value="0">
                                    <input type="hidden" name="FinalizarReabrir" value="0">
                                    <button class="btn btn-sm btn-success btn-block mb-2 font-weight-bold" type="submit">INICIAR</button>
                                </form>
                              <?php } ?>

                              <?php if($row_Recordset1['activo_archivo'] != 3){ ?>
                                <?php if($row_Recordset1['activo_archivo']==0){ ?>
                                  <form method="POST" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">
                                      <input type="hidden" name="Idalertas" value="<?php echo $row_Recordset1['Idalertas']; ?>">
                                      <input type="hidden" name="ESTADO_CODIGO" value="1">
                                      <button class="btn btn-sm btn-outline-danger btn-block mb-2" style="font-size: 11px;" type="submit">DESACTIVAR CÓDIGO</button>
                                  </form>
                                <?php } else { ?>
                                  <form method="POST" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">
                                      <input type="hidden" name="Idalertas" value="<?php echo $row_Recordset1['Idalertas']; ?>">
                                      <input type="hidden" name="ESTADO_CODIGO" value="0">
                                      <button class="btn btn-sm btn-outline-primary btn-block mb-2" style="font-size: 11px;" type="submit">ACTIVAR CÓDIGO</button>
                                  </form>
                                <?php } ?>
                              <?php } ?>
                            </div>
                            
                            <div>
                              <a href='alertas_edit.php?recordID=<?php echo $row_Recordset1['Idalertas']; ?>' class="btn btn-sm btn-info text-white btn-block mb-2 font-weight-bold">EDITAR</a>
                              <button class="btn btn-sm btn-secondary btn-block btn-ver-historial font-weight-bold" data-id="<?php echo $row_Recordset1['Idalertas']; ?>" data-nombre="<?php echo htmlspecialchars($row_Recordset1['nombrealerta']); ?>">HISTORIAL</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
                </div>
            </div>

            <!-- Modal Historial -->
            <div class="modal fade" id="historialModal" tabindex="-1" role="dialog" aria-labelledby="historialModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content border-0 shadow">
                  <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="historialModalLabel" style="font-size: 15px; font-weight: bold;">Historial de Alerta</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="font-size: 24px; border: none; background: none; opacity: 0.8;">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body p-0" id="historialModalBody">
                    <div class="text-center py-4">
                      Cargando...
                    </div>
                  </div>
                  <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cerrar</button>
                  </div>
                </div>
              </div>
            </div>

            <script>
            $(document).ready(function() {
                $(document).on('click', '.btn-ver-historial', function() {
                    var idAlerta = $(this).data('id');
                    var nombreAlerta = $(this).data('nombre');
                    $('#historialModalLabel').text('Historial: ' + nombreAlerta + ' (ID: ' + idAlerta + ')');
                    $('#historialModalBody').html('<div class="text-center py-4"><span class="spinner-border spinner-border-sm"></span> Cargando historial...</div>');
                    $('#historialModal').modal('show');
                    
                    $('#historialModalBody').load('alertas_historial_ajax.php?id=' + idAlerta, function(response, status, xhr) {
                        if (status == "error") {
                            $('#historialModalBody').html('<div class="alert alert-danger m-3">Error al cargar el historial. Intente de nuevo.</div>');
                        }
                    });
                });
            });
            </script>
        <?php } else { ?>
            <div class="alert alert-info text-center" style="font-size: 20px; padding: 50px 0;">
                No existen registros de alertas configurados en el sistema.
            </div>
        <?php } ?>
</div>>
  <!-- InstanceEndEditable -->
  </div>
  <div class="footer">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
<!-- InstanceEnd --></html>
<?php
mysqli_free_result($Recordset1);
?>
