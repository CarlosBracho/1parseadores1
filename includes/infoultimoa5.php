<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');

?>
<script language="javascript">
function cambiacolor_over(celda){ celda.style.backgroundColor="#FC0" } 
function cambiacolor_out(celda){ celda.style.backgroundColor="#A0A0A0" }
</script>
<?php
$fechasistema=fechaactualbd();
$horasistema=horaactual();
$query_Recordset4 = sprintf(
    "/* PARSEADORES1 includes\infoultimoa5.php - QUERY 1 */ SELECT 
venta.ticket, 
venta.hor_venta 
FROM 
venta
USE INDEX(id_us_fe_fe)
WHERE 
venta.lin_ticket = 1 AND 
venta.est_ticket=1 AND 
venta.fec_venta = %s AND
venta.id_usuario = %s 
ORDER BY venta.num_ticket DESC LIMIT 1",
    GetSQLValueString($fechasistema, "date"),
    GetSQLValueString(113, "int")
);
$Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);

$query_Recordset5 = sprintf(
    "/* PARSEADORES1 includes\infoultimoa5.php - QUERY 2 */ SELECT 
venta.ticket, 
venta.hor_venta, 
venta.cod_tventa,
venta.mon_venta,
venta.cod_cliente,
venta.efectivoO,
venta.num_caballo,
carrera.nom_hipodromo, 
carrera.num_carrera  
FROM 
venta, 
carrera 
WHERE 
venta.cod_carrera = carrera.cod_carrera AND  
venta.est_ticket=1 AND 
venta.fec_venta = %s AND
venta.id_usuario = %s AND
venta.ticket = %s 
ORDER BY venta.lin_ticket DESC LIMIT 100",
    GetSQLValueString($fechasistema, "date"),
    GetSQLValueString(113, "int"),
    GetSQLValueString($row_Recordset4['ticket'], "int")
);
$Recordset5 = mysqli_query($conexionbanca, $query_Recordset5) or die(mysqli_error($conexionbanca));
$row_Recordset5 = mysqli_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysqli_num_rows($Recordset5);
$nom_hipodromo=$row_Recordset5['nom_hipodromo'];
$num_carrera=$row_Recordset5['num_carrera'];
$tipo=$row_Recordset5['cod_tventa']/1;
$monto=$row_Recordset5['mon_venta']/1;
$ejemplar=$row_Recordset5['num_caballo']/1;
$efectivoO=$row_Recordset5['efectivoO']/1;

?>
<ul class="list-group">
  <li class="list-group-item d-flex justify-content-between align-items-center">
    <?php echo $nom_hipodromo; ?>
    <span class="badge badge-primary badge-pill">#<?php echo $num_carrera; ?></span>
  </li>
  <?php
            $s=0;
            $apostado=0;
            do { ?>
			
  <li class="list-group-item d-flex justify-content-between align-items-center">
    <?php echo $row_Recordset5['num_caballo'] ?>
							<?php if ($row_Recordset5['cod_tventa']=="1") {
                echo "A GAN";
            } elseif ($row_Recordset5['cod_tventa']=="2") {
                            echo "A PLA";
                        } elseif ($row_Recordset5['cod_tventa']=="3") {
                            echo "A SHO";
                        } elseif ($row_Recordset5['cod_tventa']=="4") {
                            echo "A EXA";
                        } elseif ($row_Recordset5['cod_tventa']=="5") {
                            echo "A TRIF";
                        } elseif ($row_Recordset5['cod_tventa']=="6") {
                            echo "A SUPE";
                        } elseif ($row_Recordset5['cod_tventa']=="7") {
                            echo "A (P)EXA";
                        } elseif ($row_Recordset5['cod_tventa']=="8") {
                            echo "A (P)TRIF";
                        } elseif ($row_Recordset5['cod_tventa']=="9") {
                            echo "A (P)SUPE";
                        }
                        
                        ?>
    <span class="badge badge-primary badge-pill">			<?php echo $row_Recordset5['mon_venta']; ?><?php
if ($efectivoO==0) {
                            echo ' BSS';
                        }
if ($efectivoO==1) {
    echo ' BSS';
}
if ($efectivoO==2) {
    echo ' BSS';
}
if ($efectivoO==3) {
    echo ' USD';
}
if ($efectivoO==4) {
    echo ' COP';
}
if ($efectivoO==5) {
    echo ' SOL';
}
 ?></span>
  </li>
  <?php
                $s++;
            } while ($row_Recordset5 = mysqli_fetch_assoc($Recordset5));?> 
  
  
  <li class="list-group-item d-flex justify-content-between align-items-center">
    TOTAL APOSTADO
    <span class="badge badge-primary badge-pill"><?php echo ObtenerMonTototalVenta($row_Recordset4['ticket'])." "; ?><?php
if ($efectivoO==0) {
                echo ' BSS';
            }
if ($efectivoO==1) {
    echo ' BSS';
}
if ($efectivoO==2) {
    echo ' BSS';
}
if ($efectivoO==3) {
    echo ' USD';
}
if ($efectivoO==4) {
    echo ' COP';
}
if ($efectivoO==5) {
    echo ' SOL';
}
 ?></span>
  </li>
</ul>
<ul class="list-group">
  <li class="list-group-item d-flex justify-content-between align-items-center">
    <?php echo $nom_hipodromo; ?>
    <span class="badge badge-primary badge-pill">#<?php echo $num_carrera; ?></span>
  </li>
  <?php
            $s=0;
            $apostado=0;
            do { ?>
			
  <li class="list-group-item d-flex justify-content-between align-items-center">
    <?php echo $row_Recordset5['num_caballo'] ?>
							<?php if ($row_Recordset5['cod_tventa']=="1") {
                echo "A GAN";
            } elseif ($row_Recordset5['cod_tventa']=="2") {
                            echo "A PLA";
                        } elseif ($row_Recordset5['cod_tventa']=="3") {
                            echo "A SHO";
                        } elseif ($row_Recordset5['cod_tventa']=="4") {
                            echo "A EXA";
                        } elseif ($row_Recordset5['cod_tventa']=="5") {
                            echo "A TRIF";
                        } elseif ($row_Recordset5['cod_tventa']=="6") {
                            echo "A SUPE";
                        } elseif ($row_Recordset5['cod_tventa']=="7") {
                            echo "A (P)EXA";
                        } elseif ($row_Recordset5['cod_tventa']=="8") {
                            echo "A (P)TRIF";
                        } elseif ($row_Recordset5['cod_tventa']=="9") {
                            echo "A (P)SUPE";
                        }
                        
                        ?>
    <span class="badge badge-primary badge-pill">			<?php echo $row_Recordset5['mon_venta']; ?><?php
if ($efectivoO==0) {
                            echo ' BSS';
                        }
if ($efectivoO==1) {
    echo ' BSS';
}
if ($efectivoO==2) {
    echo ' BSS';
}
if ($efectivoO==3) {
    echo ' USD';
}
if ($efectivoO==4) {
    echo ' COP';
}
if ($efectivoO==5) {
    echo ' SOL';
}
 ?></span>
  </li>
  <?php
                $s++;
            } while ($row_Recordset5 = mysqli_fetch_assoc($Recordset5));?> 
  
  
  <li class="list-group-item d-flex justify-content-between align-items-center">
    TOTAL APOSTADO
    <span class="badge badge-primary badge-pill"><?php echo ObtenerMonTototalVenta($row_Recordset4['ticket'])." "; ?><?php
if ($efectivoO==0) {
                echo ' BSS';
            }
if ($efectivoO==1) {
    echo ' BSS';
}
if ($efectivoO==2) {
    echo ' BSS';
}
if ($efectivoO==3) {
    echo ' USD';
}
if ($efectivoO==4) {
    echo ' COP';
}
if ($efectivoO==5) {
    echo ' SOL';
}
 ?></span>
  </li>
</ul>
<ul class="list-group">
  <li class="list-group-item d-flex justify-content-between align-items-center">
    <?php echo $nom_hipodromo; ?>
    <span class="badge badge-primary badge-pill">#<?php echo $num_carrera; ?></span>
  </li>
  <?php
            $s=0;
            $apostado=0;
            do { ?>
			
  <li class="list-group-item d-flex justify-content-between align-items-center">
    <?php echo $row_Recordset5['num_caballo'] ?>
							<?php if ($row_Recordset5['cod_tventa']=="1") {
                echo "A GAN";
            } elseif ($row_Recordset5['cod_tventa']=="2") {
                            echo "A PLA";
                        } elseif ($row_Recordset5['cod_tventa']=="3") {
                            echo "A SHO";
                        } elseif ($row_Recordset5['cod_tventa']=="4") {
                            echo "A EXA";
                        } elseif ($row_Recordset5['cod_tventa']=="5") {
                            echo "A TRIF";
                        } elseif ($row_Recordset5['cod_tventa']=="6") {
                            echo "A SUPE";
                        } elseif ($row_Recordset5['cod_tventa']=="7") {
                            echo "A (P)EXA";
                        } elseif ($row_Recordset5['cod_tventa']=="8") {
                            echo "A (P)TRIF";
                        } elseif ($row_Recordset5['cod_tventa']=="9") {
                            echo "A (P)SUPE";
                        }
                        
                        ?>
    <span class="badge badge-primary badge-pill">			<?php echo $row_Recordset5['mon_venta']; ?><?php
if ($efectivoO==0) {
                            echo ' BSS';
                        }
if ($efectivoO==1) {
    echo ' BSS';
}
if ($efectivoO==2) {
    echo ' BSS';
}
if ($efectivoO==3) {
    echo ' USD';
}
if ($efectivoO==4) {
    echo ' COP';
}
if ($efectivoO==5) {
    echo ' SOL';
}
 ?></span>
  </li>
  <?php
                $s++;
            } while ($row_Recordset5 = mysqli_fetch_assoc($Recordset5));?> 
  
  
  <li class="list-group-item d-flex justify-content-between align-items-center">
    TOTAL APOSTADO
    <span class="badge badge-primary badge-pill"><?php echo ObtenerMonTototalVenta($row_Recordset4['ticket'])." "; ?><?php
if ($efectivoO==0) {
                echo ' BSS';
            }
if ($efectivoO==1) {
    echo ' BSS';
}
if ($efectivoO==2) {
    echo ' BSS';
}
if ($efectivoO==3) {
    echo ' USD';
}
if ($efectivoO==4) {
    echo ' COP';
}
if ($efectivoO==5) {
    echo ' SOL';
}
 ?></span>
  </li>
</ul>
<ul class="list-group">
  <li class="list-group-item d-flex justify-content-between align-items-center">
    <?php echo $nom_hipodromo; ?>
    <span class="badge badge-primary badge-pill">#<?php echo $num_carrera; ?></span>
  </li>
  <?php
            $s=0;
            $apostado=0;
            do { ?>
			
  <li class="list-group-item d-flex justify-content-between align-items-center">
    <?php echo $row_Recordset5['num_caballo'] ?>
							<?php if ($row_Recordset5['cod_tventa']=="1") {
                echo "A GAN";
            } elseif ($row_Recordset5['cod_tventa']=="2") {
                            echo "A PLA";
                        } elseif ($row_Recordset5['cod_tventa']=="3") {
                            echo "A SHO";
                        } elseif ($row_Recordset5['cod_tventa']=="4") {
                            echo "A EXA";
                        } elseif ($row_Recordset5['cod_tventa']=="5") {
                            echo "A TRIF";
                        } elseif ($row_Recordset5['cod_tventa']=="6") {
                            echo "A SUPE";
                        } elseif ($row_Recordset5['cod_tventa']=="7") {
                            echo "A (P)EXA";
                        } elseif ($row_Recordset5['cod_tventa']=="8") {
                            echo "A (P)TRIF";
                        } elseif ($row_Recordset5['cod_tventa']=="9") {
                            echo "A (P)SUPE";
                        }
                        
                        ?>
    <span class="badge badge-primary badge-pill">			<?php echo $row_Recordset5['mon_venta']; ?><?php
if ($efectivoO==0) {
                            echo ' BSS';
                        }
if ($efectivoO==1) {
    echo ' BSS';
}
if ($efectivoO==2) {
    echo ' BSS';
}
if ($efectivoO==3) {
    echo ' USD';
}
if ($efectivoO==4) {
    echo ' COP';
}
if ($efectivoO==5) {
    echo ' SOL';
}
 ?></span>
  </li>
  <?php
                $s++;
            } while ($row_Recordset5 = mysqli_fetch_assoc($Recordset5));?> 
  
  
  <li class="list-group-item d-flex justify-content-between align-items-center">
    TOTAL APOSTADO
    <span class="badge badge-primary badge-pill"><?php echo ObtenerMonTototalVenta($row_Recordset4['ticket'])." "; ?><?php
if ($efectivoO==0) {
                echo ' BSS';
            }
if ($efectivoO==1) {
    echo ' BSS';
}
if ($efectivoO==2) {
    echo ' BSS';
}
if ($efectivoO==3) {
    echo ' USD';
}
if ($efectivoO==4) {
    echo ' COP';
}
if ($efectivoO==5) {
    echo ' SOL';
}
 ?></span>
  </li>
</ul>
<ul class="list-group">
  <li class="list-group-item d-flex justify-content-between align-items-center">
    <?php echo $nom_hipodromo; ?>
    <span class="badge badge-primary badge-pill">#<?php echo $num_carrera; ?></span>
  </li>
  <?php
            $s=0;
            $apostado=0;
            do { ?>
			
  <li class="list-group-item d-flex justify-content-between align-items-center">
    <?php echo $row_Recordset5['num_caballo'] ?>
							<?php if ($row_Recordset5['cod_tventa']=="1") {
                echo "A GAN";
            } elseif ($row_Recordset5['cod_tventa']=="2") {
                            echo "A PLA";
                        } elseif ($row_Recordset5['cod_tventa']=="3") {
                            echo "A SHO";
                        } elseif ($row_Recordset5['cod_tventa']=="4") {
                            echo "A EXA";
                        } elseif ($row_Recordset5['cod_tventa']=="5") {
                            echo "A TRIF";
                        } elseif ($row_Recordset5['cod_tventa']=="6") {
                            echo "A SUPE";
                        } elseif ($row_Recordset5['cod_tventa']=="7") {
                            echo "A (P)EXA";
                        } elseif ($row_Recordset5['cod_tventa']=="8") {
                            echo "A (P)TRIF";
                        } elseif ($row_Recordset5['cod_tventa']=="9") {
                            echo "A (P)SUPE";
                        }
                        
                        ?>
    <span class="badge badge-primary badge-pill">			<?php echo $row_Recordset5['mon_venta']; ?><?php
if ($efectivoO==0) {
                            echo ' BSS';
                        }
if ($efectivoO==1) {
    echo ' BSS';
}
if ($efectivoO==2) {
    echo ' BSS';
}
if ($efectivoO==3) {
    echo ' USD';
}
if ($efectivoO==4) {
    echo ' COP';
}
if ($efectivoO==5) {
    echo ' SOL';
}
 ?></span>
  </li>
  <?php
                $s++;
            } while ($row_Recordset5 = mysqli_fetch_assoc($Recordset5));?> 
  
  
  <li class="list-group-item d-flex justify-content-between align-items-center">
    TOTAL APOSTADO
    <span class="badge badge-primary badge-pill"><?php echo ObtenerMonTototalVenta($row_Recordset4['ticket'])." "; ?><?php
if ($efectivoO==0) {
                echo ' BSS';
            }
if ($efectivoO==1) {
    echo ' BSS';
}
if ($efectivoO==2) {
    echo ' BSS';
}
if ($efectivoO==3) {
    echo ' USD';
}
if ($efectivoO==4) {
    echo ' COP';
}
if ($efectivoO==5) {
    echo ' SOL';
}
 ?></span>
  </li>
</ul>