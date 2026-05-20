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
if (isset($_POST['largoticketani'])) {
  if($_POST['coletilla_parleyU1']==''){
    $_POST['coletilla_parleyU1']="c";
}
if($_POST['coletilla_parleyU2']==''){
    $_POST['coletilla_parleyU2']="c";
}
$Cole='*'.$_POST['coletilla_parleyD0'].',,,'.$_POST['coletilla_parleyD1'].',,,'.$_POST['coletilla_parleyD2'].'*'.$_POST['coletilla_parleyA0'].',,,'.$_POST['coletilla_parleyA1'].',,,'.$_POST['coletilla_parleyA2'].'*'.$_POST['coletilla_parleyU0'].',,,'.$_POST['coletilla_parleyU1'].',,,'.$_POST['coletilla_parleyU2'];
if(isset($_POST['tipoticket']) && $_POST['tipoticket']==1 ){
$conf='*U,,,'.$_POST['Tamano'].',,,'.$_POST['letra'].',,,'.$_POST['tipoticket']; 
}else{$conf='';}          
  $updateSQL = sprintf(
    "/* PARSEADORES1 Venta_Animalitos\aniconfiguracion.php - QUERY 1 */ UPDATE taquilla_opc_ani 
  SET 
  largoticketani=%s,
  coletilla_ani=%s,
  config_varias=%s
  WHERE 
  cod_taquilla=%s",
    GetSQLValueString($_POST['largoticketani'], "int"),
    GetSQLValueString($Cole, "text"),
    GetSQLValueString($conf, "text"),
    GetSQLValueString($_POST['cod_taquilla'], "int")
);
$Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
    



}



$query_Recordset13 = sprintf(
"/* PARSEADORES1 Venta_Animalitos\aniconfiguracion.php - QUERY 2 */ SELECT *
FROM taquilla_opc_ani top, taquilla ta
WHERE
top.cod_taquilla = %s AND 
top.cod_taquilla = %s
LIMIT 1",
GetSQLValueString($_SESSION['MM_cod_taquilla'], "int"), 
GetSQLValueString($_SESSION['MM_cod_taquilla'], "int"));
$Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
$row_Recordset13 = mysqli_fetch_assoc($Recordset13);
$totalRows_Recordset13 = mysqli_num_rows($Recordset13);

$coletilla_parley=$row_Recordset13['coletilla_ani'];
if($coletilla_parley==''){

  $coletilla_parley='*D,,,c,,,c*A,,,c,,,c*U,,,c,,,c'; 
} 
$configuracion=$row_Recordset13['config_varias'];
$configuracion3=$row_Recordset13['config_varias'];
if($configuracion==''){
  $configuracion3='*U,,,14,,,Arial,,,0'; 
  $configuracion='*U,,,14,,,Arial,,,0'; 
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
<link href="../css/bootstrap4.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="./Venta _ Lotoriente_files/bootstrap.css" rel="stylesheet" type="text/css">
							
            <link href="./Venta _ Lotoriente_files/font-awesome.css" rel="stylesheet" type="text/css">
            <link href="./Venta _ Lotoriente_files/animalito.css" rel="stylesheet" type="text/css">
            <link href="./Venta _ Lotoriente_files/animalito-bootstrap-theme.css" rel="stylesheet" type="text/css">
        
	<link href="./Venta _ Lotoriente_files/menu.css" rel="stylesheet" type="text/css">

	<link type="text/css" rel="stylesheet" href="./Venta _ Lotoriente_files/ntf.css">
	<link href="./Venta _ Lotoriente_files/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="./Venta _ Lotoriente_files/datatables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">

</head>

<body>
<header> 
<!-- Fixed navbar -->
<?php include('menutaa.php'); ?>
</header>







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

<div class="container">



  <tr>
    <th>Espacio Al final de la impresion</th>
    <th style="text-align: left;">Tipo de ticket</th>
    <?php 
$configuracion = explode("*", $configuracion);
 foreach ($configuracion as $configuracion2){
  $configuracion2 = explode(",,,", $configuracion2);
  if($configuracion2['3']==1){    
?>
    <th>Tamaño de letra</th>
    <th style="text-align: left;">Tipo de letra</th>


    <?php }}    
?>
</tr>
<tr>
<td style="height:auto; width:25%">


<select  name="largoticketani" class="form-control input-sm form-/* PARSEADORES1 Venta_Animalitos\aniconfiguracion.php - QUERY 3 */ select"  title="Loterías">
            <?php for ($i = 0; $i < 10; ++$i) {?>
                <option value="<?php echo $i; ?>"
                <?php if (!(strcmp($i, htmlentities($row_Recordset13['largoticketani'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>
                <?php echo $i; ?>
                </option>
            <?php } ?>    
            </select>    
  

  
  
</td>
<?php 
$configuracion3 = explode("*", $configuracion3);
foreach ($configuracion3 as $configuracion21){
 $configuracion21 = explode(",,,", $configuracion21);
 if($configuracion21['0']=='U'){   
?>

<td style="height:auto; width:25%">


<select  name="tipoticket" class="form-control input-sm form-/* PARSEADORES1 Venta_Animalitos\aniconfiguracion.php - QUERY 4 */ select"  title="Loterías">
<option value="0"  <?php if (!(strcmp(0, htmlentities($configuracion21['3'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>Ticket Estandar</option>
      <option value="1"  <?php if (!(strcmp(1, htmlentities($configuracion21['3'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>Ticket Nuevo</option>
  
            </select>    
  

  
  
</td>

<td style="height:auto; width:25%">

<?php if($configuracion21['3']==1){ ?>
<select  name="letra" class="form-control input-sm form-/* PARSEADORES1 Venta_Animalitos\aniconfiguracion.php - QUERY 5 */ select"  title="Loterías">
<option value="Arial"  <?php if (!(strcmp('Arial', htmlentities($configuracion21['2'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>Arial</option>
      <option value="Comic Sans"  <?php if (!(strcmp('Comic Sans', htmlentities($configuracion21['2'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>Comic Sans</option>
      <option value="Times New Roman"  <?php if (!(strcmp('Times New Roman', htmlentities($configuracion21['2'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>Times New Roman</option>
      <option value="Helvetica"  <?php if (!(strcmp('Helvetica', htmlentities($configuracion21['2'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>Helvetica</option>
<option value="Italic"  <?php if (!(strcmp('Italic', htmlentities($configuracion21['2'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>italic</option>  
            </select>    
  

  
  
</td>

<td style="height:auto; width:25%">


<select  name="Tamano" class="form-control input-sm form-/* PARSEADORES1 Venta_Animalitos\aniconfiguracion.php - QUERY 6 */ select"  title="Loterías">
<?php for ($i = 10; $i < 40; ++$i) {?>
                <option value="<?php echo $i; ?>"
                <?php if (!(strcmp($i, htmlentities($configuracion21['1'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>
                <?php echo $i; ?>
                </option>
            <?php } ?> 
            </select>    
  

  
  
</td>

<?php 
}}}
?>

  </tr>
    
 


  <?php
                  $coletilla_parley = explode("*", $coletilla_parley);
                  foreach ($coletilla_parley as $coletilla_parley2){ 
                    $coletilla_parley2 = explode(",,,", $coletilla_parley2);
                    
                    if($coletilla_parley2[0]=='A'){ ?>
<input type="hidden" name="coletilla_parleyA0" value="<?php echo $coletilla_parley2[0]; ?>">
<input type="hidden" name="coletilla_parleyA1" value="<?php echo $coletilla_parley2[1]; ?>">
<input type="hidden" name="coletilla_parleyA2" value="<?php echo $coletilla_parley2[2]; ?>">             
                    <?php } if($coletilla_parley2[0]=='D'){?>
<input type="hidden" name="coletilla_parleyD0" value="<?php echo $coletilla_parley2[0]; ?>">
<input type="hidden" name="coletilla_parleyD1" value="<?php echo $coletilla_parley2[1]; ?>">
<input type="hidden" name="coletilla_parleyD2" value="<?php echo $coletilla_parley2[2]; ?>">   
                    <?php }
                    if($coletilla_parley2[0]=='U'){  
                      if($coletilla_parley2[1]=="c"){
                        $coletilla_parley2[1]="";
                      } 
                      if($coletilla_parley2[2]=="c"){
                        $coletilla_parley2[2]="";
                      }                     
                    ?>
                  <tr valign="baseline">
                  <input type="hidden" name="coletilla_parleyU0" value="<?php echo $coletilla_parley2[0]; ?>">                    
                  <td nowrap align="left" >TEXTO AL FINAL DEL TICKET LINEA 1:</td>
                  <td colspan="4">
                  	<input type="text" name="coletilla_parleyU1" class="textboxsmal" style="height:auto; width:560px" onclick="ocultaDiv('Info4');"
                    value="<?php echo htmlentities($coletilla_parley2[1], ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" title="indique texto" maxlength="20" 
                    onKeyUp="return handleEnter(this, event)" />
                    <div id="Info4" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmig; ?></div>
                  </td>
                </tr>

                <tr valign="baseline">
                    
                  <td nowrap align="left" >TEXTO AL FINAL DEL TICKET LINEA 2:</td>
                  <td colspan="4">
                  	<input type="text" name="coletilla_parleyU2" class="textboxsmal" style="height:auto; width:560px" onclick="ocultaDiv('Info4');"
                    value="<?php echo htmlentities($coletilla_parley2[2], ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" title="indique texto" maxlength="20"  
                    onKeyUp="return handleEnter(this, event)" />
                    <div id="Info4" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmig; ?></div>
                  </td>
                </tr>
                
           <?php }}?>


  <tr>
  <td>

  <button type="button" class="btn btn-secondary"></button>		


				 </td>

<td>


</td>

<td>


<button style="color:#000" type="submit" class="btn btn-success">Guardar Cambios</button>

 
<!-- Begin page content -->


<input type="hidden" name="cod_usuario" value="<?php echo $_SESSION['MM_id_usuario']; ?>">
<input type="hidden" name="cod_taquilla" value="<?php echo $_SESSION['MM_cod_taquilla']; ?>">




</td>
</tr> 
</div>
</table>
</form> 

      
<!-- Fin Contenido --> 


<!-- Fin container -->


<!-- Bootstrap core JavaScript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 

<script src="../js/bootstrap4.js"></script>
</body>
</html>
