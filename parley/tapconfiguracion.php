<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');

//$codigoTaquilla=$_SESSION['MM_cod_taquilla'];
//print_r($_POST); 

$inicio=fechaactualbd();


$iniciof=fechaactualbd().' 00:00:01';
$finalf=fechaactualbd().' 23:59:59';

if (!isset($_SESSION['MM_id_usuario'])) {
    $id_usuarioO=$_SESSION['MM_id_usuario'];
} else {
    $id_usuarioO=0;
}
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction = "" . htmlentities($_SERVER['QUERY_STRING']);
}
if (isset($_POST['tipoticketpar'])) {
  $updateSQL = sprintf(
    "/* PARSEADORES1 parley\tapconfiguracion.php - QUERY 1 */ UPDATE taquilla_opc_parley 
  SET 
  tipoticketpar=%s,
  cod_clientepar=%s,
  taptipologro=%s,
  largotikpar=%s,
  Scrollp=%s
  WHERE 
  cod_taquilla=%s",
    GetSQLValueString($_POST['tipoticketpar'], "int"),
    GetSQLValueString($_POST['cod_clientepar'], "int"),
    GetSQLValueString($_POST['taptipologro'], "int"),
    GetSQLValueString($_POST['largotikpar'], "int"),
    GetSQLValueString($_POST['Scrollp'], "int"),
    GetSQLValueString($_POST['cod_taquilla'], "int")
);
$Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
    



}



$query_Recordset13 = sprintf(
"/* PARSEADORES1 parley\tapconfiguracion.php - QUERY 2 */ SELECT *
FROM taquilla_opc_parley top, taquilla ta
WHERE
top.cod_taquilla = %s AND 
top.cod_taquilla = %s
LIMIT 1",
GetSQLValueString($_SESSION['MM_cod_taquilla'], "int"), 
GetSQLValueString($_SESSION['MM_cod_taquilla'], "int"));
$Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
$row_Recordset13 = mysqli_fetch_assoc($Recordset13);
$totalRows_Recordset13 = mysqli_num_rows($Recordset13);





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
<link href="../css/bootstrapBootswatchv4.5.2.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<script src="../js/jquery-3.5.1.min.js"></script>
<script src="../js/datepicked.gijgo1.9.13.min.js" type="text/javascript"></script>
<link href="../css/datepicked.gijgo1.9.13.min.css" rel="stylesheet" type="text/css" />

</head>

<body>
<header> 
<!-- Fixed navbar -->
<?php include('../parley/menutap.php'); ?>
</header>




<?php if (isset($_POST['tipoticketpar'])) { ?>

<div class="alert alert-dismissible alert-success">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Configuracion de la taquilla se a guardado correctamente...</strong>
</div>

<?php } ?>


<div class="container">
<hr>
<div class="row">
<div class="col-12 col-md-12"> 
<!-- Contenido -->
<table class="table">
<thead class="thead-dark">
<tr>
<td>

</td>
</tr>       

</tr>
</thead>
</table>

<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off" onsubmit="return chequearEnvio();">

<table class="table">

<tr>
    <th>Tipo de Ticket (sin activar)</th>
    <th>Impresion o Cod Cliente (sin activar)</th>
    <th>Logro Americano o Decimal (sin activar)</th>
</tr>
<tr>
<td>

<div class="form-group">
    <select class="form-control"  name="tipoticketpar">
      <option value="0"  <?php if (!(strcmp(0, htmlentities($row_Recordset13['tipoticketpar'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>Ticket Tipo 1 Largo Estandar</option>
      <option value="1"  <?php if (!(strcmp(1, htmlentities($row_Recordset13['tipoticketpar'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>Ticket Tipo 1 Corto Estandar</option>
      <option value="0"  <?php if (!(strcmp(2, htmlentities($row_Recordset13['tipoticketpar'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>Ticket Tipo 2 Largo</option>
      <option value="1"  <?php if (!(strcmp(3, htmlentities($row_Recordset13['tipoticketpar'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>Ticket Tipo 2 Corto</option>
    </select>
  </div>



</td>
<td>




<div>

  <div class="form-group">
    <div class="custom-control custom-radio">
      <input type="radio" id="customRadio1" name="cod_clientepar" class="custom-control-input"  value="0"  <?php if (!(strcmp(0, htmlentities($row_Recordset13['cod_clientepar'], ENT_COMPAT, 'utf-8')))) {
    echo "checked= ";
} ?>>
      <label class="custom-control-label" for="customRadio1">Solo Impresion</label>
    </div>
    <div class="custom-control custom-radio">
      <input type="radio" id="customRadio2" name="cod_clientepar" class="custom-control-input"  value="1"  <?php if (!(strcmp(1, htmlentities($row_Recordset13['cod_clientepar'], ENT_COMPAT, 'utf-8')))) {
    echo "checked= ";
} ?>>
      <label class="custom-control-label" for="customRadio2">Solo Clientes</label>
    </div>
    <div class="custom-control custom-radio">
      <input type="radio" id="customRadio3" name="cod_clientepar" class="custom-control-input"  value="2"  <?php if (!(strcmp(2, htmlentities($row_Recordset13['cod_clientepar'], ENT_COMPAT, 'utf-8')))) {
    echo "checked= ";
} ?>>
      <label class="custom-control-label" for="customRadio3">Ambos Impresion y Clientes</label>
    </div>
  </div>
  </div>
                   
  </td>

  <td>




  <div>

  <div class="form-group">
    <div class="custom-control custom-radio">
      <input type="radio" id="customRadio11" name="taptipologro" class="custom-control-input"  value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset13['taptipologro'], ENT_COMPAT, 'utf-8')))) {
    echo "checked= ";
} ?>>
      <label class="custom-control-label" for="customRadio11">Logro Americano</label>
    </div>
    <div class="custom-control custom-radio">
      <input type="radio" id="customRadio22" name="taptipologro" class="custom-control-input"  value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset13['taptipologro'], ENT_COMPAT, 'utf-8')))) {
    echo "checked= ";
} ?>>
      <label class="custom-control-label" for="customRadio22">Logro Decimal</label>
    </div>
    <div class="custom-control custom-radio">
      <input type="radio" id="customRadio33" name="taptipologro" class="custom-control-input"  value="2" <?php if (!(strcmp(2, htmlentities($row_Recordset13['taptipologro'], ENT_COMPAT, 'utf-8')))) {
    echo "checked= ";
} ?>>
      <label class="custom-control-label" for="customRadio33">Ambos Americano y Decimal</label>
    </div>
  </div>
  </div>



  </td>
  </tr>



  <tr>
    <th>Espacio Al final de la impresion</th>
    <th>Scroll Si o No</th>
    <th></th>
</tr>
<tr>
<td>

<div class="form-group">
<select name="largotikpar" class="form-control"  class="textbox">
            <?php for ($i = 0; $i < 10; ++$i) {?>
                <option value="<?php echo $i; ?>"
                <?php if (!(strcmp($i, htmlentities($row_Recordset13['largotikpar'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>
                <?php echo $i; ?>
                </option>
            <?php } ?>    
            </select>    
  </div>

  
  
</td>
<td>




<div>

  <div class="form-group">
    <div class="custom-control custom-radio">
      <input type="radio" id="customRadio13" name="Scrollp" class="custom-control-input" value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset13['scrollp'], ENT_COMPAT, 'utf-8')))) {
    echo "checked= ";
} ?>>
      <label class="custom-control-label" for="customRadio13">Scroll No</label>
    </div>
    <div class="custom-control custom-radio">
      <input type="radio" id="customRadio23" name="Scrollp" class="custom-control-input" value="1"  <?php if (!(strcmp(1, htmlentities($row_Recordset13['scrollp'], ENT_COMPAT, 'utf-8')))) {
    echo "checked= ";
} ?>>
      <label class="custom-control-label" for="customRadio23">Scroll Si</label>
    </div>

  </div>
  </div>
                   
  </td>

  <td>




  <div>


  </div>



  </td>
  </tr>



  <tr>
  <td>

  <button type="button" class="btn btn-secondary"></button>		


				 </td>

<td>


</td>

<td>


<button type="submit" class="btn btn-success">Guardar Cambios</button>

 
<!-- Begin page content -->


<input type="hidden" name="cod_usuario" value="<?php echo $_SESSION['MM_id_usuario']; ?>">
<input type="hidden" name="cod_taquilla" value="<?php echo $_SESSION['MM_cod_taquilla']; ?>">




</td>
</tr> 

</table>
</form> 

      
<!-- Fin Contenido --> 
</div>
</div>
<!-- Fin row --> 
  
</div>

<!-- Fin container -->


<!-- Bootstrap core JavaScript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 

<script src="../js/bootstrap4.js"></script>
</body>
</html>
