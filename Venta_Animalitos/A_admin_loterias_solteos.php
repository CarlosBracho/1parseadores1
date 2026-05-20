<?php
 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
setlocale(LC_ALL, "es_ES");
$loginFormAction = $_SERVER['PHP_SELF'];

$query_Recordset1111 = sprintf(
    "/* PARSEADORES1 Venta_Animalitos\A_admin_loterias_solteos.php - QUERY 1 */ SELECT id_Loterias_y_nombres_ani1, nom_Loterias_y_nombres_ani1, animales_Loterias_y_nombres_ani1, horas_solteos_ani1, estado_ani1
  FROM  ani1_loterias_y_nombres
   ORDER BY id_Loterias_y_nombres_ani1 ASC");
  $Recordset1111 =mysqli_query($conexionbanca, $query_Recordset1111) or die(mysqli_error($conexionbanca));
  $row_Recordset1111 = mysqli_fetch_assoc($Recordset1111);
  $totalRows_Recordset1111 = mysqli_num_rows($Recordset1111);

  $dir = array();
  $cont = 0;
  if ($totalRows_Recordset1111>=1) {
    do {
     $dir[$cont] = $row_Recordset1111;
     $cont++;
    } while ($row_Recordset1111 = mysqli_fetch_assoc($Recordset1111));
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
<link href="../css/bootstrapBootswatchv4.5.2.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<script src="../js/jquery-3.5.1.min.js"></script>
<script src="../js/datepicked.gijgo1.9.13.min.js" type="text/javascript"></script>
<link href="../css/datepicked.gijgo1.9.13.min.css" rel="stylesheet" type="text/css" />
   

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

          
          <?php
          $num=0;
          foreach ($dir as $clave) { 
            
?>
                <form class="row g-3" id="<?php echo $num; ?>" name="<?php echo $num; ?>" method="POST" ?>">

<tr>
          <td >
          <input type="hidden" name="id_Loterias_y_nombres_ani1" id="id_Loterias_y_nombres_ani1" value="<?php echo $clave['id_Loterias_y_nombres_ani1']; ?>" disable />
          <?php echo $clave['id_Loterias_y_nombres_ani1']; ?>
          
          </td>
          <td>
          <input type="text"  name="nom_Loterias_y_nombres_ani1" id="nom_Loterias_y_nombres_ani1" value="<?php echo $clave['nom_Loterias_y_nombres_ani1']; ?>" class="form-control" >

          </td>
          <td>
          <input type="text"  name="animales_Loterias_y_nombres_ani1" id="animales_Loterias_y_nombres_ani1" value="<?php echo $clave['animales_Loterias_y_nombres_ani1']; ?>" class="form-control"  >

          </td>
          <td>
          
          <input type="text"  name="horas_solteos_ani1" id="horas_solteos_ani1" value="<?php echo $clave['horas_solteos_ani1']; ?>" class="form-control"  >

          </td>
          <td>
          <?php echo $clave['estado_ani1']; ?>

          </td>
          <td>
          <a class="btn btn-danger" href='A_admin_loterias_solteos2.php?id_Loterias_y_nombres_ani1=<?php echo $clave['id_Loterias_y_nombres_ani1']; ?>' role="button">Editar</a>
        
        </td>

          </tr>
          </form>

          <script>

















  </script>

          <?php
          $num++;
        }
        
?>
          









        </thead>
        <tbody>

        </tbody>
      </table>
      
      <!-- Fin Contenido --> 
    </div>
  </div>
  <!-- Fin row --> 
  </div>
  <script>
    function activarform3 (form){
      
        var inputValue = form.horas_solteos_ani1.value;
        //alert('url');
        let formData = new FormData(form);
  let object = {};
  formData.forEach(function(value, key){
    object[key] = value;
  });
  var json = JSON.stringify(object);

  fetch('http://localhost/full_con_animalitos/Venta_Animalitos/A_admin_loterias_solteos2.php', {
    method: 'POST',
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    },
    body: JSON.stringify(object)
})
.then(response => response.json())
.then(response => console.log(JSON.stringify(response)))


//alert('url');
  //alert(JSON.stringify(Object.fromEntries(formData)));



    };





                       

                          function activarform2 (form){
        var dataString = $(form).serialize();
        alert('Datos serializados: '+dataString);
        fetch('http://localhost/full_con_animalitos/Venta_Animalitos/A_admin_loterias_solteos2.php', {
  method: "POST",
  body: JSON.stringify(dataString),
  headers: {"Content-type": "application/json; charset=UTF-8"}
})
.then(response => response.json()) 
.then(json => console.log(json))
.catch(err => console.log(err))




    }; 


    function activarform4 (form){
      var value = 'Content-Type';
    var xhr = new XMLHttpRequest();
xhr.open("POST", 'http://localhost/full_con_animalitos/Venta_Animalitos/A_admin_loterias_solteos2.php', true);
xhr.setRequestHeader('Content-Type', 'application/json');
xhr.send(JSON.stringify({
    value: value
}));
}; 



function activarform (form) {
  var value = 'Content-Type';
		$.ajax({
			dataType: 'JSON',
			type: 'POST',
			url: 'http://localhost/full_con_animalitos/Venta_Animalitos/A_admin_loterias_solteos2.php',
			beforeSend: function() {

			},
			success: function(response) {

			},
			error: function() {
				showMessage('danger', AJAX_ERROR_INESPERADO);
			}
		});
	}
</script>




  </script>

<script src="../js/bootstrap4.js"></script>
</body>
</html>


<?php


        
?>