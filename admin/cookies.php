<?php
if (!isset($_SESSION)){session_start();} require_once('../Connections/conexionbanca.php');
set_time_limit(0);


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if (isset($_POST['cookie1'])) {


    $insertSQL1 = sprintf(
        "/* PARSEADORES1 admin\cookies.php - QUERY 1 */ UPDATE cookies  
				SET cookiefull=%s, errorcookie=0			
				WHERE id_cookie=1",
        GetSQLValueString($_POST['cookie1'], "text")
    );
        
    $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
                


}


if (isset($_POST['cookie2'])) {

   

    $insertSQL2 = sprintf(
        "/* PARSEADORES1 admin\cookies.php - QUERY 2 */ UPDATE cookies  
				SET cookiefull=%s, errorcookie=0			
				WHERE id_cookie=2",
        GetSQLValueString($_POST['cookie2'], "text")
    );
        
    $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
          

}








$query_Recordset111 = sprintf("/* PARSEADORES1 admin\cookies.php - QUERY 3 */ SELECT * 
	FROM 
	cookies  
      WHERE
    id_cookie=1");   
$Recordset111 = mysqli_query($conexionbanca, $query_Recordset111) or die(mysqli_error($conexionbanca));
$row_Recordset111 = mysqli_fetch_assoc($Recordset111);
$totalRows_Recordset111 = mysqli_num_rows($Recordset111);

$query_Recordset112 = sprintf("/* PARSEADORES1 admin\cookies.php - QUERY 4 */ SELECT * 
	FROM 
	cookies
    WHERE
    id_cookie=2
    ");   
    
$Recordset112 = mysqli_query($conexionbanca, $query_Recordset112) or die(mysqli_error($conexionbanca));
$row_Recordset112 = mysqli_fetch_assoc($Recordset112);
$totalRows_Recordset112 = mysqli_num_rows($Recordset112);




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
    <link href="../bootstrap4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="assets/sticky-footer-navbar.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="../bootstrap4.5.0/js/bootstrap.min.js"></script>
    <script>


    </script>

</head>
<?php echo $row_Recordset111['cookiefull']; ?>

<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
    <div class="container">
        <div class="row">
            <form class="form-horizontal" name="form1" method="POST" action="<?php echo $editFormAction; ?>"
                onsubmit="return chequearEnvio();">




                <label for="nombre"
                    class="col-sm-8 control-label"><?php  echo $row_Recordset111['cookinombre'];  ?></label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="cookie1" name="cookie1"
                        value="<?php echo $row_Recordset111['cookiefull']; ?>" placeholder="cookiefull"
                        title="cookie. 2-10000 caracteres" size="10000" maxlength="10000" required>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Editar Cookie Twinspire</button>
                    </div>
                </div>
            </form>


            <form class="form-horizontal" name="form2" method="POST" action="<?php echo $editFormAction; ?>"
                onsubmit="return chequearEnvio();">



                <label for="nombre"
                    class="col-sm-8 control-label"><?php  echo $row_Recordset112['cookinombre'];  ?></label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="cookie2" name="cookie2"
                        value="<?php echo $row_Recordset112['cookiefull']; ?>" placeholder="cookiefull"
                        title="cookie. 2-3000 caracteres" size="3200" maxlength="3200" required>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Editar Cookie Capital</button>
                    </div>
                </div>
            </form>





        </div>
    </div>
    <?php echo $row_Recordset112['cookiefull']; ?>
</body>

</html>