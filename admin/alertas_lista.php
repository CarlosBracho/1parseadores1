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

function tiempoTranscurridoAlerta($fechaHora) {
    if (empty($fechaHora)) {
        return "Nunca";
    }
    $ahora = new DateTime();
    $fecha = new DateTime($fechaHora);
    $diferencia = $ahora->diff($fecha);
    
    if ($fecha > $ahora) {
        return "Hace instantes";
    }
    
    if ($diferencia->y > 0) {
        return "Hace " . $diferencia->y . " año" . ($diferencia->y > 1 ? "s" : "");
    }
    if ($diferencia->m > 0) {
        return "Hace " . $diferencia->m . " me" . ($diferencia->m > 1 ? "ses" : "s");
    }
    if ($diferencia->d > 0) {
        return "Hace " . $diferencia->d . " día" . ($diferencia->d > 1 ? "s" : "");
    }
    if ($diferencia->h > 0) {
        return "Hace " . $diferencia->h . " hora" . ($diferencia->h > 1 ? "s" : "");
    }
    if ($diferencia->i > 0) {
        return "Hace " . $diferencia->i . " min";
    }
    if ($diferencia->s > 0) {
        return "Hace " . $diferencia->s . " seg";
    }
    return "Hace instantes";
}




$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;
$query_Recordset1 = sprintf(
"/* admin\alertas_lista.php - QUERY 3 */ SELECT *,
    (SELECT MAX(fecha_hora) FROM alertas_registros r WHERE r.id_alerta = alertas.Idalertas AND r.tipo = 1) as ultima_ejecucion,
    (SELECT MAX(fecha_hora) FROM alertas_registros r WHERE r.id_alerta = alertas.Idalertas AND r.tipo = 0) as ultimo_llamado
	FROM 
	alertas ORDER BY ultima_ejecucion DESC, nombrealerta ASC"
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
/* Estilos modernos y override de Bootstrap 2.0.3 para la modal del historial */
#historialModal {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    bottom: 0 !important;
    width: 100% !important;
    height: 100% !important;
    margin: 0 !important;
    background-color: rgba(0, 0, 0, 0.5) !important;
    z-index: 99999 !important;
    display: none !important;
    align-items: center;
    justify-content: center;
    overflow-x: hidden;
    overflow-y: auto;
    border: none !important;
    border-radius: 0 !important;
    box-shadow: none !important;
}
#historialModal.show {
    display: flex !important;
    opacity: 1 !important;
    visibility: visible !important;
}
#historialModal .modal-dialog {
    position: relative !important;
    width: 90% !important;
    max-width: 800px !important;
    margin: 30px auto !important;
    pointer-events: auto !important;
}
#historialModal .modal-content {
    position: relative !important;
    display: flex !important;
    flex-direction: column !important;
    width: 100% !important;
    background-color: #fff !important;
    border: 1px solid rgba(0,0,0,.2) !important;
    border-radius: 6px !important;
    box-shadow: 0 5px 15px rgba(0,0,0,.5) !important;
    outline: 0 !important;
}
/* Spinner animado nativo */
.spinner-ia {
    display: inline-block;
    width: 1.5rem;
    height: 1.5rem;
    vertical-align: text-bottom;
    border: .2em solid currentColor;
    border-right-color: transparent;
    border-radius: 50%;
    animation: spinner-ia-keyframes .75s linear infinite;
    margin-right: 5px;
}
@keyframes spinner-ia-keyframes {
    to { transform: rotate(360deg); }
}
</style>
<link href="../estilo/admin.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="../css/tcal.css" />
<script type="text/javascript" src="../js/tcal.js"></script>
<script src="../js/jquery-1.9.1.min.js"></script>
<link rel="stylesheet" href="../modal/css/alertify.min.css" />
<script src="../modal/js/alertify.min.js"></script>
<script>
var statusEnvio = false;
var timerEnvio = null;
function chequearEnvio() {
    if (!statusEnvio) {
        statusEnvio = true;
        if (timerEnvio) clearTimeout(timerEnvio);
        timerEnvio = setTimeout(function() {
            statusEnvio = false;
            console.log('statusEnvio desbloqueado por timeout de seguridad');
        }, 5000);
        return true;
    } else {
        alert("El formulario ya está siendo enviado, por favor aguarde un instante.");
        return false;
    }
}
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
                <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" style="font-size: 12px; background: #FFF; border: 1px solid #CCC; font-family: Tahoma, Geneva, sans-serif;">
                    <thead>
                        <tr style="background: #333; color: #FFF; height: 35px; font-weight: bold; text-align: left;">
                            <th style="padding-left: 10px; width: 5%; text-align: center;">ID</th>
                            <th style="width: 25%;">Alerta / Link Principal</th>
                            <th style="width: 30%;">Comentario</th>
                            <th style="width: 15%; text-align: center;">Horario (In/Fin)</th>
                            <th style="width: 13%; text-align: center;">Parámetros</th>
                            <th style="width: 12%; text-align: center;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php do { 
                            $nuevahora1 = date('H:i:s', strtotime('+6 hour', strtotime($row_Recordset1['horainicio'])));
                            $nuevahora2 = date('H:i:s', strtotime('+6 hour', strtotime($row_Recordset1['horafin'])));
                            $bgColor = ($row_Recordset1['pausa'] == 1) ? '#FBEBEB' : '#FFF';
                        ?>
                        <tr class="brillo" style="border-bottom: 1px solid #D5D5D5; background: <?php echo $bgColor; ?>; height: 60px;">
                            <td align="center" style="border-bottom: 1px solid #D5D5D5; font-weight: bold;"><?php echo $row_Recordset1['Idalertas']; ?></td>
                            <td align="left" style="border-bottom: 1px solid #D5D5D5; padding: 5px;">
                                <strong style="color: #F90; font-size: 13px;"><?php echo htmlspecialchars($row_Recordset1['nombrealerta']); ?></strong><br>
                                <a href="<?php echo htmlspecialchars($row_Recordset1['link_principal']); ?>" target="_blank" style="font-size: 11px; color: #0066CC; text-decoration: underline; word-break: break-all;"><?php echo htmlspecialchars($row_Recordset1['link_principal']); ?></a>
                                <div style="font-size: 10px; color: #666; margin-top: 5px; line-height: 1.3;">
                                    <strong>Última Ejecución:</strong> 
                                    <span style="color: #2b7a1d; font-weight: bold;">
                                        <?php 
                                        if (!empty($row_Recordset1['ultima_ejecucion'])) {
                                            echo tiempoTranscurridoAlerta($row_Recordset1['ultima_ejecucion']) . " (" . date('d/m h:i A', strtotime('+6 hour', strtotime($row_Recordset1['ultima_ejecucion']))) . ")";
                                        } else {
                                            echo "Ninguna registrada";
                                        }
                                        ?>
                                    </span>
                                    <br>
                                    <strong>Último Llamado:</strong> 
                                    <span style="color: #777;">
                                        <?php 
                                        if (!empty($row_Recordset1['ultimo_llamado'])) {
                                            echo tiempoTranscurridoAlerta($row_Recordset1['ultimo_llamado']) . " (" . date('d/m h:i A', strtotime('+6 hour', strtotime($row_Recordset1['ultimo_llamado']))) . ")";
                                        } else {
                                            echo "Ninguno";
                                        }
                                        ?>
                                    </span>
                                </div>
                            </td>
                            <td align="left" style="border-bottom: 1px solid #D5D5D5; font-size: 11px; color: #444; padding: 5px;"><?php echo htmlspecialchars($row_Recordset1['comentario']); ?></td>
                            <td align="center" style="border-bottom: 1px solid #D5D5D5; font-size: 11px;">
                                <strong>Inicio:</strong> <?php echo horaampm($nuevahora1); ?><br>
                                <strong>Fin:</strong> <?php echo horaampm($nuevahora2); ?>
                            </td>
                            <td align="center" style="border-bottom: 1px solid #D5D5D5; font-size: 11px; line-height: 1.4;">
                                Fallos: <?php echo $row_Recordset1['cont_fallos_reporte']; ?><br>
                                Rep. (m): <?php echo $row_Recordset1['min_para_reportar']; ?><br>
                                Repetir: <?php echo $row_Recordset1['mini_para_repetir']; ?>s
                            </td>
                            <td align="center" style="border-bottom: 1px solid #D5D5D5; padding: 5px;">
                                <div style="display: flex; flex-direction: column; gap: 4px; max-width: 140px; margin: auto;">
                                    <?php if($row_Recordset1['activo_archivo'] != 3){ ?>
                                        <?php if($row_Recordset1['activo_archivo']==0){ ?>
                                            <form method="POST" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();" style="margin: 0;">
                                                <input type="hidden" name="Idalertas" value="<?php echo $row_Recordset1['Idalertas']; ?>">
                                                <input type="hidden" name="ESTADO_CODIGO" value="1">
                                                <button type="submit" style="cursor: pointer; width: 100%; padding: 4px; background: #FFEBEB; color: #C00; border: 1px solid #D70000; border-radius: 3px; font-size: 10px;">DESACTIVAR CÓDIGO</button>
                                            </form>
                                        <?php } else { ?>
                                            <form method="POST" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();" style="margin: 0;">
                                                <input type="hidden" name="Idalertas" value="<?php echo $row_Recordset1['Idalertas']; ?>">
                                                <input type="hidden" name="ESTADO_CODIGO" value="0">
                                                <button type="submit" style="cursor: pointer; width: 100%; padding: 4px; background: #EBF3FF; color: #0059B3; border: 1px solid #0066CC; border-radius: 3px; font-size: 10px;">ACTIVAR CÓDIGO</button>
                                            </form>
                                        <?php } ?>
                                    <?php } ?>

                                    <div style="display: flex; gap: 4px; margin-top: 2px;">
                                        <a href="alertas_edit.php?recordID=<?php echo $row_Recordset1['Idalertas']; ?>" style="flex: 1; text-align: center; text-decoration: none; padding: 4px; font-weight: bold; background: #F90; color: #FFF; border: 1px solid #E08000; border-radius: 3px; font-size: 10px; line-height: 1.4;">EDITAR</a>
                                        <button type="button" onclick="abrirHistorial(<?php echo $row_Recordset1['Idalertas']; ?>, '<?php echo htmlspecialchars(addslashes($row_Recordset1['nombrealerta']), ENT_QUOTES, 'UTF-8'); ?>')" class="btn-ver-historial" style="flex: 1; cursor: pointer; padding: 4px; font-weight: bold; background: #6E6C64; color: #FFF; border: 1px solid #555; border-radius: 3px; font-size: 10px;">HISTORIAL</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
                    </tbody>
                </table>
            </div>

            <!-- Modal Historial -->
            <div id="historialModal" tabindex="-1" role="dialog" aria-labelledby="historialModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content border-0 shadow">
                  <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="historialModalLabel" style="font-size: 15px; font-weight: bold;">Historial de Alerta</h5>
                    <button onclick="cerrarHistorial()" type="button" class="close text-white" aria-label="Close" style="font-size: 24px; border: none; background: none; opacity: 0.8; cursor: pointer;">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body p-0" id="historialModalBody">
                    <div class="text-center py-4">
                      Cargando...
                    </div>
                  </div>
                  <div class="modal-footer bg-light">
                    <button onclick="cerrarHistorial()" type="button" class="btn btn-sm btn-secondary" style="cursor: pointer;">Cerrar</button>
                  </div>
                </div>
              </div>
            </div>

            <script>
            function abrirHistorial(idAlerta, nombreAlerta) {
                console.log('abrirHistorial nativo invocado para ID:', idAlerta, 'Nombre:', nombreAlerta);
                
                var modalLabel = document.getElementById('historialModalLabel');
                var modalBody = document.getElementById('historialModalBody');
                var modal = document.getElementById('historialModal');
                
                if (modalLabel) modalLabel.innerText = 'Historial: ' + nombreAlerta + ' (ID: ' + idAlerta + ')';
                if (modalBody) modalBody.innerHTML = '<div class="text-center py-4"><span class="spinner-ia"></span> Cargando historial...</div>';
                
                if (modal) {
                    modal.classList.add('show');
                    modal.style.setProperty('display', 'flex', 'important');
                }
                document.body.classList.add('modal-open');
                
                // Petición AJAX nativa sin jQuery
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'alertas_historial_ajax.php?id=' + idAlerta + '&_t=' + new Date().getTime(), true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        console.log('AJAX completado nativo. Status:', xhr.status);
                        if (xhr.status === 200) {
                            if (modalBody) modalBody.innerHTML = xhr.responseText;
                        } else {
                            if (modalBody) modalBody.innerHTML = '<div class="alert alert-danger m-3">Error al cargar el historial (Código: ' + xhr.status + '). Intente de nuevo.</div>';
                        }
                    }
                };
                xhr.send();
            }

            function cerrarHistorial() {
                console.log('cerrarHistorial nativo invocado');
                var modal = document.getElementById('historialModal');
                if (modal) {
                    modal.classList.remove('show');
                    modal.style.setProperty('display', 'none', 'important');
                }
                document.body.classList.remove('modal-open');
            }

            window.addEventListener('click', function(e) {
                var modal = document.getElementById('historialModal');
                if (e.target === modal) {
                    cerrarHistorial();
                }
            });
            </script>
        <?php } else { ?>
            <div class="alert alert-info text-center" style="font-size: 20px; padding: 50px 0;">
                No existen registros de alertas configurados en el sistema.
            </div>
        <?php } ?>
    </div>
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
