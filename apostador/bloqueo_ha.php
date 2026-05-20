<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
if (!isset($_SESSION['MM_id_usuario'])) {
    $id_usuarioO=$_SESSION['MM_id_usuario'];
} else {
    $id_usuarioO=0;
}

$currentPage = $_SERVER["PHP_SELF"];
$maxRows_Recordset1 = 600;
$pageNum_Recordset1 = 0;

$xCodigo = "-1";
$xCodigo2 = "-1";

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if (isset($_GET["recordID"])) {
  $xCodigo = $_GET["recordID"];
  $xCodigo2 = $_GET["recordID"];
}
$modulo=18;
$modulo2=10;


$hor=horaactual();
$fec=fechaactualbd();
$xbanca_Recordset12 = 2;

$query_Recordset12 = sprintf("/* PARSEADORES1 apostador\bloqueo_ha.php - QUERY 1 */ SELECT cod_hipodromo, nom_hipodromo, hor_carrera FROM carrera WHERE carrera.fec_carrera = %s AND carrera.hor_carrera >= %s AND carrera.est_carrera = 1 AND carrera.cod_banca = %s ORDER BY carrera.hor_carrera  LIMIT 0, 20", 
GetSQLValueString($fec, "date"), GetSQLValueString($hor, "date"), GetSQLValueString($xbanca_Recordset12, "int"));
$Recordset12 = mysqli_query($conexionbanca, $query_Recordset12) or die(mysqli_error($conexionbanca));
$row_Recordset12 = mysqli_fetch_assoc($Recordset12);
$totalRows_Recordset12 = mysqli_num_rows($Recordset12);




          
      



$query_Recordset18 = sprintf(
  "/* PARSEADORES1 apostador\bloqueo_ha.php - QUERY 2 */ SELECT 
  ta.cod_taquilla, ta.nom_taquilla, ta.cod_agencia, ag.cod_agencia, ag.nom_agencia, ag.cod_banca,
  ba.cod_banca, ba.nom_banca, us.nom_usuario, us.cod_taquilla
  FROM
  taquilla ta, agencia ag, banca ba, usuario us
 WHERE
 ta.cod_taquilla = %s AND ag.cod_agencia = ta.cod_agencia AND ba.cod_banca = ag.cod_banca AND us.cod_taquilla = ta.cod_taquilla AND ta.tipotaquilla=3",
  GetSQLValueString($xCodigo, "int"));
          $Recordset18= mysqli_query($conexionbanca, $query_Recordset18) or die(mysqli_error($conexionbanca));
          $row_Recordset18 = mysqli_fetch_assoc($Recordset18);
          $totalRows_Recordset18 = mysqli_num_rows($Recordset18);

$agenteagente=$row_Recordset18['cod_agencia'];

          $query_Recordset3 = sprintf(
            "/* PARSEADORES1 apostador\bloqueo_ha.php - QUERY 3 */ SELECT ta.cod_taquilla, ta.nom_taquilla 
          FROM taquilla ta, taquilla_opc_ame tp WHERE ta.cod_agencia = %s AND ta.cod_taquilla = tp.cod_taquilla AND ta.cod_taquilla != %s AND ta.tipotaquilla=3 ORDER BY nom_taquilla",
              GetSQLValueString($agenteagente, "int"),
              GetSQLValueString($xCodigo2, "int")
          );
          $Recordset3 =mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
          $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
          $totalRows_Recordset3 = mysqli_num_rows($Recordset3);
          
          $query_Recordset38 = sprintf(
            "/* PARSEADORES1 apostador\bloqueo_ha.php - QUERY 4 */ SELECT ta.cod_taquilla, ta.nom_taquilla 
          FROM taquilla ta, taquilla_opc_ame tp WHERE ta.cod_agencia = %s AND ta.cod_taquilla = tp.cod_taquilla AND ta.cod_taquilla != %s AND ta.tipotaquilla=3 ORDER BY nom_taquilla",
              GetSQLValueString($agenteagente, "int"),
              GetSQLValueString($xCodigo2, "int")
          );
          $Recordset38 =mysqli_query($conexionbanca, $query_Recordset38) or die(mysqli_error($conexionbanca));
          $row_Recordset38 = mysqli_fetch_assoc($Recordset38);
          $totalRows_Recordset38 = mysqli_num_rows($Recordset38);
     

if (isset($_GET['pageNum_Recordset1'])) {
    $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

$query_Recordset1 = "/* PARSEADORES1 apostador\bloqueo_ha.php - QUERY 5 */ SELECT cod_hipodromo, nom_hipodromo, est_hipodromo, bus_auto FROM hipodromo ORDER BY nom_hipodromo ASC";
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




if(isset($_POST['taq_bloq'])){

  $query_Recordset32 = sprintf(
    "/* PARSEADORES1 apostador\bloqueo_ha.php - QUERY 6 */ SELECT hip_bloqueados
  FROM taquilla_opc_ame 
  WHERE 
  cod_taquilla= %s",
    GetSQLValueString($_POST['principal'], "int")
  );
  $Recordset32 =mysqli_query($conexionbanca, $query_Recordset32) or die(mysqli_error($conexionbanca));
  $row_Recordset32 = mysqli_fetch_assoc($Recordset32);
  $totalRows_Recordset32 = mysqli_num_rows($Recordset32);
    $hipodromo=$row_Recordset32['hip_bloqueados'];
    do{
    if($_POST['taq_bloq']==0){
      $taquillinas=$row_Recordset38['cod_taquilla'];
      //echo $taquillinas;
    }else{
    $taquillinas=$_POST['taq_bloq'];
  }
    
$insertSQL1 = sprintf(
  "/* PARSEADORES1 apostador\bloqueo_ha.php - QUERY 7 */ UPDATE taquilla_opc_ame  
      SET hip_bloqueados=%s				
      WHERE cod_taquilla=%s",
  
  GetSQLValueString($hipodromo, "text"),
  GetSQLValueString($taquillinas, "int")
);
$Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
}while($row_Recordset38 = mysqli_fetch_assoc($Recordset38));

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
<link href="dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="assets/sticky-footer-navbar.css" rel="stylesheet">
<script src="../js/jquery-3.5.1.min.js"></script>
	<script type="text/javascript">
 $(document).ready(function() {
	 $("#saldocliente").load('saldoapostador.php?&js='+Math.random());
	 var refreshId6 = setInterval(function() {
	 	saldocli();
	 }, 30000);

});
</script>
</head>

<body>
<header> 
  <!-- Fixed navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#"><span id="saldocliente"></span></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    
	<?php if($_SESSION['TIPO']==1){?>
	
	<ul class="navbar-nav mr-auto">
	  	        <li class="nav-item">                
         <a class="dropdown-item" href="listaapostadoraa.php">Lista De Apostadores</a>         
      </li>

	        <li class="nav-item">
        <a class="dropdown-item" href="reporteaa.php">Reporte General<span class="sr-only">(current)</span></a>
      </li>

	        <li class="nav-item">
        <a class="dropdown-item" href="../agente/index.php">Volver<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="cerrar_sesion_apostador.php">Salir</a>
      </li>
    </ul>
	
    <?php }else{ ?>

      <ul class="navbar-nav mr-auto">
	  	        <li class="nav-item">
         <a class="dropdown-item" href="listaapostadorad.php">Lista De Apostadores</a>
      </li>

	        <li class="nav-item">
        <a class="dropdown-item" href="reportead.php">Reporte General<span class="sr-only">(current)</span></a>
      </li>

	        <li class="nav-item">
        <a class="dropdown-item" href="../distri/index.php">Volver<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="cerrar_sesion_apostador.php">Salir</a>
      </li>
    </ul>

<?php } ?>

  </div>
</nav>
</header>

<!-- Begin page content -->

<div class="container">
  <hr>
  <div class="row">
    <div class="col-12 col-md-12"> 
    </div>
              Usuario: <?php echo "  ".$row_Recordset18['nom_taquilla']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
      <!-- Contenido -->
      <div style="width:98%; float:right; text-align:right;">
      <input type="submit" value="RESTAURAR HIPODROMOS" style=float:left; class="btn btn-warning" title="" 
onclick="hipodromo_reactivar(<?php echo $row_Recordset1['cod_hipodromo']; ?>, <?php echo $row_Recordset18['cod_taquilla']; ?>, <?php echo $modulo2; ?>, 0); return false"   />  
      <form method="post" name="form2" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">
        	Exportar bloqueo de hipodromos:
            <select name="taq_bloq" id="exp_agencia" style="width:25%; height: auto; background:#9E1C0A; color:#FFFFFF" onclick="FetchModelo(this.value)" 
            	class="textbox">
                <option value="0" style="background:#9E1C0A; color:#FFFFFF">TODOS<?php
                do {?>
                    <option value="<?php echo $row_Recordset3['cod_taquilla']?>" style="background:#FFF; color:#000">
                        <?php echo $row_Recordset3['nom_taquilla']?></option><?php
                } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));?>
            </select>
			<input name="Exportar" id="botExp" type="submit"  value="Exportar" class="btn btn-danger" 
            	style=" font-size:14px;"/>
			<input type="hidden" name="principal" value="<?php echo $_GET["recordID"];?>"/>
        </form>
    </div>
          
<br><br>
      <table class="table">
        <thead class="thead-dark">
          <tr>

            <th scope="col">HIPODROMOS</th>
            <th scope="col">STATUS</th>
			<th scope="col">ACCIONES</th>
            
          </tr>
        </thead>
        <tbody>
        <?php do { ?>
          <tr >
            <td ><?php echo $row_Recordset1['nom_hipodromo']; ?></td>
            <td ><?php echo Dstatus_hipodromo($row_Recordset1['cod_hipodromo'], $row_Recordset18['cod_taquilla']); ?></td>
            <td >
            <?php $Status=boton_hipodromo($row_Recordset1['cod_hipodromo'], $row_Recordset18['cod_taquilla']);  if($Status==1){?>
            <input type="submit" value="BLOQUEAR"  class="btn btn-danger" title="" 
onclick="hipodromo_restringir(<?php echo $row_Recordset1['cod_hipodromo']; ?>, <?php echo $row_Recordset18['cod_taquilla']; ?>, <?php echo $modulo; ?>, 0); return false"   />  
<?php }else{ ?><?php echo 'HIPODROMO BLOQUEADO' ?> 
<?php } ?>
            </td>
            </tr>
          <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
        </tbody>
      </table>
      
      <!-- Fin Contenido --> 
    </div>
  </div>
  <!-- Fin row --> 
  
</div>


<!-- Fin container -->


<!-- Bootstrap core JavaScript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 
<script>
    function hipodromo_restringir(codigo_h, cod_taquilla, modulo, tipo){
        $.post("../agente/Hipodromo_funcion.php", 
        {
    codigo_h:codigo_h,
		cod_taquilla:cod_taquilla,
		modulo:modulo,
    tipo:tipo,
		},);

    location.reload();	
    } 
</script>
<script>
    function hipodromo_reactivar(codigo_h, cod_taquilla, modulo, tipo){
        $.post("../agente/Hipodromo_reset.php", 
        {
    codigo_h:codigo_h,
		cod_taquilla:cod_taquilla,
		modulo:modulo,
    tipo:tipo
		},);
    location.reload();	
    } 
</script>

<script src="dist/js/bootstrap.min.js"></script>
</body>
</html>

