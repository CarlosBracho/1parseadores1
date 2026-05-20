<?php
 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
setlocale(LC_ALL, "es_ES");
//$loginFormAction = $_SERVER['PHP_SELF'];

//var_dump($_POST);

if (isset($_POST["nom_Loterias_y_nombres_ani1"])) {
    //var_dump($_POST);


    $insertSQL1 = sprintf(
        "/* PARSEADORES1 Venta_Animalitos\A_admin_loterias_solteos2.php - QUERY 1 */ UPDATE ani1_loterias_y_nombres
            SET
            nom_Loterias_y_nombres_ani1=%s, 
            animales_Loterias_y_nombres_ani1=%s,
            horas_solteos_ani1=%s,  
            estado_ani1=%s
            WHERE 
            id_Loterias_y_nombres_ani1=%s",
        GetSQLValueString($_POST['nom_Loterias_y_nombres_ani1'], "text"),
        GetSQLValueString($_POST['animales_Loterias_y_nombres_ani1'], "text"),
        GetSQLValueString($_POST['horas_solteos_ani1'], "text"),
        GetSQLValueString($_POST['estado_ani1'], "int"),
        GetSQLValueString($_POST['id_Loterias_y_nombres_ani1'], "int")
    );
    
    $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));














    $insertGoTo = "A_admin_loterias_solteos.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
    }
    header(sprintf("Location: %s", $insertGoTo));

}




$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$query_Recordset1111 = sprintf(
    "/* PARSEADORES1 Venta_Animalitos\A_admin_loterias_solteos2.php - QUERY 2 */ SELECT id_Loterias_y_nombres_ani1, nom_Loterias_y_nombres_ani1, animales_Loterias_y_nombres_ani1, horas_solteos_ani1, estado_ani1
  FROM  ani1_loterias_y_nombres
  WHERE id_Loterias_y_nombres_ani1=%s
   ORDER BY id_Loterias_y_nombres_ani1  LIMIT 1",
	GetSQLValueString($_GET["id_Loterias_y_nombres_ani1"], "int"));
  $Recordset1111 =mysqli_query($conexionbanca, $query_Recordset1111) or die(mysqli_error($conexionbanca));
  $row_Recordset1111 = mysqli_fetch_assoc($Recordset1111);
  $totalRows_Recordset1111 = mysqli_num_rows($Recordset1111);
  echo $totalRows_Recordset1111;

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
<script>
var statusEnvio = false;
function chequearEnvio() {
    if (!statusEnvio) { statusEnvio = true;
        return true;
    } else { alert("El formulario ya está siendo enviado, por favor aguarde un instante.");
        return false;
    }
}
</script>
</head>

<body>
<header> 
  <!-- Fixed navbar -->

</header>


<div class="container">
  <hr>
  <div class="row">

  <div class="col-12 col-md-12  table-responsive "> 
      <!-- Contenido --><table class="table">
        <thead class="thead-dark">
          <tr>

            <th scope="col">ID_lot</th>
            <th scope="col">Loteria</th>
            <th scope="col">animales</th>
            <th scope="col">solteos</th>
            <th scope="col">estado</th>
            <th scope="col">editar</th>

          </tr>
          <form method="post" name="form1" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">
          <tr>


          <td >
          <input type="hidden" name="id_Loterias_y_nombres_ani1" id="id_Loterias_y_nombres_ani1" value="<?php echo $row_Recordset1111['id_Loterias_y_nombres_ani1']; ?>" disable />
          <?php echo $row_Recordset1111['id_Loterias_y_nombres_ani1']; ?>
          
          </td>
          <td>
          <input type="text"  name="nom_Loterias_y_nombres_ani1" id="nom_Loterias_y_nombres_ani1" value="<?php echo $row_Recordset1111['nom_Loterias_y_nombres_ani1']; ?>" class="form-control" >

          </td>
          <td>
          <input type="text"  name="animales_Loterias_y_nombres_ani1" id="animales_Loterias_y_nombres_ani1" value="<?php echo $row_Recordset1111['animales_Loterias_y_nombres_ani1']; ?>" class="form-control"  >

          </td>
          <td>
          
          <input type="text"  name="horas_solteos_ani1" id="horas_solteos_ani1" value="<?php echo $row_Recordset1111['horas_solteos_ani1']; ?>" class="form-control"  >

          </td>
          <td>
          <input type="text"  name="estado_ani1" id="estado_ani1" value="<?php echo $row_Recordset1111['estado_ani1']; ?>" class="form-control"  >

          

          </td>
          <td>
          <input type="submit" class="btn badge-warning" value="GUARDAR DATOS"  tabindex="50"
                  	style="width:180px; height:50px; font-size:16px;" />
        
        </td>

          </tr>

          </form>
          </thead>
        <tbody>

        </tbody>
      </table>
      
      <!-- Fin Contenido --> 
    </div>
  </div>
  <!-- Fin row --> 
  </div>


  <script src="../js/bootstrap4.js"></script>
</body>
</html>











