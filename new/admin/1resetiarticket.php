<?php require_once('../Connections/conexionbanca.php');
//print_r($_POST);
//sinseguridad
if (isset($_POST['ticketticket'])) {
    //echo $_POST['ticketticket'];
    if ($_POST['modulo']==0) {
        $query_Recordset1 = sprintf(
            "/* PARSEADORES1 new\admin\1resetiarticket.php - QUERY 1 */ SELECT *
		FROM 
			venta,
			carrera,
			usuario,
			taquilla,
			taquilla_opc_ame 
		WHERE 
			venta.ticket = %s AND
			carrera.cod_carrera = venta.cod_carrera AND
			usuario.id_usuario = venta.id_usuario AND
			usuario.cod_taquilla = taquilla.cod_taquilla AND
			taquilla_opc_ame.cod_taquilla = taquilla.cod_taquilla
		ORDER BY venta.cod_tventa",
            GetSQLValueString($_POST['ticketticket'], "int")
        );
        $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
        $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
        $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
        $cod_carrera=$row_Recordset1['cod_carrera'];
       
        if ($totalRows_Recordset1>=1) {
            $insertSQL1 = sprintf(
                "/* PARSEADORES1 new\admin\1resetiarticket.php - QUERY 2 */ UPDATE venta
            SET
            est_ticket=1,
            est_calculo=0
            WHERE ticket=%s",
                GetSQLValueString($_POST['ticketticket'], "int")
            );
    
            $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        }
    }
    if ($_POST['modulo']==1) {
    }
    if ($_POST['modulo']==2) {
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="../css/bootstrap4.min.css" rel="stylesheet">
    
<script>


</script>


<script>
var objXMLHttpRequest = new XMLHttpRequest();
objXMLHttpRequest.onreadystatechange = function() {
  if(objXMLHttpRequest.readyState === 4) {
    if(objXMLHttpRequest.status === 200) {
          alert(objXMLHttpRequest.responseText);
    } else {
          alert('Error Code: ' +  objXMLHttpRequest.status);
          alert('Error Message: ' + objXMLHttpRequest.statusText);
    }
  }
}

</script>

<?php
if (isset($cod_carrera)) {
    if ($cod_carrera>=1) {
        ?>
        <script>
function abrir1Ventanas(qqqq) {
  
        objXMLHttpRequest.open('GET', '../admin/dividendos_edit2.php?recordID='+qqqq);
objXMLHttpRequest.send();
}
</script>
<?php
$url1=$cod_carrera;
        //echo $url1;
        echo "<script>";
        echo "abrir1Ventanas('$cod_carrera')";
        
        echo "</script>";
    }
}
?>
    <title>Hello, world!</title>
  </head>
  <body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
    <h1>Hello, world!</h1>

    <form class="row g-3" name="form" method="post" action="1resetiarticket.php">
  <div class="col-auto">
    <label for="inputPassword2" class="visually-hidden">Password</label>
    <input type="number" class="form-control" id="ticketticket"  name="ticketticket" value="337425254740" placeholder="Password">
  </div>


  <div class="col-auto">
  <div class="input-group">
  <select class="custom-/* PARSEADORES1 new\admin\1resetiarticket.php - QUERY 3 */ select" id="inputGroupSelect04" name="modulo">
    <option >Choose...</option>
    <option value="0" selected>Americanas</option>
    <option value="1">Nacionales</option>
    <option value="2">Parley</option>
  </select>

</div>


</div>

  <div class="col-auto">
    <button type="submit" class="btn btn-primary mb-3">Confirm identity</button>
  </div>
</form>

<div>
                                <input type="button" class="btn btn-warning" onclick="window.location='1resetiarticket.php';"
                                value="ACTUALIZAR PÁGINA" style="width:300px; font-size:20px; height:45px"
                                tabindex="<?php echo $x;?>" title="actualiza página"/>
                            </div>



 

    


    <script src="../js/bootstrap4.bundle.min.js" ></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    -->
  </body>
</html>