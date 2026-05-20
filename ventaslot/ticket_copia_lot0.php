<?php
        echo $row_Recordset1['nom_taquilla']."<br/>-COPIA0-";
        echo "<br/>Fecha: ".fechanueva($row_Recordset1['fec_venta_lot']);
        echo "<br/>Hora: ".horaampm($row_Recordset1['hor_venta_lot']);
        echo "<br/>Cod: ".$rest;
        echo "<br/>Vend: ".$row_Recordset1['nom_completo'];
        echo "<br/>#:".$row_Recordset1['can_ticket_lot'];
        print('<br/>');
        $ip=$row_Recordset1['ip_venta_lot'];
        do {
            $codigoRegistro=$row_Recordset1['id_loteria'];
            if ($row_Recordset1['tip_loteria_lot']==2) {
                $terTriple=ObtenerTripledeTerminal($row_Recordset1['id_loteria']);
                if ($terTriple==$row_Recordset1['id_loteria']);
                {
                    $codigoRegistro=$terTriple;
                }
            }
            if ($row_Recordset1['tip_loteria_lot']==1 or ($row_Recordset1['tip_loteria_lot']==2 && $row_Recordset1['id_signo']==0)) {
                $maxCol=3;
            } else {
                $maxCol=2;
            }
            if ($cod!=$codigoRegistro) {
                //if ($columnas==$maxCol) {
                if ($columnas==2) {
                    print('--------&nbsp;--------<br/>');
                }
                if ($columnas==3) {
                    print('--------<br/>');
                }
                //}
                print "<strong>-".$row_Recordset1['nom_loteria']."-";
                print('</strong><br/>');
                print('&nbsp;Nro&nbsp;');
                print('&nbsp;Bs&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
                print('&nbsp;Nro&nbsp;');
                print('&nbsp;Bs&nbsp;');
                if ($maxCol==3) {
                    print('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nro&nbsp;');
                    print('&nbsp;Bs&nbsp;');
                }
        
                print('<br/>');
                $cod=$codigoRegistro;
                $filas=0;
                $columnas=1;
            }
            if ($filas==0) {
                $filas=1;
            }
            print $row_Recordset1['num_apuesta_lot'];
            print $row_Recordset1['nsigno'];
            print "x".number_format($row_Recordset1['mon_apuesta_lot'], 2, ",", ".")." ";
            print("&nbsp;");
            $columnas++ ;
            if ($columnas==($maxCol+1)) {
                $filas=0;
                $columnas=1;
                print "<br/>";
            }
            $montoapagar=$montoapagar+$row_Recordset1['mon_apuesta_lot'];
        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
        if ($columnas==2) {
            print('--------&nbsp;--------<br/>');
        }
        if ($columnas==3) {
            print('--------<br/>');
        }
        print "-------------------------"; print('<br/>');
        print('<strong>'); print "Total: ".number_format($montoapagar, 2, ",", "."); print('</strong><br/>');
        if ($tic_caduca>0) {
            echo "Caduca a los ".$tic_caduca." dias<br/>";
        }
        if ($estadoCodBarra==1) {
            $rest = substr($serial, 0, 2);
            $rest = $rest.$xTicket_Recordset1;
            echo "<img src='../includes/generadorBarra.php?codigo=".$rest."'>";
            echo "<br/>";
        }
        if ($estadoCodBarra==1) {
            echo $rest."<br/>";
        }
        for ($i = 0; $i < $largo; ++$i) {
            echo "<br/>";
        }
