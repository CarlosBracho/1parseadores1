<?php
if (isset($ticketPre)) {
    //foreach($ticketPre as $xdatos) {echo $xdatos[0]." ".$xdatos[1]." ".$xdatos[2]." ----- <br/>"; }
    foreach ($ticketPre as $xdatos) {
        //echo $xdatos[0]." ".$xdatos[1]." ".$xdatos[2]." ----- <br/>";
        $insertSQL1 = sprintf(
            "/* PARSEADORES1 new\admin_lot\procesar_ticket_premiados_lot.php - QUERY 1 */ UPDATE venta_lot ve 
			SET
			pag_premio_lot=%s, est_calculo_lot=%s 
			WHERE num_ticket_lot=%s",
            GetSQLValueString($xdatos[1], "int"),
            GetSQLValueString($xdatos[2], "int"),
            GetSQLValueString($xdatos[0], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
    }
} else {
    "ERROR! ALGO SALIO MAL<BR/>POR FAVOR, CONTACTE AL ADMINISTRADOR DEL SITIO INMEDIATAMENTE";
}
