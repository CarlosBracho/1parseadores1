<?php
require_once('../Connections/conexionbanca.php');
if (isset($_GET["recordID"])) {
    $xCodigo = $_GET["recordID"];
    $xCodigo2 = $_GET["recordID"];
} else {
    $xCodigo = $_POST["xCodigo"];
    $xCodigo2 = $_POST["xCodigo"];
}
$editFormAction = $_SERVER['PHP_SELF'];
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 admin\cambiodeagente2.php - QUERY 1 */ SELECT 
* 
FROM 
taquilla, agencia
WHERE
taquilla.cod_agencia=agencia.cod_agencia AND
taquilla.cod_taquilla= %s
ORDER BY 
agencia.nom_agencia",
    GetSQLValueString($xCodigo, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

$query_Recordset2 = sprintf("/* PARSEADORES1 admin\cambiodeagente2.php - QUERY 2 */ SELECT 
* 
FROM 
agencia
ORDER BY 
agencia.nom_agencia");
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);


if ((isset($_POST["cod_agencia"]))) {
    if ($_POST["cod_agencia"]>=1) {
        $insertSQL2 = sprintf(
            "/* PARSEADORES1 admin\cambiodeagente2.php - QUERY 3 */ UPDATE taquilla
SET
cod_agencia=%s
WHERE cod_taquilla=%s",
            GetSQLValueString($_POST['cod_agencia'], "int"),
            GetSQLValueString($_POST['xCodigo'], "int")
        );

        $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));





        header(sprintf("Location:cambiodeagente.php"));
    }
}




?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title></title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <br>
  <br>
  <br>
  <br>
  <table class="table table-responsive table-striped">
    <thead>
        <tr>
            <th>TAQUILLA</th>
            <th>AGENTE ACTUAL</th>
          
            
        </tr>
    </thead>
    <tbody>

   
        <tr>
            <td><?php echo $row_Recordset1['nom_taquilla'] ?></td>
            <td><?php echo $row_Recordset1['nom_agencia'] ?></td>
</tr>

    </tbody>
    <form method="post" name="form1" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">
    <div class="form-group">
    <select  name="cod_agencia" id="cod_agencia" class="form-/* PARSEADORES1 admin\cambiodeagente2.php - QUERY 4 */ select form-/* PARSEADORES1 admin\cambiodeagente2.php - QUERY 5 */ select-lg mb-3" aria-label=".form-/* PARSEADORES1 admin\cambiodeagente2.php - QUERY 6 */ select-lg example">
                <option value="" >SELECCIONE<?php
                do {?>
                    <option value="<?php echo $row_Recordset2['cod_agencia']; ?>" style="background:#FFF; color:#000">
                        <?php echo $row_Recordset2['nom_agencia']; ?></option><?php
                } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));?>
            </select>
            </div>


  <button type="submit" class="btn btn-primary">Submit</button>
  <input type="hidden" name="xCodigo" value="<?php echo $xCodigo; ?>">
</form>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
  </body>
</html>