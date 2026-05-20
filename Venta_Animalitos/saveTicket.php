<?php
 
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$horaTxt=horaactual();
$FechaTxt=fechaactualbd();
$datetime=$FechaTxt.' '.$horaTxt;
$ip_ventap=getRealIP();
$iniciof=$FechaTxt.' 00:00:01';
$finalf=$FechaTxt.' 23:59:59';


$estado_Ticket=0; // 1 se crearon todas las jugadas con exito 2 algunos solteos ya cerraron 3 limite para algun animalito selecionadi superado
//$_SESSION["MM_cod_taquilla"]

//incio funciones
function ObtenerNumeroJugadaA($identificador, $fechajugada)
{
global $conexionbanca;
$query_Recordset1 = sprintf("/* PARSEADORES1 Venta_Animalitos\saveTicket.php - QUERY 1 */ SELECT can_ticket_ani5 FROM ani5_jugadas 
WHERE  fechahora_creacion_ani5 >= %s AND linea_ticket_ani5 = 1 AND id_usuario_ani5 = %s ORDER BY id_ticket_ani5 DESC LIMIT 1", 
GetSQLValueString($fechajugada.' 00:00:01', "date"), 
GetSQLValueString($identificador, "int"));
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

$contador=$row_Recordset1['can_ticket_ani5'];

return $contador;
} 
function generarCodigoA($longitud, $texto)
{
    $key = '';
    $pattern = '123456789'.$texto;
    $max = strlen($pattern)-1;
    for ($i=0;$i < $longitud;$i++) {
        $key .= $pattern{mt_rand(0, $max)};
    }
    return $key;
}
//fin funciones
$cantTicket=ObtenerNumeroJugadaA($_SESSION["MM_id_usuario"], $FechaTxt)+1;

$query_Recordset1 = "/* PARSEADORES1 Venta_Animalitos\saveTicket.php - QUERY 2 */ SELECT MAX(id_ticket_ani5) FROM ani5_jugadas";
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$numeroticket=((int)$row_Recordset1['MAX(id_ticket_ani5)'])+1;
$numeroticket1=$numeroticket;
$serial=generarCodigoA(5, $numeroticket);
//print_r($_POST);
//var_dump($_POST["moneda_data"]);
if($_POST)
	{
		$t=1;
		$tt=1;
		$cerrado=0;

//inicio de limites de taquilla agente o distribuidor
$query_Recordset1_3 = sprintf("/* PARSEADORES1 Venta_Animalitos\saveTicket.php - QUERY 3 */ SELECT * FROM taquilla_opc_ani 
WHERE cod_taquilla = %s  LIMIT 1", 
GetSQLValueString($_SESSION["MM_cod_taquilla"], "int"));
$Recordset1_3 = mysqli_query($conexionbanca, $query_Recordset1_3) or die(mysqli_error($conexionbanca));
$row_Recordset1_3 = mysqli_fetch_assoc($Recordset1_3);
$totalRows_Recordset1_3 = mysqli_num_rows($Recordset1_3);

$porciones = explode("-", $row_Recordset1_3['varios_x_loteria']);























//echo $porciones[1].' <br>';



//fin de limites de taquilla agente o distribuidor






		


		foreach ($_POST as $clave=>$valor)
		{
			if($tt==1){
			foreach ($valor as $clave2=>$valor2){

				















				$minxcerrar=$row_Recordset1_3['cierre_adelantado']*60;
				$datetime2 = strtotime('+6 hour', strtotime($datetime));
				$datetime2 = $datetime2+$minxcerrar;
				$datetime2 = date('Y-m-d H:i:s', $datetime2);

				
			$query_Recordset1_2 = sprintf("/* PARSEADORES1 Venta_Animalitos\saveTicket.php - QUERY 4 */ SELECT id_Loterias_y_nombres_ani4 FROM ani4_solteos 
			WHERE fechahora_solteo_ani4 > %s AND id_solteo_ani4 = %s LIMIT 1", 
			GetSQLValueString($datetime2, "date"), 
			GetSQLValueString($valor2["id_sorteo"], "int"));
			$Recordset1_2 = mysqli_query($conexionbanca, $query_Recordset1_2) or die(mysqli_error($conexionbanca));
			$row_Recordset1_2 = mysqli_fetch_assoc($Recordset1_2);
			$totalRows_Recordset1_2 = mysqli_num_rows($Recordset1_2);
			//echo $totalRows_Recordset1_2.' $totalRows_Recordset1_2<br>';

				






//inicio select de jugadas de animalito contra limites de taquilla agente o distribuidor
$query_Recordset13 = sprintf(
	"/* PARSEADORES1 Venta_Animalitos\saveTicket.php - QUERY 5 */ SELECT 
 
SUM(CASE WHEN  ani5_jugadas.fechahora_creacion_ani5 >= %s AND ani5_jugadas.fechahora_creacion_ani5 <= %s  AND ani5_jugadas.moneda_ani5 <= 2 THEN ani5_jugadas.mon_venta_ani5 ELSE 0 END) AS total_ventabss,
SUM(CASE WHEN  ani5_jugadas.fechahora_pago_ani5 >= %s AND ani5_jugadas.fechahora_pago_ani5 <= %s AND (ani5_jugadas.estadojugada_ani5 = 5) AND ani5_jugadas.moneda_ani5 <= 2  THEN ani5_jugadas.mon_pago_ani5 ELSE 0 END) AS total_pagadobss,
SUM(CASE WHEN  ani5_jugadas.fechahora_pago_ani5 >= %s AND ani5_jugadas.fechahora_pago_ani5 <= %s AND (ani5_jugadas.estadojugada_ani5 = 4) AND ani5_jugadas.moneda_ani5 <= 2  THEN ani5_jugadas.mon_pago_ani5 ELSE 0 END) AS total_eliminadosbss,
SUM(CASE WHEN  ani5_jugadas.fechahora_pago_ani5 >= %s AND ani5_jugadas.fechahora_pago_ani5 <= %s AND (ani5_jugadas.estadojugada_ani5 = 6) AND ani5_jugadas.moneda_ani5 <= 2  THEN ani5_jugadas.mon_pago_ani5 ELSE 0 END) AS total_anuladosbss,

SUM(CASE WHEN  ani5_jugadas.fechahora_creacion_ani5 >= %s AND ani5_jugadas.fechahora_creacion_ani5 <= %s AND ani5_jugadas.moneda_ani5 = 3 THEN ani5_jugadas.mon_venta_ani5 ELSE 0 END) AS total_ventausd,
SUM(CASE WHEN  ani5_jugadas.fechahora_pago_ani5 >= %s AND ani5_jugadas.fechahora_pago_ani5 <= %s AND (ani5_jugadas.estadojugada_ani5 = 5) AND ani5_jugadas.moneda_ani5 = 3  THEN ani5_jugadas.mon_pago_ani5 ELSE 0 END) AS total_pagadousd,
SUM(CASE WHEN  ani5_jugadas.fechahora_pago_ani5 >= %s AND ani5_jugadas.fechahora_pago_ani5 <= %s AND (ani5_jugadas.estadojugada_ani5 = 4) AND ani5_jugadas.moneda_ani5 = 3  THEN ani5_jugadas.mon_pago_ani5 ELSE 0 END) AS total_eliminadosusd,
SUM(CASE WHEN  ani5_jugadas.fechahora_pago_ani5 >= %s AND ani5_jugadas.fechahora_pago_ani5 <= %s AND (ani5_jugadas.estadojugada_ani5 = 6) AND ani5_jugadas.moneda_ani5 = 3  THEN ani5_jugadas.mon_pago_ani5 ELSE 0 END) AS total_anuladosusd,

SUM(CASE WHEN  ani5_jugadas.fechahora_creacion_ani5 >= %s AND ani5_jugadas.fechahora_creacion_ani5 <= %s AND ani5_jugadas.moneda_ani5 = 4 THEN ani5_jugadas.mon_venta_ani5 ELSE 0 END) AS total_ventacop,
SUM(CASE WHEN  ani5_jugadas.fechahora_pago_ani5 >= %s AND ani5_jugadas.fechahora_pago_ani5 <= %s AND (ani5_jugadas.estadojugada_ani5 = 5) AND ani5_jugadas.moneda_ani5 = 4  THEN ani5_jugadas.mon_pago_ani5 ELSE 0 END) AS total_pagadocop,
SUM(CASE WHEN  ani5_jugadas.fechahora_pago_ani5 >= %s AND ani5_jugadas.fechahora_pago_ani5 <= %s AND (ani5_jugadas.estadojugada_ani5 = 4) AND ani5_jugadas.moneda_ani5 = 4  THEN ani5_jugadas.mon_pago_ani5 ELSE 0 END) AS total_eliminadoscop,
SUM(CASE WHEN  ani5_jugadas.fechahora_pago_ani5 >= %s AND ani5_jugadas.fechahora_pago_ani5 <= %s AND (ani5_jugadas.estadojugada_ani5 = 6) AND ani5_jugadas.moneda_ani5 = 4  THEN ani5_jugadas.mon_pago_ani5 ELSE 0 END) AS total_anuladoscop,

SUM(CASE WHEN  ani5_jugadas.fechahora_creacion_ani5 >= %s AND ani5_jugadas.fechahora_creacion_ani5 <= %s AND ani5_jugadas.moneda_ani5 = 5 THEN ani5_jugadas.mon_venta_ani5 ELSE 0 END) AS total_ventasol,
SUM(CASE WHEN  ani5_jugadas.fechahora_pago_ani5 >= %s AND ani5_jugadas.fechahora_pago_ani5 <= %s AND  (ani5_jugadas.estadojugada_ani5 = 5) AND ani5_jugadas.moneda_ani5 = 5  THEN ani5_jugadas.mon_pago_ani5 ELSE 0 END) AS total_pagadosol,
SUM(CASE WHEN  ani5_jugadas.fechahora_pago_ani5 >= %s AND ani5_jugadas.fechahora_pago_ani5 <= %s AND  (ani5_jugadas.estadojugada_ani5 = 4) AND ani5_jugadas.moneda_ani5 = 5  THEN ani5_jugadas.mon_pago_ani5 ELSE 0 END) AS total_eliminadossol,
SUM(CASE WHEN  ani5_jugadas.fechahora_pago_ani5 >= %s AND ani5_jugadas.fechahora_pago_ani5 <= %s AND  (ani5_jugadas.estadojugada_ani5 = 6) AND ani5_jugadas.moneda_ani5 = 5  THEN ani5_jugadas.mon_pago_ani5 ELSE 0 END) AS total_anuladossol
FROM 
ani5_jugadas
WHERE
ani5_jugadas.id_solteo_ani5= %s AND
ani5_jugadas.id_animalito_ani5= %s AND
ani5_jugadas.id_usuario_ani5= %s",

GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"),
GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"),
GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"),
GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"),
GetSQLValueString($valor2["id_sorteo"], "int"),
GetSQLValueString($valor2["id_animalito"], "int"),
GetSQLValueString($_SESSION['MM_id_usuario'], "int")
);
$Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
$row_Recordset13 = mysqli_fetch_assoc($Recordset13);
$totalRows_Recordset13 = mysqli_num_rows($Recordset13);
//echo $valor2["id_animalito"].' id_animalito '.$valor2["id_sorteo"].' id_sorteo '.$totalRows_Recordset13.' $totalRows_Recordset13<br>';

$total_ventabss=$row_Recordset13['total_ventabss']-$row_Recordset13['total_eliminadosbss']-$row_Recordset13['total_anuladosbss'];
$total_ventabss=$total_ventabss+$valor2["monto"];
$total_ventausd=$row_Recordset13['total_ventausd']-$row_Recordset13['total_eliminadosusd']-$row_Recordset13['total_anuladosusd'];
$total_ventacop=$row_Recordset13['total_ventacop']-$row_Recordset13['total_eliminadoscop']-$row_Recordset13['total_anuladoscop'];
$total_ventasol=$row_Recordset13['total_ventasol']-$row_Recordset13['total_eliminadossol']-$row_Recordset13['total_anuladossol'];
//echo $total_ventabss.' total_ventabss<br>';

$id_loteria=$valor2["id_loteria"]-1;
$porciones2 = explode(",", $porciones[$id_loteria]);
//echo $porciones2[3].' <br>';
//-1,1,30,101,-2,1,30,100,-3,1,30,100,-4,1,30,100,-5,1,30,100,-6,1,30,100,-7,1,30,100,-8,1,30,100,-9,1,30,100,-10,1,30,100,-11,1,30,100,
if($total_ventabss>$porciones2[3]){//echo 'tope es mayor '; 
	$estado_Ticket=3;}
//fin select de jugadas de animalito contra limites de taquilla agente o distribuidor
if($totalRows_Recordset1_2==0){$cerrado++; }

		}
	
	
	
	
	
	
	
	
	
	
	
	 }else{
		if($clave=='monto_total'){




	}}}$tt++;











if($cerrado>0){  $estado_Ticket=2; }

if($estado_Ticket==0){
	foreach ($_POST as $clave=>$valor)
   		{
			if($t==1){
				$linea=1;
				foreach ($valor as $clave2=>$valor2){

				//echo "El valor de $clave2 es: $valor2"; echo '<br>';
				//echo 'linea '.$linea.'<br>';
				//var_dump($valor2["hora_sorteo"]);  echo '<br>';
				//var_dump($valor2["nombre_loteria"]);  echo '<br>';
				//var_dump($valor2["nombre_animalito"]);  echo '<br>';
				//var_dump($valor2["moneda_data"]);  echo '<br>';
					//var_dump($valor2["id_loteria"]);  echo '<br>';
				
				//var_dump($valor2);  echo '<br>';
				//jugadas[23][id_sorteo]: 2
				//jugadas[23][hora_sorteo]: 10:00 AM
				//jugadas[23][monto]: 5
				//jugadas[23][id_loteria]: 1


				$query_Recordset1_1 = sprintf("/* PARSEADORES1 Venta_Animalitos\saveTicket.php - QUERY 6 */ SELECT id_Loterias_y_nombres_ani4 FROM ani4_solteos 
				WHERE fechahora_solteo_ani4 >= %s AND id_solteo_ani4 = %s LIMIT 1", 
				GetSQLValueString($FechaTxt.' 00:00:01', "date"), 
				GetSQLValueString($valor2["id_sorteo"], "int"));
				$Recordset1_1 = mysqli_query($conexionbanca, $query_Recordset1_1) or die(mysqli_error($conexionbanca));
				$row_Recordset1_1 = mysqli_fetch_assoc($Recordset1_1);
				$totalRows_Recordset1_1 = mysqli_num_rows($Recordset1_1);
			//	var_dump($row_Recordset1_1 );
//echo $totalRows_Recordset1_1.' '.$row_Recordset1_1['id_Loterias_y_nombres_ani4'].' $totalRows_Recordset1_1';
				//$row_Recordset1_1['id_Loterias_y_nombres_ani4']
				//$valor2["id_loteria"] da un resultado malo por eso cree el select





				$insertSQL155 = sprintf(
					"/* PARSEADORES1 Venta_Animalitos\saveTicket.php - QUERY 7 */ INSERT INTO ani5_jugadas  
			(mon_venta_ani5, ser_venta_ani5, id_ticket_ani5, num_ticket_ani5, id_loteria_ani5, id_solteo_ani5, id_animalito_ani5, cod_taquilla_ani5, id_usuario_ani5, fechahora_creacion_ani5, linea_ticket_ani5, estado_ticket_ani5, moneda_ani5)
			VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
			GetSQLValueString($valor2["monto"], "double"),
			GetSQLValueString($serial, "int"),
					GetSQLValueString($numeroticket1, "int"),
					GetSQLValueString($numeroticket, "int"),

					GetSQLValueString($row_Recordset1_1['id_Loterias_y_nombres_ani4'], "int"),
					GetSQLValueString($valor2["id_sorteo"], "int"),
					GetSQLValueString($valor2["id_animalito"], "int"),

					GetSQLValueString($_SESSION["MM_cod_taquilla"], "int"),
					GetSQLValueString($_SESSION["MM_id_usuario"], "int"),
					GetSQLValueString($datetime, "date"),
					GetSQLValueString($linea, "int"),
					GetSQLValueString(0, "int"),
					GetSQLValueString($_POST["moneda_data"], "int")
				);
			
				$Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));

				$_SESSION["monedaani"] = $_POST["moneda_data"];



				$numeroticket1++;


				$linea++;
			}

//var_dump($valor2);  echo '<br>';
			}else{
   		//echo "El valor de $clave es: $valor"; echo '<br>';
		if($clave=='monto_total'){
			$linea2=$linea-1;
			$valor2=$valor/$linea2;
			$insertSQL1monto_total = sprintf(
				"/* PARSEADORES1 Venta_Animalitos\saveTicket.php - QUERY 8 */ UPDATE ani5_jugadas
					SET
					ser_venta_ani5=%s,
					ip_venta_ani5=%s,
					can_ticket_ani5=%s
					WHERE 
					fechahora_creacion_ani5=%s
					AND num_ticket_ani5=%s",
			GetSQLValueString($serial, "text"),
			GetSQLValueString($ip_ventap, "text"),
			GetSQLValueString($cantTicket, "int"),
			GetSQLValueString($datetime, "date"),
			GetSQLValueString($numeroticket, "int")
			);
			
			$Result1monto_total = mysqli_query($conexionbanca, $insertSQL1monto_total) or die(mysqli_error($conexionbanca));

		}
		
   		}$t++;
	}
	$estado_Ticket=1;
}else{
	//$estado_Ticket=2;

}


	}

	//$numticket='20349099';




// 1 se crearon todas las jugadas con exito 2 algunos solteos ya cerraron 3 limite para algun animalito selecionadi superado

if($estado_Ticket==1){
	$data = array("type"=>"success", "id_ticket"=>$numeroticket, "message"=>"El ticket ha sido procesado de forma exitosa.");
}
if($estado_Ticket==2){
	$data = array("type"=>"Cerrada", "id_ticket"=>"000000", "message"=>"Algunas Jugadas ya han cerrado por favor reformule la apuesta.");
}
if($estado_Ticket==3){
	$data = array("type"=>"LimiteSuperado", "id_ticket"=>"000000", "message"=>"Algunos animalitos han superado el limite de apuesta por favor reformule la apuesta.");
}

if($estado_Ticket==4){
	$data = array("type"=>"tieneresultado", "id_ticket"=>"000000", "message"=>"Algunas jugadas no estan activas por tener resultados por favor reformule la apuesta.");
}
//el siguiente es apra crear en un futuro 999999999
if($estado_Ticket==9999999){
	$data = array("type"=>"LimiteSuperado", "id_ticket"=>"000000", "message"=>"Algunas jugadas no estan permitidas por el banquero por favor actualice la taquilla.");
}
echo json_encode($data);
?>