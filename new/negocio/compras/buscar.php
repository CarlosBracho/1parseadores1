<?php
require_once('../Connections/conexionbanca.php');
//Variable de búsqueda
// $consultaBusqueda = $_POST['valorBusqueda'];
$consultaBusqueda = 'CHIMU';
//Filtro anti-XSS
$caracteres_malos = array("<", ">", "\"", "'", "/", "<", ">", "'", "/");
$caracteres_buenos = array("& lt;", "& gt;", "& quot;", "& #x27;", "& #x2F;", "& #060;", "& #062;", "& #039;", "& #047;");
$consultaBusqueda = str_replace($caracteres_malos, $caracteres_buenos, $consultaBusqueda);

//Variable vacía (para evitar los E_NOTICE)
$mensaje = "";

//Comprueba si $consultaBusqueda está seteado
if (isset($consultaBusqueda)) {

    //Selecciona todo de la tabla mmv001
    //donde el nombre sea igual a $consultaBusqueda,
    //o el apellido sea igual a $consultaBusqueda,
    //o $consultaBusqueda sea igual a nombre + (espacio) + apellido
    
    
    $query_Recordset1 = sprintf("/* PARSEADORES1 new\negocio\compras\buscar.php - QUERY 1 */ SELECT 
		* 
		FROM 
			producto
		WHERE  
			productoensede COLLATE UTF8_SPANISH_CI LIKE '%$consultaBusqueda%' ");
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    
    
    
    //	$consulta = sprintf( "SELECT * FROM producto
    //	WHERE productoensede COLLATE UTF8_SPANISH_CI LIKE '%$consultaBusqueda%'
    //	");
    
    //Obtiene la cantidad de filas que hay en la consulta
    $filas = $totalRows_Recordset1;

    //Si no existe ninguna fila que sea igual a $consultaBusqueda, entonces mostramos el siguiente mensaje
    if ($filas === 0) {
        $mensaje = "<p>No hay ningún usuario con ese nombre y/o apellido</p>";
    } else {
        //Si existe alguna fila que sea igual a $consultaBusqueda, entonces mostramos el siguiente mensaje
        echo 'Resultados para <strong>'.$consultaBusqueda.'</strong>';

        //La variable $resultado contiene el array que se genera en la consulta, así que obtenemos los datos y los mostramos en un bucle
        while ($resultados = mysqli_fetch_array($consulta)) {
            $nombre = $resultados['cantidad'];
            $apellido = $resultados['productoensede'];


            
            
            //Output
            $mensaje .= '
			<p>
			<strong>Nombre:</strong> ' . $nombre . '<br>
			<strong>Apellido:</strong> ' . $apellido . '<br>
			</p>';
        };//Fin while $resultados
    }; //Fin else $filas
};//Fin isset $consultaBusqueda

//Devolvemos el mensaje que tomará jQuery
echo $mensaje;


  
      $buscar = $_POST['b'];
        
      if (!empty($buscar)) {
          buscar($buscar);
      }
        
      function buscar($b)
      {
          $con = mysql_connect('localhost', 'usuario', 'password-bd');
          mysql_select_db('nombre-bd', $con);
        
          $sql = mysql_query("/* PARSEADORES1 new\negocio\compras\buscar.php - QUERY 2 */ SELECT * FROM paises WHERE nombre LIKE '%".$b."%' LIMIT 9", $con);
              
          $contar = @mysql_num_rows($sql);
              
          if ($contar == 0) {
              echo "No se han encontrado resultados para '<b>".$b."</b>'.";
          } else {
              while ($row=mysql_fetch_array($sql)) {
                  $nombre = $row['nombre'];
                  $prefijo = $row['prefijo'];
                  $continente = $row['continente'];
                  echo $prefijo." - "."<a>".$nombre."</a>"."<br />";
              }
          }
      }
