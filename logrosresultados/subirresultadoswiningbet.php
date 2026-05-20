<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");

//echo "  ".$_SESSION['MM_nom_usuario'];

$usuario=$_SESSION['MM_nom_usuario'];
echo $usuario.'<br>';
/**
* Multi file upload example
* @author Resalat Haque
* @link http://www.w3bees.com/2013/02/multiple-file-upload-with-php.html
**/

$valid_formats = array("html");
$max_file_size = 2048*10000; //100 kb
$path = "../logrosresultados/"; // Upload directory
$count = 0;



if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {



$insertSQL155 = sprintf(
"/* PARSEADORES1 logrosresultados\subirresultadoswiningbet.php - QUERY 1 */ UPDATE variables  SET 
variabledat=%s
WHERE variablenom=%s",
GetSQLValueString($_POST['fecha_inicio'], "text"),
GetSQLValueString('fechalogrosresultados', "text"));
$Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));







    // Loop $_FILES to execute all files
    foreach ($_FILES['files']['name'] as $f => $name) {
        if ($_FILES['files']['error'][$f] == 4) {
            continue; // Skip file if any error found
        }
        if ($_FILES['files']['error'][$f] == 0) {
            if ($_FILES['files']['size'][$f] > $max_file_size) {
                $message[] = "$name is too large!.";
                continue; // Skip large files
            } elseif (! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats)) {
                $message[] = "$name is not a valid format";
                continue; // Skip invalid file formats
            } else { // No error found! Move uploaded files
                if (move_uploaded_file($_FILES["files"]["tmp_name"][$f], $path.$name)) {
                    $count++; // Number of successfully uploaded files
                }

			// Leo

			$msj='El Administrador ' .$usuario. ' subio los resultados de Winningbet';
			$msjx=utf8_encode($msj);
			$post=[
  			'chat_id'=>-1001793339821,
  			'text'=>$msjx,
			];
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,"https://api.telegram.org/bot5218437625:AAHpDKAOQ3Nv-UZD9F_FtIFn9f7sRWLDpsw/sendMessage");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_exec ($ch);
			curl_close ($ch);

				/*/

			$url = '../logrosresultados/WiningBetresultadosMejorado.php';
    		$ch = curl_init();
    		curl_setopt($ch, CURLOPT_URL, $url);
    		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    		curl_setopt($ch, CURLOPT_TIMEOUT, 90);
    		$datoscurl = curl_exec($ch);
    		curl_close($ch);
   
    		var_dump($datoscurl);
			/*/
			//Fin Leo

            }
        }
    }
}


$query_Recordset1771 = sprintf(
    "/* PARSEADORES1 logrosresultados\subirresultadoswiningbet.php - QUERY 2 */ SELECT *
FROM variables 
WHERE  
variablenom = %s ",
    GetSQLValueString('fechalogrosresultados', "text")
);
$Recordset1771 = mysqli_query($conexionbanca, $query_Recordset1771) or die(mysqli_error($conexionbanca));
$row_Recordset1771 = mysqli_fetch_assoc($Recordset1771);
$totalRows_Recordset1771 = mysqli_num_rows($Recordset1771);
$totaltotalRows=$totalRows_Recordset1771;
$FechaTxt=$row_Recordset1771['variabledat'];
?>




<!DOCTYPE html>
<!-- saved from url=(0033)https:// -->
<html lang="es">
<head>
<title>.:SUBIR RESULTADOS:.</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>.:Apuestas:.</title>
    <!-- Bootstrap core CSS 
    <link href="./Vendedor/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    -->
	<link href="../css/bootstrapBootswatchv4.5.2.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<script src="../js/jquery-3.5.1.min.js"></script>
<script src="../js/datepicked.gijgo1.9.13.min.js" type="text/javascript"></script>
<link href="../css/datepicked.gijgo1.9.13.min.css" rel="stylesheet" type="text/css" />



<style type="text/css">
a{ text-decoration: none; color: #333}
h1{ font-size: 1.9em; margin: 10px 0}
p{ margin: 8px 0}
*{
	margin: 0;
	padding: 0;
	box-sizing: border-box;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	-webkit-font-smoothing: antialiased;
	-moz-font-smoothing: antialiased;
	-o-font-smoothing: antialiased;
	font-smoothing: antialiased;
	text-rendering: optimizeLegibility;
}
body{
	font: 12px Arial,Tahoma,Helvetica,FreeSans,sans-serif;
	text-transform: inherit;
	color: #333;
	background: #e7edee;
	width: 100%;
	line-height: 18px;
}
.wrap{
	width: 500px;
	margin: 15px auto;
	padding: 20px 25px;
	background: white;
	border: 2px solid #DBDBDB;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	overflow: hidden;
	text-align: center;
}
.status{
	/*display: none;*/
	padding: 8px 35px 8px 14px;
	margin: 20px 0;
	text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
	color: #468847;
	background-color: #dff0d8;
	border-color: #d6e9c6;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
}
input[type="submit"] {
	cursor:pointer;
	width:100%;
	border:none;
	background:#991D57;
	background-image:linear-gradient(bottom, #8C1C50 0%, #991D57 52%);
	background-image:-moz-linear-gradient(bottom, #8C1C50 0%, #991D57 52%);
	background-image:-webkit-linear-gradient(bottom, #8C1C50 0%, #991D57 52%);
	color:#FFF;
	font-weight: bold;
	margin: 20px 0;
	padding: 10px;
	border-radius:5px;
}
input[type="submit"]:hover {
	background-image:linear-gradient(bottom, #9C215A 0%, #A82767 52%);
	background-image:-moz-linear-gradient(bottom, #9C215A 0%, #A82767 52%);
	background-image:-webkit-linear-gradient(bottom, #9C215A 0%, #A82767 52%);
	-webkit-transition:background 0.3s ease-in-out;
	-moz-transition:background 0.3s ease-in-out;
	transition:background-color 0.3s ease-in-out;
}
input[type="submit"]:active {
	box-shadow:inset 0 1px 3px rgba(0,0,0,0.5);
}
</style>

</head>
<body>
<form action="" method="post" enctype="multipart/form-data">
<input name="fecha_inicio" id="datepicker" width="276" value="<?php echo htmlentities($FechaTxt, ENT_COMPAT, 'utf-8'); ?>" />
    <script>
        $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4',
            dateFormat: 'yyyy-mm-dd'
        });
    </script>
	<div class="wrap">
		<h1>SUBIR RESULTADOS PARLEY</h1>
		<?php
        # error messages
        if (isset($message)) {
            foreach ($message as $msg) {
                printf("<p class='status'>%s</p></ br>\n", $msg);
            }
        }
        # success message
        if ($count !=0) {
            printf("<p class='status'>%d files added successfully!</p>\n", $count);
			
			
			//$url = 'http://localhost/proyectosglobales/primertrabajo/apuestas/new/logrosresultados/WiningBetresultadosMejorado2.php';
			$url = 'http://localhost/new/logrosresultados/WiningBetresultadosMejorado.php';
    		$ch = curl_init();
    		curl_setopt($ch, CURLOPT_URL, $url);
    		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    		curl_setopt($ch, CURLOPT_TIMEOUT, 90);
    		$datoscurl = curl_exec($ch);
    		curl_close($ch);
   
    		var_dump($datoscurl);

			
        }
		
        ?>
		<p>SOLO SE DEBEN METER RESULTADOS .PDF</p>
		<br />
		RECUERDE QUE LOS RESULTADOS QUE SUBA CORRESPONDA CON LA FECHA ACTUAL<br />
		<!-- Multiple file upload html form-->



			<input type="file" name="files[]" multiple="multiple" accept=""*.html*"">
			<input type="submit" value="SUBIR">
		</form>
</div >




<script src="../js/bootstrap4.js"></script>

</body>
</html>