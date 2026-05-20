<?php
require_once('../Connections/conexionbanca.php');
date_default_timezone_set("Pacific/Honolulu") ;


$horaactual=horaactual();
$fecha=fechaactualbd();
//echo $fechasistema;
$hora1=$horaactual;
$nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
$nuevahora1 = date('H:i:s', $nuevahora1);
//echo horaampm($nuevahora1);
//echo $nuevahora1;

$inicio=fechanueva(fechaactualbd());
$final=fechanueva(fechaactualbd());
$in=fechaymd($inicio); $fi=fechaymd($final);

$x=0;

    $query_Recordset4 = sprintf('/* PARSEADORES1 negocio\venta\ventasfechaluisana.php - QUERY 1 */ SELECT 
		usuario.id_usuario, usuario.usuario_nombre
		
		FROM 
			usuario
		WHERE  
			usuario.usuario_tipo = 3
		ORDER BY 
			usuario.usuario_nombre');
$Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);
$t=0;
$x=0;
if ($totalRows_Recordset4>0) {
    do {
        $usuario_nombre[$t]=$row_Recordset4['usuario_nombre'];
        $id_usuario[$t]=$row_Recordset4['id_usuario'];
        $t++;
    } while ($row_Recordset4 = mysqli_fetch_assoc($Recordset4));
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>.::.</title>



 <script src="../js/jquery.min.js"></script>
<script src="../js/moment.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="../css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="../css/bootstrap.min.css">
    <script type="text/javascript">
        $(function() {              
           // Bootstrap DateTimePicker v4
           $('#fechadesde').datetimepicker({
                 format: 'YYYY-MM-DD'
           });
        });  
        $(function() {              
           // Bootstrap DateTimePicker v4
           $('#fechahasta').datetimepicker({
                 format: 'YYYY-MM-DD'
           });
        });      		
    </script>

<!-- InstanceBeginEditable name="aHead" -->
<!-- InstanceEndEditable -->
</head>
<body>
<CENTER>

           <div align="center" style="font-size:18px;width:140px; height:100px;text-align:center; background: #FFF; float:left;
        	padding:5px 5px 5px 5px;"></div>
            <br/><input type="button" onclick="window.location='./index.php';" 
            	style="height:65px; width:340px; font-size:20px; margin:0px 15px 0px 0px" 
            	value="Volver Menu Anteriol" />
				</CENTER>
				
				
<div class="container">
  <div class="panel panel-primary">
    <div class="panel-heading">Selecciones Rango De Fecha A Consultar</div>
      <div class="panel-body">
                   <form action="ventaslistaluisana.php" method="GET" name="form1" id="form1" autocomplete="off"  
				   
				  <div class="row">
            <div class="col-md-6">

            </div>
        </div>
         <div class="row">
            <div class="col-md-6">
			               <div class="form-group">

                  <label class="control-label">DESDE</label>
                  <div class='input-group date' name="fechadesde" id='fechadesde'>
                     <input type='text' class="form-control" name="fechadesde" value="<?php echo htmlentities($fecha, ENT_COMPAT, 'utf-8'); ?>"/>
                     <span class="input-group-addon">
                     <span class="glyphicon glyphicon-calendar"></span>
                     </span>
					  </div>
                  </div>
            </div>
            <div class='col-md-6'>
               <div class="form-group">
                  <label class="control-label">HASTA</label>
                  <div class='input-group date' name="fechahasta" id='fechahasta'>
                     <input type='text' class="form-control" name="fechahasta" value="<?php echo htmlentities($fecha, ENT_COMPAT, 'utf-8'); ?>"/>
                     <span class="input-group-addon">
                     <span class="glyphicon glyphicon-calendar"></span>
                     </span>
                  </div>
               </div>
            </div>
        </div>
        <input type="submit" class="btn btn-primary" value="Submit">
		</form>  
      </div>
   </div>
</div>

</body>
<!-- InstanceEnd --></html>
<?php

?>